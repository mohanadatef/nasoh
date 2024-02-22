<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\Client\HomeSliderController;
use Modules\Setting\Http\Controllers\Client\PageController;
use Modules\Setting\Http\Controllers\Client\SettingController;
use Modules\Setting\Http\Controllers\Client\NotificationController;
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

Route::group(['middleware' => 'api', 'language'], function () {
    Route::name('client.')->group(function () {
        Route::prefix('/setting')->name('setting.')->group(function () {
            Route::prefix('/home_slider')->name('home_slider.')->group(function () {
                Route::any('/list', [HomeSliderController::class, 'list'])->name('list');
            });
            Route::prefix('/page')->name('page.')->group(function () {
                Route::any('/policy', [PageController::class, 'policyPage'])->name('policy');
            });
            Route::name('setting.')->group(function () {
                Route::any('/support', [SettingController::class, 'support'])->name('support');
            });
            Route::prefix('/notification')->name('notification.')->group(function()
            {
                Route::any('/list', [NotificationController::class, 'list'])->name('list');
            });
        });
    });
});
