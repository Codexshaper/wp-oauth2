<?php
/**
 * This is the api routes file.
 *
 * You can declare your all api routes here.
 * Either $router object or Route facade
 *
 * @link       https://github.com/maab16
 * @since      1.0.0
 *
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/routes
 */

use Codexshaper_Oauth_Server\Support\Facades\Route;
use Illuminate\Http\Request;

/**
 * You can use either $router object or Route facate to create new route
 */

$router->get(
	'test',
	function( Request $request ) {
		echo 'API Test';
		die();
	}
);
