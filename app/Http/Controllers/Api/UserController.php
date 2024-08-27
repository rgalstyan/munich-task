<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

final class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function profile(): UserResource
    {
        return UserResource::make(auth()->user());
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if($this->userService->updateProfile($validated)) {
            return $this->response200();
        }
        return $this->response400();
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        if($this->userService->changePassword($request->validated())) {
            return $this->response200();
        }
        return $this->response400();
    }

    public function verifyNewEmail(string $hash): JsonResponse
    {
        if($this->userService->verifyNewEmail($hash)) {
            return $this->response200();
        }
        return $this->response400();
    }

    public function delete(): JsonResponse
    {
        if($this->userService->delete()) {
            return $this->response200();
        }
        return $this->response400();
    }
}
