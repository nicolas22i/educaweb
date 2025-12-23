@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('dashboard-content')
<!-- Panel principal del administrador -->
<div class="py-6" id="dashboard-content">
    <!-- Primera fila de tarjetas de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Usuarios -->
        <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
            <div class="p-5 bg-gradient-to-r from-blue-500 to-blue-600">
                <div class="flex justify-between items-center">
                    <h2 class="text-white font-bold">Usuarios Registrados</h2>
                    <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                        <i class="bi bi-person-gear text-white"></i>
                    </div>
                </div>
            </div>
            <div class="px-5 py-4">
                <p class="text-4xl font-extrabold text-blue-600">{{ $totalUsers }}</p>
                <p class="text-xs text-gray-500 mt-1">Total de usuarios en la plataforma</p>
            </div>
        </div>

        <!-- Cursos -->
        <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
            <div class="p-5 bg-gradient-to-r from-green-500 to-green-600">
                <div class="flex justify-between items-center">
                    <h2 class="text-white font-bold">Cursos</h2>
                    <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                        <i class="bi bi-easel2-fill text-white"></i>
                    </div>
                </div>
            </div>
            <div class="px-5 py-4">
                <p class="text-4xl font-extrabold text-green-600">{{ $activeCourses }}</p>
                <p class="text-xs text-gray-500 mt-1">Cursos activos</p>
            </div>
        </div>

        <!-- Profesores -->
        <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
            <div class="p-5 bg-gradient-to-r from-red-500 to-red-600">
                <div class="flex justify-between items-center">
                    <h2 class="text-white font-bold">Profesores</h2>
                    <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                        <i class="bi bi-person-badge text-white"></i>
                    </div>
                </div>
            </div>
            <div class="px-5 py-4">
                <p class="text-4xl font-extrabold text-red-600">{{ $totalTeachers }}</p>
                <p class="text-xs text-gray-500 mt-1">Total de profesores</p>
            </div>
        </div>
    </div>

    <!-- Segunda fila de tarjetas de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Estudiantes -->
        <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
            <div class="p-5 bg-gradient-to-r from-purple-500 to-purple-600">
                <div class="flex justify-between items-center">
                    <h2 class="text-white font-bold">Estudiantes</h2>
                    <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                        <i class="bi bi-people-fill text-white"></i>
                    </div>
                </div>
            </div>
            <div class="px-5 py-4">
                <p class="text-4xl font-extrabold text-purple-600">{{ $totalStudents }}</p>
                <p class="text-xs text-gray-500 mt-1">Total de estudiantes matriculados</p>
            </div>
        </div>

        <!-- Asignaturas -->
        <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
            <div class="p-5 bg-gradient-to-r from-yellow-500 to-yellow-600">
                <div class="flex justify-between items-center">
                    <h2 class="text-white font-bold">Asignaturas</h2>
                    <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                        <i class="bi bi-journals text-white"></i>
                    </div>
                </div>
            </div>
            <div class="px-5 py-4">
                <p class="text-4xl font-extrabold text-yellow-500">{{ $totalSubjects }}</p>
                <p class="text-xs text-gray-500 mt-1">Total de asignaturas ofertadas</p>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
            <div class="p-5 bg-gradient-to-r from-indigo-500 to-indigo-600">
                <div class="flex justify-between items-center">
                    <h2 class="text-white font-bold">Nuevos Usuarios</h2>
                    <div class="p-2 bg-white bg-opacity-30 rounded-lg">
                        <i class="bi bi-person-plus text-white"></i>
                    </div>
                </div>
            </div>
            <div class="px-5 py-4">
                <p class="text-4xl font-extrabold text-indigo-600">{{ $newUsersLastMonth }}</p>
                <p class="text-xs text-gray-500 mt-1">Registros este mes</p>
            </div>
        </div>
    </div>
</div>
@endsection