<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ColumnController;
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

    // Column routes
    Route::get('/boards/{board}/columns', [ColumnController::class, 'findAllColumns']);
    Route::get('/boards/{board}/columns/{column}', [ColumnController::class, 'findColumn']);
    Route::post('/boards/{board}/columns', [ColumnController::class, 'createColumn']);
    Route::put('/boards/{board}/columns/{column}', [ColumnController::class, 'updateColumn']);
    Route::delete('/boards/{board}/columns/{column}', [ColumnController::class, 'deleteColumn']);
});

