<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Dompu Aman',
            'email' => 'admin@dompuaman.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'last_login_at' => Carbon::now(), // Recently logged in
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'user@dompuaman.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'last_login_at' => Carbon::now()->subDays(5), // Active user
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'last_login_at' => Carbon::now()->subDays(45), // Inactive user
        ]);
    }
}
