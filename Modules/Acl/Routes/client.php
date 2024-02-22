<?php

use Modules\Acl\Http\Controllers\Client\ClientController;
use Modules\Acl\Http\Controllers\Client\AuthController;
use Modules\Acl\Http\Controllers\Client\AdviserController;
use Modules\Acl\Http\Controllers\Client\RegisterMobileController;

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
        Route::prefix('/auth')->name('auth.')->group(function()
        {
            Route::controller(AuthController::class)->group(function()
            {
                //login
                Route::post('/getUserByMobile', 'getUserByMobile')->name('getUserByMobile');
                //logout
                Route::post('/logout', 'logout')->name('logout');
                //get user
                Route::get('/get_user', 'getUserByToken')->name('auth.token');
            });
            //register
            Route::post('/store', [ClientController::class, 'store'])->name('store');
        });
        Route::controller(RegisterMobileController::class)->prefix('/check_mobile')->name('check_mobile.')
            ->group(function()
            {
                Route::post('/cheek', 'store')->name('cheek_mobile');
                Route::post('/code', 'check')->name('cheek_code');
                Route::post('/resend', 'resend')->name('resend');
            });
        Route::controller(ClientController::class)->group(function()
        {
            Route::get('/profile/{id}', 'profile')->name('profile');
            Route::post('/update', 'update')->name('update');
        });
        Route::controller(AdviserController::class)->prefix('/adviser')->group(function()
        {
            Route::any('/list', 'list')->name('list');
            Route::get('/profile/{id}', 'profile')->name('profile');
            Route::get('/setting', 'changeSetting')->name('setting');
        });
    });
});

