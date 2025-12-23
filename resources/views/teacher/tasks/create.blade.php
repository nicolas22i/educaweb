@extends('layouts.teacher')

@section('title', 'Crear Nueva Tarea')

@section('dashboard-content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-2">
            <i class="bi bi-plus-circle text-blue-700 text-2xl"></i>
            Crear Nueva Tarea
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Ups!</strong> Hay errores en el formulario:
                <ul class="mt-2 list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teacher.tasks.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="title" class="block font-medium text-gray-700 mb-1">Título de la tarea</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label for="description" class="block font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:ring focus:ring-blue-200">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="subject_id" class="block font-medium text-gray-700 mb-1">Asignatura</label>
                <select name="subject_id" id="subject_id" required
                    class="w-full border border-gray-300 rounded px-4 py-2 bg-white focus:ring focus:ring-blue-200">
                    <option value="">Selecciona una asignatura</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="resources-container">
                <label for="resource_ids" class="block font-medium text-gray-700 mb-1">Recursos relacionados
                    (opcional)</label>
                <select name="resource_ids[]" id="resource_ids" multiple class="w-full border p-2 rounded">
                    <option disabled>Selecciona una asignatura primero</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Puedes mantener pulsado Ctrl/Cmd para seleccionar varios.</p>
            </div>


            <div>
                <label for="deadline" class="block font-medium text-gray-700 mb-1">Fecha límite</label>
                <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:ring focus:ring-blue-200">
            </div>

            <div class="text-right">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    <i class="bi bi-check-circle-fill text-white"></i>
                    Guardar Tarea
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('subject_id').addEventListener('change', function() {
            console.log("Cambio detectado en asignatura");
            const subjectId = this.value;
            const resourceSelect = document.querySelector('select[name="resource_ids[]"]');

            // Limpiar opciones anteriores
            resourceSelect.innerHTML = '';

            if (subjectId) {
                fetch(`/teacher/resources/by-subject/${subjectId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            const option = document.createElement('option');
                            option.text = 'No hay recursos disponibles';
                            option.disabled = true;
                            resourceSelect.appendChild(option);
                        } else {
                            data.forEach(resource => {
                                const option = document.createElement('option');
                                option.value = resource.id;
                                option.text = resource.title;
                                resourceSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener recursos:', error);
                    });
            }
        });
    </script>
@endsection
