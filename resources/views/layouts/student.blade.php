<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel del Estudiante')</title>
    @vite('resources/css/app.css')
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        /* Fondo animado */
        .animated-bg {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        .animated-bubble {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(to right, rgba(37, 99, 235, 0.05), rgba(124, 58, 237, 0.05));
            animation: float 15s infinite ease-in-out;
            opacity: 0.9;
        }

        .animated-bubble:nth-child(1) {
            width: 150px;
            height: 150px;
            top: 10%;
            left: 10%;
            animation-duration: 25s;
        }

        .animated-bubble:nth-child(2) {
            width: 300px;
            height: 300px;
            top: 60%;
            left: 80%;
            animation-duration: 30s;
            animation-delay: 2s;
        }

        .animated-bubble:nth-child(3) {
            width: 200px;
            height: 200px;
            top: 80%;
            left: 30%;
            animation-duration: 20s;
            animation-delay: 1s;
        }

        .animated-bubble:nth-child(4) {
            width: 120px;
            height: 120px;
            top: 30%;
            left: 60%;
            animation-duration: 22s;
            animation-delay: 3s;
        }

        .animated-bubble:nth-child(5) {
            width: 180px;
            height: 180px;
            top: 50%;
            left: 5%;
            animation-duration: 28s;
            animation-delay: 4s;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(50px, -50px) scale(1.05);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.95);
            }

            100% {
                transform: translate(0, 0) scale(1);
            }
        }

        /* Mejoras visuales a elementos existentes */
        header {
            background: rgba(31, 41, 55, 0.95);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        /* Logo y texto */
        header a img {
            transition: transform 0.3s ease;
        }

        header a:hover img {
            transform: scale(1.05);
        }

        header .text-lg {
            background: linear-gradient(45deg, #60a5fa 30%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.3s ease;
        }

        header a:hover .text-lg {
            text-shadow: 0 0 10px rgba(96, 165, 250, 0.6);
        }

        /* Sidebar */
        #sidebar {
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1);
            background: rgba(31, 41, 55, 0.95);
            backdrop-filter: blur(10px);
        }

        #sidebar a {
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            color: rgba(229, 231, 235, 0.9);
        }

        #sidebar a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #60a5fa, #818cf8);
            transform: translateX(-4px);
            transition: transform 0.3s ease;
            opacity: 0;
        }

        #sidebar a:hover {
            color: #fff;
            background-color: rgba(55, 65, 81, 0.7);
        }

        #sidebar a:hover::before {
            transform: translateX(0);
            opacity: 1;
        }

        #sidebar a:hover i {
            transform: translateY(-2px);
            color: #60a5fa;
        }

        #sidebar a.active {
            background-color: rgba(59, 130, 246, 0.2);
            color: #fff;
        }

        #sidebar a.active::before {
            transform: translateX(0);
            opacity: 1;
        }

        #sidebar a.active i {
            color: #60a5fa;
        }

        /* Botones y elementos interactivos */
        button {
            transition: all 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
        }

        /* Tarjetas de contenido */
        .content-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .content-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        /* Animación de entrada para alertas */
        .bg-green-100 {
            animation: slideIn 0.5s ease forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animated-title {
            background: linear-gradient(90deg, #60a5fa, #93c5fd, #8995FA, #60a5fa);
            background-size: 300% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientMove 5s ease-in-out infinite alternate;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            100% {
                background-position: 100% 50%;
            }
        }

        /* Contenido principal con fondo y sombra */
        .main-content {
            background-color: #f9fafb;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
        }



        /* Separador más visible */
        .sidebar-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(156, 163, 175, 0.3), transparent);
            margin: 0.75rem 0;
        }

        /* Perfil de usuario en header */
        .user-profile {
            background-color: rgba(55, 65, 81, 0.5);
            border: 1px solid rgba(75, 85, 99, 0.3);
            transition: all 0.3s ease;
        }

        .user-profile:hover {
            background-color: rgba(55, 65, 81, 0.7);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Fondo animado -->
    <div class="animated-bg">
        <div class="animated-bubble"></div>
        <div class="animated-bubble"></div>
        <div class="animated-bubble"></div>
        <div class="animated-bubble"></div>
        <div class="animated-bubble"></div>
    </div>

    <!-- Header/Navbar Superior oscuro -->
    <header class="fixed top-0 left-0 right-0 z-30 h-16">
        <div class="flex justify-between items-center px-4 h-full">
            <!-- Logo y Toggle del sidebar -->
            <div class="flex items-center gap-4">
                <button id="sidebar-toggle" class="lg:hidden text-gray-300 hover:text-blue-400 transition">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/educaweb-logo.png') }}" alt="EducaWeb" class="h-8">
                    <div class="flex flex-col">
                        <span class="text-lg font-bold text-blue-400 leading-tight">EducaWeb</span>
                    </div>
                </a>
            </div>

            <!-- Centro - Título de la página actual -->
            <div class="hidden md:block">
                <h2 class="text-base font-semibold text-gray-200">Academia Marco</h2>
            </div>
            <!-- Perfil de usuario (simplificado) -->
            <a href="{{ route('profile.show') }}"
                class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-gray-700 transition user-profile">
                @if(Auth::check())
                    <img src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('images/avatar-placeholder.png') }}"
                        alt="Usuario" class="h-8 w-8 rounded-full border border-gray-600 object-cover">
                @else
                    <img src="{{ asset('images/avatar-placeholder.png') }}" alt="Usuario"
                        class="h-8 w-8 rounded-full border border-gray-600">
                @endif
                <div class="hidden md:block">
                    <p class="text-sm font-medium text-gray-200 leading-tight">{{ Auth::user()->name ?? 'Invitado' }}
                    </p>
                    <p class="text-xs text-gray-400 leading-tight capitalize">ESTUDIANTE</p>
                </div>
            </a>
        </div>
    </header>

    <div class="flex pt-16 h-screen">
        <aside id="sidebar"
            class="w-64 fixed left-0 top-16 h-[calc(100vh-4rem)] z-20 transform transition-transform duration-300 lg:translate-x-0 -translate-x-full lg:translate-x-0">
            <nav class="p-4 text-sm h-full flex flex-col">
                <div class="mb-6 px-2">
                    <p class="text-xs uppercase font-semibold text-gray-400 tracking-wider">Panel del estudiante</p>
                </div>

                <ul class="space-y-1 flex-1">
                    <li>
                        <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg transition
                            {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                            <i
                                class="bi bi-speedometer2 text-lg {{ request()->routeIs('student.dashboard') ? 'text-blue-400' : 'text-gray-400' }}"></i>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.subjects') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg transition
                            {{ request()->routeIs('student.subjects*') ? 'active' : '' }}">
                            <i
                                class="bi bi-journals text-lg {{ request()->routeIs('student.subjects*') ? 'text-blue-400' : 'text-gray-400' }}"></i>
                            Mis Asignaturas
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.tasks') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg transition
                            {{ request()->routeIs('student.tasks*') ? 'active' : '' }}">
                            <i
                                class="bi bi-list-task text-lg {{ request()->routeIs('student.tasks*') ? 'text-blue-400' : 'text-gray-400' }}"></i>
                            Mis Tareas
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.attendances') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg transition
                            {{ request()->routeIs('student.attendances*') ? 'active' : '' }}">
                            <i
                                class="bi bi-calendar-check text-lg {{ request()->routeIs('student.attendances*') ? 'text-blue-400' : 'text-gray-400' }}"></i>
                            Asistencia
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.chat') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg transition
                            {{ request()->routeIs('student.chat*') ? 'active' : '' }}">
                            <i
                                class="bi bi-chat-left-dots text-lg {{ request()->routeIs('student.chat*') ? 'text-blue-400' : 'text-gray-400' }}"></i>
                            Chat
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.resources') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg transition
                            {{ request()->routeIs('student.resources*') ? 'active' : '' }}">
                            <i
                                class="bi bi-archive text-lg {{ request()->routeIs('student.resources*') ? 'text-blue-400' : 'text-gray-400' }}"></i>
                            Recursos
                        </a>
                    </li>
                </ul>

                <div class="mt-auto pt-4 border-t border-gray-700">
                    <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('¿Cerrar sesión?')">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-2 px-4 py-2 text-left rounded hover:bg-red-900 text-red-300 transition">
                            <i class="bi bi-box-arrow-left text-base text-red-300"></i>
                            Cerrar sesión
                        </button>
                    </form>

                    <div class="flex items-center justify-between px-3 py-2 text-xs text-gray-400 mt-4">
                        <span>© 2025 EducaWeb</span>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 ml-0 lg:ml-64 p-6 overflow-y-auto">
            <div class="main-content p-6">
                <!-- Breadcrumb -->


                <!-- Titulo de página y acciones -->
                <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
                    <h1 class="text-5xl font-bold animated-title leading-tight">@yield('title')</h1>

                    <div class="mt-4 md:mt-0">
                        @yield('page-actions')
                    </div>
                </div>

                <!-- Mensajes de alerta -->
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                        <div class="flex items-center">
                            <i class="bi bi-check-circle-fill mr-2"></i>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Contenido de la página -->
                @yield('dashboard-content')
            </div>
        </main>
    </div>

    <!-- Script para el toggle del sidebar en móvil -->
    <script>
        document.getElementById('sidebar-toggle').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });

        // Cerrar sidebar en móvil cuando se hace click fuera
        document.addEventListener('click', function (event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');

            if (window.innerWidth < 1024 &&
                !sidebar.contains(event.target) &&
                !sidebarToggle.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Animación de entrada para elementos
        document.addEventListener('DOMContentLoaded', function () {
            const pageContent = document.querySelector('main');
            if (pageContent) {
                const contentElements = pageContent.querySelectorAll('.content-card');
                contentElements.forEach((element, index) => {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(20px)';
                    element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

                    setTimeout(() => {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }, 100 + (index * 50));
                });
            }
        });
    </script>
    <!-- Scripts -->
    @stack('scripts')
    @yield('scripts')
</body>

</html>