<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\PasswordResetTokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('users/login', [UserController::class, 'login']);

Route::post('users/forgotPassword', [PasswordResetTokenController::class, 'forgotPassword']);

Route::post('users/resetPassword', [PasswordResetTokenController::class, 'resetPassword']);

Route::post('users', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class, 'index']);

    Route::get('users/current', [UserController::class, 'show']);

    Route::put('users', [UserController::class, 'update']);

    Route::delete('users', [UserController::class, 'destroy']);
    
    Route::delete('users/logout', [UserController::class, 'logout']);
    
    Route::resource('clients', ClientController::class);
});



