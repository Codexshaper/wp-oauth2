<?php

namespace CodexShaper\Blade;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerContract;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Illuminate\View\ViewServiceProvider;

class View
{
    /**
     * @var
     */
    protected $app;

    /**
     * @var
     */
    private $view;

    /**
     * @var
     */
    private $viewPaths;

    /**
     * @var
     */
    private $cachePath;

    /**
     * Create view factory instance if not exists.
     *
     * @param array                                          $views
     * @param string                                         $cache
     * @param \Illuminate\Contracts\Container\Container|null $container
     *
     * @return void
     */
    public function __construct($views = [], $cache = '', ContainerContract $container = null)
    {
        $this->app = $container;

        if (is_null($this->app)) {
            if (!is_array($views)) {
                $views = (array) $views;
            }

            $this->viewPaths = $views;
            $this->cachePath = $cache;

            $this->app = $container ?? new Container();
            Facade::setFacadeApplication($this->app);

            // Check this files, events and config is binding with shared or not. If not then bind
            $this->registerFileSystem();
            $this->registerEvents();
            $this->registerConfig();

            // Make sure files, events and config are register before call register
            with(new ViewServiceProvider($this->app))->register();
        }

        $this->view = $this->app['view'];
    }

    /**
     * Bind files calss if not exists.
     *
     * @return void
     */
    protected function registerFileSystem()
    {
        $this->app->bindIf('files', function () {
            return new Filesystem();
        }, true);
    }

    /**
     * Bind events calss if not exists.
     *
     * @return void
     */
    protected function registerEvents()
    {
        $this->app->bindIf('events', function () {
            return new Dispatcher();
        }, true);
    }

    /**
     * Bind config calss if not exists.
     *
     * @return void
     */
    protected function registerConfig()
    {
        if (!is_array($this->viewPaths)) {
            throw new \Exception('Views path must be array');
        }

        $self = $this;

        $this->app->bindIf('config', function () use ($self) {
            return [
                'view.paths'    => $self->viewPaths,
                'view.compiled' => $self->cachePath,
            ];
        }, true);
    }

    /**
     * Get blade compiler.
     *
     * @return \Illuminate\View\Compilers\BladeCompiler
     */
    public function blade()
    {
        return $this->app['blade.compiler'];
    }

    /**
     * Call view factory methods dynamically.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return \Illuminate\View\View|\BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (!method_exists(new self(), $method) && method_exists($this->view, $method)) {
            return call_user_func_array([$this->view, $method], $parameters);
        }

        return $this->$method(...$parameters);
    }

    /**
     * Call view factory methods statically.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return \Illuminate\View\View|\BadMethodCallException
     */
    public static function __callStatic($method, $parameters)
    {
        if (!method_exists(new static(), $method) && method_exists($this->view, $method)) {
            return forward_static_call_array([$this->view, $method], $parameters);
        }

        return (new static() )->$method(...$parameters);
    }
}
