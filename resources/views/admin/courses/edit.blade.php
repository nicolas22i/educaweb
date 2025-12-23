@extends('layouts.admin')

@section('title', 'Editar Curso')

@section('dashboard-content')
    <div class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Curso</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong class="font-bold">Errores:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium text-gray-700 mb-1">Nombre del Curso</label>
                <input type="text" name="name" value="{{ old('name', $course->name) }}"
                    class="w-full border-gray-300 rounded-md p-2" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Año Académico</label>
                <input type="text" name="academic_year" value="{{ old('academic_year', $course->academic_year) }}"
                    class="w-full border-gray-300 rounded-md p-2" required>
            </div>

            <div>
                <label for="teacher_id" class="block font-medium text-gray-700 mb-1">Profesor Asignado</label>
                <select name="teacher_id" id="teacher_id" class="w-full border-gray-300 rounded p-2" required>
                    <option value="">Selecciona un profesor</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ $course->teacher_id == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user->name ?? 'Sin nombre' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md transition">
                    Actualizar Curso
                </button>
            </div>
        </form>
    </div>
@endsection
