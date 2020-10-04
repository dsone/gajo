<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\RSSController;

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

Route::group([ 'prefix' => '/v1', 'middleware' => [ 'auth' ] ], function () {
	Route::put('/{user}/options', [ OptionsController::class, 'update' ])->name('user-options-update')->middleware('auth');

	Route::get('/options/rss', [ RSSController::class, 'changeToken' ])->name('api-refresh-rss');
});