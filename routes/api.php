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

Route::group(['prefix' => '/v1'], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::post('/entry/change-visibility', 'EntryController@changeVisibility');
        Route::post('/entry/remove', 'EntryController@remove');
        
        Route::post('/entry', 'EntryController@store');
        Route::put('/entry', 'EntryController@update');

        Route::post('/options/save-type', 'TypeController@store');
        Route::delete('/options/type', 'TypeController@destroy');
        Route::put('/options/type', 'TypeController@update');
        Route::put('/options/type-order', 'TypeController@refreshOrder'); 
        
        Route::put('/options', 'OptionsController@update');
        Route::get('/options/refresh/rss', 'OptionsController@refreshRss');
    });
});
