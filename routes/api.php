<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\UserController;
use App\Models\Order;

// Route pour récupérer les informations de l'utilisateur authentifié
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('api')->group(function () {
    Route::resource('categories', CategorieController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('items', ItemController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('users', UserController::class);
});
Route::put('/users/{id}', [UserController::class, 'update']);
Route::middleware('api')->group(function () {
    Route::resource('orders', OrderController::class);
});
Route::middleware('api')->group(function () {
    Route::resource('order_items', OrderItemController::class);
});