<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    // Board routes
    Route::get('/boards', [BoardController::class, 'findAllBoards']);
    Route::get('/boards/{board}', [BoardController::class, 'findBoard']);
    Route::post('/boards', [BoardController::class, 'createBoard']);
    Route::put('/boards/{board}', [BoardController::class, 'updateBoard']);
    Route::delete('/boards/{board}', [BoardController::class, 'deleteBoard']);
});

