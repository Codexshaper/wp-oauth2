<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/includes
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Codexshaper_Oauth_Server {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Codexshaper_Oauth_Server_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->define_constants();

		if ( defined( 'CODEXSHAPER_OAUTH_SERVER_VERSION' ) ) {
			$this->version = CODEXSHAPER_OAUTH_SERVER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'codexshaper-oauth-server';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->register_assets();
		$this->define_oauth2_hooks();

		$menu              = new Codexshaper_Oauth_Server_Admin_Menu($this->plugin_name);
		$menu->page_title  = 'OAuth2 Server';
		$menu->menu_title  = 'OAuth2 Server';
		$menu->capability  = 'manage_options';
		$menu->slug        = 'codexshaper-oauth-server';
		$menu->callback    = function() {
				echo '<div class="wrap"><div id="codexshaper-oauth-server-admin" base-url="' . get_site_url() . '" csrf-token="' . codexshaper_oauth_server_csrf_token() . '"></div></div>';
		};
		$menu->icon        = 'dashicons-unlock';
		$menu->save();

		$submenu              = new Codexshaper_Oauth_Server_Admin_SubMenu($this->plugin_name);
		$submenu->parent_slug = $menu->slug;
		$submenu->page_title  = 'Clients';
		$submenu->menu_title  = 'Clients';
		$submenu->capability  = 'manage_options';
		$submenu->slug        = 'admin.php?page=' . $menu->slug . '#/clients';
		$submenu->save();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Codexshaper_Oauth_Server_Loader. Orchestrates the hooks of the plugin.
	 * - Codexshaper_Oauth_Server_i18n. Defines internationalization functionality.
	 * - Codexshaper_Oauth_Server_Admin. Defines all hooks for the admin area.
	 * - Codexshaper_Oauth_Server_Public. Defines all hooks for the public side of the site.
	 * - Codexshaper_Oauth_Server_Admin_Menu. Include admin menu.
	 * - Codexshaper_Oauth_Server_Admin_SubMenu. Include admin sub menu.
	 * - Codexshaper_Oauth_Server_Handler. Defines all hooks for the oauth server of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codexshaper-oauth-server-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codexshaper-oauth-server-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-codexshaper-oauth-server-admin.php';

		/**
		 * The class responsible for defining all menu actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-codexshaper-oauth-server-admin-menu.php';

		/**
		 * The class responsible for defining all submenu actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-codexshaper-oauth-server-admin-submenu.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-codexshaper-oauth-server-public.php';

		/**
		 * The class responsible for defining all actions that occur in the oauth2 implementation.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codexshaper-oauth-server-handler.php';

		$this->loader = new Codexshaper_Oauth_Server_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Codexshaper_Oauth_Server_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Codexshaper_Oauth_Server_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Codexshaper_Oauth_Server_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Codexshaper_Oauth_Server_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the oauth2
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_oauth2_hooks() {

		$plugin_oauth = new Codexshaper_Oauth_Server_Handler( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'determine_current_user', $plugin_oauth, 'codexshaper_bypass_user_for_oauth_authentication' );
		$this->loader->add_filter( 'rest_authentication_errors', $plugin_oauth, 'codexshaper_handle_authentication_errors' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Codexshaper_Oauth_Server_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Define the constants.
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'CODEXSHAPER_OAUTH_SERVER_VERSION', $this->version );
	}

	/**
	 * Register our app scripts and styles.
	 *
	 * @return void
	 */
	public function register_assets() {
		$this->register_scripts( $this->get_scripts() );
		$this->register_styles( $this->get_styles() );
	}

	/**
	 * Register scripts.
	 *
	 * @param  array $scripts
	 *
	 * @return void
	 */
	private function register_scripts( $scripts ) {
		foreach ( $scripts as $handle => $script ) {
			$deps      = isset( $script['deps'] ) ? $script['deps'] : false;
			$in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : false;
			$version   = isset( $script['version'] ) ? $script['version'] : CODEXSHAPER_OAUTH_SERVER_VERSION;

			wp_register_script( $handle, $script['src'], $deps, $version, $in_footer );
		}
	}

	/**
	 * Register styles.
	 *
	 * @param  array $styles
	 *
	 * @return void
	 */
	public function register_styles( $styles ) {
		foreach ( $styles as $handle => $style ) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : false;

			wp_register_style( $handle, $style['src'], $deps, CODEXSHAPER_OAUTH_SERVER_VERSION );
		}
	}

	/**
	 * Get all registered scripts.
	 *
	 * @return array
	 */
	public function get_scripts() {

		$prefix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.min' : '';

		$scripts = array(
			'codexshaper-oauth-server-runtime'  => array(
				'src'       => CODEXSHAPER_OAUTH_SERVER_ASSETS . '/js/runtime.js',
				'version'   => filemtime( CODEXSHAPER_OAUTH_SERVER_PATH . '/public/js/runtime.js' ),
				'in_footer' => true,
			),
			'codexshaper-oauth-server-vendor'   => array(
				'src'       => CODEXSHAPER_OAUTH_SERVER_ASSETS . '/js/vendors.js',
				'version'   => filemtime( CODEXSHAPER_OAUTH_SERVER_PATH . '/public/js/vendors.js' ),
				'in_footer' => true,
			),
			'codexshaper-oauth-server-frontend' => array(
				'src'       => CODEXSHAPER_OAUTH_SERVER_ASSETS . '/js/frontend.js',
				'deps'      => array( 'jquery', 'codexshaper-oauth-server-vendor', 'codexshaper-oauth-server-runtime' ),
				'version'   => filemtime( CODEXSHAPER_OAUTH_SERVER_PATH . '/public/js/frontend.js' ),
				'in_footer' => true,
			),
			'codexshaper-oauth-server-admin'    => array(
				'src'       => CODEXSHAPER_OAUTH_SERVER_ASSETS . '/js/admin.js',
				'deps'      => array( 'jquery', 'codexshaper-oauth-server-vendor', 'codexshaper-oauth-server-runtime' ),
				'version'   => filemtime( CODEXSHAPER_OAUTH_SERVER_PATH . '/public/js/admin.js' ),
				'in_footer' => true,
			),
			'codexshaper-oauth-server-spa'      => array(
				'src'       => CODEXSHAPER_OAUTH_SERVER_ASSETS . '/js/spa.js',
				'deps'      => array( 'jquery', 'codexshaper-oauth-server-vendor', 'codexshaper-oauth-server-runtime' ),
				'version'   => filemtime( CODEXSHAPER_OAUTH_SERVER_PATH . '/public/js/spa.js' ),
				'in_footer' => true,
			),
		);

		return $scripts;
	}

	/**
	 * Get registered styles.
	 *
	 * @return array
	 */
	public function get_styles() {

		$styles = array(
			'codexshaper-oauth-server-style'    => array(
				'src' => CODEXSHAPER_OAUTH_SERVER_ASSETS . '/css/style.css',
			),
			'codexshaper-oauth-server-frontend' => array(
				'src' => CODEXSHAPER_OAUTH_SERVER_ASSETS . '/css/frontend.css',
			),
			'codexshaper-oauth-server-admin'    => array(
				'src' => CODEXSHAPER_OAUTH_SERVER_ASSETS . '/css/admin.css',
			),
			'codexshaper-oauth-server-spa'      => array(
				'src' => CODEXSHAPER_OAUTH_SERVER_ASSETS . '/css/spa.css',
			),
			'codexshaper-oauth-server-vendors'  => array(
				'src' => CODEXSHAPER_OAUTH_SERVER_ASSETS . '/css/vendors.css',
			),
		);

		return $styles;
	}
}
