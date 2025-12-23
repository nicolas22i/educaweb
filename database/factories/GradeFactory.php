<?php
// database/factories/GradeFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => null,
            'subject_id' => null,
            'grade' => $this->faker->randomFloat(1, 4, 10),
        ];
    }
}
