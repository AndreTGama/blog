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
    Route::post('/reset-password', 'sendEmailToResetPassword')->name('email.reset.password');
    Route::put('/reset-password', 'sendEmailToResetPassword')->name('reset.password');

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::group(['prefix' => 'my-profile'], function () {
            Route::get('/', 'getProfileLoged')->name('my.profile.get');
            Route::put('/', 'updateProfileLoged')->name('my.profile.updte');
            Route::delete('/', 'deleteProfileLoged')->name('my.profile.delete');
            Route::delete('/destroy', 'destroyProfileLoged')->name('my.profile.put');
        });

        Route::get('/', 'getAll')->name('get.all');
        Route::get('/{id}', 'getOne')->name('get.one');
        Route::put('/{id}', 'update')->name('get.one.update');
        Route::delete('/{id}', 'delete')->name('get.one.update');
        Route::put('/restore/{id}', 'restore')->name('get.one.restore');
        Route::delete('/destroy/{id}', 'destroy')->name('get.one.update');
    });
});
