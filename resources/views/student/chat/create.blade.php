@extends('layouts.student')

@section('dashboard-content')
<div class="max-w-md mx-auto px-4 py-8">
    <!-- Encabezado con botón de volver mejorado -->
    <div class="flex items-center mb-8">
        <a href="{{ route('student.chat') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors mr-4">
            <i class="bi bi-arrow-left text-xl mr-2"></i>
            <span class="font-medium">Volver</span>
        </a>
    </div>

    <!-- Tarjeta con efecto de elevación y bordes más suaves -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Cabecera de la tarjeta con gradiente -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">Nuevo chat</h2>
            <p class="text-blue-100 text-sm mt-1">Selecciona un profesor para comenzar</p>
        </div>

        <!-- Cuerpo del formulario -->
        <form action="{{ route('student.chat.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-6">
                <label for="teacher_id" class="block text-gray-700 font-medium mb-3">Profesor</label>
                <div class="relative">
                    <select name="teacher_id" id="teacher_id" 
                            class="appearance-none w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Seleccionar profesor...</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">
                                {{ $teacher->user->name }} - {{ $teacher->specialization }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="bi bi-chat-left-text mr-2"></i> Iniciar conversación
            </button>
        </form>
    </div>

    <!-- Efecto visual decorativo opcional -->
    <div class="mt-8 text-center">
        <p class="text-gray-400 text-sm">
            <i class="bi bi-info-circle mr-1"></i> Podrás enviar mensajes una vez creado el chat
        </p>
    </div>
</div>

<style>
    /* Estilo personalizado para el select */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }
</style>
@endsection