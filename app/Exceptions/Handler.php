<?php

namespace Codexshaper_Oauth_Server\App\Exceptions;

use Codexshaper_Oauth_Server\Exceptions\Handler as ExceptionHandler;
use Throwable;

/**
 * Exception handler.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/app/Exceptions
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dont_report = array();

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
	 * Report or log an exception.
	 *
	 * @param  \Throwable $exception Throwable object.
	 * @return void
	 *
	 * @throws \Exception Throw the exception.
	 */
	public function report( Throwable $exception ) {
		parent::report( $exception );
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request The app request.
	 * @param  \Throwable               $exception The throwable execption.
	 * @return \Symfony\Component\HttpFoundation\Response The app response.
	 *
	 * @throws \Throwable Throw the exception.
	 */
	public function render( $request, Throwable $exception ) {
		return parent::render( $request, $exception );
	}
}
