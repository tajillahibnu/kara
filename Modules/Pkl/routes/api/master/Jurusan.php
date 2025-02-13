<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\Master\JurusanController;

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

Route::group(['prefix' => 'jurusan', 'middleware' => ['web', 'auth']], function () {
    Route::post('main-table', [JurusanController::class, 'mainTable'])->name('main-table');
    Route::post('store', [JurusanController::class, 'store'])->name('store');
    Route::post('update/{id}', [JurusanController::class, 'update'])->name('update');
    Route::post('delete', [JurusanController::class, 'delete'])->name('delete');
    Route::post('status', [JurusanController::class, 'status'])->name('status');
});
