<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\Data\PegawaiController;

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


Route::group(['prefix' => 'dapeg', 'middleware' => ['web', 'auth']], function () {
    Route::post('main-table', [PegawaiController::class, 'mainTable'])->name('main-table');
    Route::post('store', [PegawaiController::class, 'store'])->name('store');
    Route::post('update/{id}', [PegawaiController::class, 'update'])->name('update');
    Route::post('delete', [PegawaiController::class, 'delete'])->name('delete');
    Route::post('status', [PegawaiController::class, 'status'])->name('status');
});
