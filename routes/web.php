<?php
/**
 * This is the web routes file.
 *
 * You can declare your all web routes here.
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
use CodexShaper\OAuth2\Server\Manager;

Route::group(
	array(
		'prefix'    => 'cos/oauth',
		'namespace' => '\CodexShaper\OAuth2\Server\Http\Controllers',
	),
	function () {
		Route::post( 'token', 'ClientController@issueAccessToken' );
		Route::get( 'authorize', 'AuthorizationController@authorize' );

		Route::group(
			array( 'middleware' => array( 'web', 'auth' ) ),
			function () {
				Route::get( 'clients', 'ClientController@all' );
				Route::post( 'clients', 'ClientController@store' );
				Route::put( 'clients', 'ClientController@update' );
				Route::delete( 'clients', 'ClientController@destroy' );

				// Refresh token.
				Route::post( 'token/refresh', 'ClientController@issueAccessToken' );
			}
		);
	}
);