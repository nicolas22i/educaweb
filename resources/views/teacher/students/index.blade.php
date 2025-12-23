@extends('layouts.teacher')

@section('title', 'Mis Estudiantes')

@section('dashboard-content')
<div class="mb-8">
    <p class="text-gray-600">Administra y visualiza todos tus estudiantes</p>
</div>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($students as $student)
    <a href="{{ route('teacher.students.show', $student->id) }}"
        class="group relative overflow-hidden bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">

        <!-- Banner superior con color aleatorio -->
        <div class="h-3 bg-gradient-to-r from-green-500 to-teal-600"></div>

        <div class="p-6">
            <!-- Contenedor flex para imagen y nombre -->
            <div class="flex items-start gap-4 mb-4">
                <!-- Imagen de perfil -->
                <div class="flex-shrink-0 h-14 w-14 rounded-full overflow-hidden border-2 border-green-100">
                    <img src="{{ $student->user->profile_image ? asset($student->user->profile_image) : asset('images/avatar-placeholder.png') }}"
                         alt="{{ $student->user->name }}"
                         class="h-full w-full object-cover"
                         onerror="this.onerror=null; this.src='{{ asset('images/avatar-placeholder.png') }}'">
                </div>
                
                <!-- Nombre del estudiante -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-green-600 transition-colors">
                        {{ $student->user->name }}
                    </h2>
                    <p class="text-sm text-gray-500">{{ $student->student_code }}</p>
                </div>
            </div>

            <!-- Información del estudiante -->
            <div class="text-gray-600 mb-4">
                <p class="mb-1"><span class="font-medium">Fecha nacimiento:</span> {{ $student->date_of_birth }}</p>
                <p><span class="font-medium">Teléfono:</span> {{ $student->phone_number }}</p>
            </div>

            <!-- Cursos del estudiante -->
            @if(isset($student->courses) && $student->courses->count() > 0)
            <div class="mt-3 space-y-2">
                @foreach($student->courses as $course)
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book text-gray-500" viewBox="0 0 16 16">
                        <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
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
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </div>
        </div>
    </a>
    @empty
    <div class="col-span-full flex flex-col items-center justify-center p-10 bg-gray-50 rounded-xl border border-gray-200">
        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"></path>
        </svg>
        <p class="text-xl font-medium text-gray-600 mb-2">Ningún estudiante encontrado</p>
        <p class="text-gray-500 text-center">No tienes estudiantes asignados actualmente.<br>Contacta con administración si crees que es un error.</p>
    </div>
    @endforelse
</div>
@endsection