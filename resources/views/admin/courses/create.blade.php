@extends('layouts.admin')
@section('title', 'Crear Curso')

@section('dashboard-content')
    <div class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear Nuevo Curso</h2>

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

        <form action="{{ route('admin.courses.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block font-medium text-gray-700 mb-1">Nombre del curso</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm p-2" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Año académico</label>
                <input type="text" name="academic_year" class="w-full border-gray-300 rounded-md shadow-sm p-2"
                    placeholder="Ej: 2024/2025" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Tutor del curso</label>
                <select name="teacher_id" class="w-full border-gray-300 rounded-md shadow-sm p-2" required>
                    <option value="">Selecciona un profesor</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md transition">
                    Crear Curso
                </button>
            </div>
        </form>
    </div>
@endsection
