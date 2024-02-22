<?php

use Modules\Accounting\Http\Controllers\Client\WalletController;

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
        Route::prefix('/wallet')->name('wallet.')->group(function()
        {
            Route::controller(WalletController::class)->group(function()
            {
                Route::get('/show', 'show')->name('show');
            });
        });
    });
});

