<?php

use Modules\Advice\Http\Controllers\Client\AdviceController;
use Modules\Advice\Http\Controllers\Client\ChatController;

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
Route::group(['middleware' => 'api', 'language'], function()
{
    Route::name('client.')->group(function()
    {
        Route::controller(AdviceController::class)->prefix('/advice')->group(function()
        {
            Route::get('/list', 'list')->name('list');
            Route::get('/show/{id}', 'show')->name('show');
            Route::post('/store', 'store')->name('store');
            Route::post('/pay/{id}', 'pay')->name('pay');
            Route::post('/done/{id}', 'done')->name('done');
            Route::post('/review/{id}', 'review')->name('review');
            Route::post('/reject/{id}', 'reject')->name('reject');
        });
        Route::controller(ChatController::class)->prefix('/chat')->group(function()
        {
            Route::post('/store', 'store')->name('store');
        });
    });
});

