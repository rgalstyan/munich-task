<?php

namespace App\Services\Auth;


use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

final readonly class VerificationService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){
    }

    public function verify(Request $request, int $id, string $hash): array
    {
        try {
            $response = [
                'success' => true,
                'message' => 'Verify Successfully',
            ];

            if (! URL::hasValidSignature($request)) {
                $response['message'] =  'Invalid or expired verification link';
            }

            $user = $this->userRepository->find($id);

            if(!$user) {
                $response['message'] =  'User not found';
            } else {
                if (! hash_equals($hash, sha1($user->getEmailForVerification()))) {
                    $response['message'] = 'Invalid verification link';
                }

                if ($user->hasVerifiedEmail()) {
                    $response['message'] = 'Email already verified';
                }

                $user->markEmailAsVerified();
                return $response;
            }

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            Log::error($e->getMessage());
        }
        return $response;
    }
}
