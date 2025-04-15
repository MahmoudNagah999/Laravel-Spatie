<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    /** Auth Controller **/
    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout','logout');
        Route::get('/user', 'user');
    });

    /** User Controller **/
    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');

        Route::post('/{id}/status', 'toggleStatus');
        Route::post('/{id}/reset-password', 'resetPassword'); // reset password by admin
    });
});
