@extends('layouts.admin')
@section('title', 'Gestión de Asignaturas')

@section('dashboard-content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Asignaturas Registradas</h2>
        <a href="{{ route('admin.subjects.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
            + Crear Asignatura
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <form method="GET" action="{{ route('admin.subjects') }}"
            class="mb-6 px-6 py-4 bg-gray-50 border-b border-gray-200 flex flex-wrap items-center gap-4 rounded-t-lg">
            <div class="flex items-center gap-2">
                <label for="course_id" class="text-sm font-semibold text-gray-700">Filtrar por curso:</label>
                <select name="course_id" id="course_id"
                    class="border-gray-300 rounded px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded transition">
                    Aplicar filtro
                </button>
            </div>
        </form>


        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Descripción</th>
                    <th class="px-6 py-3">Curso</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse($subjects as $subject)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $subject->id }}</td>
                        <td class="px-6 py-4">{{ $subject->name }}</td>
                        <td class="px-6 py-4">{{ $subject->description }}</td>
                        <td class="px-6 py-4">{{ $subject->course?->name ?? 'Sin curso' }}</td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ route('admin.subjects.edit', $subject->id) }}"
                                class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition">
                                Editar
                            </a>

                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST"
                                class="inline-block"
                                onsubmit="return confirm('¿Estás seguro de eliminar esta asignatura?');">
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
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            No hay asignaturas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $subjects->links() }}
    </div>
@endsection
