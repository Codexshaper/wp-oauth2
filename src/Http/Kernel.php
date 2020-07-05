<?php

namespace Codexshaper_Oauth_Server\Http;

use Codexshaper_Oauth_Server\Http\Events\RequestHandled;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Http\Kernel as KernelContract;
use Illuminate\Routing\Pipeline;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Facade;
use InvalidArgumentException;
use Throwable;

/**
 * Http handler.
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/src/Http
 */

/**
 * Http handler.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/src/Http
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Kernel {

	/**
	 * The application implementation.
	 *
	 * @var \Codexshaper_Oauth_Server\Application
	 */
	protected $app;

	/**
	 * The router instance.
	 *
	 * @var \Illuminate\Routing\Router
	 */
	protected $router;

	/**
	 * The bootstrap classes for the application.
	 *
	 * @var array
	 */
	protected $bootstrappers = array();

	/**
	 * The application's middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = array();

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middleware_groups = array();

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $route_middleware = array();

	/**
	 * The priority-sorted list of middleware.
	 *
	 * Forces non-global middleware to always be in the given order.
	 *
	 * @var array
	 */
	protected $middleware_priority = array();

	/**
	 * Create a new HTTP kernel instance.
	 *
	 * @param \Illuminate\Contracts\Container\Container $app The app container.
	 * @param \Illuminate\Routing\Router                $router The app router.
	 *
	 * @return void
	 */
	public function __construct( Container $app, Router $router ) {
		$this->app    = $app;
		$this->router = $router;

		$this->sync_middleware_to_router();
	}

	/**
	 * Handle an incoming HTTP request.
	 *
	 * @param \Illuminate\Http\Request $request The app request.
	 *
	 * @throws \Exception Throw error if response failed.
	 * @return \Illuminate\Http\Response
	 */
	public function handle( $request ) {
		try {
			$request->enableHttpMethodParameterOverride();
			$response = $this->send_request_through_router( $request );
		} catch ( Throwable $e ) {
			throw new \Exception( $e, 1 );
			$this->reportException( $e );

			$response = $this->render_exception( $request, $e );
		}

		$this->app['events']->dispatch(
			new RequestHandled( $request, $response )
		);

		return $response;
	}

	/**
	 * Send the given request through the middleware / router.
	 *
	 * @param \Illuminate\Http\Request $request The app request.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function send_request_through_router( $request ) {
		$this->app->instance( 'request', $request );

		Facade::clearResolvedInstance( 'request' );

		$this->bootstrap();

		return ( new Pipeline( $this->app ) )
					->send( $request )
					->through( $this->middleware )
					->then( $this->dispatch_to_router() );
	}

	/**
	 * Bootstrap the application for HTTP requests.
	 *
	 * @return void
	 */
	public function bootstrap() {
		/*
		if (! $this->app->hasBeenBootstrapped()) {
		$this->app->bootstrapWith($this->bootstrappers());
		}
		*/
	}

	/**
	 * Get the route dispatcher callback.
	 *
	 * @return \Closure
	 */
	protected function dispatch_to_router() {
		return function ( $request ) {
			$this->app->instance( 'request', $request );

			return $this->router->dispatch( $request );
		};
	}

	/**
	 * Call the terminate method on any terminable middleware.
	 *
	 * @param \Illuminate\Http\Request  $request The app request.
	 * @param \Illuminate\Http\Response $response The app response.
	 *
	 * @return void
	 */
	public function terminate( $request, $response ) {
		$this->terminate_middleware( $request, $response );

		$this->app->terminate();
	}

	/**
	 * Call the terminate method on any terminable middleware.
	 *
	 * @param \Illuminate\Http\Request  $request The app request.
	 * @param \Illuminate\Http\Response $response The app response.
	 *
	 * @return void
	 */
	protected function terminate_middleware( $request, $response ) {
		$middlewares = $this->app->shouldSkipMiddleware() ? array() : array_merge(
			$this->gather_route_middleware( $request ),
			$this->middleware
		);

		foreach ( $middlewares as $middleware ) {
			if ( ! is_string( $middleware ) ) {
				continue;
			}

			$name = $this->parse_middleware( $middleware );

			$instance = $this->app->make( $name );

			if ( method_exists( $instance, 'terminate' ) ) {
				$instance->terminate( $request, $response );
			}
		}
	}

	/**
	 * Gather the route middleware for the given request.
	 *
	 * @param \Illuminate\Http\Request $request The app request.
	 *
	 * @return array
	 */
	protected function gather_route_middleware( $request ) {
		$route = $request->route();
		if ( $route ) {
			return $this->router->gatherRouteMiddleware( $route );
		}

		return array();
	}

	/**
	 * Parse a middleware string to get the name and parameters.
	 *
	 * @param string $middleware The app middleware.
	 *
	 * @return array
	 */
	protected function parse_middleware( $middleware ) {
		list( $name, $parameters ) = array_pad( explode( ':', $middleware, 2 ), 2, array() );

		if ( is_string( $parameters ) ) {
			$parameters = explode( ',', $parameters );
		}

		return array( $name, $parameters );
	}

	/**
	 * Determine if the kernel has a given middleware.
	 *
	 * @param string $middleware The app middleware.
	 *
	 * @return bool
	 */
	public function has_middleware( $middleware ) {
		return in_array( $middleware, $this->middleware );
	}

	/**
	 * Add a new middleware to beginning of the stack if it does not already exist.
	 *
	 * @param string $middleware The app middleware.
	 *
	 * @return $this
	 */
	public function prepend_middleware( $middleware ) {
		if ( array_search( $middleware, $this->middleware ) === false ) {
			array_unshift( $this->middleware, $middleware );
		}

		return $this;
	}

	/**
	 * Add a new middleware to end of the stack if it does not already exist.
	 *
	 * @param string $middleware The app middleware.
	 *
	 * @return $this
	 */
	public function push_middleware( $middleware ) {
		if ( array_search( $middleware, $this->middleware ) === false ) {
			$this->middleware[] = $middleware;
		}

		return $this;
	}

	/**
	 * Prepend the given middleware to the given middleware group.
	 *
	 * @param string $group The app group.
	 * @param string $middleware The app middleware.
	 *
	 * @throws \InvalidArgumentException Throw when argument is invalid.
	 *
	 * @return $this
	 */
	public function prepend_middleware_to_group( $group, $middleware ) {
		if ( ! isset( $this->middleware_groups[ $group ] ) ) {
			throw new InvalidArgumentException( "The [{$group}] middleware group has not been defined." );
		}

		if ( array_search( $middleware, $this->middleware_groups[ $group ] ) === false ) {
			array_unshift( $this->middleware_groups[ $group ], $middleware );
		}

		$this->sync_middleware_to_router();

		return $this;
	}

	/**
	 * Append the given middleware to the given middleware group.
	 *
	 * @param string $group The app group.
	 * @param string $middleware The app middleware.
	 *
	 * @throws \InvalidArgumentException Throw when argument is invalid.
	 *
	 * @return $this
	 */
	public function append_middleware_to_group( $group, $middleware ) {
		if ( ! isset( $this->middleware_groups[ $group ] ) ) {
			throw new InvalidArgumentException( "The [{$group}] middleware group has not been defined." );
		}

		if ( array_search( $middleware, $this->middleware_groups[ $group ] ) === false ) {
			$this->middleware_groups[ $group ][] = $middleware;
		}

		$this->sync_middleware_to_router();

		return $this;
	}

	/**
	 * Prepend the given middleware to the middleware priority list.
	 *
	 * @param string $middleware The app middleware.
	 *
	 * @return $this
	 */
	public function prepend_to_middleware_priority( $middleware ) {
		if ( ! in_array( $middleware, $this->middleware_priority ) ) {
			array_unshift( $this->middleware_priority, $middleware );
		}

		$this->sync_middleware_to_router();

		return $this;
	}

	/**
	 * Append the given middleware to the middleware priority list.
	 *
	 * @param string $middleware The app middleware.
	 *
	 * @return $this
	 */
	public function append_to_middleware_priority( $middleware ) {
		if ( ! in_array( $middleware, $this->middleware_priority ) ) {
			$this->middleware_priority[] = $middleware;
		}

		$this->sync_middleware_to_router();

		return $this;
	}

	/**
	 * Sync the current state of the middleware to the router.
	 *
	 * @return void
	 */
	protected function sync_middleware_to_router() {
		$this->router->middlewarePriority = $this->middleware_priority;

		foreach ( $this->middleware_groups as $key => $middleware ) {
			$this->router->middlewareGroup( $key, $middleware );
		}

		foreach ( $this->route_middleware as $key => $middleware ) {
			$this->router->aliasMiddleware( $key, $middleware );
		}
	}

	/**
	 * Get the bootstrap classes for the application.
	 *
	 * @return array
	 */
	protected function bootstrappers() {
		return $this->bootstrappers;
	}

	/**
	 * Report the exception to the exception handler.
	 *
	 * @param \Throwable $e Throwable error.
	 *
	 * @return void
	 */
	protected function report_exception( Throwable $e ) {
		$this->app[ ExceptionHandler::class ]->report( $e );
	}

	/**
	 * Render the exception to a response.
	 *
	 * @param \Illuminate\Http\Request $request The app middlerequestware.
	 * @param \Throwable               $e Throwable error.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function render_exception( $request, Throwable $e ) {
		return $this->app[ ExceptionHandler::class ]->render( $request, $e );
	}

	/**
	 * Get the application's route middleware groups.
	 *
	 * @return array
	 */
	public function get_middleware_groups() {
		return $this->middleware_groups;
	}

	/**
	 * Get the application's route middleware.
	 *
	 * @return array
	 */
	public function get_route_middleware() {
		return $this->route_middleware;
	}

	/**
	 * Get the Laravel application instance.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application
	 */
	public function get_application() {
		return $this->app;
	}
}
