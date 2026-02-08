<?php

use App\Http\Controllers\Category\CategoryController;
use Illuminate\Support\Facades\Route;


Route::bind('categoryRestore', function ($value) {
    return App\Models\Category::withTrashed()
        ->where('id', $value)
        ->firstOrFail();
});

Route::middleware('auth:sanctum')->prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index')->withoutMiddleware('auth:sanctum');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::put('/{categoryRestore}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
});
