<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 py-8 sm:py-12 relative">
        <!-- Tarjeta principal con efecto glass - ahora responsive -->
        <div
            class="glass-card max-w-2xl w-full rounded-xl sm:rounded-2xl p-6 sm:p-10 mx-4 text-center relative overflow-hidden animate-entrance z-20">
            <!-- Destellos de luz en esquinas - ajustados para móvil -->

            <div
                class="absolute -bottom-5 sm:-bottom-10 -left-5 sm:-left-10 w-20 sm:w-40 h-20 sm:h-40 bg-indigo-300 rounded-full opacity-20 blur-md sm:blur-lg">
            </div>

            <!-- Logo con animación - tamaño responsive -->
            <div class="mb-6 sm:mb-8">
                <img src="{{ asset('images/educaweb-logo.png') }}" alt="EducaWeb"
                    class="w-24 sm:w-36 mx-auto logo-animation">
            </div>

            <!-- Título con efecto glow - tamaño responsive -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-3 sm:mb-4 text-glow">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600">
                    EducaWeb
                </span>
            </h1>

            <p class="text-lg sm:text-xl font-light text-gray-600 mb-3 sm:mb-4">
                La plataforma educativa que transforma la gestión académica
            </p>

            <p class="text-sm sm:text-base text-gray-500 mb-6 sm:mb-8">
                Gestiona estudiantes, profesores y cursos en un solo lugar
                con una interfaz intuitiva y potentes herramientas.
            </p>

            <!-- Iconos de características - ahora responsive (1 columna móvil, 3 columnas desktop) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 md:gap-8 mb-8 sm:mb-12">
                <div class="flex flex-col items-center animate-entrance" style="animation-delay: 0.3s;">
                    <div
                        class="rounded-full p-3 sm:p-4 mb-2 sm:mb-3 bg-gradient-to-br from-blue-100 to-blue-200 shadow-lg">
                        <i class="bi bi-mortarboard text-blue-600 text-xl sm:text-2xl"></i>
                    </div>
                    <span class="font-medium text-gray-700 text-sm sm:text-base">Gestión Académica</span>
                </div>
                <div class="flex flex-col items-center animate-entrance" style="animation-delay: 0.5s;">
                    <div
                        class="rounded-full p-3 sm:p-4 mb-2 sm:mb-3 bg-gradient-to-br from-indigo-100 to-indigo-200 shadow-lg">
                        <i class="bi bi-people text-indigo-600 text-xl sm:text-2xl"></i>
                    </div>
                    <span class="font-medium text-gray-700 text-sm sm:text-base">Comunidad Educativa</span>
                </div>
                <div class="flex flex-col items-center animate-entrance" style="animation-delay: 0.7s;">
                    <div
                        class="rounded-full p-3 sm:p-4 mb-2 sm:mb-3 bg-gradient-to-br from-blue-100 to-indigo-200 shadow-lg">
                        <i class="bi bi-graph-up text-blue-600 text-xl sm:text-2xl"></i>
                    </div>
                    <span class="font-medium text-gray-700 text-sm sm:text-base">Análisis de Rendimiento</span>
                </div>
            </div>

            <!-- Botones de acción - apilados verticalmente en móvil -->
            <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-5 mb-6 sm:mb-8">
                <a href="{{ route('login') }}"
                    class="btn-gradient text-white font-medium py-2 sm:py-3 px-6 sm:px-8 rounded-lg sm:rounded-xl shadow-lg flex items-center justify-center group text-sm sm:text-base">
                    <i class="bi bi-box-arrow-in-right mr-2 group-hover:translate-x-1 transition-transform"></i>
                    Iniciar Sesión
                </a>
                <a href="{{ route('register') }}"
                    class="bg-white text-indigo-600 border border-indigo-100 hover:border-indigo-300 font-medium py-2 sm:py-3 px-6 sm:px-8 rounded-lg sm:rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center group text-sm sm:text-base mt-2 sm:mt-0">
                    <i class="bi bi-person-plus mr-2 group-hover:rotate-12 transition-transform"></i>
                    Registrarse
                </a>
            </div>
        </div>
    </div>

    <!-- Script para animaciones adicionales - optimizado para móvil -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Solo activar animaciones complejas en desktop
            if (window.innerWidth > 768) {
                // Animación para testimonios
                const testimonialSlider = document.querySelector('.testimonial-slider');
                if (testimonialSlider) {
                    let currentPosition = 0;
                    const testimonials = testimonialSlider.children;
                    const testimonialHeight = testimonials[0].offsetHeight;

                    setInterval(() => {
                        currentPosition = (currentPosition + 1) % testimonials.length;
                        testimonialSlider.style.transform = `translateY(-${currentPosition * testimonialHeight}px)`;
                        testimonialSlider.style.transition = 'transform 0.5s ease';
                    }, 5000);
                }
            }

            // Animación de entrada para elementos (más rápida en móvil)
            const animateElements = document.querySelectorAll('.animate-entrance');
            animateElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(10px)';
                element.style.transition = window.innerWidth <= 640 ?
                    'opacity 0.5s ease, transform 0.5s ease' :
                    'opacity 0.8s ease, transform 0.8s ease';

                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, window.innerWidth <= 640 ? 100 + (index * 100) : 200 + (index * 150));
            });
        });
    </script>

    <!-- Estilos adicionales - optimizados para responsive -->
    <style>
        /* Estilo para el slider de testimonios */
        .testimonial-slider {
            transition: transform 0.8s ease;
        }

        /* Animación de entrada */
        .animate-entrance {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        /* Animación para el logo - simplificada en móvil */
        .logo-animation {
            animation: pulse-glow 3s infinite alternate;
        }

        @media (max-width: 640px) {
            .logo-animation {
                animation: none;
                filter: drop-shadow(0 0 8px rgba(59, 130, 246, 0.4));
            }
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

        /* Animación para textos - simplificada en móvil */
        .text-glow {
            animation: text-pulse 3s infinite alternate;
        }

        @media (max-width: 640px) {
            .text-glow {
                animation: none;
                text-shadow: 0 0 5px rgba(59, 130, 246, 0.3);
            }
        }

        @keyframes text-pulse {
            0% {
                text-shadow: 0 0 5px rgba(59, 130, 246, 0);
            }

            100% {
                text-shadow: 0 0 10px rgba(59, 130, 246, 0.4);
            }
        }

        /* Efecto vidrio para tarjetas - ajustado para móvil */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        @media (max-width: 640px) {
            .glass-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(5px);
            }
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(31, 38, 135, 0.15);
        }

        /* Estilos para botones - responsive */
        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
        }

        @media (max-width: 640px) {

            .btn-gradient,
            .btn-gradient:hover {
                transform: none;
            }
        }

        /* Animación para links */
        .link-hover {
            position: relative;
            transition: all 0.3s ease;
        }

        .link-hover::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(90deg, #3b82f6, #6366f1);
            transition: width 0.3s ease;
        }

        .link-hover:hover::after {
            width: 100%;
        }
    </style>
</x-guest-layout>