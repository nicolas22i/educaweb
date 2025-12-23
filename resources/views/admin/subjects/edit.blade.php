@extends('layouts.admin')

@section('title', 'Editar Asignatura')

@section('dashboard-content')
    <div class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Asignatura</h2>

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

        <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Curso al que pertenece</label>
                <select name="course_id" id="course_id" required class="w-full border-gray-300 rounded">
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ $subject->course_id == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $subject->name) }}"
                    class="w-full border-gray-300 rounded-md p-2" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md p-2">{{ old('description', $subject->description) }}</textarea>
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md transition">
                    Actualizar Asignatura
                </button>
            </div>
        </form>
    </div>
@endsection
