<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['as' => 'api.'], function () {
    Route::group(['as' => 'beeline.', 'prefix' => 'beeline'], function () {
        Route::group(['as' => 'webhook'], function () {
            Route::post('{beeline}/webhook', 'Api\BeelineController@webhook');
        });
    });
});
