<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Profesores
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "Profesor $i",
                'email' => "profesor$i@gmail.com",
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]);
        }

        // Estudiantes
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => "Estudiante $i",
                'email' => "estudiante$i@gmail.com",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
        }
    }
}