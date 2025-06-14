<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@perpus.com',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN,
        ]);

        User::create([
            'name' => 'Petugas User',
            'email' => 'petugas@perpus.com',
            'password' => Hash::make('password'),
            'role' => UserRole::OFFICER,
        ]);

        User::create([
            'name' => 'Anggota User',
            'email' => 'anggota@perpus.com',
            'password' => Hash::make('password'),
            'role' => UserRole::MEMBER,
        ]);
    }
}