<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use App\Models\Course;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $studentUsers = User::where('role', 'student')->limit(20)->get();
        $courses = Course::all();
        $courseCount = $courses->count();

        foreach ($studentUsers as $index => $user) {
            $course = $courses[$index % $courseCount]; // Distribuye estudiantes entre cursos

            Student::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'student_code' => 'ALUMNO' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'date_of_birth' => $faker->dateTimeBetween('-25 years', '-15 years')->format('Y-m-d'),
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);
        }
    }
}