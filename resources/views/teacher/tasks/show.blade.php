@extends('layouts.teacher')

@section('title', 'Detalles de la Tarea')

@section('dashboard-content')
<!-- INFO PRINCIPAL DE LA TAREA -->
<div class="bg-white p-6 rounded-2xl shadow-md border border-gray-200 mb-6">
    <h2 class="text-3xl font-extrabold text-blue-600 flex items-center gap-2 mb-2">
        <i class="bi bi-journal-text text-blue-500 text-2xl"></i>
        {{ $task->title }}
    </h2>

    <div class="text-sm text-gray-600 space-y-1">
        <p>
            <i class="bi bi-bookmark-fill text-blue-400 mr-1"></i>
            <strong>Asignatura:</strong> {{ $task->subject->name }}
        </p>
        <p>
            <i class="bi bi-calendar-event text-blue-400 mr-1"></i>
            <strong>Fecha límite:</strong> {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
        </p>
    </div>

    <div class="mt-4 text-gray-800 text-base leading-relaxed border-t pt-4">
        {{ $task->description }}
    </div>
</div>

<!-- RECURSOS ASOCIADOS -->
@if ($task->resources->count())
<div class="bg-white p-6 rounded-2xl shadow-md mb-6 border border-gray-100">
    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="bi bi-folder2-open text-blue-500"></i> Recursos asociados
    </h3>
    <ul class="space-y-2 text-sm text-gray-700">
        @foreach ($task->resources as $resource)
        <li class="flex items-center gap-2">
            <i class="bi bi-file-earmark-text-fill text-blue-400"></i>
            <a href="{{ route('teacher.resources.download', $resource->id) }}"
                class="text-blue-600 hover:underline font-medium">
                {{ $resource->title }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endif

<!-- ENTREGAS DE ESTUDIANTES -->
<div class="bg-white p-6 rounded-2xl shadow-md border border-gray-200">
    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="bi bi-people-fill text-blue-500"></i> Entregas de estudiantes
    </h3>

    @if ($task->submissions->isEmpty())
    <p class="text-sm text-gray-600 italic">Ningún estudiante ha entregado aún.</p>
    @else
    <div class="overflow-x-auto rounded-lg border border-gray-100">
        <table class="min-w-full text-sm text-left bg-white">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-700 uppercase tracking-wide text-xs">
                <tr>
                    <th class="px-4 py-3">Estudiante</th>
                    <th class="px-4 py-3 text-center">Archivo</th>
                    <th class="px-4 py-3 text-center">Nota</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($task->submissions as $submission)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 font-medium text-gray-800">{{ $submission->student->user->name }}</td>
                    <td class="px-4 py-2 text-center">
                        @if ($submission->file_path)
                        <a href="{{ route('teacher.tasks.submissions.view', ['task' => $task->id, 'submission' => $submission->id]) }}"
                            class="text-blue-600 hover:underline"
                            target="_blank">
                            Ver archivo
                        </a>
                        @else
                        <span class="text-gray-400 italic">Sin archivo</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-center font-semibold text-gray-700">
                        {{ $submission->grade ?? '—' }}
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button onclick="openGradeModal({{ $submission->id }}, '{{ $submission->grade }}', '{{ $submission->feedback }}')"
                            class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-full font-medium transition">
                            <i class="bi bi-pencil-fill"></i> Calificar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    @endif
</div>

<div id="grade-modal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md relative">
        <button class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl" onclick="closeGradeModal()">
            <i class="bi bi-x-lg"></i>
        </button>
        <h3 class="text-lg font-bold text-gray-800 mb-4">Calificar entrega</h3>
        <form method="POST" id="grade-form">
            @csrf
            @method('PUT')

            <label class="block text-sm font-medium text-gray-700 mb-1">Nota (0 - 10)</label>
            <input type="number" name="grade" id="grade-input" min="0" max="10" step="0.1" required
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-200 mb-4">

            <label class="block text-sm font-medium text-gray-700 mb-1">Feedback</label>
            <textarea name="feedback" id="feedback-input" rows="3"
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-200 mb-4"
                placeholder="Comentario opcional para el estudiante..."></textarea>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                Guardar calificación
            </button>
        </form>
    </div>
</div>

<script>
    function openGradeModal(submissionId, currentGrade = '', currentFeedback = '') {
        const modal = document.getElementById('grade-modal');
        const form = document.getElementById('grade-form');
        const inputGrade = document.getElementById('grade-input');
        const inputFeedback = document.getElementById('feedback-input');

        form.action = "{{ route('teacher.tasks.submissions.grade', ['task' => ':taskId', 'submission' => ':submissionId']) }}"
            .replace(':taskId', '{{ $task->id }}')
            .replace(':submissionId', submissionId);

        inputGrade.value = currentGrade;
        inputFeedback.value = currentFeedback;
        modal.classList.remove('hidden');
    }

    function closeGradeModal() {
        document.getElementById('grade-modal').classList.add('hidden');
    }
</script>


@endsection