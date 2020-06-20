<?php

use CodexShaper\OAuth2\Server\Manager;
use CodexShaper\WP\Support\Facades\Route;


Route::get('test', function(){
    echo view('welcome');
    die();
});

Manager::routes();
