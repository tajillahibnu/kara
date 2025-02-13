<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\ComboMasterController;
use Modules\Pkl\Http\Controllers\Data\KelasController;

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


Route::group(['prefix' => 'dakel', 'middleware' => ['web', 'auth']], function () {
    Route::post('main-table', [KelasController::class, 'mainTable'])->name('main-table');
    Route::post('status', [KelasController::class, 'status'])->name('status');
    Route::post('combo/{tipe}', [ComboMasterController::class, 'combo'])->name('combo');
    Route::post('table-siswa', [KelasController::class, 'tableSiswa'])->name('table-siswa');
    Route::post('enrol-siswa', [KelasController::class, 'enrolSiswa'])->name('enrol-siswa');
});
