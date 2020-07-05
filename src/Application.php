<?php

namespace Codexshaper_Oauth_Server;

use Codexshaper_Oauth_Server\App\User;
use CodexShaper\Database\Database;
use CodexShaper\Database\Facades\DB;
use Codexshaper_Oauth_Server\Support\Facades\Config;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * Base Application.
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/src
 */

/**
 * Base Application.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/src
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Application {

	/**
	 * The application container.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      \Illuminate\Contracts\Container\Container    $app
	 */
	protected $app = null;

	/**
	 * The configuration object.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      \Codexshaper_Oauth_Server\Support\Facades\Config    $config
	 */
	protected $config;

	/**
	 * The database manager.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      \CodexShaper\Database\Database    $db
	 */
	protected $db;

	/**
	 * The options.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $options
	 */
	protected $options;

	/**
	 * The unique root path.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $root
	 */
	protected $root;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @param   array                                          $options The default options.
	 * @param   null|\Illuminate\Contracts\Container\Container $container Bind the container.
	 *
	 * @return  void
	 */
	public function __construct( $options = array(), ContainerInterface $container = null ) {
		$this->options = $options;

		$this->app = $container;

		if ( is_null( $this->app ) ) {
			$this->app = new Container();
			Facade::setFacadeApplication( $this->app );
			$this->app->instance( ContainerInterface::class, $this->app );
		}

		$this->app['app'] = $this->app;

		$this->root = __DIR__ . '/../../../../';

		if ( ! empty( $this->options ) && isset( $this->options['paths']['root'] ) ) {
			$this->root = rtrim( $this->options['paths']['root'], '/' ) . '/';
		}

		if ( ! isset( $this->app['root'] ) ) {
			$this->app['root'] = $this->root;
		}

		$this->config = new Config( $this->options );

		$this->setup_env();
		$this->register_config();
		$this->setup_database();
		$this->register_providers();
		$this->register_request();
		$this->register_router();
		$this->load_routes( $this->app['router'] );
	}

	/**
	 * Get the instance of \Illuminate\Contracts\Container\Container.
	 *
	 * @since     1.0.0
	 * @return    \Illuminate\Contracts\Container\Container
	 */
	public function instance() {
		if ( ! $this->app ) {
			return new self();
		}

		return $this->app;
	}

	/**
	 * Setup the app environment.
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	protected function setup_env() {
		$this->app['env'] = $this->config->get( 'app.env' );
	}

	/**
	 * Register the app config.
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	protected function register_config() {
		$this->app->bind(
			'config',
			function () {
				return array(
					'app'           => $this->config->get( 'app' ),
					'view.paths'    => $this->config->get( 'view.paths' ),
					'view.compiled' => $this->config->get( 'view.compiled' ),
				);
			},
			true
		);
	}

	/**
	 * Setup the database.
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	protected function setup_database() {
		global $wpdb;

		$this->db = new Database(
			array(
				'driver'    => 'mysql',
				'host'      => $wpdb->dbhost,
				'database'  => $wpdb->dbname,
				'username'  => $wpdb->dbuser,
				'password'  => $wpdb->dbpassword,
				'prefix'    => $wpdb->prefix,
				'charset'   => $wpdb->charset,
				'collation' => $wpdb->collate,
			)
		);

		$this->db->run();

		$this->app->singleton(
			'db',
			function () {
				return $this->db;
			}
		);
	}

	/**
	 * Register providers.
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	protected function register_providers() {
		$providers = $this->config->get( 'app.providers' );

		if ( $providers && count( $providers ) > 0 ) {
			foreach ( $providers as $provider ) {
				with( new $provider( $this->app ) )->register();
			}
		}
	}

	/**
	 * Register request.
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	protected function register_request() {
		$this->app->bind(
			Request::class,
			function ( $app ) {
				$request = Request::capture();
				$wp_user = wp_get_current_user();

				if ( $wp_user ) {
					$user = User::find( $wp_user->ID );
					$request->merge( array( 'user' => $user ) );
					$request->setUserResolver(
						function () use ( $user ) {
							return $user;
						}
					);
				}

				return $request;
			}
		);
	}

	/**
	 * Register router.
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	protected function register_router() {
		$this->app->instance( \Illuminate\Routing\Router::class, $this->app['router'] );
		$this->app->instance( \Codexshaper_Oauth_Server\Router::class, $this->app['router'] );
		$this->app->alias( 'Route', \Codexshaper_Oauth_Server\Support\Facades\Route::class );
	}

	/**
	 * Load all routes.
	 *
	 * @since     1.0.0
	 * @param   \Illuminate\Routing\Router $router The Router to load routes.
	 * @param   null|string                $dir This is the routes dir.
	 * @return    void
	 */
	public function load_routes( $router, $dir = null ) {
		if ( ! $dir ) {
			$dir = __DIR__ . '/../routes/';
		}

		require $dir . 'web.php';

		$router->group(
			array( 'prefix' => 'api' ),
			function () use ( $dir, $router ) {
				require $dir . 'api.php';
			}
		);
	}
}
