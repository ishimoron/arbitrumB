<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('auth')->group(function() {
    Route::post('login', 'AuthController@login');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('sign-up', 'AuthController@signUp');

    Route::middleware('auth')->group(function() {
        Route::get('me', 'AuthController@me');
    });
});
