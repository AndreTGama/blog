<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersControllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('/', [UsersControllers::class, 'store']);
});

Route::group(['middleware' => 'api','prefix' => 'auth'], function () {
    Route::post('/', [AuthController::class, 'login']);
});
