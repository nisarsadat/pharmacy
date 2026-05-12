<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'image' => null,
            'note' => 'System Admin',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'user@gmail.com',
            'username' => 'user1',
            'image' => null,
            'note' => 'Test account',
            'password' => Hash::make('123456'),
        ]);
    }
}