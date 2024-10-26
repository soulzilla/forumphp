<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'permissions' => [
                    'platform.index' => 1,
                    'platform.systems.roles' => 1,
                ],
            ],
            [
                'name' => 'Moderator',
                'slug' => 'moderator',
                'permissions' => [
                    'platform.index' => 1,
                ],
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'permissions' => [
                ],
            ],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );
        }
    }
}
