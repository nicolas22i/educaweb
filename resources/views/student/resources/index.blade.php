@extends('layouts.student')

@section('title', 'Recursos Educativos')

@section('dashboard-content')
    <div class="mb-8">
        <p class="text-gray-600">Accede a materiales y archivos compartidos por tus profesores</p>
    </div>

    <div class="flex flex-col gap-4 mb-8 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Recursos Disponibles</h2>

        <form method="GET" action="{{ route('student.resources') }}"
            class="flex flex-wrap items-center gap-2 bg-white p-2 rounded-lg shadow-sm border border-gray-200">
            <input type="text" name="search" value="{{ request('search') }}"
                class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                placeholder="Buscar por título...">

            <select name="subject_id"
                class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                <option value="">Todas las asignaturas</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded text-sm transition-colors duration-300">
                Buscar
            </button>

            @if(request()->has('search') || request()->has('subject_id'))
                <a href="{{ route('student.resources') }}" class="text-sm text-gray-600 hover:text-gray-800 ml-2">
                    Limpiar filtros
                </a>
            @endif
        </form>
    </div>

    @if ($resources->count())
        <div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-3">
            @foreach ($resources as $resource)
                <div
                    class="group bg-white rounded-xl shadow-sm hover:shadow-lg border border-gray-200 overflow-hidden transition-all duration-300 transform hover:-translate-y-1">
                    <div class="h-3 bg-gradient-to-r from-purple-500 to-indigo-600"></div>

                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="inline-flex bg-purple-100 text-purple-600 rounded-full p-3 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>

                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition-colors">
                                    {{ $resource->title }}
                                </h3>

                                <div class="flex flex-wrap gap-2 mb-4">
                                    @if($resource->course)
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                            {{ $resource->course->name }}
                                        </span>
                                    @endif

                                    @if($resource->subject)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                            {{ $resource->subject->name }}
                                        </span>
                                    @endif

                                    <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                        Subido: {{ $resource->created_at->format('d/m/Y') }}
                                    </span>
                                </div>

                                <div class="flex gap-2 mt-2">
                                    <a href="{{ route('student.resources.download', $resource->id) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                                        </svg>
                                        Descargar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center p-10 bg-gray-50 rounded-xl border border-gray-200 mt-8">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-xl font-medium text-gray-600 mb-2">No hay recursos disponibles</p>
            <p class="text-gray-500 text-center">Cuando tus profesores compartan archivos, aparecerán aquí.</p>
        </div>
    @endif
@endsection