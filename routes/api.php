<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersControllers;
use Illuminate\Support\Facades\Route;


Route::group([], base_path('routes/Api/user/index.php'));

Route::group(['prefix' => 'auth'], function () {
    Route::post('/', [AuthController::class, 'login'])->name('auth.login');
});

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::group([], base_path('routes/Api/category/index.php'));
    Route::group(['prefix' => 'blog'], function () {

    });
});

