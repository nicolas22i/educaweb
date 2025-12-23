@extends('layouts.teacher')

@section('title', 'Gestión de Calificaciones')

@section('dashboard-content')
    <div class="mb-8">
        <p class="text-gray-600">Administra las calificaciones de tus estudiantes por asignatura</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Banner superior con color aleatorio -->
        <div class="h-3 bg-gradient-to-r from-indigo-500 to-blue-600"></div>

        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                <span class="inline-flex bg-indigo-100 text-indigo-600 rounded-full p-3">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </span>
                Calificaciones por Asignatura
            </h2>

            @if ($students->isEmpty() || $subjects->isEmpty())
                <div class="flex flex-col items-center justify-center p-10 bg-gray-50 rounded-xl border border-gray-200 mt-8">
                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="text-xl font-medium text-gray-600 mb-2">No hay datos disponibles</p>
                    <p class="text-gray-500 text-center">No hay estudiantes o asignaturas disponibles en tu curso actualmente.
                    </p>
                </div>
            @else
                <!-- Vista de cards para cada estudiante -->
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($students as $student)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden border border-gray-200">
                                        <img src="{{ $student->user->profile_image ? asset($student->user->profile_image) : asset('images/avatar-placeholder.png') }}"
                                            alt="{{ $student->user->name }}" class="h-full w-full object-cover"
                                            onerror="this.onerror=null; this.src='{{ asset('images/avatar-placeholder.png') }}'">
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $student->user->name }}</h3>
                                </div>
                                <span class="text-sm text-gray-500">Código: {{ $student->student_code }}</span>
                            </div>

                            <div class="p-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-3">Calificaciones por asignatura:</h4>

                                <div class="space-y-3">
                                    @foreach ($subjects as $subject)
                                                    @php
                                                        $key = $student->id . '-' . $subject->id;
                                                        $grade = $grades[$key][0] ?? null;
                                                        $gradeColor = $grade
                                                            ? ($grade->grade >= 5
                                                                ? 'bg-green-100 text-green-700 border-green-200'
                                                                : 'bg-red-100 text-red-700 border-red-200')
                                                            : 'bg-gray-100 text-gray-600 border-gray-200';
                                                        $gradeValue = $grade ? number_format($grade->grade, 2) : 'No calificado';
                                                    @endphp

                                                    <div class="flex items-center justify-between p-3 rounded-lg border {{ $gradeColor }}">
                                                        <div class="font-medium">{{ $subject->name }}</div>

                                                        <div class="flex items-center gap-2">
                                                            <span class="font-bold">{{ $gradeValue }}</span>

                                                            <button class="p-1.5 rounded-full hover:bg-white/50 transition openModalBtn"
                                                                title="{{ $grade ? 'Editar calificación' : 'Añadir calificación' }}"
                                                                data-student="{{ $student->id }}" data-subject="{{ $subject->id }}"
                                                                data-grade="{{ $grade ? $grade->grade : '' }}"
                                                                data-action="{{ $grade ? 'edit' : 'create' }}"
                                                                data-studentname="{{ $student->user->name }}"
                                                                data-subjectname="{{ $subject->name }}">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M4 21h4l10-10a2.828 2.828 0 00-4-4L4 17v4z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación si es necesaria -->
                @if(isset($students) && method_exists($students, 'links'))
                    <div class="mt-6">
                        {{ $students->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Modal mejorado -->
    <div id="gradeModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md relative animate__animated animate__fadeInUp">
            <button id="closeModal"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="border-b border-gray-200 pb-4 mb-4">
                <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Gestionar Calificación</h3>
                <p class="text-gray-600 text-sm" id="modalSubtitle"></p>
            </div>

            <form method="POST" id="modalForm" class="space-y-4">
                @csrf
                <input type="hidden" name="student_id" id="modalStudentId">
                <input type="hidden" name="subject_id" id="modalSubjectId">

                <div>
                    <label for="modalGrade" class="block text-gray-700 font-medium mb-1">Calificación (0 - 10)</label>
                    <div class="relative">
                        <input type="number" step="0.01" min="0" max="10" name="grade" id="modalGrade"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none"
                            required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-8 pointer-events-none">
                            <span class="text-gray-500">/10</span>
                        </div>
                    </div>
                </div>

                <!-- Visualización de estado aprobado/suspenso -->
                <div id="gradeStatus" class="p-3 rounded-lg text-center font-medium hidden"></div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" id="cancelBtn"
                        class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('gradeModal');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const modalForm = document.getElementById('modalForm');
        const studentInput = document.getElementById('modalStudentId');
        const subjectInput = document.getElementById('modalSubjectId');
        const gradeInput = document.getElementById('modalGrade');
        const submitBtn = modalForm.querySelector('button[type="submit"]');
        const modalTitle = document.getElementById('modalTitle');
        const modalSubtitle = document.getElementById('modalSubtitle');
        const gradeStatus = document.getElementById('gradeStatus');

        // Mostrar el estado de aprobado/suspenso al cambiar la nota
        gradeInput.addEventListener('input', function () {
            const value = parseFloat(this.value);
            if (!isNaN(value)) {
                gradeStatus.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');

                if (value >= 5) {
                    gradeStatus.classList.add('bg-green-100', 'text-green-700');
                    gradeStatus.textContent = '✓ Aprobado';
                } else {
                    gradeStatus.classList.add('bg-red-100', 'text-red-700');
                    gradeStatus.textContent = '✗ Suspenso';
                }
            } else {
                gradeStatus.classList.add('hidden');
            }
        });

        document.querySelectorAll('.openModalBtn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                const studentId = this.dataset.student;
                const subjectId = this.dataset.subject;
                const gradeValue = this.dataset.grade || '';
                const action = this.dataset.action;
                const studentName = this.dataset.studentname;
                const subjectName = this.dataset.subjectname;

                studentInput.value = studentId;
                subjectInput.value = subjectId;
                gradeInput.value = gradeValue;

                // Personalizar el título del modal
                if (action === 'edit') {
                    modalTitle.textContent = 'Modificar Calificación';
                    submitBtn.textContent = 'Actualizar';
                    modalForm.action = `/teacher/grades/update/${studentId}/${subjectId}`;
                } else {
                    modalTitle.textContent = 'Añadir Nueva Calificación';
                    submitBtn.textContent = 'Guardar';
                    modalForm.action = `{{ route('teacher.grades.store') }}`;
                }

                // Mostrar detalles del estudiante y asignatura
                modalSubtitle.textContent = `${studentName} - ${subjectName}`;

                // Disparar el evento input para mostrar el estado
                if (gradeValue) {
                    const event = new Event('input');
                    gradeInput.dispatchEvent(event);
                } else {
                    gradeStatus.classList.add('hidden');
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        // Funciones para cerrar el modal
        function closeModalFunction() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        closeModal.addEventListener('click', closeModalFunction);
        cancelBtn.addEventListener('click', closeModalFunction);

        window.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeModalFunction();
            }
        });
    </script>
@endsection