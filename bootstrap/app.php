<?php
/**
 * The file that defines the bootsrap plugin
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/bootstrap
 */

require_once ABSPATH . 'wp-includes/pluggable.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/helpers.php';

use Codexshaper_Oauth_Server\Application;

$app = ( new Application(
	array(
		'paths' => array(
			'root' => CODEXSHAPER_OAUTH_SERVER_APP_ROOT,
		),
	)
) );

$container = $app->instance();

$container->singleton(
	Illuminate\Contracts\Http\Kernel::class,
	\Codexshaper_Oauth_Server\App\Http\Kernel::class
);
$container->singleton(
	\Illuminate\Contracts\Debug\ExceptionHandler::class,
	\Codexshaper_Oauth_Server\App\Exceptions\Handler::class
);

try {

	$kernel = $container->make( \Illuminate\Contracts\Http\Kernel::class );

	$response = $kernel->handle( \Illuminate\Http\Request::capture() );

	$response->send();

} catch ( \Exception $ex ) {
	if ( ! \Codexshaper_Oauth_Server\Support\Facades\Route::current() ) {
		return true;
	}
	throw new \Exception( $ex, 1 );
}
