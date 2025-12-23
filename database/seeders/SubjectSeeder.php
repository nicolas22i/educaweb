<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use Faker\Factory as Faker;
use App\Models\Course;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create(); // ✅ Aquí está la clave

        $courses = Course::all();

        foreach ($courses as $course) {
            for ($i = 1; $i <= 3; $i++) {
                Subject::create([
                    'name' => "Asignatura $i",
                    'course_id' => $course->id,
                    'description' => $faker->sentence(10),
                ]);
            }
        }
    }
}
