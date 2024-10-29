<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenExistMiddleware;

Route::get('/', [FrontController::class, 'index'])->name('main.page');
Route::get('/get-token', [FrontController::class, 'getToken'])->name('token.get');
Route::get('/show-more/{page}', [FrontController::class, 'showMore']);
Route::get('/register', [UserController::class, 'create'])
    ->name('register.page')
    ->middleware(TokenExistMiddleware::class);
Route::post('/register', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
