<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\VerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class VerificationController extends Controller
{
    public function __construct(
        private readonly VerificationService $verificationService
    ){
    }

    public function verify(Request $request, int $id, string $hash): JsonResponse
    {
        $response = $this->verificationService->verify($request, $id, $hash);
        if($response['success']) {
            return $this->response200($response['message']);
        }

        return $this->response400($response['message']);
    }

    public function resend(): JsonResponse
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return $this->response400();
        }

        auth()->user()->sendEmailVerificationNotification();

        return $this->response200();
    }
}
