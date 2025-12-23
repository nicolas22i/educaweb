<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $subjects = Subject::all();

        foreach ($students as $student) {
            foreach ($subjects->where('course_id', $student->course_id) as $subject) {
                Grade::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'grade' => rand(20, 100) / 10,
                ]);
            }
        }
    }
}