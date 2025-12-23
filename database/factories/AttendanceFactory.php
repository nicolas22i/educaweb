<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['present', 'late', 'absent'];
        
        return [
            'student_id' => null, // Se asignará en el seeder
            'subject_id' => null,  // Se asignará en el seeder
            'date' => $this->faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
            'status' => $this->faker->randomElement($statuses),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}