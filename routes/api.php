<?php

use CodexShaper\WP\Support\Facades\Route;

Route::get('test', function(){
	echo "API Test";
	die();
});