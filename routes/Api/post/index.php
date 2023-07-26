<?php

namespace Route\Api\Post\Index;

use App\Http\Controllers\Api\PostsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'controller' => PostsController::class,
    'prefix' => 'posts',
    'as' => 'posts.',
], function () {

    Route::get('/{page}', 'getAll')->name('get.all');
    Route::get('/read/{id}', 'getOne')->name('get.one');

    Route::group(['middleware' => 'auth.jwt'], function () {

        Route::post('/', 'store')->name('create');
        Route::group(['prefix' => 'my-posts'], function () {

        });

        Route::group(['prefix' => 'moderator'], function () {
            Route::get('/{page}', 'getAllModerator')->name('get.moderator.all');
            Route::get('/read/{page}', 'getOneModerator')->name('get.moderator.one');
            Route::put('/aprove/{id}', 'aprove')->name('get.moderator.aprove');
            Route::put('/desaprove/{id}', 'desaprove')->name('get.moderator.desaprove');
        });
    });
});
