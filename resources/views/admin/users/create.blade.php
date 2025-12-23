@extends('layouts.admin')

@section('title', 'Crear Usuario')

@section('dashboard-content')
    <div class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear Nuevo Usuario</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong class="font-bold">¡Ups!</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Rol</label>
                <select name="role"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-200" required>
                    <option value="">Selecciona un rol</option>
                    <option value="admin">Administrador</option>
                    <option value="teacher">Profesor</option>
                    <option value="student">Estudiante</option>
                </select>
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md transition">
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>
@endsection
