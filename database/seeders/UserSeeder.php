<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //


        $users = [
            [
                'name' => 'entidad2',
                'email' => 'entidad2@gmail.com',
            ],
            [
                'name' => 'Alan',
                'email' => 'alandavidg13@gmail.com',
            ],
            [
                'name' => 'Auditor #1',
                'email' => 'auditor@gmail.com',
            ],
            [
                'name' => 'Auditor #2',
                'email' => 'auditor2@gmail.com',
            ],
        ];

        $valuesToUpdate = [
            'password' => Hash::make('12345678'),
        ];

        foreach($users as $user) {
            User::updateOrCreate($user, $valuesToUpdate);
        }

    }
}
