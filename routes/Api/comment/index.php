<?php

namespace Route\Api\Post\Index;

use App\Http\Controllers\Api\CommentsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'controller' => CommentsController::class,
    'as' => 'comments.',
    'middleware' => 'auth.jwt',
], function () {

    Route::group(['prefix' => 'my-comments'], function () {
        Route::post('/{idPost}', 'store')->name('create');
        Route::get('/{page}', 'getAllAuthComments')->name('auth.all');
        Route::get('/read/{idComment}', 'getOneAuthComments')->name('auth.one');
    });

    Route::group(['prefix' => 'moderator'], function () {
        Route::get('/{page}', 'getAllModerator')->name('moderator.all');
        Route::get('/read/{page}', 'getOneModerator')->name('moderator.one');
        Route::put('/aprove/{id}', 'aprove')->name('moderator.aprove');
        Route::put('/desaprove/{id}', 'desaprove')->name('moderator.desaprove');
        Route::delete('/destroy/{id}', 'destroy')->name('moderator.destroy');
    });
});
