<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Teacher;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::all();
        foreach ($teachers as $index => $teacher) {
            Course::create([
                'name' => "Curso " . ($index + 1),
                'teacher_id' => $teacher->id,
                'academic_year' => '2024-2025'
            ]);
        }
    }
}