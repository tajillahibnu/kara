<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\ComboMasterController;
use Modules\Pkl\Http\Controllers\Pkl\PriodePKLController;
use Modules\Pkl\Http\Controllers\Pkl\RegisterPklController;

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


Route::group(['prefix' => 'dudi', 'middleware' => ['web', 'auth']], function () {
    Route::post('main-table', [PriodePKLController::class, 'mainTable'])->name('main-table');
    Route::post('store', [PriodePKLController::class, 'store'])->name('store');
    Route::post('update/{id}', [PriodePKLController::class, 'update'])->name('update');
    Route::post('delete', [PriodePKLController::class, 'delete'])->name('delete');
    Route::post('status', [PriodePKLController::class, 'status'])->name('status');
});

Route::group(['prefix' => 'xxxxx', 'middleware' => []], function () {
    Route::post('main-table', [RegisterPklController::class, 'mainTable'])->name('main-table');
    Route::post('table-registrasi', [RegisterPklController::class, 'tableregistrasi'])->name('table-registrasi');
    Route::post('combosiswa', [RegisterPklController::class, 'combosiswa'])->name('combosiswa');
    Route::post('combopriode', [RegisterPklController::class, 'combopriode'])->name('combopriode');
    Route::post('register', [RegisterPklController::class, 'register_pkl'])->name('register');
    // Route::post('update/{id}', [RegisterPklController::class, 'update'])->name('update');
    // Route::post('delete', [RegisterPklController::class, 'delete'])->name('delete');
    // Route::post('status', [RegisterPklController::class, 'status'])->name('status');
    Route::post('combo/{tipe}', [ComboMasterController::class, 'combo'])->name('combo');
});
