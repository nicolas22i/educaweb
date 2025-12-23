<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TeacherSeeder::class,
            CourseSeeder::class,
            SubjectSeeder::class,
            StudentSeeder::class,
            GradeSeeder::class,
            ResourceSeeder::class,
            AttendanceSeeder::class,
            TaskSeeder::class,
            TaskSubmissionSeeder::class,
            ResourceTaskSeeder::class,
        ]);
    }
}
