@extends('layouts.teacher')

@section('title', 'Panel del Profesor')

@section('dashboard-content')
    <!-- Panel principal del profesor -->
    <div class="py-6" id="dashboard-content">
        <!-- Tarjetas de estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Estudiantes -->
            <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                <div class="p-5 bg-gradient-to-r from-blue-500 to-blue-600">
                    <div class="flex justify-between items-center">
                        <h2 class="text-white font-bold">Estudiantes</h2>
                        <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                            <i class="bi bi-people-fill text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="px-5 py-4">
                    <p class="text-4xl font-extrabold text-blue-600">{{ $students->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total de estudiantes</p>
                </div>
            </div>

            <!-- Asignaturas -->
            <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                <div class="p-5 bg-gradient-to-r from-purple-500 to-purple-600">
                    <div class="flex justify-between items-center">
                        <h2 class="text-white font-bold">Asignaturas</h2>
                        <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                            <i class="bi bi-journals text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="px-5 py-4">
                    <p class="text-4xl font-extrabold text-purple-600">{{ $subjects->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total de asignaturas</p>
                </div>
            </div>

            <!-- Recursos -->
            <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                <div class="p-5 bg-gradient-to-r from-yellow-500 to-yellow-600">
                    <div class="flex justify-between items-center">
                        <h2 class="text-white font-bold">Recursos</h2>
                        <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                            <i class="bi bi-archive text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="px-5 py-4">
                    <p class="text-4xl font-extrabold text-yellow-500">{{ $totalResources }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total de recursos</p>
                </div>
            </div>

            <!-- Nota Media -->
            <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                <div class="p-5 bg-gradient-to-r from-green-500 to-green-600">
                    <div class="flex justify-between items-center">
                        <h2 class="text-white font-bold">Nota Media</h2>
                        <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                            <i class="bi bi-bar-chart-line text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="px-5 py-4">
                    <p class="text-4xl font-extrabold text-green-600">{{ number_format($averageGrade, 2) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Promedio de calificaciones</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- GRÁFICO DE NOTAS POR ASIGNATURA -->
            <div class="bg-white rounded-xl shadow-lg lg:col-span-2 overflow-hidden">
                <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Promedio de notas por asignatura</h3>
                    <div class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-medium">
                        Vista general
                    </div>
                </div>
                <div class="p-6">
                    <div class="relative h-64">
                        <canvas id="gradesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- ALERTA DE NOTAS BAJAS -->
            <div class="lg:col-span-1">
    @if ($lowGradeStudents->count())
        <div class="bg-white rounded-xl shadow-lg overflow-hidden h-full">
            <div class="p-5 bg-gradient-to-r from-red-500 to-red-600">
                <div class="flex justify-between items-center">
                    <h2 class="text-white font-bold">Alumnos con nota < 5</h2>
                    <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                        <i class="bi bi-exclamation-triangle-fill text-white"></i>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <ul class="space-y-3">
                    @foreach ($lowGradeStudents as $student)
                        <li class="p-3 rounded-lg border border-red-100 hover:bg-red-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <!-- Imagen de perfil del estudiante -->
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden">
                                        <img 
                                            src="{{ $student->user->profile_image ? asset($student->user->profile_image) : asset('images/avatar-placeholder.png') }}"
                                            alt="{{ $student->user->name }}"
                                            class="h-full w-full object-cover"
                                            onerror="this.onerror=null; this.src='{{ asset('images/avatar-placeholder.png') }}'"
                                        >
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $student->user->name }}</span>
                                </div>
                                <span class="font-bold text-red-600">{{ number_format($student->average_grade, 2) }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @else
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden h-full">
                        <div class="p-5 bg-gradient-to-r from-green-500 to-green-600">
                            <div class="flex justify-between items-center">
                                <h2 class="text-white font-bold">Rendimiento de estudiantes</h2>
                                <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                                    <i class="bi bi-check-circle-fill text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col items-center justify-center text-center">
                            <div class="bg-green-100 rounded-full p-4 mb-4">
                                <i class="bi bi-emoji-smile text-3xl text-green-600"></i>
                            </div>
                            <h4 class="text-lg font-medium text-gray-800 mb-2">¡Excelente trabajo!</h4>
                            <p class="text-gray-600">Todos los estudiantes tienen un promedio superior a 5.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar el gráfico con animación
            const ctx = document.getElementById('gradesChart');
            
            // Configurar los colores para las barras
            const createGradient = (ctx, subject, index) => {
                const colors = [
                    ['#3B82F6', '#2563EB'], // azul
                    ['#8B5CF6', '#7C3AED'], // morado
                    ['#EC4899', '#DB2777'], // rosa
                    ['#F59E0B', '#D97706'], // naranja
                    ['#10B981', '#059669']  // verde
                ];
                
                const colorIndex = index % colors.length;
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, colors[colorIndex][0]);
                gradient.addColorStop(1, colors[colorIndex][1]);
                return gradient;
            };
            
            // Obtener los datos
            const labels = {!! json_encode($gradeChartData->pluck('subject')) !!};
            const data = {!! json_encode($gradeChartData->pluck('average')) !!};
            
            // Crear los colores para cada barra
            const backgroundColors = [];
            for (let i = 0; i < labels.length; i++) {
                backgroundColors.push(createGradient(ctx.getContext('2d'), labels[i], i));
            }
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Nota media',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderRadius: 6,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10,
                            grid: {
                                display: true,
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(53, 162, 235, 0.9)',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            },
                            padding: 10,
                            cornerRadius: 6,
                            displayColors: false
                        }
                    },
                    layout: {
                        padding: {
                            top: 10
                        }
                    }
                }
            });
        });
    </script>
@endsection