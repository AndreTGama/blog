<?php

use App\Http\Controllers\Api\UsersControllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('/', [UsersControllers::class, 'store']);
});
