@extends('layouts.admin')

@section('title', 'Editar Estudiante')

@section('dashboard-content')
<div class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Estudiante</h2>

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

    <form action="{{ route('admin.students.update', $student->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="user_id" class="block font-medium text-gray-700 mb-1">Selecciona Usuario</label>
            <select name="user_id" id="user_id" class="w-full border-gray-300 rounded p-2" required>
                <option value="">Selecciona un usuario</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $user->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="course_id" class="block font-medium text-gray-700 mb-1">Selecciona Curso</label>
            <select name="course_id" id="course_id" class="w-full border-gray-300 rounded p-2" required>
                <option value="">Selecciona un curso</option>
                @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ $student->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->name }} ({{ $course->academic_year }})
                </option>
                @endforeach
            </select>
        </div>


        <div>
            <label class="block font-medium text-gray-700 mb-1">Código del Estudiante</label>
            <input type="text" name="student_code" value="{{ old('student_code', $student->student_code) }}"
                class="w-full border-gray-300 rounded-md p-2" required>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}"
                class="w-full border-gray-300 rounded-md p-2" required>
        </div>


        <div>
            <label class="block font-medium text-gray-700 mb-1">Teléfono</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $student->phone_number) }}"
                class="w-full border-gray-300 rounded-md p-2">
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Dirección</label>
            <input type="text" name="address" value="{{ old('address', $student->address) }}"
                class="w-full border-gray-300 rounded-md p-2">
        </div>

        <div class="text-right">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md transition">
                Actualizar Estudiante
            </button>
        </div>
    </form>
</div>
@endsection