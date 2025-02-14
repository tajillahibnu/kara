<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\ComboMasterController;
use Modules\Pkl\Http\Controllers\Master\RombelController;

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

Route::group(['prefix' => 'rombel', 'middleware' => ['web', 'auth']], function () {
    Route::post('main-table', [RombelController::class, 'mainTable'])->name('main-table');
    Route::post('store', [RombelController::class, 'store'])->name('store');
    Route::post('update/{id}', [RombelController::class, 'update'])->name('update');
    Route::post('delete', [RombelController::class, 'delete'])->name('delete');
    Route::post('status', [RombelController::class, 'status'])->name('status');
    Route::post('combo/{tipe}', [ComboMasterController::class, 'combo'])->name('combo');
});
