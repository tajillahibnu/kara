<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\ComboMasterController;
use Modules\Pkl\Http\Controllers\Data\SiswaController;

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

// Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//     Route::get('management', fn (Request $request) => $request->user())->name('management');
// });


Route::group(['prefix' => 'dasi', 'middleware' => ['web', 'auth']], function () {
    Route::post('main-table', [SiswaController::class, 'mainTable'])->name('main-table');
    Route::post('store', [SiswaController::class, 'store'])->name('store');
    Route::post('update/{id}', [SiswaController::class, 'update'])->name('update');
    Route::post('delete', [SiswaController::class, 'delete'])->name('delete');
    Route::post('status', [SiswaController::class, 'status'])->name('status');
    Route::post('combo/{tipe}', [ComboMasterController::class, 'combo'])->name('combo');
});
