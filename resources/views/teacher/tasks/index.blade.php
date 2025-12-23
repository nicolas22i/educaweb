@extends('layouts.teacher')

@section('title', 'Tareas')

@section('dashboard-content')
<div class="mb-8">
    <p class="text-gray-600">Administra y visualiza todas tus tareas asignadas</p>
</div>

<div class="flex flex-wrap justify-between items-center mb-8 gap-4">
    <div class="flex items-center space-x-3">
        <span class="text-gray-700">Filtrar por asignatura:</span>
        <div class="relative inline-block w-48">
            <select name="subject_id" id="subject_id"
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Todos</option>
                @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>
    </div>

    <a href="{{ route('teacher.tasks.create') }}"
        class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-full transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
            </path>
        </svg>
        Crear Nueva Tarea
    </a>
</div>

@if ($tasks->isEmpty())
<div class="col-span-full flex flex-col items-center justify-center p-10 bg-gray-50 rounded-xl border border-gray-200">
    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z">
        </path>
    </svg>
    <p class="text-xl font-medium text-gray-600 mb-2">No tienes tareas creadas aún</p>
    <p class="text-gray-500 text-center">No se encontraron tareas con los filtros actuales.<br>Utiliza el botón
        "Crear Nueva Tarea" para comenzar.</p>
</div>
@else
<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($tasks as $task)
    <div
        class="group relative overflow-hidden bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
        <!-- Banner superior con gradiente -->
        <div class="h-3 bg-gradient-to-r from-blue-500 to-purple-600"></div>

        <div class="p-6">
            <!-- Contenedor flex para icono y nombre de la tarea -->
            <div class="flex items-start gap-4 mb-4">
                <!-- Icono -->
                <div
                    class="flex-shrink-0 bg-blue-100 text-blue-600 rounded-full p-3 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>

                <!-- Título de la tarea -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                        {{ $task->title }}
                    </h2>
                    <p class="text-sm text-gray-500">{{ $task->subject->name }}</p>
                </div>
            </div>

            <!-- Información de la tarea -->
            <div class="text-gray-600 mb-4">
                <div class="mb-1">
                    <span class="font-medium">Fecha límite:</span>
                    {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
                </div>
                <div>
                    <span class="font-medium">Entregas:</span>
                    {{ $task->submissions->count() }}
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('teacher.tasks.show', $task) }}"
                    class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium hover:bg-blue-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    Ver
                </a>

                <a href="{{ route('teacher.tasks.edit', $task) }}"
                    class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium hover:bg-yellow-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                        </path>
                    </svg>
                    Editar
                </a>

                <form action="{{ route('teacher.tasks.destroy', $task) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium hover:bg-red-200 transition"
                        onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
@section('scripts')
<script>
    document.getElementById('subject_id').addEventListener('change', function() {
        const subjectId = this.value;
        let url = window.location.pathname; // Obtiene solo la ruta sin parámetros

        if (subjectId) {
            // Si hay un subjectId, añadirlo como parámetro
            url += (url.includes('?') ? '&' : '?') + 'subject_id=' + subjectId;
        }

        window.location.href = url;
    });
</script>
@endsection