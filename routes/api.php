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
    Route::group(['as' => 'roistat.', 'prefix' => 'roistat',], function () {
        Route::group(['as' => 'webhook.old', 'prefix' => 'webhook',], function () {
            Route::post('{amo}', function ($amo) {
                return redirect(route('api.amo.roistat.webhook', $amo));
            });
        });
    });
    Route::group(['as' => 'amo.', 'prefix' => 'amo'], function () {
        Route::post('auth', 'Api\AmoController@auth')
            ->name('auth');
        Route::group(['as' => 'roistat.',], function () {
            Route::post('{amo}/roistat/webhook', 'Api\RoistatController@webhook')
                ->name('webhook');
        });
    });
});
