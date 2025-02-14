<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\Master\DudiController;

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


Route::group(['prefix' => 'dudi', 'middleware' => ['web', 'auth']], function () {
    Route::post('main-table', [DudiController::class, 'mainTable'])->name('main-table');
    Route::post('store', [DudiController::class, 'store'])->name('store');
    Route::post('update/{id}', [DudiController::class, 'update'])->name('update');
    Route::post('delete', [DudiController::class, 'delete'])->name('delete');
    Route::post('status', [DudiController::class, 'status'])->name('status');
});
