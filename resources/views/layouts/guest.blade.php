<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>EducaWeb - Portal Educativo</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Estilos generales para formularios */
        .form-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Media queries para responsive */
        @media (max-width: 640px) {
            body {
                overflow-x: hidden;
                /* Previene la barra de scroll horizontal */
            }

            .glass-card {
                padding: 1.5rem !important;
                margin: 0.5rem;
                width: calc(100% - 1rem);
            }

            .form-input {
                width: 100%;
                box-sizing: border-box;
            }

            .form-actions {
                flex-direction: column;
                gap: 0.5rem;
            }

            .form-footer {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
        }

        /* Ajustes para móvil */
        @media (max-width: 640px) {
            .side-glow {
                width: 70%;
                height: 40%;
                filter: blur(40px);
            }

            .side-glow-left {
                left: -30%;
            }

            .side-glow-right {
                right: -30%;
            }

            .grid-overlay {
                background-size: 20px 20px;
            }

            .nebula {
                filter: blur(30px);
            }

            .glass-card {
                backdrop-filter: blur(5px);
            }
        }

        /* Ajustes para tablets */
        @media (min-width: 641px) and (max-width: 1024px) {
            .side-glow {
                width: 50%;
                filter: blur(60px);
            }
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background-color: #0f172a;
            color: #e2e8f0;
            margin: 0;
            padding: 0;
        }

        /* Fondo base con gradiente */
        .background-container {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -2;
            background: radial-gradient(circle at 10% 20%, rgba(21, 94, 117, 0.3) 0%, rgba(14, 30, 58, 0) 80%);
        }

        /* Efecto de nebulosa */
        .nebula {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -3;
            background:
                radial-gradient(circle at 90% 75%, rgba(98, 93, 220, 0.15) 0%, rgba(21, 45, 90, 0) 50%),
                radial-gradient(circle at 10% 25%, rgba(55, 160, 201, 0.15) 0%, rgba(21, 45, 90, 0) 50%);
            filter: blur(50px);
        }

        /* Grid luminoso */
        .grid-overlay {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            background-image:
                linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            background-position: -1px -1px;
        }

        /* Burbujas animadas que suben desde abajo */
        .bubbles-container {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
        }



        @keyframes rise {
            0% {
                transform: translateY(100vh) scale(0.8);
                opacity: 0;
            }

            10% {
                opacity: 0.7;
            }

            90% {
                opacity: 0.7;
            }

            100% {
                transform: translateY(-20vh) scale(1.2);
                opacity: 0;
            }
        }

        /* Decoración superior con efecto de neón */
        .top-decoration {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #6366f1, #8b5cf6);
            z-index: 10;
            box-shadow:
                0 0 10px rgba(59, 130, 246, 0.5),
                0 0 20px rgba(99, 102, 241, 0.3),
                0 0 30px rgba(139, 92, 246, 0.2);
        }

        /* Decoración inferior con efecto neón */
        .bottom-decoration {
            position: absolute;
            bottom: 45px;
            left: 0;
            width: 100%;
            overflow: hidden;
            height: 2px;
            background: linear-gradient(90deg, #6366f1, #3b82f6, #6366f1);
            box-shadow:
                0 0 10px rgba(99, 102, 241, 0.5),
                0 0 20px rgba(59, 130, 246, 0.3);
            z-index: 10;
        }

        /* Efecto para los costados */
        .side-glow {
            position: fixed;
            width: 30%;
            height: 60%;
            filter: blur(80px);
            z-index: -2;
            opacity: 0.15;
            border-radius: 50%;
        }

        .side-glow-left {
            top: 20%;
            left: -15%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.8), rgba(59, 130, 246, 0));
            animation: pulse-left 8s infinite alternate ease-in-out;
        }

        .side-glow-right {
            top: 30%;
            right: -15%;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.8), rgba(139, 92, 246, 0));
            animation: pulse-right 10s infinite alternate ease-in-out;
        }

        @keyframes pulse-left {
            0% {
                opacity: 0.1;
                transform: scale(0.95);
            }

            100% {
                opacity: 0.2;
                transform: scale(1.05);
            }
        }

        @keyframes pulse-right {
            0% {
                opacity: 0.1;
                transform: scale(1.05);
            }

            100% {
                opacity: 0.2;
                transform: scale(0.95);
            }
        }

        /* Efectos para tarjetas de contenido */
        .glass-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            box-shadow:
                0 8px 32px rgba(15, 23, 42, 0.3),
                0 2px 1px rgba(255, 255, 255, 0.05) inset,
                0 -1px 1px rgba(0, 0, 0, 0.2) inset;
            border: 1px solid rgba(71, 85, 105, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow:
                0 15px 40px rgba(15, 23, 42, 0.4),
                0 2px 1px rgba(255, 255, 255, 0.1) inset,
                0 -1px 1px rgba(0, 0, 0, 0.3) inset,
                0 0 8px rgba(59, 130, 246, 0.2);
        }

        /* Animación para el logo */
        .logo-animation {
            animation: pulse 3s infinite alternate;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                filter: drop-shadow(0 0 5px rgba(96, 165, 250, 0.4));
            }

            100% {
                transform: scale(1.05);
                filter: drop-shadow(0 0 15px rgba(96, 165, 250, 0.8));
            }
        }

        /* Animación para textos */
        .text-glow {
            animation: text-glow 3s infinite alternate;
        }

        @keyframes text-glow {
            0% {
                text-shadow: 0 0 5px rgba(96, 165, 250, 0);
            }

            100% {
                text-shadow: 0 0 10px rgba(96, 165, 250, 0.5);
            }
        }

        /* Estilos para input personalizados */
        .custom-input {
            transition: all 0.3s ease;
            border: 1px solid rgba(125, 139, 158, 0.8);
            background-color: rgba(186, 196, 214, 0.7);
            color: #e2e8f0;
        }

        .custom-input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
            transform: translateY(-2px);
        }

        /* Estilos para botones */
        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        /* Animación para links */
        .link-hover {
            position: relative;
            transition: all 0.3s ease;
            color: #60a5fa;
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

        /* Footer estilizado */
        footer {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(5px);
            border-top: 1px solid rgba(51, 65, 85, 0.3);
        }
    </style>
</head>

<body class="min-h-screen font-sans antialiased">
    <!-- Efectos de fondo -->
    <div class="background-container"></div>
    <div class="nebula"></div>
    <div class="grid-overlay"></div>

    <!-- Efectos laterales -->
    <div class="side-glow side-glow-left"></div>
    <div class="side-glow side-glow-right"></div>

    <!-- Decoración superior -->
    <div class="top-decoration"></div>


    <!-- Contenido principal -->
    <div class="relative z-10 min-h-screen">
        {{ $slot }}
    </div>



    <!-- Footer -->
    <footer class="w-full py-3 text-center text-gray-400 text-sm z-10 relative">

        <!-- Decoración inferior -->
        <div class="bottom-decoration"></div>
        <p>© 2025 EducaWeb - Portal Educativo</p>

    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {


            // Animación de entrada para elementos principales
            const mainElements = document.querySelectorAll('.animate-entrance');
            mainElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 100 + (index * 100));
            });
        });
    </script>
</body>

</html>