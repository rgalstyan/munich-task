<?php

namespace App\Services;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final readonly class RegistrationService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function register(array $validated): User|false
    {
        try {
            DB::beginTransaction();
            $user = $this->userRepository->create($validated);
            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('error', [
                'message' => $e->getMessage(),
            ]);
        }

        return false;
    }
}
