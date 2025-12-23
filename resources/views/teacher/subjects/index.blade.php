@extends('layouts.teacher')

@section('title', 'Mis Asignaturas')

@section('dashboard-content')
    <div class="mb-8">
        <p class="text-gray-600">Gestiona y accede a todas tus asignaturas</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($subjects as $subject)
            <a href="{{ route('teacher.subjects.show', $subject->id) }}"
                class="group relative overflow-hidden bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">

                <!-- Banner superior con color aleatorio -->
                <div class="h-3 bg-gradient-to-r from-blue-500 to-purple-600"></div>

                <div class="p-6">
                    <!-- Contenedor flex para icono y nombre de asignatura -->
                    <div class="flex items-start gap-4 mb-4">
                        <!-- Icono -->
                        <div
                            class="flex-shrink-0 bg-blue-100 text-blue-600 rounded-full p-3 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z" />
                            </svg>
                        </div>

                        <!-- Nombre de la asignatura -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                                {{ $subject->name }}
                            </h2>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <p class="text-gray-600 mb-4">
                        {{ $subject->description ?? 'Sin descripción disponible para esta asignatura' }}
                    </p>

                    <!-- Cursos asociados - Versión segura -->
                    @if(isset($subject->courses) && $subject->courses?->count() > 0)
                        <div class="mt-3 space-y-2">
                            @foreach($subject->courses as $course)
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-book text-gray-500 flex-shrink-0" viewBox="0 0 16 16">
                                        <path
                                            d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ $course->name }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Flecha indicadora -->
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                            </path>
                        </svg>
                    </div>
                </div>
            </a>
        @empty
            <div
                class="col-span-full flex flex-col items-center justify-center p-10 bg-gray-50 rounded-xl border border-gray-200">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z">
                    </path>
                </svg>
                <p class="text-xl font-medium text-gray-600 mb-2">Ninguna asignatura encontrada</p>
                <p class="text-gray-500 text-center">No tienes asignaturas asignadas actualmente.<br>Contacta con administración
                    si crees que es un error.</p>
            </div>
        @endforelse
    </div>
@endsection