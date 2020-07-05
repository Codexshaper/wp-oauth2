<?php

namespace Codexshaper_Oauth_Server\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Whoops\Handler\HandlerInterface;
use Whoops\Run as Whoops;

/**
 * Exception handler.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/src/Exceptions
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Handler {

	/**
	 * The container implementation.
	 *
	 * @var \Illuminate\Contracts\Container\Container
	 */
	protected $container;

	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dont_report = array();

	/**
	 * A list of the internal exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $internal_dont_report = array(
		AuthenticationException::class,
		AuthorizationException::class,
		HttpException::class,
		HttpResponseException::class,
		ModelNotFoundException::class,
		SuspiciousOperationException::class,
		TokenMismatchException::class,
		ValidationException::class,
	);

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dont_flash = array(
		'password',
		'password_confirmation',
	);

	/**
	 * Create a new exception handler instance.
	 *
	 * @param \Illuminate\Contracts\Container\Container $container The app container.
	 *
	 * @return void
	 */
	public function __construct( Container $container ) {
		$this->container = $container;
	}

	/**
	 * Report or log an exception.
	 *
	 * @param \Throwable $e The throwable exception.
	 *
	 * @throws \Exception Throw the exception.
	 *
	 * @return void
	 */
	public function report( Throwable $e ) {
		if ( $this->shouldnt_report( $e ) ) {
			return;
		}

		if ( is_callable( $report_callable = array( $e, 'report' ) ) ) {
			$this->container->call( $report_callable );

			return;
		}

		try {
			$logger = $this->container->make( LoggerInterface::class );
		} catch ( Exception $ex ) {
			throw $e;
		}

		$logger->error(
			$e->getMessage(),
			array_merge(
				$this->exception_context( $e ),
				$this->context(),
				array( 'exception' => $e )
			)
		);
	}

	/**
	 * Determine if the exception should be reported.
	 *
	 * @param \Throwable $e The throwable exception.
	 *
	 * @return bool
	 */
	public function should_report( Throwable $e ) {
		return ! $this->shouldnt_report( $e );
	}

	/**
	 * Determine if the exception is in the "do not report" list.
	 *
	 * @param \Throwable $e The throwable exception.
	 *
	 * @return bool
	 */
	protected function shouldnt_report( Throwable $e ) {
		$dont_report = array_merge( $this->dont_report, $this->internal_dont_report );

		return ! is_null(
			Arr::first(
				$dont_report,
				function ( $type ) use ( $e ) {
					return $e instanceof $type;
				}
			)
		);
	}

	/**
	 * Get the default exception context variables for logging.
	 *
	 * @param \Throwable $e The throwable exception.
	 *
	 * @return array
	 */
	protected function exception_context( Throwable $e ) {
		return array();
	}

	/**
	 * Get the default context variables for logging.
	 *
	 * @return array
	 */
	protected function context() {
		try {
			return array_filter(
				array(
					'userId' => Auth::id(),
				// 'email' => optional(Auth::user())->email,
				)
			);
		} catch ( Throwable $e ) {
			return array();
		}
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param \Illuminate\Http\Request $request The app request.
	 * @param \Throwable               $e The throwable exception.
	 *
	 * @throws \Throwable Throw the exception.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function render( $request, Throwable $e ) {
		if ( method_exists( $e, 'render' ) && $response = $e->render( $request ) ) {
			return Router::toResponse( $request, $response );
		} elseif ( $e instanceof Responsable ) {
			return $e->toResponse( $request );
		}

		$e = $this->prepare_exception( $e );

		if ( $e instanceof HttpResponseException ) {
			return $e->getResponse();
		} elseif ( $e instanceof AuthenticationException ) {
			return $this->unauthenticated( $request, $e );
		} elseif ( $e instanceof ValidationException ) {
			return $this->convert_validation_exception_to_response( $e, $request );
		}

		return $request->expectsJson()
					? $this->prepare_json_response( $request, $e )
					: $this->prepare_response( $request, $e );
	}

	/**
	 * Prepare exception for rendering.
	 *
	 * @param \Throwable $e The throwable exception.
	 *
	 * @return \Throwable Throw the error.
	 */
	protected function prepare_exception( Throwable $e ) {
		if ( $e instanceof ModelNotFoundException ) {
			$e = new NotFoundHttpException( $e->getMessage(), $e );
		} elseif ( $e instanceof AuthorizationException ) {
			$e = new AccessDeniedHttpException( $e->getMessage(), $e );
		} elseif ( $e instanceof TokenMismatchException ) {
			$e = new HttpException( 419, $e->getMessage(), $e );
		} elseif ( $e instanceof SuspiciousOperationException ) {
			$e = new NotFoundHttpException( 'Bad hostname provided.', $e );
		}

		return $e;
	}

	/**
	 * Convert an authentication exception into a response.
	 *
	 * @param \Illuminate\Http\Request                 $request The app request.
	 * @param \Illuminate\Auth\AuthenticationException $exception Authenticated exception.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function unauthenticated( $request, AuthenticationException $exception ) {
		return $request->expectsJson()
					? response()->json( array( 'message' => $exception->getMessage() ), 401 )
					: redirect()->guest( $exception->redirectTo() ?? route( 'login' ) );
	}

	/**
	 * Create a response object from the given validation exception.
	 *
	 * @param \Illuminate\Validation\ValidationException $e The validator exception.
	 * @param \Illuminate\Http\Request                   $request The app request.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function convert_validation_exception_to_response( ValidationException $e, $request ) {
		if ( $e->response ) {
			return $e->response;
		}

		return $request->expectsJson()
					? $this->invalid_json( $request, $e )
					: $this->invalid( $request, $e );
	}

	/**
	 * Convert a validation exception into a response.
	 *
	 * @param \Illuminate\Http\Request                   $request The app request.
	 * @param \Illuminate\Validation\ValidationException $exception The validator exception.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function invalid( $request, ValidationException $exception ) {
		return redirect( $exception->redirectTo ?? url()->previous() )
					->withInput( Arr::except( $request->input(), $this->dont_flash ) )
					->withErrors( $exception->errors(), $exception->errorBag );
	}

	/**
	 * Convert a validation exception into a JSON response.
	 *
	 * @param \Illuminate\Http\Request                   $request The app request.
	 * @param \Illuminate\Validation\ValidationException $exception The validator exception.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function invalid_json( $request, ValidationException $exception ) {
		return response()->json(
			array(
				'message' => $exception->getMessage(),
				'errors'  => $exception->errors(),
			),
			$exception->status
		);
	}

	/**
	 * Prepare a response for the given exception.
	 *
	 * @param \Illuminate\Http\Request $request The app request.
	 * @param \Throwable               $e Throw the exception.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function prepare_response( $request, Throwable $e ) {
		if ( ! $this->is_http_exception( $e ) && $this->container['config']['app.debug'] ) {
			return $this->to_illuminate_response( $this->convert_exception_to_response( $e ), $e );
		}

		if ( ! $this->is_http_exception( $e ) ) {
			$e = new HttpException( 500, $e->getMessage() );
		}

		return $this->to_illuminate_response(
			$this->render_http_exception( $e ),
			$e
		);
	}

	/**
	 * Create a Symfony response for the given exception.
	 *
	 * @param \Throwable $e Throw the exception.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function convert_exception_to_response( Throwable $e ) {
		return SymfonyResponse::create(
			$this->render_exception_content( $e ),
			$this->is_http_exception( $e ) ? $e->getStatusCode() : 500,
			$this->is_http_exception( $e ) ? $e->getHeaders() : array()
		);
	}

	/**
	 * Get the response content for the given exception.
	 *
	 * @param \Throwable $e Throw the exception.
	 *
	 * @return string
	 */
	protected function render_exception_content( Throwable $e ) {
		try {
			return $this->container['config']['app.debug'] && class_exists( Whoops::class )
						? $this->render_exception_with_whoops( $e )
						: $this->render_exception_with_symfony( $e, $this->container['config']['app.debug'] );
		} catch ( Exception $e ) {
			return $this->render_exception_with_symfony( $e, $this->container['config']['app.debug'] );
		}
	}

	/**
	 * Render an exception to a string using "Whoops".
	 *
	 * @param \Throwable $e Throw the exception.
	 *
	 * @return string
	 */
	protected function render_exception_with_whoops( Throwable $e ) {
		return tap(
			new Whoops(),
			function ( $whoops ) {
				$whoops->appendHandler( $this->whoops_handler() );

				$whoops->writeToOutput( false );

				$whoops->allowQuit( false );
			}
		)->handleException( $e );
	}

	/**
	 * Get the Whoops handler for the application.
	 *
	 * @return \Whoops\Handler\Handler
	 */
	protected function whoops_handler() {
		try {
			return $this->container( HandlerInterface::class );
		} catch ( BindingResolutionException $e ) {
			return ( new WhoopsHandler() )->forDebug();
		}
	}

	/**
	 * Render an exception to a string using Symfony.
	 *
	 * @param \Throwable $e Throw the exception.
	 * @param bool       $debug Enable or disable debug.
	 *
	 * @return string
	 */
	protected function render_exception_with_symfony( Throwable $e, $debug ) {
		$renderer = new HtmlErrorRenderer( $debug );

		return $renderer->getBody( $renderer->render( $e ) );
	}

	/**
	 * Render the given HttpException.
	 *
	 * @param \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e Http exception.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function render_http_exception( HttpExceptionInterface $e ) {
		$this->registerErrorViewPaths();

		$view = $this->get_http_exception_view( $e );

		if ( view()->exists( $view ) ) {
			return response()->view(
				$view,
				array(
					'errors'    => new ViewErrorBag(),
					'exception' => $e,
				),
				$e->getStatusCode(),
				$e->getHeaders()
			);
		}

		return $this->convert_exception_to_response( $e );
	}

	/**
	 * Register the error template hint paths.
	 *
	 * @return void
	 */
	protected function register_error_view_paths() {
		$paths = collect( $this->container['config']['view.paths'] );

		View::replaceNamespace(
			'errors',
			$paths->map(
				function ( $path ) {
					return "{$path}/errors";
				}
			)->push( __DIR__ . '/views' )->all()
		);
	}

	/**
	 * Get the view used to render HTTP exceptions.
	 *
	 * @param \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e Http exception.
	 *
	 * @return string
	 */
	protected function get_http_exception_view( HttpExceptionInterface $e ) {
		return "errors::{$e->getStatusCode()}";
	}

	/**
	 * Map the given exception into an Illuminate response.
	 *
	 * @param \Symfony\Component\HttpFoundation\Response $response The app response.
	 * @param \Throwable                                 $e Throw the exception.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function to_illuminate_response( $response, Throwable $e ) {
		if ( $response instanceof SymfonyRedirectResponse ) {
			$response = new RedirectResponse(
				$response->getTargetUrl(),
				$response->getStatusCode(),
				$response->headers->all()
			);
		} else {
			$response = new Response(
				$response->getContent(),
				$response->getStatusCode(),
				$response->headers->all()
			);
		}

		return $response->withException( $e );
	}

	/**
	 * Prepare a JSON response for the given exception.
	 *
	 * @param \Illuminate\Http\Request $request The app request.
	 * @param \Throwable               $e Throw the exception.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function prepare_json_response( $request, Throwable $e ) {
		return new JsonResponse(
			$this->convert_exception_to_array( $e ),
			$this->is_http_exception( $e ) ? $e->getStatusCode() : 500,
			$this->is_http_exception( $e ) ? $e->getHeaders() : array(),
			JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
		);
	}

	/**
	 * Convert the given exception to an array.
	 *
	 * @param \Throwable $e Throw the exception.
	 *
	 * @return array
	 */
	protected function convert_exception_to_array( Throwable $e ) {
		return $this->container['config']['app.debug'] ? array(
			'message'   => $e->getMessage(),
			'exception' => get_class( $e ),
			'file'      => $e->getFile(),
			'line'      => $e->getLine(),
			'trace'     => collect( $e->getTrace() )->map(
				function ( $trace ) {
					return Arr::except( $trace, array( 'args' ) );
				}
			)->all(),
		) : array(
			'message' => $this->is_http_exception( $e ) ? $e->getMessage() : 'Server Error',
		);
	}

	/**
	 * Render an exception to the console.
	 *
	 * @param \Symfony\Component\Console\Output\OutputInterface $output The symphony Output.
	 * @param \Throwable                                        $e      Throw the exception.
	 *
	 * @return void
	 */
	public function render_for_console( $output, Throwable $e ) {
		( new ConsoleApplication() )->renderThrowable( $e, $output );
	}

	/**
	 * Determine if the given exception is an HTTP exception.
	 *
	 * @param \Throwable $e Throw the exception.
	 *
	 * @return bool
	 */
	protected function is_http_exception( Throwable $e ) {
		return $e instanceof HttpExceptionInterface;
	}
}
