<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'me',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Pembina
        User::create([
            'name' => 'Pembina User',
            'email' => 'pembina',
            'username' => 'pembina',
            'password' => Hash::make('password'),
            'role' => 'pembina',
        ]);
        User::factory()->count(5)->create([
            'username' => 'pembina' . rand(1, 100),
            'role' => 'pembina'
        ]);

        // Students
        User::factory()->count(50)->create([
            'username' => 'student' . rand(1, 100),
            'role' => 'student'
        ]);
    }
}
