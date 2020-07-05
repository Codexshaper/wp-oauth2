<?php

namespace Codexshaper_Oauth_Server\App\Http;

use Codexshaper_Oauth_Server\Http\Kernel as HttpKernel;

/**
 * Http request handler.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/app/Http
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = array();

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middleware_groups = array(
		'web' => array(
			\Codexshaper_Oauth_Server\App\Http\Middleware\VerifyCsrfToken::class,
		),

		'api' => array(
			'throttle:60,1',
		),
	);

	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */
	protected $route_middleware = array(
		'auth' => \Codexshaper_Oauth_Server\App\Http\Middleware\AuthMiddleware::class,
	);
}
