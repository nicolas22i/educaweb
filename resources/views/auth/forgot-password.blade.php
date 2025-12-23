<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full glass-card rounded-2xl p-8 animate-entrance">
            <!-- Logo con animación -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/educaweb-logo.png') }}" alt="EducaWeb" class="w-24 mx-auto mb-4 logo-animation">
                <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 mb-1">¿Olvidaste tu contraseña?</h2>
                <p class="text-gray-500 px-4 text-sm">Introduce tu correo electrónico y te enviaremos un enlace para restablecerla.</p>
            </div>

            <!-- Línea decorativa -->
            <div class="relative flex py-2 items-center mb-6">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink mx-3 text-gray-400 text-sm">Recuperar acceso</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            <!-- Mensaje de estado -->
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center animate-entrance">
                    <i class="bi bi-check-circle mr-2"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus
                            class="custom-input w-full pl-10 pr-4 py-2 rounded-lg" placeholder="Correo electrónico" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                </div>

                <!-- Botón de enviar enlace -->
                <button type="submit"
                    class="btn-gradient text-white font-semibold mt-4 py-2 px-4 rounded-lg w-full flex items-center justify-center">
                    <i class="bi bi-send mr-2"></i>
                    Enviar enlace de recuperación
                </button>
            </form>

            <!-- Separador -->
            <div class="relative flex py-4 items-center my-4">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink mx-4 text-gray-400 text-sm">o</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            <!-- Volver al login -->
            <div class="text-center">
                <a href="{{ route('login') }}" 
                   class="block w-full bg-white hover:bg-gray-50 text-blue-600 font-medium py-2 px-4 border border-blue-200 rounded-lg transition flex items-center justify-center">
                    <i class="bi bi-arrow-left mr-2"></i>
                    Volver al inicio de sesión
                </a>
            </div>

            <!-- Enlaces adicionales -->
            <div class="mt-6 text-center text-xs text-gray-500 space-x-3">
                <a href="#" class="hover:text-gray-700">Privacidad</a>
                <span>•</span>
                <a href="#" class="hover:text-gray-700">Términos</a>
                <span>•</span>
                <a href="#" class="hover:text-gray-700">Contacto</a>
            </div>
        </div>
    </div>

    <!-- Estilos adicionales -->
    <style>
        /* Efecto vidrio para tarjetas */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
        }
        
        /* Animación para el logo */
        .logo-animation {
            animation: pulse-glow 3s infinite alternate;
        }
        
        @keyframes pulse-glow {
            0% {
                transform: scale(1);
                filter: drop-shadow(0 0 5px rgba(59, 130, 246, 0.3));
            }
            100% {
                transform: scale(1.05);
                filter: drop-shadow(0 0 15px rgba(59, 130, 246, 0.7));
            }
        }
        
        /* Animación de entrada */
        .animate-entrance {
            animation: fadeInUp 0.8s ease forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
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
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
        }
        
        /* Estilos para inputs */
        .custom-input {
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .custom-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            outline: none;
        }
        
        /* Animación para links */
        .link-hover {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .link-hover:hover {
            color: #2563eb;
        }
    </style>
</x-guest-layout>