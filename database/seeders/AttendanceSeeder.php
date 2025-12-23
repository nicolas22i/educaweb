<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AttendanceSeeder extends Seeder
{
    // Probabilidades de cada estado
    private $statusProbabilities = [
        'present' => 70, // 70%
        'late' => 20,    // 20%
        'absent' => 10    // 10%
    ];

    public function run(): void
    {
        // Obtener todos los estudiantes con su curso
        $students = Student::with('course.subjects')->get();

        foreach ($students as $student) {
            // Verificar que el estudiante tiene curso y asignaturas
            if (!$student->course || $student->course->subjects->isEmpty()) {
                continue;
            }

            // Por cada asignatura del curso del estudiante
            foreach ($student->course->subjects as $subject) {
                // Generar entre 8-12 registros de asistencia por asignatura
                $recordsCount = rand(8, 12);
                
                // Generar fechas únicas para este estudiante/asignatura
                $dates = $this->generateUniqueDates($recordsCount);
                
                foreach ($dates as $date) {
                    Attendance::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'date' => $date,
                        'status' => $this->getRandomStatus(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Genera fechas escolares únicas (de lunes a viernes)
     */
    private function generateUniqueDates(int $count): array
    {
        $dates = [];
        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();

        while (count($dates) < $count) {
            $date = $this->generateSchoolDate($startDate, $endDate);
            
            // Asegurar fechas únicas
            if (!in_array($date, $dates)) {
                $dates[] = $date;
            }
        }

        return $dates;
    }

    /**
     * Genera una fecha escolar aleatoria (excluye fines de semana)
     */
    private function generateSchoolDate(Carbon $startDate, Carbon $endDate): string
    {
        do {
            $date = fake()->dateTimeBetween($startDate, $endDate)->format('Y-m-d');
            $dayOfWeek = date('N', strtotime($date));
        } while ($dayOfWeek >= 6); // 6 = sábado, 7 = domingo

        return $date;
    }

    /**
     * Devuelve un estado de asistencia aleatorio según probabilidades
     */
    private function getRandomStatus(): string
    {
        $rand = rand(1, 100);
        $cumulative = 0;

        foreach ($this->statusProbabilities as $status => $probability) {
            $cumulative += $probability;
            if ($rand <= $cumulative) {
                return $status;
            }
        }

        return 'present'; // Por defecto
    }
}