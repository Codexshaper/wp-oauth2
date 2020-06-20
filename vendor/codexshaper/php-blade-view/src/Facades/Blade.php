<?php

namespace CodexShaper\Blade\Facades;

use Illuminate\Support\Facades\Facade;

class Blade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'blade.compiler';
    }
}
