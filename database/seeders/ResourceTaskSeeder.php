<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceTaskSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Vaciar la tabla primero (opcional, solo si no hay datos importantes)
        DB::table('resource_task')->truncate();

        // 2. Obtener todas las tareas con sus asignaturas
        $tasks = Task::with('subject')->get();

        foreach ($tasks as $task) {
            // 3. Buscar recursos de la misma asignatura (1-3 por tarea)
            $resources = Resource::where('subject_id', $task->subject_id)
                              ->inRandomOrder()
                              ->limit(rand(1, 3))
                              ->pluck('id')
                              ->toArray();

            // 4. Preparar datos para insertar
            $attachments = [];
            foreach ($resources as $resource_id) {
                $attachments[] = [
                    'task_id'     => $task->id,
                    'resource_id' => $resource_id,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }

            // 5. Insertar masivamente (más eficiente que attach() individual)
            DB::table('resource_task')->insert($attachments);
        }
    }
}