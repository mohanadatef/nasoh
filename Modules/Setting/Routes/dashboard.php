<?php

header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\Dashboard\HomeSliderController;
use Modules\Setting\Http\Controllers\Dashboard\PageController;
use Modules\Setting\Http\Controllers\Dashboard\SettingController;
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
        Route::prefix('/setting')->name('setting.')->group(function () {
            Route::apiresource('home_slider', HomeSliderController::class)
                ->parameters(['home_slider' => 'id']);
            Route::controller(HomeSliderController::class)->prefix('/home_slider')->name('home_slider.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
            Route::apiresource('page', PageController::class)
                ->parameters(['page' => 'id']);
            Route::controller(PageController::class)->prefix('/page')->name('page.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
            Route::controller(SettingController::class)->prefix('/setting')->name('setting.')
                ->group(function () {
                    Route::get('/list', 'list')->name('list');
                    Route::post('/update', 'update')->name('update');
                });
        });
    });
});
