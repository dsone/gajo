<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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
    if (Auth::user()) {
        return redirect()->route('user-profile', [ 'user' => Auth::user()->name ]);
    } else {
        return view('welcome');
    }
})->name('index');
Route::get('/profile/{user}', [ ProfileController::class, 'index' ])->name('user-profile')->middleware('verified');