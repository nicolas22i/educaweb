@extends('layouts.student')

@section('title', 'Detalle de Tarea')

@section('dashboard-content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $task->title }}</h2>
            <p class="text-gray-600">Asignatura: {{ $task->subject->name }}</p>
        </div>
        <a href="{{ route('student.tasks') }}"
            class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Volver a mis tareas
        </a>
    </div>

    <!-- Tarjeta principal de información de la tarea -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-200">
        <div class="h-3 bg-gradient-to-r from-blue-500 to-purple-600"></div>
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="bg-blue-100 text-blue-600 rounded-full p-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Información de la tarea</h3>
                    </div>
                    <p class="text-gray-500 mb-4">Todos los detalles sobre esta actividad</p>
                </div>

                <!-- Fecha límite con indicador -->
                @php
                    $now = \Carbon\Carbon::now();
                    $deadline = \Carbon\Carbon::parse($task->deadline);
                    $isLate = $now->gt($deadline);
                    $isUrgent = !$isLate && $now->diffInHours($deadline) <= 48;

                    // Crear un formato legible de tiempo restante
                    if ($isLate) {
                        // Si ya venció
                        $diffDays = $now->diffInDays($deadline);
                        $diffHours = $now->copy()->subDays($diffDays)->diffInHours($deadline);
                        $diffMinutes = $now->copy()->subDays($diffDays)->subHours($diffHours)->diffInMinutes($deadline);

                        if ($diffDays > 0) {
                            $timeRemaining = "Hace {$diffDays} día" . ($diffDays > 1 ? 's' : '');
                            if ($diffHours > 0) {
                                $timeRemaining .= " y {$diffHours} hora" . ($diffHours > 1 ? 's' : '');
                            }
                        } elseif ($diffHours > 0) {
                            $timeRemaining = "Hace {$diffHours} hora" . ($diffHours > 1 ? 's' : '');
                            if ($diffMinutes > 0) {
                                $timeRemaining .= " y {$diffMinutes} minuto" . ($diffMinutes > 1 ? 's' : '');
                            }
                        } else {
                            $timeRemaining = "Hace {$diffMinutes} minuto" . ($diffMinutes > 1 ? 's' : '');
                        }
                    } else {
                        // Si aún no vence
                        $diffDays = $deadline->diffInDays($now);
                        $diffHours = $deadline->copy()->subDays($diffDays)->diffInHours($now);
                        $diffMinutes = $deadline->copy()->subDays($diffDays)->subHours($diffHours)->diffInMinutes($now);

                        if ($diffDays > 0) {
                            $timeRemaining = "Faltan {$diffDays} día" . ($diffDays > 1 ? 's' : '');
                            if ($diffHours > 0) {
                                $timeRemaining .= " y {$diffHours} hora" . ($diffHours > 1 ? 's' : '');
                            }
                        } elseif ($diffHours > 0) {
                            $timeRemaining = "Faltan {$diffHours} hora" . ($diffHours > 1 ? 's' : '');
                            if ($diffMinutes > 0) {
                                $timeRemaining .= " y {$diffMinutes} minuto" . ($diffMinutes > 1 ? 's' : '');
                            }
                        } else {
                            $timeRemaining = "Faltan {$diffMinutes} minuto" . ($diffMinutes > 1 ? 's' : '');
                        }
                    }
                @endphp

                <div class="flex flex-col items-end">
                    <div class="text-sm font-medium mb-1">Fecha límite:</div>
                    <div
                        class="text-lg font-bold {{ $isLate ? 'text-red-600' : ($isUrgent ? 'text-yellow-600' : 'text-blue-600') }}">
                        {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y H:i') }}
                    </div>

                </div>
            </div>

            <div class="mt-6 text-gray-700 bg-gray-50 p-5 rounded-lg border border-gray-100">
                <p class="text-base leading-relaxed">{{ $task->description }}</p>
            </div>
        </div>
    </div>

    <!-- Recursos asociados -->
    @if ($task->resources->count())
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-200">
            <div class="p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full p-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Recursos disponibles</h3>
                </div>

                <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                    @foreach ($task->resources as $resource)
                        <li
                            class="bg-gray-50 rounded-lg p-3 flex items-center gap-3 border border-gray-100 hover:border-indigo-200 transition-colors">
                            <div class="bg-indigo-100 text-indigo-600 rounded-full p-2 flex-shrink-0">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <a href="{{ route('student.resources.download', $resource->id) }}"
                                    class="text-indigo-600 hover:text-indigo-800 hover:underline font-medium" target="_blank">
                                    {{ $resource->title }}
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Entrega del alumno -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="h-3 bg-gradient-to-r {{ $submission ? 'from-green-500 to-green-600' : 'from-blue-500 to-purple-600' }}">
        </div>
        <div class="p-6">
            <div class="flex items-center gap-2 mb-4">
                <div
                    class="bg-{{ $submission ? 'green' : 'blue' }}-100 text-{{ $submission ? 'green' : 'blue' }}-600 rounded-full p-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if ($submission)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        @endif
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $submission ? 'Tu entrega' : 'Entregar tarea' }}</h3>
            </div>

            @if ($submission)
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md mb-4">
                    <p class="text-green-800 font-medium flex items-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Ya has enviado tu entrega
                    </p>
                    <p class="mt-2">
                        <a href="{{ route('student.tasks.submissions.view', ['task' => $task->id, 'submission' => $submission->id]) }}" target="_blank"
                            class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122">
                                </path>
                            </svg>
                            Ver archivo enviado
                        </a>
                    </p>
                </div>

                {{-- Nota obtenida (si existe) --}}
                @if ($submission->grade !== null)
                    <div class="mt-6 bg-blue-50 rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-bold text-blue-800 flex items-center gap-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                                Calificación
                            </h4>
                            <span class="text-3xl font-extrabold {{ $submission->grade >= 5 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $submission->grade }}
                            </span>
                        </div>

                        @if ($submission->feedback)
                            <div class="mt-3">
                                <h5 class="text-sm font-semibold text-gray-700 mb-2">Feedback del profesor:</h5>
                                <div class="bg-white p-4 rounded-lg border border-blue-100 text-gray-700">
                                    {{ $submission->feedback }}
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-md flex items-start gap-3">
                        <svg class="h-6 w-6 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-yellow-800">Tu entrega está pendiente de calificación</p>
                            <p class="text-sm text-yellow-700 mt-1">El profesor revisará tu trabajo próximamente</p>
                        </div>
                    </div>
                @endif

                {{-- Botón eliminar entrega --}}
                <div class="mt-6">
                    <form action="{{ route('student.tasks.deleteSubmission', $task) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de eliminar tu entrega? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center bg-red-50 hover:bg-red-100 text-red-700 font-medium text-sm px-4 py-2.5 rounded-lg transition-colors">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Eliminar entrega
                        </button>
                    </form>
                </div>
            @else
                {{-- Formulario de subida --}}
                <div class="bg-blue-50 rounded-lg p-6">
                    <form action="{{ route('student.tasks.submit', $task) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf

                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Sube tu archivo (PDF, DOC,
                                DOCX)</label>
                            <div
                                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                                <input type="file" name="file" id="file" required
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                <p class="text-xs text-gray-500 mt-2">Arrastra un archivo o haz clic para seleccionar</p>
                            </div>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-3 rounded-lg transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Enviar Tarea
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection