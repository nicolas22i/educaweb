@extends('layouts.student')
@section('title', 'Mis Tareas')
@section('dashboard-content')
<div class="mb-8">
    <p class="text-gray-600">Visualiza y gestiona todas tus tareas asignadas</p>
</div>

<div class="flex flex-wrap justify-between items-center mb-8 gap-4">
    <div class="flex items-center space-x-3">

        <span class="text-gray-700">Filtrar por asignatura:</span>
        <div class="relative inline-block w-48">
            <select name="subject_id" id="subject_id"
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Todos</option>
                @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" @if(request('subject_id')==$subject->id) selected @endif>
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
</div>

@if ($tasks->isEmpty())
<div class="col-span-full flex flex-col items-center justify-center p-10 bg-gray-50 rounded-xl border border-gray-200">
    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z">
        </path>
    </svg>
    <p class="text-xl font-medium text-gray-600 mb-2">No tienes tareas asignadas</p>
    <p class="text-gray-500 text-center">No se encontraron tareas pendientes por el momento.<br>Revisa más tarde para
        ver nuevas asignaciones.</p>
</div>
@else
<div class="flex flex-wrap gap-4 mb-8">
    <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200 flex items-center">
        <div class="bg-blue-100 text-blue-600 rounded-full p-2 mr-3">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                </path>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">Total de tareas</p>
            <p class="font-bold text-gray-800">{{ $tasks->count() }}</p>
        </div>
    </div>

    <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200 flex items-center">
        <div class="bg-green-100 text-green-600 rounded-full p-2 mr-3">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">Completadas</p>
            <p class="font-bold text-gray-800">
                {{ $tasks->filter(function ($task) {
                return $task->submissions->where('student_id', auth()->user()->student->id)->count() > 0; })->count() }}
            </p>
        </div>
    </div>

    <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200 flex items-center">
        <div class="bg-yellow-100 text-yellow-600 rounded-full p-2 mr-3">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">Pendientes</p>
            <p class="font-bold text-gray-800">
                {{ $tasks->filter(function ($task) {
                return $task->submissions->where('student_id', auth()->user()->student->id)->count() == 0; })->count() }}
            </p>
        </div>
    </div>
</div>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($tasks as $task)
    @php
    $submission = $task->submissions->firstWhere('student_id', auth()->user()->student->id);
    $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($task->deadline), false);
    $isLate = $daysLeft < 0;
        $isUrgent=$daysLeft>= 0 && $daysLeft <= 2;
            @endphp
            <div
            class="group relative overflow-hidden bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <!-- Banner superior con gradiente -->
            <div
                class="h-3 bg-gradient-to-r {{ $submission ? 'from-green-500 to-green-600' : ($isLate ? 'from-red-500 to-red-600' : ($isUrgent ? 'from-yellow-500 to-yellow-600' : 'from-blue-500 to-purple-600')) }}">
            </div>

            <div class="p-6">
                <!-- Contenedor flex para icono y nombre de la tarea -->
                <div class="flex items-start gap-4 mb-4">
                    <!-- Icono -->
                    <div
                        class="flex-shrink-0 {{ $submission ? 'bg-green-100 text-green-600' : ($isLate ? 'bg-red-100 text-red-600' : ($isUrgent ? 'bg-yellow-100 text-yellow-600' : 'bg-blue-100 text-blue-600')) }} rounded-full p-3 group-hover:{{ $submission ? 'bg-green-600' : ($isLate ? 'bg-red-600' : ($isUrgent ? 'bg-yellow-600' : 'bg-blue-600')) }} group-hover:text-white transition-colors duration-300">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            @if ($submission)
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @elseif ($isLate)
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                            @endif
                        </svg>
                    </div>
                    <!-- Título de la tarea -->
                    <div>
                        <h2
                            class="text-xl font-bold text-gray-800 group-hover:{{ $submission ? 'text-green-600' : ($isLate ? 'text-red-600' : ($isUrgent ? 'text-yellow-600' : 'text-blue-600')) }} transition-colors">
                            {{ $task->title }}
                        </h2>
                        <p class="text-sm text-gray-500">{{ $task->subject->name }}</p>
                    </div>
                </div>

                <!-- Información de la tarea -->
                <div class="text-gray-600 mb-4">
                    <div class="mb-1">
                        <span class="font-medium">Fecha límite:</span>
                        <span
                            class="{{ $isLate ? 'text-red-600 font-semibold' : ($isUrgent ? 'text-yellow-600 font-semibold' : '') }}">
                            {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
                            @if ($isLate)
                            (Vencida)
                            @elseif ($isUrgent)
                            ({{ $daysLeft == 0 ? 'Hoy' : 'En ' . round($daysLeft) . ' días' }})
                            @endif
                        </span>
                    </div>
                    <div>
                        <span class="font-medium">Estado:</span>
                        @if ($submission)
                        <span class="text-green-600 font-semibold">Entregada el
                            {{ \Carbon\Carbon::parse($submission->created_at)->format('d/m/Y') }}</span>
                        @else
                        <span
                            class="{{ $isLate ? 'text-red-600' : 'text-yellow-600' }} font-semibold">{{ $isLate ? 'No entregada' : 'Pendiente' }}</span>
                        @endif
                    </div>
                </div>

                <!-- Botón de acción -->
                <div class="mt-4">
                    <a href="{{ route('student.tasks.show', $task) }}"
                        class="inline-flex items-center justify-center w-full {{ $submission ? 'bg-green-600 hover:bg-green-700' : ($isLate ? 'bg-red-600 hover:bg-red-700' : ($isUrgent ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-blue-600 hover:bg-blue-700')) }} text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        {{ $submission ? 'Ver Entrega' : 'Ver Detalle' }}
                    </a>
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
        const url = new URL(window.location.href);

        // Actualizar o eliminar el parámetro subject_id
        if (subjectId) {
            url.searchParams.set('subject_id', subjectId);
        } else {
            url.searchParams.delete('subject_id');
        }

        // Redirigir manteniendo otros parámetros
        window.location.href = url.toString();
    });
</script>
@endsection