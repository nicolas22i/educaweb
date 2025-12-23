@extends('layouts.student')

@section('title', 'Mis Asignaturas')

@section('dashboard-content')
    <div class="mb-8">
        <p class="text-gray-600">Consulta tus asignaturas y el estado de tus calificaciones</p>
    </div>

    @if ($grades->isEmpty())
        <div class="col-span-full flex flex-col items-center justify-center p-10 bg-gray-50 rounded-xl border border-gray-200">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z" />
            </svg>
            <p class="text-xl font-medium text-gray-600 mb-2">No tienes asignaturas disponibles</p>
            <p class="text-gray-500 text-center">Tus asignaturas aparecerán aquí cuando estén registradas en el sistema.</p>
        </div>
    @else
        <div class="flex flex-wrap gap-4 mb-8">
            <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200 flex items-center">
                <div class="bg-blue-100 text-blue-600 rounded-full p-2 mr-3">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Total de asignaturas</p>
                    <p class="font-bold text-gray-800">{{ $subjects->count() }}</p>
                </div>
            </div>

            <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200 flex items-center">
                <div class="bg-green-100 text-green-600 rounded-full p-2 mr-3">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Asignaturas aprobadas</p>
                    <p class="font-bold text-gray-800">{{ $grades->where('grade', '>=', 5)->count() }}</p>
                </div>
            </div>

            <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200 flex items-center">
                <div class="bg-red-100 text-red-600 rounded-full p-2 mr-3">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Asignaturas suspendidas</p>
                    <p class="font-bold text-gray-800">{{ $grades->where('grade', '<', 5)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($grades as $grade)
                @php
                    $isApproved = $grade->grade >= 5;
                @endphp
                <div
                    class="group relative overflow-hidden bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <!-- Banner superior con gradiente -->
                    <div class="h-3 bg-gradient-to-r {{ $isApproved ? 'from-green-500 to-green-600' : 'from-red-500 to-red-600' }}">
                    </div>

                    <div class="p-6">
                        <!-- Contenedor flex para icono y nombre de la asignatura -->
                        <div class="flex items-start gap-4 mb-4">
                            <!-- Icono -->
                            <div
                                class="flex-shrink-0 {{ $isApproved ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} rounded-full p-3 group-hover:{{ $isApproved ? 'bg-green-600' : 'bg-red-600' }} group-hover:text-white transition-colors duration-300">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    @if ($isApproved)
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @endif
                                </svg>
                            </div>
                            <!-- Título de la asignatura -->
                            <div>
                                <h2
                                    class="text-xl font-bold text-gray-800 group-hover:{{ $isApproved ? 'text-green-600' : 'text-red-600' }} transition-colors">
                                    {{ $grade->subject->name }}
                                </h2>
                                <p class="text-sm text-gray-500">Curso: {{ $grade->subject->course->name ?? '—' }}</p>
                            </div>
                        </div>

                        <!-- Información de la calificación -->
                        <div class="text-gray-600 mb-4">
                            <div class="mb-1">
                                <span class="font-medium">Calificación:</span>
                                <span class="text-2xl ml-2 font-bold {{ $isApproved ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($grade->grade, 2) }}
                                </span>
                            </div>
                            <div>
                                <span
                                    class="inline-block mt-2 text-xs px-2 py-1 rounded-full {{ $isApproved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $isApproved ? 'Aprobado' : 'Suspenso' }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('student.subjects.show', $grade->id) }}"
                                class="inline-flex items-center justify-center w-full {{ $isApproved ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection