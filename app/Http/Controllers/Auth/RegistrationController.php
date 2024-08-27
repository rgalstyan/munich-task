<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\RegistrationRequest;
use App\Http\Resources\User\UserResource;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;

final class RegistrationController extends Controller
{
    public function __construct(
        private readonly RegistrationService $registrationService,
    ) {}

    public function register(RegistrationRequest $request): JsonResponse|UserResource
    {
        $createdUser = $this->registrationService->register($request->validated());

        if ($createdUser) {
            $createdUser->sendEmailVerificationNotification();
            return UserResource::make($createdUser);
        }

        return $this->response400();
    }
}
