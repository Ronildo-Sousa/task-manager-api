<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::post('/register', RegisterUserController::class)->name('register');    
    Route::post('/login', [AuthController::class, 'login'])->name('login');    
});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});