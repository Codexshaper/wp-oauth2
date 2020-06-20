<?php
require_once(ABSPATH.'wp-includes/pluggable.php');

require_once __DIR__.'/../vendor/autoload.php';
// require_once __DIR__.'/../routes/web.php';

require_once __DIR__. '/../vendor/illuminate/support/helpers.php';
require_once __DIR__. '/../vendor/codexshaper/wpb-foundation/src/helpers.php';
require_once __DIR__. '/../vendor/codexshaper/wpb-foundation/src/shortcodes.php';

use CodexShaper\WP\Application;
use Illuminate\Support\Str;

$basePath = Str::finish(dirname(__FILE__), '/');
if (! defined('PLUGIN_BASE_PATH')) {
	define('PLUGIN_BASE_PATH', $basePath);
}

$wpb = $app = (new Application)->getInstance();

// require_once PLUGIN_BASE_PATH . '../database/migrations/2014_10_12_000000_create_custom_options_table.php';

// with(new CreateCustomOptionsTable)->up();


global $wpb;

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    CodexShaper\App\Http\Kernel::class
);
$app->singleton(
    \Illuminate\Contracts\Debug\ExceptionHandler::class,
    \CodexShaper\App\Exceptions\Handler::class
);

if(\CodexShaper\WP\Support\Facades\Route::exists(\Illuminate\Http\Request::capture())) {
	try {

		$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

		$response = $kernel->handle(
		    $request = Illuminate\Http\Request::capture()
		);

		$response->send();

	} catch(\Exception $ex) {
		if(! \CodexShaper\WP\Support\Facades\Route::current()) {
			return true;
		}
		throw new \Exception($ex, 1);
	}
}

