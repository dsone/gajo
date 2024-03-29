<?php

use App\Http\Controllers\EntryController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\RSSController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => '/v1', 'middleware' => ['auth']], function () {
    Route::put('/{user}/options', [OptionsController::class, 'update'])->name('user-options-update');

    Route::get('/options/rss', [RSSController::class, 'changeToken'])->name('api-refresh-rss');

    Route::post('/type/order', [TypeController::class, 'order'])->name('api-type-order');
    Route::post('/type', [TypeController::class, 'store'])->name('api-type-store');
    Route::put('/type', [TypeController::class, 'update'])->name('api-type-update');
    Route::delete('/type', [TypeController::class, 'destroy'])->name('api-type-destroy');

    Route::post('/entry', [EntryController::class, 'store'])->name('api-entry-store');
    Route::put('/entry', [EntryController::class, 'update'])->name('api-entry-update');
    Route::delete('/entry', [EntryController::class, 'destroy'])->name('api-entry-destroy');
});
