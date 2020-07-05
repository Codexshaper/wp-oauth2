<?php

namespace CodexShaper\Composer;

use Composer\Script\Event;
use Symfony\Component\Process\Process;

/**
 * Run composer script after autoload dump.
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/src/Composer
 */

/**
 * Run composer script after autoload dump.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/src/Composer
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class ComposerScripts {

	/**
	 * Handle the post-install Composer event.
	 *
	 * @param  \Composer\Script\Event $event The composer event.
	 * @return void
	 */
	public static function post_install( Event $event ) {
		require_once $event->getComposer()->getConfig()->get( 'vendor-dir' ) . '/autoload.php';
	}

	/**
	 * Handle the post-update Composer event.
	 *
	 * @param  \Composer\Script\Event $event The composer event.
	 * @return void
	 */
	public static function post_update( Event $event ) {
		require_once $event->getComposer()->getConfig()->get( 'vendor-dir' ) . '/autoload.php';
	}

	/**
	 * Handle the post-autoload-dump Composer event.
	 *
	 * @param  \Composer\Script\Event $event The composer event.
	 * @return void
	 */
	public static function post_autoload_dump( Event $event ) {
		require_once $event->getComposer()->getConfig()->get( 'vendor-dir' ) . '/autoload.php';

		$dir  = $event->getComposer()->getConfig()->get( 'vendor-dir' ) . '/../';
		$root = dirname( $event->getComposer()->getConfig()->get( 'vendor-dir' ) );

		$vendor_name         = strtolower( basename( $root ) );
		$partials            = explode( '-', $vendor_name );
		$camel_case_partials = array();
		foreach ( $partials as $partial ) {
			$camel_case_partials[] = ucfirst( strtolower( $partial ) );
		}
		$camel_case = implode( '_', $camel_case_partials );
		$snake_case = implode( '_', $partials );

		$files = array(
			'/wpb.php',
			'/bootstrap/app.php',
			'/includes/class-wpb-activator.php',
			'/includes/class-wpb-deactivator.php',
			'/includes/class-wpb-i18n.php',
			'/includes/class-wpb-loader.php',
			'/includes/class-wpb.php',
			'/admin/class-wpb-admin.php',
			'/admin/class-wpb-admin-menu.php',
			'/admin/class-wpb-admin-submenu.php',
			'/admin/partials/wpb-admin-display.php',
			'/admin/css/wpb-admin.css',
			'/admin/js/wpb-admin.js',
			'/public/class-wpb-public.php',
			'/public/partials/wpb-public-display.php',
			'/public/css/wpb-public.css',
			'/public/js/wpb-public.js',
			'/routes/web.php',
			'/routes/api.php',
			'/resources/js/admin/main.js',
			'/resources/js/frontend/main.js',
			'/resources/js/spa/main.js',
			'/src/Application.php',
			'/src/helpers.php',
			'/src/Support/Facades/Config.php',
			'/src/Support/Facades/Route.php',
			'/src/Http/Kernel.php',
			'/src/Http/Events/RequestHandler.php',
			'/src/Exceptions/Handler.php',
			'/app/User.php',
			'/app/Post.php',
			'/app/Http/Controllers/ProductController.php',
			'/app/Http/Middleware/AuthMiddleware.php',
			'/app/Http/Middleware/VerifyCsrfToken.php',
			'/app/Http/Kernel.php',
			'/app/Exceptions/Handler.php',
		);

		foreach ( $files as $file ) {
			$file = $root . $file;
			if ( file_exists( $file ) ) {
				$contents = file_get_contents( $file );
				$contents = str_replace( 'wpb_', $snake_case . '_', $contents );
				$contents = str_replace( 'wpb', $vendor_name, $contents );
				$contents = str_replace( 'WPB_APP_ROOT', strtoupper( $camel_case ) . '_APP_ROOT', $contents );
				$contents = str_replace( 'WPB_FILE', strtoupper( $camel_case ) . '_FILE', $contents );
				$contents = str_replace( 'WPB_PATH', strtoupper( $camel_case ) . '_PATH', $contents );
				$contents = str_replace( 'WPB_INCLUDES', strtoupper( $camel_case ) . '_INCLUDES', $contents );
				$contents = str_replace( 'WPB_URL', strtoupper( $camel_case ) . '_URL', $contents );
				$contents = str_replace( 'WPB_ASSETS', strtoupper( $camel_case ) . '_ASSETS', $contents );
				$contents = str_replace( 'WPB_VERSION', strtoupper( $camel_case ) . '_VERSION', $contents );
				$contents = str_replace( 'WPB', $camel_case, $contents );
				file_put_contents(
					$file,
					$contents
				);

				$dir           = dirname( $file );
				$file_name     = basename( $file );
				$new_file_name = str_replace( 'wpb', $vendor_name, $file_name );

				if ( $file_name !== $new_file_name ) {
					rename( $file, $dir . '/' . $new_file_name );
				}
			}
		}

		static::config_app( $root, $camel_case );
		// static::update_composer( $root, $camel_case );
	}

	/**
	 * Prepare configuration for app.
	 *
	 * @param  string $root The app root.
	 * @param  string $camel_case The composer event.
	 *
	 * @return void
	 */
	protected static function config_app( $root, $camel_case ) {
		$file = $root . '/bootstrap/app.php';
		if ( file_exists( $file ) ) {
			$contents = file_get_contents( $file );
			$contents = str_replace( 'WPB_APP_ROOT', strtoupper( $camel_case ) . '_APP_ROOT', $contents );
			file_put_contents(
				$file,
				$contents
			);

		}
	}

	/**
	 * Update composer.
	 *
	 * @param  string $root The app root.
	 * @param  string $camel_case The composer event.
	 *
	 * @return void
	 */
	protected static function update_composer( $root, $camel_case ) {
		$file = $root . '/composer.json';
		if ( file_exists( $file ) ) {
			$contents = file_get_contents( $file );
			$contents = str_replace( 'WPB', $camel_case, $contents );
			file_put_contents(
				$file,
				$contents
			);
		}
	}
}
