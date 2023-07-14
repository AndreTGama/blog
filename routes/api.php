<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\UsersControllers;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('/', [UsersControllers::class, 'store'])->name('users.create');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/', [AuthController::class, 'login'])->name('auth.login');
});

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UsersControllers::class, 'getAll'])->name('users.get.all');
        Route::get('/my-profile', [UsersControllers::class, 'getProfileLoged'])->name('users.my.profile');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::post('/', [CategoriesController::class, 'store'])->name('categories.store');
    });

    Route::group(['prefix' => 'blog'], function () {

    });
});

