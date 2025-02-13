<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\ComboMasterController;
use Modules\Pkl\Http\Controllers\Management\PegawaiController;

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

Route::group(['prefix' => 'manpeg', 'middleware' => ['web', 'auth']], function () {
    Route::post('main-table', [PegawaiController::class, 'mainTable'])->name('main-table');
    Route::post('store', [PegawaiController::class, 'store'])->name('store');
    Route::post('update/{id}', [PegawaiController::class, 'update'])->name('update');
    Route::post('delete', [PegawaiController::class, 'delete'])->name('delete');
    Route::post('combo/{tipe}', [ComboMasterController::class, 'combo'])->name('combo');
});
