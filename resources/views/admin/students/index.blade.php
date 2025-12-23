@extends('layouts.admin')
@section('title', 'Gestión de Estudiantes')

@section('dashboard-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Estudiantes Registrados</h2>
    <a href="{{ route('admin.students.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
        + Crear Estudiante
    </a>
</div>

<div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full text-left text-sm">
        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
            <tr>
                <th class="px-6 py-3">ID</th>
                <th class="px-6 py-3">Nombre</th>
                <th class="px-6 py-3">Código</th>
                <th class="px-6 py-3">Curso</th>
                <th class="px-6 py-3">Teléfono</th>
                <th class="px-6 py-3">Dirección</th>
                <th class="px-6 py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @forelse($students as $student)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4">{{ $student->id }}</td>
                <td class="px-6 py-4">{{ $student->user->name }}</td>
                <td class="px-6 py-4">{{ $student->student_code }}</td>
                <td class="px-6 py-4">
                    {{ $student->course ? $student->course->name : 'Sin asignar' }}
                </td>
                <td class="px-6 py-4">{{ $student->phone_number }}</td>
                <td class="px-6 py-4">{{ $student->address }}</td>
                <td class="px-6 py-4 text-center space-x-2">
                    <a href="{{ route('admin.students.edit', $student->id) }}"
                        class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition">
                        Editar
                    </a>

                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                        class="inline-block"
                        onsubmit="return confirm('¿Estás seguro de eliminar este estudiante?');">
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
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                    No hay estudiantes registrados.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $students->links() }}
</div>
@endsection