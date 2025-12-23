<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $teacherUsers = User::where('role', 'teacher')->get();

        foreach ($teacherUsers as $user) {
            Teacher::create([
                'user_id' => $user->id,
                'teacher_code' => Str::upper(Str::random(6)), // Ejemplo: código aleatorio como 'K9T3GH'
                'specialization' => 'General', // Ejemplo: especialización general
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);
        }
    }
}