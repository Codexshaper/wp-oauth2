<?php

use Illuminate\Filesystem\Filesystem;

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/includes
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Codexshaper_Oauth_Server_Deactivator {

	/**
	 * Decativate plugin.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		static::update_authorization_rewrite_condition();
	}

	/**
	 * Reset authorization in .htaccess.
	 *
	 * @since    1.0.0
	 */
	protected static function update_authorization_rewrite_condition() {

		$filesystem = new Filesystem();
		$path       = __DIR__ . '/../../../../';
		$htaccess   = $filesystem->get( $path . '.htaccess' );

		$rules = explode( "\n", $htaccess );

		foreach ( $rules as $key => $search ) {
			if ( ( false !== strpos( $search, 'RewriteCond %{HTTP:Authorization} ^(.*)' ) ) || ( false !== strpos( $search, 'RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]' ) ) ) {
				unset( $rules[ $key ] );
			}
		}

		$filesystem->put(
			$path . '.htaccess',
			implode( "\n", $rules )
		);
	}

}
