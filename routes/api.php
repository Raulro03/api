<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('lists/categories', [CategoryController::class, 'list']);
Route::get('products/category/{category_id}', [ProductController::class, 'ProductByCategory']);
Route::get('products/tag/{tag_id}', [ProductController::class, 'ProductByTag']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('tags', TagController::class);
});

//Route::get('categories', [CategoryController::class, 'index']);
//Route::get('categories/{category}', [CategoryController::class, 'show']);
//Route::post('categories', [CategoryController::class, 'store']);
//Route::put('categories/{category}', [CategoryController::class, 'update']);
//Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
