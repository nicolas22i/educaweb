<?php
// database/factories/StudentFactory.php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'student']),
            'student_code' => strtoupper($this->faker->bothify('ALUM###??')),
            'date_of_birth' => $this->faker->date('Y-m-d', '-10 years'),
            'phone_number' => $this->faker->phoneNumber(),
            'course_id' => null, // se setea luego en el seeder
        ];
    }
}
