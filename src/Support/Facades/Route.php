<?php

namespace Codexshaper_Oauth_Server\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Route facade.
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/src/Support/Facades
 */

/**
 *  Route facade.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/src/Support/Facades
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Route extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return \Codexshaper_Oauth_Server\Router::class;
	}
}
