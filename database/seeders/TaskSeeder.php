<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = Subject::with('course.teacher')->get();

        foreach ($subjects as $subject) {
            // Verifica que la asignatura tenga curso y profesor
            if ($subject->course && $subject->course->teacher) {
                Task::factory()->count(rand(2, 4))->create([
                    'subject_id' => $subject->id,
                    'teacher_id' => $subject->course->teacher->id, // Asigna el teacher_id correcto
                ]);
            }
        }
    }
}