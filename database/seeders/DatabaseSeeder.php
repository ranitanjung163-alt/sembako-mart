<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@sembakomart.com'],
            [
                'name' => 'Admin Sembako',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Buat Akun Staff
        User::updateOrCreate(
            ['email' => 'staff@sembakomart.com'],
            [
                'name' => 'Staff Sembako',
                'password' => Hash::make('password123'),
                'role' => 'staff',
            ]
        );

        // Buat Akun User
        User::updateOrCreate(
            ['email' => 'user@sembakomart.com'],
            [
                'name' => 'User Sembako',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );
    }
}