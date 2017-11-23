<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::get('user', function () {
            return auth()->user();
        });

        Route::resource('ideas', 'IdeaController', [
           'only' => ['index', 'store', 'show', 'update', 'destroy'],
        ]);
    });

    Route::namespace('Auth')->group(function () {
        Route::post('register', 'RegisterController@register')->name('register');
        Route::post('login', 'LoginController@login')->name('login');
    });
});
