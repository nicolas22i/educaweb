@extends('layouts.teacher')

@section('title', 'Detalle de Estudiante')

@section('dashboard-content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <p class="text-gray-600">Información completa del estudiante</p>
    </div>
   
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Banner superior con color similar al del index -->
    <div class="h-6 bg-gradient-to-r from-green-500 to-teal-600"></div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-8">
        <!-- Columna izquierda con información principal -->
        <div class="md:col-span-1">
            <div class="flex flex-col items-center mb-6">
                <!-- Imagen de perfil más grande -->
                <div class="h-40 w-40 rounded-full overflow-hidden border-4 border-green-100 mb-4 shadow-md">
                    <img src="{{ $student->user->profile_image ? asset($student->user->profile_image) : asset('images/avatar-placeholder.png') }}"
                         alt="{{ $student->user->name }}"
                         class="h-full w-full object-cover"
                         onerror="this.onerror=null; this.src='{{ asset('images/avatar-placeholder.png') }}'">
                </div>
                
                <!-- Nombre del estudiante -->
                <h2 class="text-2xl font-bold text-gray-800 text-center">
                    {{ $student->user->name }}
                </h2>
                <p class="text-gray-500 mb-4">{{ $student->student_code }}</p>
                
            </div>
            
            <!-- Información del estudiante -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="font-semibold text-gray-700 mb-3">Información Personal</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Fecha de nacimiento</p>
                        <p class="font-medium text-gray-800">{{ $student->date_of_birth }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Teléfono</p>
                        <p class="font-medium text-gray-800">{{ $student->phone_number }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-800">{{ $student->user->email }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Dirección</p>
                        <p class="font-medium text-gray-800">{{ $student->address ?? 'No disponible' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Columna derecha con información académica -->
        <div class="md:col-span-2">
        
            
            <!-- Calificaciones -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-award text-green-600" viewBox="0 0 16 16">
                        <path d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 10.874l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.25-1.506 1.087-1.072.684-1.365 1.51-.229L8 1.126l1.356.702 1.509.229z"/>
                        <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
                    </svg>
                    Calificaciones
                </h3>
                
                @if(isset($grades) && $grades->count() > 0)
                <div class="space-y-4">
                    @foreach($grades as $grade)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-all flex justify-between items-center">
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $grade->subject->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $grade->evaluation_type ?? 'Evaluación general' }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                <span class="text-xl font-bold text-green-700">{{ $grade->grade }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <p class="text-gray-600">No hay calificaciones registradas para este estudiante.</p>
                </div>
                @endif
            </div>
            
           
        </div>
    </div>
</div>
@endsection