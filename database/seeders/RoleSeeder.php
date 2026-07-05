<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the roles table with the three application roles.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'Head Admin', 'slug' => Role::HEAD_ADMIN],
            ['id' => 2, 'name' => 'Teacher',    'slug' => Role::TEACHER],
            ['id' => 3, 'name' => 'Student',    'slug' => Role::STUDENT],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
