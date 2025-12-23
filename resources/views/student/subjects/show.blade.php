@extends('layouts.student')

@section('title', 'Detalle de Asignatura')

@section('dashboard-content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-4xl font-bold text-gray-800">{{ $grade->subject->name }}</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $grade->subject->description }}</p>
            <p class="text-gray-600">Curso: {{ $grade->subject->course->name ?? '—' }}</p>
        </div>
        <a href="{{ route('student.subjects') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a mis asignaturas
        </a>
    </div>

    <!-- Tarjeta de calificación principal -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 border border-gray-200">
        <div class="h-3 bg-gradient-to-r {{ $grade->grade >= 5 ? 'from-green-500 to-green-600' : 'from-red-500 to-red-600' }}"></div>
        <div class="p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Calificación Final</h3>
                    <p class="text-gray-500">Evaluación global de la asignatura</p>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-3xl font-bold {{ $grade->grade >= 5 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($grade->grade, 2) }}
                    </span>
                    <span class="text-sm px-3 py-1 rounded-full mt-1 {{ $grade->grade >= 5 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $grade->grade >= 5 ? 'Aprobado' : 'Suspenso' }}
                    </span>
                </div>
            </div>

            <!-- Desglose de criterios de evaluación (opcional) -->
            @if(isset($grade->evaluation_criteria) && $grade->evaluation_criteria)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="font-semibold text-gray-700 mb-3">Criterios de evaluación</h4>
                <div class="space-y-3">
                    @foreach(json_decode($grade->evaluation_criteria, true) ?? [] as $key => $value)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">{{ $key }}</span>
                        <span class="text-gray-800 font-medium">{{ $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Comentarios del profesor (opcional) -->
            @if(isset($grade->feedback) && $grade->feedback)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="font-semibold text-gray-700 mb-2">Comentarios del profesor</h4>
                <div class="bg-gray-50 p-4 rounded-lg text-gray-600">
                    {{ $grade->feedback }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Sección de tareas relacionadas con la asignatura -->
    <h3 class="text-xl font-bold text-gray-800 mb-4">Tareas realizadas</h3>
    
    @if($taskSubmissions->isEmpty())
        <div class="bg-white rounded-xl shadow-sm p-6 text-center border border-gray-200">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                </path>
            </svg>
            <p class="text-gray-600">No hay tareas entregadas para esta asignatura.</p>
        </div>
    @else
        <div class="overflow-hidden bg-white rounded-xl shadow-sm border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarea</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de entrega</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Calificación</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($taskSubmissions as $submission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="font-medium">{{ $submission->task->title }}</div>
                            <div class="text-gray-500 text-xs">{{ Str::limit($submission->task->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($submission->created_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($submission->grade !== null)
                                <span class="font-medium {{ $submission->grade >= 5 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($submission->grade, 2) }}
                                </span>
                            @else
                                <span class="text-yellow-500">
                                    Pendiente
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($submission->grade !== null)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->grade >= 5 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $submission->grade >= 5 ? 'Aprobado' : 'Suspenso' }}
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Sin calificar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-right">
                            <a href="{{ route('student.tasks.show', $submission->task) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if(count($taskSubmissions) > 0)
    <div class="mt-8 bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Evolución de calificaciones</h3>
            <div class="relative" style="height: 300px;">
                <canvas id="grafico-calificaciones" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('scripts')
@if(count($taskSubmissions) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener datos de calificaciones
        const tareas = @json($taskSubmissions->map(function($submission) {
            return [
                'title' => $submission->task->title,
                'grade' => $submission->grade ?? null,
                'date' => \Carbon\Carbon::parse($submission->created_at)->format('d/m/Y')
            ];
        }));
        
        // Filtrar tareas que tienen calificación
        const tareasCalificadas = tareas.filter(tarea => tarea.grade !== null);
        
        if (tareasCalificadas.length > 0) {
            const ctx = document.getElementById('grafico-calificaciones').getContext('2d');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: tareasCalificadas.map(t => t.title),
                    datasets: [{
                        label: 'Calificación',
                        data: tareasCalificadas.map(t => t.grade),
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.1,
                        pointBackgroundColor: tareasCalificadas.map(t => t.grade >= 5 ? 'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'),
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Calificación: ${context.raw}`;
                                },
                                afterLabel: function(context) {
                                    return `Fecha: ${tareasCalificadas[context.dataIndex].date}`;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endif
@endsection