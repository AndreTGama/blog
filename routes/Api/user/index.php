<?php

namespace Route\Api\User\Index;

use App\Http\Controllers\Api\UsersControllers;
use Illuminate\Support\Facades\Route;

Route::group([
    'controller' => UsersControllers::class,
    'prefix' => 'users',
    'as' => 'users.',
], function () {
    Route::post('/', 'store')->name('create');
    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::get('/', 'getAll')->name('get.all');
        Route::get('/my-profile', 'getProfileLoged')->name('my.profile');
        Route::put('/', 'getProfileLoged')->name('my.profile');
    });
});
