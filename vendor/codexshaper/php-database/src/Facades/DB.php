<?php

namespace CodexShaper\Database\Facades;

use CodexShaper\Database\Database;
use Illuminate\Support\Facades\Facade;

class DB extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
	    return Database::class;
	}
}