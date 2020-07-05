<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/maab16
 * @since             1.0.0
 * @package           Codexshaper_Oauth_Server
 *
 * @wordpress-plugin
 * Plugin Name:       WP Oauth2 Server
 * Plugin URI:        https://github.com/Codexshaper/wp-oauth2
 * Description:       Enbble full oauth2 authentication for your site.
 * Version:           1.0.1
 * Author:            CodexShaper
 * Author URI:        https://github.com/Codexshaper
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       codexshaper-oauth-server
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Application root directory.
if (!defined('CODEXSHAPER_OAUTH_SERVER_APP_ROOT')) {
	define( 'CODEXSHAPER_OAUTH_SERVER_APP_ROOT', __DIR__ );
}
// Worpress plugin builder file path.
if (!defined('CODEXSHAPER_OAUTH_SERVER_FILE')) {
	define( 'CODEXSHAPER_OAUTH_SERVER_FILE', __FILE__ );
}
// Worpress plugin builder directory path.
if (!defined('CODEXSHAPER_OAUTH_SERVER_PATH')) {
	define( 'CODEXSHAPER_OAUTH_SERVER_PATH', dirname( CODEXSHAPER_OAUTH_SERVER_FILE ) );
}
// Worpress plugin builder includes path.
if (!defined('CODEXSHAPER_OAUTH_SERVER_INCLUDES')) {
	define( 'CODEXSHAPER_OAUTH_SERVER_INCLUDES', CODEXSHAPER_OAUTH_SERVER_PATH . '/includes' );
}
// Worpress plugin builder url.
if (!defined('CODEXSHAPER_OAUTH_SERVER_URL')) {
	define( 'CODEXSHAPER_OAUTH_SERVER_URL', plugins_url( '', CODEXSHAPER_OAUTH_SERVER_FILE ) );
}
// Worpress plugin builder assets path.
if (!defined('CODEXSHAPER_OAUTH_SERVER_ASSETS')) {
	define( 'CODEXSHAPER_OAUTH_SERVER_ASSETS', CODEXSHAPER_OAUTH_SERVER_URL . '/public' );
}

require_once __DIR__.'/bootstrap/app.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CODEXSHAPER_OAUTH_SERVER_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-codexshaper-oauth-server-activator.php
 */
function codexshaper_oauth_server_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-codexshaper-oauth-server-activator.php';
	Codexshaper_Oauth_Server_Activator::activate();

	add_option('is_cos_activated', true);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-codexshaper-oauth-server-deactivator.php
 */
function codexshaper_oauth_server_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-codexshaper-oauth-server-deactivator.php';
	Codexshaper_Oauth_Server_Deactivator::deactivate();
	update_option('is_cos_activated', false);
}

register_activation_hook( __FILE__, 'codexshaper_oauth_server_activate' );
register_deactivation_hook( __FILE__, 'codexshaper_oauth_server_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-codexshaper-oauth-server.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function codexshaper_oauth_server_run() {

	$plugin = new Codexshaper_Oauth_Server();
	$plugin->run();

}
codexshaper_oauth_server_run();