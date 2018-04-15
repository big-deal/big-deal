<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::any('/register', function () {
    return redirect(route('login'))->with('status', [
        'message' => 'Registration disabled.',
        'reason' => 'danger',
    ]);
});

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

    /*
     * Companies
     */
    Route::resource('companies', 'CompanyController', [
        'except' => [
            'show',
        ],
    ]);
    Route::group(['as' => 'companies.', 'prefix' => 'companies'], function () {
        Route::group(['prefix' => '{company}'], function () {
            Route::match(['put', 'patch'], 'restore', 'CompanyController@restore')->name('restore');
            /*
             * Beeline
             */
            Route::resource('beelines', 'BeelineController', [
                'only' => [
                    'create',
                    'store',
                    'destroy',
                ],
            ]);
            /*
             * AmoCRM
             */
            Route::resource('amos', 'AmoController', [
                'only' => [
                    'create',
                    'store',
                    'edit',
                    'update',
                ],
            ]);
            Route::group(['as' => 'amos.', 'prefix' => 'amos/{amo}'], function () {
                Route::group(['as' => 'managers.', 'prefix' => 'managers'], function () {
                    Route::get('', 'AmoController@managersEdit')->name('edit');
                    Route::put('', 'AmoController@managersUpdate')->name('update');
                });
            });
        });
    });
});
