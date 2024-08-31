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
                'name' => 'Alan',
                'email' => 'alandavidg13@gmail.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Executive',
                'email' => 'executive@gmail.com',
                'role' => 'executive',
            ],
            [
                'name' => 'Auditor #1',
                'email' => 'auditor@gmail.com',
                'role' => 'auditor',
            ],
            [
                'name' => 'Auditor #2',
                'email' => 'auditor2@gmail.com',
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
