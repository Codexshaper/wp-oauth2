<?php

namespace CodexShaper\Routing;


use CodexShaper\Routing\RouteCollection;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router as IlluminateRouter;
use Illuminate\Http\Request;


/**
 * @mixin \Illuminate\Routing\RouteRegistrar
 */
class Router extends IlluminateRouter
{
    

    /**
     * Create a new Router instance.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @param  \Illuminate\Container\Container|null  $container
     * @return void
     */
    public function __construct(Dispatcher $events, Container $container = null)
    {
        $this->events = $events;
        $this->routes = new RouteCollection;
        $this->container = $container ?: new Container;
    }

    public function exists(Request $request)
    {
        return $this->routes->match($request);
    }
}
