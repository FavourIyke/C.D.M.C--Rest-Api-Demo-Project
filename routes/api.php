<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:api', 'throttle:5,1'])->group(function () {
      Route::get('posts', [PostController::class, 'index']); 
     Route::post('posts', [PostController::class, 'store']); 
     Route::get('posts/{id}', [PostController::class, 'show']); 
     Route::put('posts/{id}', [PostController::class, 'update']); 
     Route::delete('posts/{id}', [PostController::class, 'destroy']); 
});

