<?php

namespace Route\Api\Category\Index;

use App\Http\Controllers\Api\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::group([
    'controller' => CategoriesController::class,
    'prefix' => 'categories',
    'as' => 'categories.',
    'middleware' => 'auth.jwt',
], function () {
    Route::get('/{id}', 'get')->name('get');
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'delete')->name('delete');
});
