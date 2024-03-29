<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function() {
    Route::group(['prefix' => 'cage', 'as' => 'cage.'], function() {
        Route::post('slaughter', 'CageController@slaughter')->name('slaughter');
    });

    Route::group(['prefix' => 'counter', 'as' => 'counter.'], function() {
        Route::post('stop', 'CounterController@start')->name('start');
    });

    Route::group(['prefix' => 'report', 'as' => 'report.'], function() {
        Route::get('generate', 'ReportController@generate')->name('generate');
    });
});