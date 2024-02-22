<?php

header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

use Modules\Acl\Http\Controllers\Dashboard\AuthController;
use Modules\Acl\Http\Controllers\Dashboard\UserController;
use Modules\Acl\Http\Controllers\Dashboard\AdviserController;
use Modules\Acl\Http\Controllers\Dashboard\ClientController;
use Modules\Acl\Http\Controllers\Dashboard\RoleController;
use Modules\Acl\Http\Controllers\Dashboard\PermissionController;

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
        Route::prefix('/acl')->name('acl.')->group(function()
        {
            //auth
            Route::controller(AuthController::class)->prefix('/auth')->name('auth.')->group(function()
            {
                //login
                Route::post('/login', 'login')->name('login');
                //logout
                Route::post('/logout', 'logout')->name('logout');
                //get user
                Route::group(['middleware' => 'auth:dashboard'], function()
                {
                    Route::get('/get_user', 'getUserByToken')->name('token');
                });
            });
            Route::group(['middleware' => 'auth:dashboard'], function()
            {
                Route::apiresource('user', UserController::class)
                    ->parameters(['user' => 'id']);
                Route::controller(UserController::class)->prefix('/user')->name('user.')
                    ->group(function()
                    {
                        Route::get('/change_status/{id}', 'changeStatus')->name('status');
                    });
                Route::apiresource('role', RoleController::class)
                    ->parameters(['role' => 'id']);
                Route::controller(RoleController::class)->prefix('/role')->name('role.')
                    ->group(function()
                    {
                        Route::get('/change_status/{id}', 'changeStatus')->name('status');
                    });
                Route::apiresource('permission', PermissionController::class)
                    ->parameters(['permission' => 'id']);
                Route::controller(PermissionController::class)->prefix('/permission')->name('permission.')
                    ->group(function()
                    {
                        Route::get('/change_status/{id}', 'changeStatus')->name('status');
                    });
                Route::apiresource('adviser', AdviserController::class, ['except' => ['show']])
                    ->parameters(['adviser' => 'id']);
                Route::controller(AdviserController::class)->prefix('/adviser')->name('adviser.')
                    ->group(function()
                    {
                        Route::get('/profile/{id}', 'profile')->name('profile');
                        Route::get('/profile/report/{id}', 'report')->name('report.profile');
                        Route::get('/report', 'report')->name('report');
                        Route::get('/change_status/{id}', 'changeStatus')->name('status');
                    });
                Route::apiresource('client', ClientController::class, ['except' => ['show']])
                    ->parameters(['client' => 'id']);
                Route::controller(ClientController::class)->prefix('/client')->name('client.')
                    ->group(function()
                    {
                        Route::get('/report', 'report')->name('report');
                        Route::get('/change_status/{id}', 'changeStatus')->name('status');
                    });
            });
        });
    });
});
