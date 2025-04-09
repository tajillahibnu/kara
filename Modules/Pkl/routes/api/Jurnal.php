<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\Jurnal\KegiatanController;

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


Route::group(['prefix' => 'kegiatan'], function () {
    Route::post('main-table', [KegiatanController::class, 'mainTable'])->name('main-table');
    Route::post('store', [KegiatanController::class, 'store'])->name('store');
    Route::post('update/{id}', [KegiatanController::class, 'update'])->name('update');
    Route::post('delete', [KegiatanController::class, 'delete'])->name('delete');
});
Route::group(['prefix' => 'kegiatan/karyawan'], function () {
    Route::post('main-table', [KegiatanController::class, 'mainTable'])->name('main-table');
    Route::post('store', [KegiatanController::class, 'store'])->name('store');
    Route::post('update/{id}', [KegiatanController::class, 'update'])->name('update');
    Route::post('delete', [KegiatanController::class, 'delete'])->name('delete');
});
