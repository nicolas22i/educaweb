<?php
// database/factories/SubjectFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'course_id' => null, // se asigna luego
        ];
    }
}
