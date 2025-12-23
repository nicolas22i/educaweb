@extends('layouts.admin')
@section('title', 'Gestión de Cursos')

@section('dashboard-content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Cursos Activos</h2>
        <a href="{{ route('admin.courses.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
            + Crear Curso
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Profesor</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse($courses as $course)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $course->id }}</td>
                        <td class="px-6 py-4">{{ $course->name }}</td>
                        <td class="px-6 py-4">
                            {{ optional($course->teacher->user)->name ?? 'Sin profesor' }}
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ route('admin.courses.edit', $course->id) }}"
                                class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition">
                                Editar
                            </a>

                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST"
                                class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este curso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm font-medium rounded hover:bg-red-600 transition">
                                    Eliminar
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            No hay cursos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $courses->links() }}
    </div>
@endsection
