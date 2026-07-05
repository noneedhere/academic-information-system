<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed default user accounts for each role.
     */
    public function run(): void
    {
        $users = [
            [
                'role_id'  => 1,
                'name'     => 'Administrator',
                'username' => 'admin',
                'email'    => 'admin@siakad.test',
                'password' => Hash::make('password'),
            ],
            [
                'role_id'  => 2,
                'name'     => 'Demo Teacher',
                'username' => 'teacher',
                'email'    => 'teacher@siakad.test',
                'password' => Hash::make('password'),
            ],
            [
                'role_id'  => 3,
                'name'     => 'Demo Student',
                'username' => 'student',
                'email'    => 'student@siakad.test',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
