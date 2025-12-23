@extends('layouts.student')

@section('dashboard-content')
    <!-- Contenido para cuando NO hay curso asignado -->
    <div class="py-6" id="no-course-section">
        <div class="max-w-3xl mx-auto px-4 lg:px-6">
            <div class="glass-card rounded-xl p-6 animate-entrance">
                <!-- Ilustración central -->
                <div class="text-center mb-4">
                    <div class="relative w-40 h-40 mx-auto mb-4">
                        <!-- Círculo decorativo de fondo -->
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 animate-pulse-slow"></div>
                        
                        <!-- Ícono central -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="bi bi-journal-bookmark text-indigo-500 text-5xl"></i>
                        </div>
                        
                        <!-- Elementos decorativos orbitando -->
                        <div class="absolute w-full h-full animate-orbit">
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 bg-blue-500 w-6 h-6 rounded-lg opacity-30"></div>
                        </div>
                        <div class="absolute w-full h-full animate-orbit-reverse">
                            <div class="absolute top-1/2 left-0 -translate-y-1/2 bg-indigo-500 w-4 h-4 rounded-full opacity-30"></div>
                        </div>
                        <div class="absolute w-full h-full animate-orbit-slow">
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 bg-purple-500 w-6 h-3 rounded-full opacity-30"></div>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-bold mb-2 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                        No tienes curso asignado
                    </h2>
                    
                    <p class="text-base text-gray-600 mb-4 max-w-lg mx-auto">
                        Tu cuenta ha sido creada correctamente, pero aún no se te ha asignado ningún curso.
                    </p>
                </div>
                
                <!-- Tarjeta de información -->
                <div class="bg-white border border-blue-100 rounded-lg p-4 shadow-sm mb-5">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-blue-100 rounded-full p-2">
                            <i class="bi bi-info-circle text-blue-600 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="font-semibold text-gray-800 mb-1 text-sm">¿Qué debes hacer?</h3>
                            <p class="text-gray-600 text-sm">
                                El administrador debe asignarte a tu curso correspondiente. Una vez completado, podrás ver tu curso en este panel.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Pasos a seguir -->
                <div class="grid md:grid-cols-3 gap-3 mb-4">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-3 rounded-lg border border-blue-200 flex flex-col items-center text-center animate-entrance-delay-1">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mb-2 shadow-md">
                            1
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1 text-sm">Espera asignación</h3>
                        <p class="text-gray-600 text-xs">Tu administrador está revisando tu perfil para asignarte el curso apropiado.</p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-3 rounded-lg border border-indigo-200 flex flex-col items-center text-center animate-entrance-delay-2">
                        <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold mb-2 shadow-md">
                            2
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1 text-sm">Recibe notificación</h3>
                        <p class="text-gray-600 text-xs">Recibirás un correo cuando se te asigne un curso en la plataforma.</p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-3 rounded-lg border border-purple-200 flex flex-col items-center text-center animate-entrance-delay-3">
                        <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold mb-2 shadow-md">
                            3
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1 text-sm">Comienza a aprender</h3>
                        <p class="text-gray-600 text-xs">Accede a tu curso y materiales de estudio desde tu panel personal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estilos adicionales -->
    <style>
        /* Efecto vidrio para tarjetas */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 6px 24px rgba(31, 38, 135, 0.08);
        }
        
        /* Animación de entrada */
        .animate-entrance {
            animation: fadeInUp 0.7s ease forwards;
            opacity: 0;
        }
        
        .animate-entrance-delay-1 {
            animation: fadeInUp 0.7s ease forwards;
            animation-delay: 0.15s;
            opacity: 0;
        }
        
        .animate-entrance-delay-2 {
            animation: fadeInUp 0.7s ease forwards;
            animation-delay: 0.3s;
            opacity: 0;
        }
        
        .animate-entrance-delay-3 {
            animation: fadeInUp 0.7s ease forwards;
            animation-delay: 0.45s;
            opacity: 0;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Animación de pulso lento */
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 0.3;
            }
            50% {
                opacity: 0.6;
            }
        }
        
        /* Animación para el ícono central */
        .bi-journal-bookmark {
            animation: iconPulse 3s infinite alternate;
        }
        
        @keyframes iconPulse {
            0% {
                transform: scale(1);
                filter: drop-shadow(0 0 3px rgba(79, 70, 229, 0.3));
            }
            100% {
                transform: scale(1.1);
                filter: drop-shadow(0 0 10px rgba(79, 70, 229, 0.7));
            }
        }
        
        /* Animaciones de órbita */
        .animate-orbit {
            animation: orbit 15s linear infinite;
        }
        
        .animate-orbit-reverse {
            animation: orbit 12s linear infinite reverse;
        }
        
        .animate-orbit-slow {
            animation: orbit 20s linear infinite;
        }
        
        @keyframes orbit {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Estilos para botones */
        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }
    </style>
@endsection