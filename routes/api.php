<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::resource('ideas', 'IdeaController', [
       'only' => ['index', 'store', 'show', 'update', 'destroy'],
    ]);
});
