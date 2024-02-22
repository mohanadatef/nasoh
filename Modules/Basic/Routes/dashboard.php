<?php

header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

use Modules\Basic\Http\Controllers\Dashboard\MediaController;
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

Route::group(['middleware' => 'api', 'language','auth:dashboard'], function () {
    Route::name('dashboard.')->group(function () {
        Route::prefix('/basic')->name('basic.')->group(function () {
            //media
            Route::prefix('/media')->group(function () {
                Route::delete('', [MediaController::class, 'destroy'])->name('destroy');
            });
        });
    });
});
