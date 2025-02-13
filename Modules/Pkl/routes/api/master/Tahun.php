<?php
use Illuminate\Support\Facades\Route;
use Modules\Panel\Http\Controllers\Master\TahunController;

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


Route::group(['prefix' => 'tahun', 'middleware' => ['web', 'auth']], function () {
    Route::post('main-table', [TahunController::class, 'mainTable'])->name('main-table');
    Route::post('store', [TahunController::class, 'store'])->name('store');
    Route::post('update/{id}', [TahunController::class, 'update'])->name('update');
    Route::post('delete', [TahunController::class, 'delete'])->name('delete');
});
