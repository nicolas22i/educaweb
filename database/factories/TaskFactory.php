<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'subject_id' => null, // Se asignará en el seeder
            'teacher_id' => null, // Se asignará en el seeder
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'deadline' => $this->faker->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}