<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\ComboMasterController;
use Modules\Pkl\Http\Controllers\Setting\SekolahController;
use Modules\Pkl\Http\Controllers\Setting\UploadSiswaController;

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


Route::group(['prefix' => 'app'], function () {
    Route::post('read', [SekolahController::class, 'read'])->name('read');
    Route::post('update', [SekolahController::class, 'update'])->name('update');
});

Route::group(['prefix' => 'sekolah'], function () {
    Route::post('read', [SekolahController::class, 'read'])->name('read');
    Route::post('update', [SekolahController::class, 'update'])->name('update');
    Route::post('combo/{tipe}', [ComboMasterController::class, 'combo'])->name('combo');
});

Route::group(['prefix' => 'upload'], function () {
    Route::post('main-table', [UploadSiswaController::class, 'mainTable'])->name('main-table');
    Route::post('table-siswa', [UploadSiswaController::class, 'tableSiswa'])->name('table-siswa');
    Route::post('siswa', [UploadSiswaController::class, 'uploadSiswaJurusan'])->name('siswa');
    Route::post('read', [UploadSiswaController::class, 'read'])->name('read');
    Route::post('update', [UploadSiswaController::class, 'update'])->name('update');
    Route::post('delete', [UploadSiswaController::class, 'delete'])->name('delete');
    Route::post('combo/{tipe}', [ComboMasterController::class, 'combo'])->name('combo');
});