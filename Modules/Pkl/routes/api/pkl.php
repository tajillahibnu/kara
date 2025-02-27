<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\ComboMasterController;
use Modules\Pkl\Http\Controllers\Pkl\PriodePKLController;
use Modules\Pkl\Http\Controllers\Pkl\ProsesRegisterController;
use Modules\Pkl\Http\Controllers\Pkl\RegisterPklController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| File ini berisi daftar route untuk API yang digunakan dalam aplikasi.
| Semua route dalam file ini akan dimuat oleh RouteServiceProvider dalam
| grup yang ditentukan untuk middleware API atau Web.
|
| Struktur route dalam file ini:
| - Group 'priode': Mengelola periode PKL dengan middleware 'web' dan 'auth'
| - Group 'pendaftaranpkl': Mengelola pendaftaran PKL tanpa middleware tambahan
|
*/

/*
|--------------------------------------------------------------------------
| Routes untuk Manajemen Priode PKL
|--------------------------------------------------------------------------
|
| Route dalam grup ini digunakan untuk mengelola periode PKL.
| Semua route di sini membutuhkan autentikasi melalui middleware 'web' dan 'auth'.
|
*/

Route::group(['prefix' => 'priode', 'middleware' => []], function () {
    Route::post('main-table', [PriodePKLController::class, 'mainTable'])->name('main-table');
    Route::post('store', [PriodePKLController::class, 'store'])->name('store');
    Route::post('update/{id}', [PriodePKLController::class, 'update'])->name('update');
    Route::post('delete', [PriodePKLController::class, 'delete'])->name('delete');
    Route::post('status', [PriodePKLController::class, 'status'])->name('status');
    Route::post('combo/{tipe}', [ComboMasterController::class, 'combo'])->name('combo');
});

/*
|--------------------------------------------------------------------------
| Routes untuk Pendaftaran PKL
|--------------------------------------------------------------------------
|
| Route dalam grup ini digunakan untuk proses pendaftaran PKL.
| Tidak ada middleware tambahan yang diterapkan pada grup ini.
|
*/
Route::group(['prefix' => 'pendaftaranpkl', 'middleware' => []], function () {
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

Route::group(['prefix' => 'konfirmasipkl', 'middleware' => []], function () {
    Route::post('main-table', [ProsesRegisterController::class, 'mainTable'])->name('main-table');
    Route::post('confirmall', [ProsesRegisterController::class, 'proses'])->name('confirmall');
    // Route::post('table-registrasi', [RegisterPklController::class, 'tableregistrasi'])->name('table-registrasi');
    // Route::post('combosiswa', [RegisterPklController::class, 'combosiswa'])->name('combosiswa');
    // Route::post('combopriode', [RegisterPklController::class, 'combopriode'])->name('combopriode');
    // Route::post('register', [RegisterPklController::class, 'register_pkl'])->name('register');
    // // Route::post('update/{id}', [RegisterPklController::class, 'update'])->name('update');
    // // Route::post('status', [RegisterPklController::class, 'status'])->name('status');
    // Route::post('combo/{tipe}', [ComboMasterController::class, 'combo'])->name('combo');
});
