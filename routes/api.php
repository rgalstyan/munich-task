<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class)->except(['create', 'update', 'destroy']);

Route::group(['middleware' => ['auth:api', 'verified', 'all_users']], function () {
    Route::apiResource('products', ProductController::class);

    Route::get('profile', [UserController::class, 'profile'])->name('profile');

    Route::post('users/update-profile', [UserController::class, 'updateProfile']);
    Route::post('change-password', [UserController::class, 'changePassword'])->middleware(['update_password']);
    Route::post('users/delete', [UserController::class, 'delete']);
});

Route::get('email/verify-new/{hash}', [UserController::class, 'verifyNewEmail'])->name('mail-change');
