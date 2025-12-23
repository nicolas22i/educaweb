@extends('layouts.teacher')

@section('title', 'Editar Tarea')

@section('dashboard-content')
    <h2 class="text-2xl font-bold mb-6">Editar Tarea</h2>

    <form action="{{ route('teacher.tasks.update', $task) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Título --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Título</label>
            <input type="text" name="title" value="{{ old('title', $task->title) }}" required
                class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring focus:ring-blue-200">
        </div>

        {{-- Descripción --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="description" rows="4"
                class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring focus:ring-blue-200">{{ old('description', $task->description) }}</textarea>
        </div>

        {{-- Fecha límite --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Fecha límite</label>
            <input type="date" name="deadline"
                value="{{ old('deadline', \Carbon\Carbon::parse($task->deadline)->format('Y-m-d')) }}"
                class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring focus:ring-blue-200">
        </div>

        {{-- Asignatura --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Asignatura</label>
            <select name="subject_id" id="subject_id"
                class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring focus:ring-blue-200">
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $task->subject_id == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Recursos --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Recursos</label>
            <select name="resources[]" id="resources" multiple
                class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring focus:ring-blue-200">
                @foreach($resources as $resource)
                    <option value="{{ $resource->id }}" {{ $task->resources->pluck('id')->contains($resource->id) ? 'selected' : '' }}>
                        {{ $resource->title }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Botón --}}
        <div class="pt-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                Guardar Cambios
            </button>
        </div>
    </form>

    {{-- SCRIPT directo dentro de la vista --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const subjectSelect = document.getElementById('subject_id');
            const resourcesSelect = document.getElementById('resources');
    
            subjectSelect.addEventListener('change', function () {
                const subjectId = this.value;
    
                if (!subjectId) {
                    resourcesSelect.innerHTML = '';
                    return;
                }
    
                fetch(`/teacher/resources/by-subject/${subjectId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Respuesta de red no fue ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        resourcesSelect.innerHTML = '';
    
                        data.forEach(resource => {
                            const option = document.createElement('option');
                            option.value = resource.id;
                            option.textContent = resource.title;
                            resourcesSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar los recursos:', error);
                    });
            });
        });
    </script>
    
@endsection
