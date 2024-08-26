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

        $userData = [
            'name' => 'Alan',
            'email' => 'alandavidg13@gmail.com',
        ];

        $valuesToUpdate = [
            'password' => Hash::make('12345678'),
        ];

        User::updateOrCreate($userData, $valuesToUpdate);
    }
}
