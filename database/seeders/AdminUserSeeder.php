<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (! is_string($email)
            || filter_var($email, FILTER_VALIDATE_EMAIL) === false
            || ! is_string($password)
            || $password === ''
        ) {
            throw new RuntimeException('Set ADMIN_EMAIL and ADMIN_PASSWORD before seeding the admin account.');
        }

        if (app()->isProduction() && strlen($password) < 12) {
            throw new RuntimeException('ADMIN_PASSWORD must contain at least 12 characters in production.');
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->forceFill([
            'name' => config('admin.name'),
            'password' => $password,
            'is_admin' => true,
        ])->save();
    }
}
