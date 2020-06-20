<?php

namespace CodexShaper\Routing;

use CodexShaper\Routing\Router;
use Illuminate\Routing\RoutingServiceProvider as IlluminateRoutingServiceProvider;

class RoutingServiceProvider extends IlluminateRoutingServiceProvider
{

    /**
     * Register the router instance.
     *
     * @return void
     */
    protected function registerRouter()
    {
        $this->app->singleton('router', function ($app) {
            return new Router($app['events'], $app);
        });
    }
}
