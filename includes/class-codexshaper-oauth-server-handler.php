<?php

use CodexShaper\OAuth2\Server\Http\Requests\ServerRequest;
use CodexShaper\OAuth2\Server\Manager;
use League\OAuth2\Server\Exception\OAuthServerException;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/admin
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Codexshaper_Oauth_Server_Handler {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Bypass authenticate user.
	 *
	 * @since    1.0.0
	 */
	public function codexshaper_bypass_user_for_oauth_authentication( $user_id ) {

		if ( $user_id && $user_id > 0 ) {
			return (int) $user_id;
		}

		$manager         = new Manager();
		$resource_server = $manager->getResourceServer();
		$request         = ServerRequest::getPsrServerRequest();

		try {
			$psr     = $resource_server->validateAuthenticatedRequest( $request );
			$user_id = $manager->validateUserForRequest( $psr );

			if ( $user_id ) {
				return (int) $user_id;
			}
		} catch ( OAuthServerException $e ) {
			return null;
		}

		return null;
	}

	/**
	 * Handle authentication errors.
	 *
	 * @since    1.0.0
	 */
	public function codexshaper_handle_authentication_errors( $result ) {

		return $result;

	}

}
