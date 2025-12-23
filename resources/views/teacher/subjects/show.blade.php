@extends('layouts.teacher')

@section('title', $subject->name)

@section('dashboard-content')
<!-- Encabezado de la asignatura con banner de color -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8 border border-gray-200">
    <div class="h-3 bg-gradient-to-r from-blue-500 to-purple-600"></div>
    <div class="p-6">
        <div class="flex items-center gap-5">
            <div class="bg-blue-100 text-blue-600 p-4 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $subject->name }}</h1>
                <p class="text-gray-600 mt-1">{{ $subject->description ?? 'Sin descripción para esta asignatura' }}</p>

                <!-- Información adicional -->
                <div class="flex flex-wrap gap-6 mt-4">
                    @if(isset($subject->course))
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Curso: <span class="font-medium">{{ $subject->course->name }}</span></span>
                    </div>
                    @endif

                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>{{ $subject->students_count ?? 0 }} estudiantes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navegación de pestañas con JavaScript -->
<div class="mb-6 border-b border-gray-200">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tabsNav">
        <li class="mr-2">
            <button type="button" data-tab="resources" class="inline-flex items-center px-4 py-3 rounded-t-lg tab-btn active">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Recursos
            </button>
        </li>
        <li class="mr-2">
            <button type="button" data-tab="tasks" class="inline-flex items-center px-4 py-3 rounded-t-lg tab-btn">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                Tareas
            </button>
        </li>

    </ul>
</div>

<!-- Contenido de pestañas -->
<div id="tabsContent">
    <!-- Pestaña de Recursos -->
    <div id="resources" class="tab-content active">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Recursos de la asignatura</h2>
            <a href="{{ route('teacher.resources.create.from-subject', ['subject_id' => $subject->id]) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition inline-flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Subir nuevo recurso
            </a>
        </div>

        @if ($subject->resources->count())
        <div class="grid gap-4">
            @foreach ($subject->resources as $resource)
            <div
                class="flex justify-between items-center bg-white shadow-sm rounded-lg p-5 border border-gray-200 hover:shadow-md transition group">
                <div class="flex items-center gap-4">
                    <!-- Icono según tipo de archivo -->
                    <div class="bg-gray-100 text-blue-600 p-3 rounded-lg group-hover:bg-blue-50 transition-colors">
                        @php
                        $extension = pathinfo($resource->file_path, PATHINFO_EXTENSION);
                        $icon = 'document';

                        if (in_array($extension, ['pdf'])) {
                        $icon = 'pdf';
                        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $icon = 'image';
                        } elseif (in_array($extension, ['doc', 'docx'])) {
                        $icon = 'word';
                        } elseif (in_array($extension, ['xls', 'xlsx'])) {
                        $icon = 'excel';
                        } elseif (in_array($extension, ['ppt', 'pptx'])) {
                        $icon = 'powerpoint';
                        }
                        @endphp

                        @if($icon == 'pdf')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        @elseif($icon == 'image')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        @endif
                    </div>

                    <div class="flex flex-col">
                        <p class="text-lg font-medium text-gray-800">{{ $resource->title }}</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span>{{ strtoupper(pathinfo($resource->file_path, PATHINFO_EXTENSION)) }}</span>
                            <span>•</span>
                            <span>{{ $resource->created_at->format('d/m/Y') }}</span>
                            @if(isset($resource->size))
                            <span>•</span>
                            <span>{{ number_format($resource->size / 1024, 2) }} KB</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('teacher.resources.download', $resource->id) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                        </svg>
                        Descargar
                    </a>

                    <form action="{{ route('teacher.resources.destroy', $resource->id) }}" method="POST"
                        onsubmit="return confirm('¿Seguro que quieres eliminar este recurso?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex flex-col items-center justify-center p-10 bg-gray-50 rounded-xl border border-gray-200 text-center">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-700 mb-2">No hay recursos disponibles</h3>
            <p class="text-gray-500 mb-6">Aún no has subido recursos para esta asignatura.</p>
            <a href="{{ route('teacher.resources.create.from-subject', ['subject_id' => $subject->id]) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition inline-flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Subir primer recurso
            </a>
        </div>
        @endif
    </div>

    <!-- Pestaña de Tareas -->
    <div id="tasks" class="tab-content hidden">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Tareas de la asignatura</h2>
            <a href="{{ route('teacher.tasks.create', ['subject_id' => $subject->id]) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition inline-flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Crear nueva tarea
            </a>
        </div>

        @if ($subject->tasks && $subject->tasks->count())
        <div class="grid gap-4">
            @foreach ($subject->tasks as $task)
            <div class="bg-white shadow-sm rounded-lg p-5 border border-gray-200 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800">{{ $task->title }}</h3>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mt-1">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Fecha límite: {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
                            </span>
                            <span>•</span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                {{ $task->submissions->count() }} entregas
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('teacher.tasks.show', $task->id) }}"
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-md text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Ver
                        </a>
                        <a href="{{ route('teacher.tasks.edit', $task->id) }}"
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-md text-sm font-medium text-green-600 bg-green-50 hover:bg-green-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Editar
                        </a>
                        <form action="{{ route('teacher.tasks.destroy', $task->id) }}" method="POST"
                            onsubmit="return confirm('¿Seguro que quieres eliminar esta tarea?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-md text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                <div class="mt-3 text-gray-600 text-sm line-clamp-2">
                    {{ Str::limit($task->description, 150) }}
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex flex-col items-center justify-center p-10 bg-gray-50 rounded-xl border border-gray-200 text-center">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="text-lg font-medium text-gray-700 mb-2">No hay tareas disponibles</h3>
            <p class="text-gray-500 mb-6">Aún no has creado tareas para esta asignatura.</p>
            <a href="{{ route('teacher.tasks.create', ['subject_id' => $subject->id]) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition inline-flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Crear primera tarea
            </a>
        </div>
        @endif
    </div>

    
       

    

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tabButtons = document.querySelectorAll('.tab-btn');
                const tabContents = document.querySelectorAll('.tab-content');

                tabButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        tabButtons.forEach(btn => btn.classList.remove('active'));
                        tabContents.forEach(content => content.classList.add('hidden'));
                        button.classList.add('active');
                        const tabId = button.getAttribute('data-tab');
                        document.getElementById(tabId).classList.remove('hidden');
                    });
                });
            });
        </script>
        @endsection