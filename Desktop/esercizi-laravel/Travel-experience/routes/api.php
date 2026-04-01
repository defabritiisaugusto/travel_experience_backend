<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TravelPostsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;   

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to the API',
        'status' => 'success'
    ]);
});


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/travel-posts', TravelPostsController::class);
    Route::apiResource('/comments', CommentController::class);
    Route::apiResource('/likes', LikeController::class);
    Route::apiResource('/users', UserController::class);
});
