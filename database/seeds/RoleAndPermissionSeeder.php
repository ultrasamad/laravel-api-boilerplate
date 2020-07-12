<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            [
                'name' => 'Super Admin',
                'guards' => ['web', 'api'],
                'permissions' => []
            ],
            [
                'name' => 'Admin',
                'guards' => ['web', 'api'],
                'permissions' => []
            ]
        ];

        $permissions = [
            [
                'name' => 'Create user',
                'guards' => ['web', 'api']
            ],
            [
                'name' => 'Update user',
                'guards' => ['web', 'api']
            ],
            [
                'name' => 'Delete user',
                'guards' => ['web', 'api']
            ],
            [
                'name' => 'Force delete user',
                'guards' => ['web', 'api']
            ]
        ];

        //Create roles
        foreach ($roles as $role) {
            foreach ($role['guards'] as $guard) {
                Role::firstOrCreate([
                    'name' => $role['name'],
                    'guard_name' => $guard
                ], []);
            }
        }

        //Create permissions
        foreach ($permissions as $permission) {
            foreach ($permission['guards'] as $guard) {
                Permission::firstOrCreate([
                    'name' => $permission['name'],
                    'guard_name' => $guard
                ], []);
            }
        }
    }
}
