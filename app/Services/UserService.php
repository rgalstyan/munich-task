<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\SendVerificationLinkForeMailChange;
use App\Repository\MailChangeRequestRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Log;

final readonly class UserService
{
    public function __construct(
        private Mailer                               $mailer,
        private UserRepositoryInterface              $userRepository,
        private MailChangeRequestRepositoryInterface $mailChangeRequestRepository,
    ){
    }

    /**
     * @param array $data {
     *      first_name: ?string,
     *      last_name: ?string,
     *      email: ?string,
     * }
     * @return bool
     */
    public function updateProfile(array $data): bool
    {
        try {
            $userId = auth()->id();

            DB::beginTransaction();

            if(!empty($data['email'])) {
                $this->updateUserEmail($data['email'], $userId);
                unset($data['email']);
            }
            $this->userRepository->updateById($userId, $data);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
        return false;
    }

    private function updateUserEmail(string $email, int $userId): void
    {
        $hash = str_replace('/', '', Hash::make(now()->toDateTimeString()));
        $this->mailChangeRequestRepository->updateOrCreate(
            ['user_id' => $userId],
            [
                'email' => $email,
                'hash'  => $hash,
                'end_at' => now()->addDay()->toDateString(),
            ]
        );

        $this->mailer->to($email)
            ->send(new SendVerificationLinkForeMailChange([
                'subject' => config('app.name'),
                'hash'    => $hash,
            ]));
    }

    public function verifyNewEmail(string $hash): bool
    {
        try {
            $mailChangeRequest = $this->mailChangeRequestRepository->findWhere([
                'hash' => $hash,
            ])->first();
            if($mailChangeRequest) {
                if($mailChangeRequest->end_at >= now()->toDateString()) {
                    DB::beginTransaction();
                    $this->userRepository->updateById($mailChangeRequest->user_id, [
                        'email'             => $mailChangeRequest->email,
                        'email_verified_at' => now()->toDateTimeString(),
                    ]);
                    $mailChangeRequest->delete();
                    DB::commit();
                    return true;
                } else {
                    $mailChangeRequest->delete();
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }

        return false;
    }

    /**
     * @param array $data {
     *      password: string,
     *      new_password: string,
     * }
     * @return bool
     */
    public function changePassword(array $data): bool
    {
        $user = auth()->user();

        try {
            DB::beginTransaction();
            $user->fill([
                'password' => $data['new_password']
            ])->save();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }

        return false;
    }

    public function delete(): bool
    {
        try {
            DB::beginTransaction();
            $this->userRepository->delete(auth()->id());
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }

        return false;
    }
}
