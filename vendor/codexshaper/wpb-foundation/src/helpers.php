<?php

use Codexshaper\WP\Application;
use Illuminate\Container\Container;

if (!function_exists('csrf_token')) {
    function csrf_token($action = 'wbp_nonce')
    {
        return wp_create_nonce($action);
    }
}

if (!function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param string|null $abstract
     * @param array       $parameters
     *
     * @return mixed|\Illuminate\Contracts\Foundation\Application
     */
    function app($abstract = null, array $parameters = [])
    {
        $app = new Application();
        var_dump($app->app);
        die();
        if (is_null($abstract) && $container != null) {
            return $container;
        }

        return Container::getInstance()->make($abstract, $parameters);
    }
}

if (!function_exists('config')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param array|string|null $key
     * @param mixed             $default
     *
     * @return mixed|\Illuminate\Config\Repository
     */
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }

        if (is_array($key)) {
            return app('config')->set($key);
        }

        return app('config')->get($key, $default);
    }
}

if (!function_exists('view')) {
    function view($view, $data = [], $mergeData = [])
    {
        global $wpb;

        if (!class_exists(\CodexShaper\Blade\View::class)) {
            throw new \Exception('View not resolved. Please install View');
        }

        return (new \CodexShaper\Blade\View([], '', $wpb))->make($view, $data = [], $mergeData = []);
    }
}
