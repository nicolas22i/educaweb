@extends('layouts.teacher')

@section('title', 'Subir Recurso')

@section('dashboard-content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Subir nuevo recurso
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Ups!</strong> Hay algunos errores en el formulario.
                <ul class="mt-2 list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teacher.resources.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-5">
            @csrf

            <div>
                <label for="title" class="block font-medium text-gray-700 mb-1">Título del recurso</label>
                <input type="text" name="title" id="title" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- Curso fijo --}}
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <p class="text-sm text-gray-700">Curso: <strong>{{ $course->name }}</strong></p>

            {{-- Asignatura --}}
            <div>
                <label for="subject_id" class="block font-medium text-gray-700 mb-1">Asignatura</label>
                <select name="subject_id" id="subject_id" required
                    class="w-full border border-gray-300 rounded px-4 py-2 bg-white focus:ring focus:ring-blue-200">
                    <option value="">Selecciona una asignatura</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="file" class="block font-medium text-gray-700 mb-1">Archivo</label>
                <input type="file" name="file" id="file" required
                    class="w-full border border-gray-300 rounded px-4 py-2 bg-white focus:ring focus:ring-blue-200">
            </div>

            <div class="text-right">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Subir recurso
                </button>
            </div>
        </form>
    </div>
@endsection
