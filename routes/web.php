<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OptionsController;


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

Route::get('/', function() {
	if (\Auth::user()) {
		return redirect()->route('user-profile', [ 'user' => \Auth::user()->name ], 301);
	}

	return view('welcome');
})->name('index');

Route::get('/rss/{token}', [ ProfileController::class, 'rss' ])->name('user-rss');

Route::group([ 'prefix' => '/profile' ], function() {
	Route::get('/{user}', [ ProfileController::class, 'index' ])->name('user-profile');

	Route::get('/{user}/options', [ OptionsController::class, 'index' ])->name('user-options')->middleware('auth');
});

Route::group([ 'prefix' => '/page' ], function() {
	Route::get('/privacy', function() { return view('page.privacy'); })->name('page-privacy');
});

Route::any('{catchall}', function($page) {
	return redirect()->route('index', 302);
})->where('catchall', '(.*)');