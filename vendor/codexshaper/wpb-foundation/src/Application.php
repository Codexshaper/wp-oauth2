<?php

namespace CodexShaper\WP;

use CodexShaper\App\User;
use CodexShaper\Database\Database;
use CodexShaper\Database\Facades\DB;
use CodexShaper\WP\Support\Facades\Config;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

class Application
{
    /**
     * @var app
     */
    protected $app = null;

    /**
     * @var config
     */
    protected $config;

    /**
     * @var db
     */
    protected $db;

    public function __construct(ContainerInterface $container = null)
    {
        $this->config = new Config();
        $this->app = $container;

        if (is_null($this->app)) {
            $this->app = new Container();
            Facade::setFacadeApplication($this->app);
            $this->app->instance(ContainerInterface::class, $this->app);
        }

        $this->app['app'] = $this->app;

        $this->setupEnv();
        $this->registerConfig();
        $this->setupDatabase();
        $this->registerProviders();
        $this->registerRequest();
        $this->registerRouter();
        $this->loadRoutes();

        // $app['router']->aliasMiddleware('admin', CodexShaper\App\Http\Middleware\AuthMiddleware::class);
    }

    public function getInstance()
    {
        if (!$this->app) {
            return new self();
        }

        return $this->app;
    }

    protected function setupEnv()
    {
        $this->app['env'] = $this->config->get('app.env');
    }

    protected function registerConfig()
    {
        $this->app->bind('config', function () {
            return [
                'app'           => $this->config->get('app'),
                'view.paths'    => $this->config->get('view.paths'),
                'view.compiled' => $this->config->get('view.compiled'),
            ];
        }, true);
    }

    protected function setupDatabase()
    {
        global $wpdb;

        $this->db = new Database([
            'driver' 		    => 'mysql',
            'host' 			     => $wpdb->dbhost,
            'database' 		  => $wpdb->dbname,
            'username' 		  => $wpdb->dbuser,
            'password' 		  => $wpdb->dbpassword,
            'prefix'   		  => $wpdb->prefix,
            'charset'   		 => $wpdb->charset,
            'collation'   	=> $wpdb->collate,
        ]);

        $this->db->run();

        $this->app->singleton('db', function () {
            return $this->db;
        });
    }

    protected function registerProviders()
    {
        $providers = $this->config->get('app.providers');

        foreach ($providers as $provider) {
            with(new $provider($this->app))->register();
        }
    }

    protected function registerRequest()
    {
        $this->app->bind(Request::class, function ($app) {
            $request = Request::capture();

            if ($wp_user = wp_get_current_user()) {
                $user = User::find($wp_user->ID);
                $request->merge(['user' => $user]);
                $request->setUserResolver(function () use ($user) {
                    return $user;
                });
            }

            return $request;
        });
    }

    protected function registerRouter()
    {
        $this->app->instance(\Illuminate\Routing\Router::class, $this->app['router']);
        $this->app->alias('Route', \CodexShaper\WP\Support\Facades\Route::class);
    }

    protected function loadRoutes($dir = null)
    {
        if (!$dir) {
            $dir = PLUGIN_BASE_PATH.'../routes/';
        }
        // $app['router']->group(['middleware' => ['web']], function(){
        require $dir.'web.php';
        // });

        $this->app['router']->group(['prefix' => 'api'], function () use ($dir) {
            require $dir.'api.php';
        });

        $this->app['router']->group(['prefix' => 'wp-admin'], function () use ($dir) {
            require $dir.'admin.php';
        });
    }
}
