<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
});
