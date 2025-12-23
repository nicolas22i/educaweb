<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ResourceFactory extends Factory
{
    public function definition(): array
    {
        // Crear PDF real
        Storage::makeDirectory('public/resources');
        $filename = 'resource_' . Str::random(10) . '.pdf';
        $filepath = 'resources/' . $filename;

        Pdf::loadHTML('<h1>Recurso Educativo</h1><p>Asignatura: ' . fake()->sentence(3) . '</p>')
           ->save(storage_path('app/public/' . $filepath));

        return [
            'teacher_id' => null, // Se asignará en el seeder
            'course_id' => null,
            'subject_id' => null,
            'title' => fake()->sentence(3),
            'file_path' => $filepath, // Ruta relativa (ej: 'resources/resource_abc123.pdf')
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
            'updated_at' => now(),
        ];
    }
}