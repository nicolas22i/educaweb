@extends('layouts.teacher')

@section('title', 'Asistencia')

@section('dashboard-content')
<div class="mb-8">
    <p class="text-gray-600">Gestiona y registra la asistencia de tus estudiantes</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Banner superior con color aleatorio -->
    <div class="h-3 bg-gradient-to-r from-amber-500 to-orange-600"></div>
    
    <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
            <span class="inline-flex bg-amber-100 text-amber-600 rounded-full p-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </span>
            Registro de Asistencia
        </h2>

        <!-- Formulario selector con diseño mejorado -->
        <div class="bg-amber-50 rounded-lg p-4 mb-6 border border-amber-100">
            <form method="GET" action="{{ route('teacher.attendance') }}" class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
                <div class="w-full sm:w-1/2">
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Asignatura</label>
                    <select name="subject_id" id="subject_id" onchange="this.form.submit()"
                        class="block w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-base text-gray-900 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 shadow-sm">
                        <option value="">Selecciona una asignatura</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full sm:w-1/2">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="date" name="date" id="date" value="{{ now()->format('Y-m-d') }}" readonly
                            class="w-full pl-10 p-2 border border-gray-300 rounded bg-gray-100 cursor-not-allowed shadow-sm">
                    </div>
                </div>
            </form>
        </div>

        <!-- Contenido condicional -->
        @if(isset($selectedSubject) && $selectedSubject)
            <form method="POST" action="{{ route('teacher.attendance.store') }}" class="animate__animated animate__fadeIn">
                @csrf
                <input type="hidden" name="subject_id" value="{{ $selectedSubject->id }}">
                <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-amber-500 to-orange-600 text-white">
                                <th class="px-6 py-3 text-left font-medium">Estudiante</th>
                                <th class="px-6 py-3 text-center font-medium">Presente</th>
                                <th class="px-6 py-3 text-center font-medium">Tarde</th>
                                <th class="px-6 py-3 text-center font-medium">Ausente</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($students as $student)
                                @php
                                    $attendance = $attendances->get($student->id);
                                @endphp
                                <tr class="hover:bg-amber-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        <div class="flex items-center gap-3">
                                            <!-- Aquí está el cambio para mostrar la imagen -->
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden border border-gray-200">
                                                <img src="{{ $student->user->profile_image ? asset($student->user->profile_image) : asset('images/avatar-placeholder.png') }}"
                                                    alt="{{ $student->user->name }}"
                                                    class="h-full w-full object-cover"
                                                    onerror="this.onerror=null; this.src='{{ asset('images/avatar-placeholder.png') }}'">
                                            </div>
                                            <div>{{ $student->user->name }}</div>
                                        </div>
                                    </td>
                                    
                                    <!-- Estado: Presente -->
                                    <td class="px-6 py-4 text-center">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="present"
                                                {{ $attendance && $attendance->status === 'present' ? 'checked' : '' }}
                                                class="sr-only peer" required>
                                            <div class="w-24 h-10 flex items-center justify-center rounded-md border-2 border-gray-200 
                                                     peer-checked:border-green-500 peer-checked:bg-green-50 transition-all">
                                                <span class="text-sm font-medium text-gray-600 peer-checked:text-green-700">Presente</span>
                                            </div>
                                        </label>
                                    </td>
                                    
                                    <!-- Estado: Tarde -->
                                    <td class="px-6 py-4 text-center">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="late"
                                                {{ $attendance && $attendance->status === 'late' ? 'checked' : '' }}
                                                class="sr-only peer" required>
                                            <div class="w-24 h-10 flex items-center justify-center rounded-md border-2 border-gray-200 
                                                     peer-checked:border-yellow-500 peer-checked:bg-yellow-50 transition-all">
                                                <span class="text-sm font-medium text-gray-600 peer-checked:text-yellow-700">Tarde</span>
                                            </div>
                                        </label>
                                    </td>
                                    
                                    <!-- Estado: Ausente -->
                                    <td class="px-6 py-4 text-center">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="absent"
                                                {{ $attendance && $attendance->status === 'absent' ? 'checked' : '' }}
                                                class="sr-only peer" required>
                                            <div class="w-24 h-10 flex items-center justify-center rounded-md border-2 border-gray-200 
                                                     peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                                <span class="text-sm font-medium text-gray-600 peer-checked:text-red-700">Ausente</span>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                        No hay estudiantes disponibles para esta asignatura.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M5 13l4 4L19 7" />
                        </svg>
                        Guardar Asistencia
                    </button>
                </div>
            </form>
        @else
            <div class="flex flex-col items-center justify-center p-10 bg-gray-50 rounded-xl border border-gray-200 mt-8">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <p class="text-xl font-medium text-gray-600 mb-2">Selecciona una asignatura</p>
                <p class="text-gray-500 text-center">Elige una asignatura del menú desplegable<br>para comenzar a registrar la asistencia.</p>
            </div>
        @endif
    </div>
</div>
@endsection