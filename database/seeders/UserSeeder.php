<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usersData = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => '12345678'
            ],
        ];
        foreach ($usersData as $userData) {
            $user = User::query()->create($userData);
            $user->assignRole('super-admin');
        }
    }
}
