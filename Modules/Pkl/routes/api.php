<?php

use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\DashboardController;
use Modules\Pkl\Http\Controllers\MenuPageController;
use Modules\Pkl\Http\Controllers\PklController;
use Modules\Pkl\Http\Controllers\Profil\UserController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/


Route::group(['prefix' => 'pkl', 'middleware' => ['web', 'auth', 'PageAccess']], function () {
    Route::post('load-page', [MenuPageController::class, 'getMenuPage'])->name('load-page');
    Route::post('switch/module', [MenuPageController::class, 'switchModule'])->name('switch.module');
});



// Route::group(['prefix' => 'pkl', 'middleware' => ['web', 'auth','AccessLog']], function () {
Route::group(['prefix' => 'pkl', 'middleware' => ['web', 'auth']], function () {

    Route::post('dashboard/info', [DashboardController::class, 'show'])->name('dashboard.info');
    Route::post('profile/info', [UserController::class, 'info'])->name('profile.info');
    Route::post('profile/save', [UserController::class, 'update'])->name('profile.save');
    Route::post('profile/upload', [UserController::class, 'doUpload'])->name('profile.upload');

    Route::group(['prefix' => 'setting'], function () {
        require_once(__DIR__ . '/api/setting/app.php');
    });

    Route::group(['prefix' => 'data'], function () {
        require_once(__DIR__ . '/api/data/Pegawai.php');
        require_once(__DIR__ . '/api/data/Siswa.php');
        require_once(__DIR__ . '/api/data/Kelas.php');
    });

    Route::group(['prefix' => 'management'], function () {
        require_once(__DIR__ . '/api/management/mansi.php');
        require_once(__DIR__ . '/api/management/manpeg.php');
    });

    Route::group(['prefix' => 'master'], function () {
        require_once(__DIR__ . '/api/master/Dudi.php');
        require_once(__DIR__ . '/api/master/Jurusan.php');
        require_once(__DIR__ . '/api/master/Rombel.php');
    });

    Route::group(['prefix' => 'prakerin'], function () {
        require_once(__DIR__ . '/api/pkl.php');
    });
    Route::group(['prefix' => 'jurnal'], function () {
        require_once(__DIR__ . '/api/Jurnal.php');
    });
});
