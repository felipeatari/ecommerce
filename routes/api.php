<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SkuController;
use App\Http\Controllers\Api\VariationController;
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

    Route::group(['prefix' => 'vatiations', 'as' => 'api.vatiations.'], function () {
        Route::get('/', [VariationController::class, 'index'])->name('index');
    });
    Route::group(['prefix' => 'vatiation', 'as' => 'api.vatiation.'], function () {
        Route::get('/{id}', [VariationController::class, 'show'])->name('show');
        Route::post('/', [VariationController::class, 'store'])->name('store');
        Route::put('/{id}', [VariationController::class, 'update'])->name('update');
        Route::delete('/{id}', [VariationController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'skus', 'as' => 'api.skus.'], function () {
        Route::get('/', [SkuController::class, 'index'])->name('index');
    });
    Route::group(['prefix' => 'sku', 'as' => 'api.sku.'], function () {
        Route::get('/{id}', [SkuController::class, 'show'])->name('show');
        Route::post('/', [SkuController::class, 'store'])->name('store');
        Route::put('/{id}', [SkuController::class, 'update'])->name('update');
        Route::delete('/{id}', [SkuController::class, 'destroy'])->name('destroy');
    });
});
