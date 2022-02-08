<?php

use App\User;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();

        // create roles
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'moderator',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'author',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'standard',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'artist',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'pro',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);

        // create permissions
        DB::table('permissions')->insert([
            [
                'name' => 'view admin dashboard',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'access reports',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'receive contact submissions',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'create unlimited releases',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'create releases',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'upload videos',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'add events',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'add merch',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);

        // assign permissions to roles
        DB::table('role_has_permissions')->insert([
            ['permission_id' => 1, 'role_id' => 1], // Admin can view admin dashboard
            ['permission_id' => 1, 'role_id' => 2], // Moderator can view admin dashboard

            ['permission_id' => 2, 'role_id' => 1], // Admin can access reports
            ['permission_id' => 2, 'role_id' => 2], // Mod can access reports

            ['permission_id' => 3, 'role_id' => 1], // Admin can receive contact submissions

            ['permission_id' => 4, 'role_id' => 1],
            ['permission_id' => 4, 'role_id' => 6],

            ['permission_id' => 5, 'role_id' => 1],
            ['permission_id' => 5, 'role_id' => 5],
            ['permission_id' => 5, 'role_id' => 6],

            ['permission_id' => 6, 'role_id' => 1],
            ['permission_id' => 6, 'role_id' => 6],

            ['permission_id' => 7, 'role_id' => 1],
            ['permission_id' => 7, 'role_id' => 6],

            ['permission_id' => 8, 'role_id' => 1],
            ['permission_id' => 8, 'role_id' => 6],
        ]);

        // create user / role relationships
        DB::table('model_has_roles')->insert([
            ['role_id' => 1, 'model_type' => 'user', 'model_id' => 1],
            ['role_id' => 4, 'model_type' => 'user', 'model_id' => 2],
            ['role_id' => 5, 'model_type' => 'user', 'model_id' => 3],
        ]);

        User::find(1)->assignRole('pro');
    }
}
