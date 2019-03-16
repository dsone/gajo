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
    if (\Auth::user()) {
        return redirect()->route('user-profile', [ 'user' => \Auth::user()->name ]);
    } else {
        return view('start.index');
    }
})->name('index');
Route::get('/profile/{user}', 'ProfileController@index')->name('user-profile');
Route::get('/profile/{user}/options', 'OptionsController@index')->name('user-options');
Route::get('/rss/{user}/{id}', 'ProfileController@rss')->name('user-rss');
Route::get('/privacy', function() { return view('page.privacy'); })->name('privacy');

Route::get('/home', function () { return redirect('/'); });

Auth::routes();

Route::get('/profile', function() {
    if (\Auth::user()) { return redirect()->route('user-profile', [ 'user' => \Auth::user()->name ]); }
    return redirect('/');
});

Route::any('{catchall}', function($page) { abort(404); })->where('catchall', '(.*)');