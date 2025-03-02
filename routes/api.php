<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'categories', 'as' => 'api.categories.'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
    });
    Route::group(['prefix' => 'category', 'as' => 'api.category.'], function () {
        Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'products', 'as' => 'api.products.'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
    });
    Route::group(['prefix' => 'product', 'as' => 'api.product.'], function () {
        Route::get('/{id}', [ProductController::class, 'show'])->name('show');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });
});
