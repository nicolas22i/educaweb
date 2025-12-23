<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class TaskSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        // Crear carpeta si no existe
        Storage::makeDirectory('submissions');

        $tasks = Task::with('subject.course.students')->get();

        foreach ($tasks as $task) {
            $students = $task->subject->course->students;
            $submissionCount = rand(5, min(10, $students->count()));

            foreach ($students->random($submissionCount) as $student) {
                // Generar PDF real
                $filename = 'entrega_' . Str::random(8) . '.pdf';
                $filepath = 'submissions/' . $filename;

                Pdf::loadHTML('<h1>Tarea: ' . $task->title . '</h1><p>Alumno: ' . $student->user->name . '</p>')
                   ->save(storage_path('app/public/' . $filepath));

                // Guardar en la base de datos
                $task->submissions()->create([
                    'student_id' => $student->id,
                    'file_path' => $filepath,
                    'text_response' => fake()->paragraph(),
                    'grade' => rand(0, 10),
                    'feedback' => fake()->randomElement(['Excelente', 'Aprobado', 'Necesita mejorar']),
                ]);
            }
        }
    }
}