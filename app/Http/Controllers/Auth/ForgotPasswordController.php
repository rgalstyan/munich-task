<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Services\ForgotPasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

final class ForgotPasswordController extends Controller
{
    public function __construct(
        private readonly ForgotPasswordService $forgotPasswordService
    ) {}

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink($request->validated());

        return $status === Password::RESET_LINK_SENT
            ? response()->json($status)
            : $this->response400();
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse|string
    {
        $validated = $request->validated();

        $status = $this->forgotPasswordService->resetPassword($validated);

        return $status === Password::PASSWORD_RESET
            ? $this->response200()
            : $this->response400();
    }
}
