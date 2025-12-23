@extends('layouts.admin')

@section('title', 'Crear Profesor')

@section('dashboard-content')
    <div class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear Nuevo Profesor</h2>

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

        <form action="{{ route('admin.teachers.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="user_id" class="block font-medium text-gray-700 mb-1">Selecciona Usuario</label>
                <select name="user_id" id="user_id" class="w-full border-gray-300 rounded p-2" required>
                    <option value="">Selecciona un usuario</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="teacher_code" class="block font-medium text-gray-700 mb-1">Código del Profesor</label>
                <input type="text" name="teacher_code" id="teacher_code" placeholder="Ej: PRF1234"
                    class="w-full border-gray-300 rounded p-2" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Especialidad</label>
                <input type="text" name="specialization" class="w-full border-gray-300 rounded-md p-2" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Teléfono</label>
                <input type="text" name="phone_number" class="w-full border-gray-300 rounded-md p-2">
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Dirección</label>
                <input type="text" name="address" class="w-full border-gray-300 rounded-md p-2">
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md transition">
                    Crear Profesor
                </button>
            </div>
        </form>
    </div>
@endsection
