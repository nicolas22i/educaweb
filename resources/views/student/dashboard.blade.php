@extends('layouts.student')

@section('title', 'Mi Panel')

@section('dashboard-content')
    <!-- Panel principal del estudiante -->
    <div class="py-6" id="dashboard-content">
        <!-- Tarjetas de estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Asignaturas -->
            <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                <div class="p-5 bg-gradient-to-r from-purple-500 to-purple-600">
                    <div class="flex justify-between items-center">
                        <h2 class="text-white font-bold">Asignaturas</h2>
                        <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                            <i class="bi bi-journal-text text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="px-5 py-4">
                    <p class="text-4xl font-extrabold text-purple-600">{{ $subjects->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total de asignaturas matriculadas</p>
                </div>
            </div>

            <!-- Nota media -->
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
                    <p class="text-xs text-gray-500 mt-1">Promedio de calificaciones actuales</p>
                </div>
            </div>

            <!-- Asistencia -->
            <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                <div class="p-5 bg-gradient-to-r from-blue-500 to-blue-600">
                    <div class="flex justify-between items-center">
                        <h2 class="text-white font-bold">Asistencia</h2>
                        <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                            <i class="bi bi-calendar-check text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="px-5 py-4">
                    <p class="text-4xl font-extrabold text-blue-600">{{ $attendanceRate }}%</p>
                    <p class="text-xs text-gray-500 mt-1">Porcentaje de asistencia global</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Últimos recursos -->
            <div class="bg-white rounded-xl shadow-lg lg:col-span-2 overflow-hidden">
                <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Últimos Recursos</h3>
                    <a href="{{ route('student.resources') }}" class="text-sm text-blue-600 hover:underline">
                        Ver todos <i class="bi bi-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="p-6">
                    @if ($latestResources->isEmpty())
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <i class="bi bi-folder text-4xl text-gray-300 mb-2"></i>
                            <p class="text-gray-500">Aún no hay recursos disponibles.</p>
                        </div>
                    @else
                        <ul class="divide-y divide-gray-100">
                            @foreach ($latestResources as $resource)
                                <li class="py-3 flex items-center justify-between hover:bg-gray-50 px-2 rounded transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-blue-50 rounded-lg text-blue-500">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $resource->title }}</p>
                                            <p class="text-gray-500 text-xs">{{ $resource->subject->name }} · {{ $resource->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('student.resources.download', $resource->id) }}"
                                        class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full hover:bg-blue-100 text-xs font-medium transition-colors">
                                        <i class="bi bi-download mr-1"></i> Descargar
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

           <!--   Calendario o próximos eventos 
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-gray-800">Calendario</h3>
                </div>

                <div class="p-6">
                    Aquí podrías mostrar próximas entregas, exámenes, etc.
                    <div class="space-y-3">
                      
                    </div>
                </div>
            </div> -->
        </div>
    </div>
@endsection