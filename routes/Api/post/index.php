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
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');

        Route::group(['prefix' => 'my-posts'], function () {
            Route::get('/{page}', 'getAllAuthPost')->name('auth.all');
            Route::get('/read/{page}', 'getOneAuthPost')->name('auth.one');
        });

        Route::group(['prefix' => 'moderator'], function () {
            Route::get('/{page}', 'getAllModerator')->name('moderator.all');
            Route::get('/read/{page}', 'getOneModerator')->name('moderator.one');
            Route::put('/aprove/{id}', 'aprove')->name('moderator.aprove');
            Route::put('/desaprove/{id}', 'desaprove')->name('moderator.desaprove');
            Route::delete('/destroy/{id}', 'destroy')->name('moderator.destroy');
        });
    });
});
