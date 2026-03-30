<?php

use App\User\Infrastructure\Entrypoint\Http\CreateUserController;
use App\User\Infrastructure\Entrypoint\Http\DeleteUserController;
use App\User\Infrastructure\Entrypoint\Http\GetUserController;
use App\User\Infrastructure\Entrypoint\Http\ListUsersController;
use App\User\Infrastructure\Entrypoint\Http\LoginController;
use App\User\Infrastructure\Entrypoint\Http\LogoutController;
use App\User\Infrastructure\Entrypoint\Http\GetMeController;
use App\User\Infrastructure\Entrypoint\Http\UpdateUserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', LogoutController::class);
    Route::get('/auth/me', GetMeController::class);
    Route::get('/users', ListUsersController::class);
    Route::post('/users', CreateUserController::class);
    Route::get('/users/{uuid}', GetUserController::class);
    Route::put('/users/{uuid}', UpdateUserController::class);
    Route::delete('/users/{uuid}', DeleteUserController::class);
});
