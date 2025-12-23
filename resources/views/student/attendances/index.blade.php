@extends('layouts.student')

@section('title', 'Mi Asistencia')

@section('dashboard-content')

    <div class="mb-8">
        <p class="text-gray-600">Consulta tu historial de asistencia por asignatura o fechas.</p>
    </div>

    <!-- FILTRO -->
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <select name="subject_id" class="border rounded px-3 py-2">
            <option value="">Todas las asignaturas</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>

        <input type="date" name="from_date" value="{{ request('from_date') }}" class="border rounded px-3 py-2"
            placeholder="Desde">
        <input type="date" name="to_date" value="{{ request('to_date') }}" class="border rounded px-3 py-2"
            placeholder="Hasta">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Filtrar
        </button>
    </form>

    <!-- RESUMEN -->
    <div
        class="bg-white border border-gray-200 rounded-lg p-4 mb-6 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="bg-green-100 text-green-600 p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Asistencia total</p>
                <p class="font-bold text-lg text-gray-800">{{ $attendanceRate }}%</p>
            </div>
        </div>
    </div>

    @if($attendances->isEmpty())
        <div class="bg-white p-6 rounded-lg text-center text-gray-600 border border-gray-200">
            No hay registros de asistencia disponibles para los filtros seleccionados.
        </div>
    @else
        <!-- LISTADO -->
        <div class="overflow-auto bg-white rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Asignatura</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($attendances as $attendance)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">{{ $attendance->subject->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                @if ($attendance->status === 'present')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Presente</span>
                                @elseif ($attendance->status === 'absent')
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">Ausente</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">Tarde</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $attendances->withQueryString()->links() }}
        </div>
    @endif

@endsection