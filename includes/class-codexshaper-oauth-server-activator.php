<?php

use CodexShaper\OAuth2\Server\Manager;
use Illuminate\Filesystem\Filesystem;

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/includes
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Codexshaper_Oauth_Server_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		static::codexshaper_oauth_server_add_rewrite_authorization();
		// Migrate database
		Manager::migrate();
	}

	/**
	 * Add Authorization rule to .htaccess.
	 *
	 * @since    1.0.0
	 */
	public static function codexshaper_oauth_server_add_rewrite_authorization() {

		global $wp_rewrite;

		$wp_rewrite->add_rule( '(.*) - [E=HTTP_AUTHORIZATION:%1]', null );

		$wp_rewrite->wp_rewrite_rules();
		$wp_rewrite->flush_rules();

		flush_rewrite_rules();

		static::codexshaper_oauth_server_rewrite_auth_conditions();
	}

	/**
	 * Add Authorization condition to .htaccess.
	 *
	 * @since    1.0.0
	 */
	public static function codexshaper_oauth_server_rewrite_auth_conditions() {

		$filesystem = new Filesystem();
		$path       = __DIR__ . '/../../../../';
		$htaccess   = $filesystem->get( $path . '.htaccess' );

		// Check if our RewriteRule is present
		$needle  = 'RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]';
		$replace = 'RewriteCond %{HTTP:Authorization} ^(.*)';

		if ( false !== strpos( $htaccess, $needle ) ) {
			$htaccess = str_replace( $needle, $replace . "\n" . $needle, $htaccess );
		}

		$filesystem->put(
			$path . '.htaccess',
			$htaccess
		);
	}
}
