<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskSubmissionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'task_id' => null, // Se asignará en el seeder
            'student_id' => null, // Se asignará en el seeder
            'file_path' => 'submissions/'.Str::random(40).'.pdf',
            'comments' => rand(0, 1) ? $this->faker->sentence(10) : null,
            'score' => rand(0, 1) ? $this->faker->randomFloat(2, 0, 10) : null,
            'feedback' => rand(0, 1) ? $this->faker->paragraph(2) : null,
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}