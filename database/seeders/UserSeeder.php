<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'name' => 'Admin Fintech',
                'email' => 'admin@fintech.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Executive Fintech',
                'email' => 'executive@fintech.com',
                'role' => 'executive',
            ],
            [
                'name' => 'Auditor Fintech',
                'email' => 'auditor@fintech.com',
                'role' => 'auditor',
            ],
            [
                'name' => 'Admin Bank',
                'email' => 'admin@bank.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Executive Bank',
                'email' => 'executive@bank.com',
                'role' => 'executive',
            ],
            [
                'name' => 'Auditor Bank',
                'email' => 'auditor@bank.com',
                'role' => 'auditor',
            ],
        ];

        $roles = [
            [
                'name' => 'admin',
            ],
            [
                'name' => 'auditor',
            ],
            [
                'name' => 'executive',
            ],
        ];

        DB::transaction(function () use ($users, $roles) {
            foreach($roles as $role) {
                $roles = Role::updateOrCreate($role);
            }

            foreach($users as $user) {
                $role = $user['role'];
                unset($user['role']);
                $user = User::updateOrCreate($user, [ 'password' => Hash::make('12345678')]);
                $user->syncRoles([$role]);
            }
        });
    }
}
