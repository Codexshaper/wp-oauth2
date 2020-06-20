<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'oauth', 'namespace' => '\CodexShaper\OAuth2\Server\Http\Controllers'], function () {
    Route::post('token', 'ClientController@issueAccessToken');
    Route::get('authorize', 'AuthorizationController@authorize');

    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('clients', 'ClientController@all');
        Route::post('clients', 'ClientController@store');
        Route::put('clients', 'ClientController@update');
        Route::delete('clients', 'ClientController@destroy');

        // Refresh token
        Route::post('token/refresh', 'ClientController@issueAccessToken');
    });
});
