<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('/', [AuthController::class, 'login'])->name('auth.login');
});

Route::group([], base_path('routes/Api/user/index.php'));
Route::group([], base_path('routes/Api/category/index.php'));


Route::group(['middleware' => 'auth.jwt'], function () {
    Route::group(['prefix' => 'blog'], function () {

    });
});

