<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        
        // Crear 3 recursos por asignatura
        Subject::with('course')->each(function ($subject) {
            Resource::factory(3)->create([
                'teacher_id' => $subject->course->teacher_id,
                'course_id' => $subject->course_id,
                'subject_id' => $subject->id,
            ]);
        });
    }
}