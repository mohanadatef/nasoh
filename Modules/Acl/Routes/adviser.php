<?php

use Modules\Acl\Http\Controllers\Adviser\AdviserController;
use Modules\Acl\Http\Controllers\Adviser\AuthController;
use Modules\Acl\Http\Controllers\Adviser\RegisterMobileController;
use Modules\Acl\Http\Controllers\Adviser\ForgetPasswordController;
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
        Route::prefix('/auth')->name('auth.')->group(function () {
            //login
            Route::post('/login', [AuthController::class, 'login'])->name('login');
            //logout
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            //register
            Route::post('/store', [AdviserController::class, 'store'])->name('store');
            //get user
            Route::get('/get_user', [AuthController::class, 'getUserByToken'])->name('auth.token');
        });
        Route::prefix('/check_mobile')->name('check_mobile.')->group(function () {
            //forget_password
            Route::post('/cheek', [RegisterMobileController::class, 'store'])->name('cheek_mobile');
            Route::post('/code', [RegisterMobileController::class, 'check'])->name('cheek_code');
            Route::post('/resend', [RegisterMobileController::class, 'resend'])->name('resend');
        });
        Route::prefix('/forget_password')->name('forget_password.')->group(function () {
            //forget_password
            Route::post('/cheek', [ForgetPasswordController::class, 'store'])->name('cheek_email');
            Route::post('/code', [ForgetPasswordController::class, 'check'])->name('cheek_code');
            Route::post('/change_password', [ForgetPasswordController::class, 'changePassword'])->name('change_password');
        });
        Route::controller(AdviserController::class)->group(function()
        {
        Route::get('/profile/{id}',  'profile')->name('profile');
        Route::post('/update', 'update')->name('update');
        Route::delete('/social/delete/{id}', 'socialDelete')->name('social_delete');
        Route::delete('/document/delete/{id}', 'documentDelete')->name('document_delete');
        Route::get('/setting', 'changeSetting')->name('setting');
    });
    });
});

