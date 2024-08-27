<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;


Route::post('register', [RegistrationController::class, 'register']);

Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
