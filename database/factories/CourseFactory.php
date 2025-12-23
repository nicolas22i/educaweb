<?php
// database/factories/CourseFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Curso ' . $this->faker->word(),
            'teacher_id' => null, // lo ponemos en el seeder
        ];
    }
}
