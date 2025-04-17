<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\Absensi\IjinSiswaPKLController;
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


Route::group(['prefix' => 'ijin/pkl'], function () {
    Route::post('main-table', [IjinSiswaPKLController::class, 'mainTable'])->name('main-table');
    Route::post('store', [IjinSiswaPKLController::class, 'store'])->name('store');
    Route::post('update/{id}', [IjinSiswaPKLController::class, 'update'])->name('update');
    Route::post('delete', [IjinSiswaPKLController::class, 'delete'])->name('delete');
    Route::post('confirm', [IjinSiswaPKLController::class, 'proses'])->name('confirm');
});
