<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// api login
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

// product api
Route::apiResource('/api-product', App\Http\Controllers\Api\ProductController::class)->middleware('auth:sanctum');

// category api
Route::apiResource('/api-category', App\Http\Controllers\Api\CategoryController::class)->middleware('auth:sanctum');
