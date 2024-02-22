<?php

header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

use Illuminate\Support\Facades\Route;
use Modules\CoreData\Http\Controllers\Dashboard\LanguageController;
use Modules\CoreData\Http\Controllers\Dashboard\CategoryController;
use Modules\CoreData\Http\Controllers\Dashboard\CountryController;
use Modules\CoreData\Http\Controllers\Dashboard\CityController;
use Modules\CoreData\Http\Controllers\Dashboard\NationalityController;
use Modules\CoreData\Http\Controllers\Dashboard\SocialController;
use Modules\CoreData\Http\Controllers\Dashboard\StatusController;
use Modules\CoreData\Http\Controllers\Dashboard\PaymentController;
use Modules\CoreData\Http\Controllers\Dashboard\LabelController;
use Modules\CoreData\Http\Controllers\Dashboard\CommentController;
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
        Route::prefix('/coredata')->name('coredata.')->group(function () {
            Route::apiresource('language', LanguageController::class)
                ->parameters(['language' => 'id']);
            Route::controller(LanguageController::class)->prefix('/language')->name('language.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
            Route::apiresource('category', CategoryController::class)
                ->parameters(['category' => 'id']);
            Route::controller(CategoryController::class)->prefix('/category')->name('category.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
            Route::apiresource('country', CountryController::class)
                ->parameters(['country' => 'id']);
            Route::controller(CountryController::class)->prefix('/country')->name('country.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
            Route::apiresource('city', CityController::class)
                ->parameters(['city' => 'id']);
            Route::controller(CityController::class)->prefix('/city')->name('city.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
            Route::apiresource('nationality', NationalityController::class)
                ->parameters(['nationality' => 'id']);
            Route::controller(NationalityController::class)->prefix('/nationality')->name('nationality.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
            Route::apiresource('social', SocialController::class)
                ->parameters(['social' => 'id']);
            Route::controller(SocialController::class)->prefix('/social')->name('social.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
            Route::apiresource('status', StatusController::class)
                ->parameters(['status' => 'id']);
            Route::controller(StatusController::class)->prefix('/status')->name('status.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
            Route::apiresource('payment', PaymentController::class)
                ->parameters(['payment' => 'id']);
            Route::controller(PaymentController::class)->prefix('/payment')->name('payment.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
            Route::apiresource('label', LabelController::class)
                ->parameters(['label' => 'id']);
            Route::controller(LabelController::class)->prefix('/label')->name('label.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
            Route::apiresource('comment', CommentController::class)
                ->parameters(['comment' => 'id']);
            Route::controller(CommentController::class)->prefix('/comment')->name('comment.')
                ->group(function () {
                    Route::get('/change_status/{id}', 'changeStatus')->name('status');
                });
        });
    });
});
