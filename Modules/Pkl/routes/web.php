<?php

use Illuminate\Support\Facades\Route;
use Modules\Pkl\Http\Controllers\Auth\MemberController;
use Modules\Pkl\Http\Controllers\PklController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::group([], function () {
//     Route::resource('pkl', PklController::class)->names('pkl');
// });

Route::group(['prefix' => 'pkl', 'middleware' => ['auth','MenuRolePkl','AppMetaPkl']], function () {
    Route::get('/', [PklController::class, 'index'])->name('/');
});

Route::group(['prefix' => 'pkl', 'middleware' => ['guest','AppMetaPkl']], function () {
    Route::get('login', [PklController::class, 'pageLogin'])->name('login');
});

Route::group(['prefix' => 'pkl'], function () {
    Route::get('logout', [MemberController::class, 'logout'])->name('pkl.logout');
    Route::post('do_login', [MemberController::class, 'do_login'])->name('pkl.do_login');
    Route::get('do_login', function () {
        return redirect('pkl');
    });
});