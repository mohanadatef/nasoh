<?php

use Illuminate\Support\Facades\Route;
use Modules\CoreData\Http\Controllers\Adviser\LanguageController;
use Modules\CoreData\Http\Controllers\Adviser\CategoryController;
use Modules\CoreData\Http\Controllers\Adviser\CountryController;
use Modules\CoreData\Http\Controllers\Adviser\CityController;
use Modules\CoreData\Http\Controllers\Adviser\NationalityController;
use Modules\CoreData\Http\Controllers\Adviser\SocialController;
use Modules\CoreData\Http\Controllers\Adviser\StatusController;
use Modules\CoreData\Http\Controllers\Adviser\CommentController;
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
    Route::name('adviser.')->group(function () {
        Route::prefix('/coredata')->name('coredata.')->group(function () {
            Route::prefix('/language')->name('language.')->group(function () {
                Route::any('/list', [LanguageController::class, 'list'])->name('list');
            });
            Route::prefix('/category')->name('category.')->group(function () {
                Route::any('/list', [CategoryController::class, 'list'])->name('list');
                Route::any('/list/parent', [CategoryController::class, 'listParent'])->name('listParent');
            });
            Route::prefix('/country')->name('country.')->group(function () {
                Route::any('/list', [CountryController::class, 'list'])->name('list');
            });
            Route::prefix('/city')->name('city.')->group(function () {
                Route::any('/list', [CityController::class, 'list'])->name('list');
            });
            Route::prefix('/nationality')->name('nationality.')->group(function () {
                Route::any('/list', [NationalityController::class, 'list'])->name('list');
            });
            Route::prefix('/social')->name('social.')->group(function () {
                Route::any('/list', [SocialController::class, 'list'])->name('list');
            });
            Route::prefix('/status')->name('status.')->group(function () {
                Route::any('/list', [StatusController::class, 'list'])->name('list');
            });
            Route::prefix('/comment')->name('comment.')->group(function () {
                Route::any('/list', [CommentController::class, 'list'])->name('list');
            });
        });
    });
});
