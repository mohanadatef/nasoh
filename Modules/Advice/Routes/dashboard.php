<?php

header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

use Modules\Advice\Http\Controllers\Dashboard\AdviceController;


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
    Route::name('dashboard.')->group(function()
    {
        Route::prefix('/advice')->name('advice.')->group(function()
        {
            Route::group(['middleware' => 'auth:dashboard'], function()
            {
                Route::apiresource('advice', AdviceController::class, ['except' => ['show']])
                    ->parameters(['advice' => 'id']);
                Route::controller(AdviceController::class)->prefix('/advice')->name('advice.')
                    ->group(function()
                    {
                        Route::get('/report', 'report')->name('report');
                    });
            });
        });
    });
});
