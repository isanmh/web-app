<?php

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\ProductApiController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Test API
Route::get('/test-api', function () {
    return response()->json([
        'status' => 200,
        'message' => 'Hai, ini adalah test API',
    ]);
});

// Endpoint API Products
Route::get('products', [ProductApiController::class, 'index']);
Route::get('products/{id}', [ProductApiController::class, 'show']);
Route::post('products', [ProductApiController::class, 'store']);
Route::put('products/{id}', [ProductApiController::class, 'update']);
Route::delete('products/{id}', [ProductApiController::class, 'destroy']);

// Auth Sanctum
Route::post('users/register', [AuthApiController::class, 'register']);
Route::post('users/login', [AuthApiController::class, 'login']);
// middleware auth:sanctum group
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', [AuthApiController::class, 'user']);
    Route::post('users/logout', [AuthApiController::class, 'logout']);
});
