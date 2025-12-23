<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Resource;
use App\Models\Message;
use App\Models\Subject;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $course = $teacher->course()->with('subjects', 'students.user')->first();

        $students = $course?->students ?? collect();
        $subjects = $course?->subjects ?? collect();

        $totalStudents = $students->count();
        $totalSubjects = $subjects->count();

        // Recursos
        $totalResources = Resource::where('teacher_id', Auth::id())->count();

        // Calificaciones medias por asignatura (gráfico)
        $gradeChartData = collect(); 

        foreach ($subjects as $subject) {
            $grades = Grade::where('subject_id', $subject->id)->whereIn('student_id', $students->pluck('id'))->pluck('grade');

            $gradeChartData->push([
                'subject' => $subject->name,
                'average' => $grades->count() ? round($grades->avg(), 2) : 0,
            ]);
        }

        // Nota media total (se usa en la tarjeta de "Nota Media")
        $allGrades = Grade::whereIn('student_id', $students->pluck('id'))->pluck('grade');
        $averageGrade = $allGrades->count() ? $allGrades->avg() : 0;

        // Alumnos con nota media menor a 5
        $lowGradeStudents = $students
            ->map(function ($student) {
                $average = $student->grades()->avg('grade');
                return (object) [
                    'user' => $student->user,
                    'average_grade' => $average,
                ];
            })
            ->filter(fn($s) => $s->average_grade < 5);

        return view('teacher.dashboard', compact('students', 'subjects', 'totalStudents', 'totalSubjects', 'totalResources', 'averageGrade', 'gradeChartData', 'lowGradeStudents'));
    }

    public function students()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher || !$teacher->course) {
            return view('teacher.students.index', ['students' => collect()]);
        }

        $students = $teacher->course->students()->with('user')->get();

        return view('teacher.students.index', compact('students'));
    }

    public function gradeSubmission(Request $request, Task $task, TaskSubmission $submission)
    {
        $teacher = Auth::user()->teacher; // Obtenemos el modelo Teacher completo

        if ($task->teacher_id != $teacher->id) {
            Log::error('Error de autorización', [
                'task_teacher_id' => $task->teacher_id,
                'authenticated_teacher_id' => $teacher->id,
                'user_id' => Auth::id(),
                'task' => $task->toArray()
            ]);

            abort(403, 'No tienes permiso para calificar esta tarea. ' .
                'ID Profesor de la tarea: ' . $task->teacher_id .
                ' | Tu ID de profesor: ' . $teacher->id);
        }

        $request->validate([
            'grade' => 'required|numeric|between:0,10',
            'feedback' => 'nullable|string|max:500'
        ]);

        $submission->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback,
            'graded_at' => now()
        ]);

        return back()->with('success', 'Calificación actualizada correctamente');
    }


    public function showStudent(Student $student)
    {
        // Solo permitir ver si el profesor tiene ese curso
        $teacher = Auth::user()->teacher;

        if (!$teacher || $student->course_id !== optional($teacher->course)->id) {
            abort(403, 'No tienes permiso para ver este estudiante.');
        }

        $student->load('user', 'course');

        $grades = \App\Models\Grade::with('subject')->where('student_id', $student->id)->get();

        return view('teacher.students.show', compact('student', 'grades'));
    }

    public function courses()
    {
        $teacher = Auth::user()->teacher;
        $courses = Course::where('teacher_id', $teacher->id)->get();
        return view('teacher.courses.index', compact('courses'));
    }

    public function grades()
    {
        $teacher = Auth::user()->teacher;
        $course = $teacher->course()->with('subjects', 'students.user')->first();

        $students = $course ? $course->students : collect();
        $subjects = $course ? $course->subjects : collect();

        $grades = Grade::with('student', 'subject')
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->groupBy(function ($grade) {
                return $grade->student_id . '-' . $grade->subject_id;
            });

        return view('teacher.grades.index', compact('students', 'subjects', 'grades'));
    }

    public function storeGrades(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:10',
        ]);

        Grade::create($validatedData);

        return redirect()->route('teacher.grades')->with('success', 'Calificación registrada exitosamente');
    }

    public function updateGrade(Request $request, $student_id, $subject_id)
    {
        $validated = $request->validate([
            'grade' => 'required|numeric|min:0|max:10',
        ]);

        Grade::updateOrCreate(['student_id' => $student_id, 'subject_id' => $subject_id], ['grade' => $validated['grade']]);

        return redirect()->route('teacher.grades')->with('success', 'Calificación actualizada correctamente.');
    }

    public function attendance(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $course = $teacher->course()->with('subjects', 'students.user')->first();

        $students = $course ? $course->students : collect();
        $subjects = $course ? $course->subjects : collect();

        $selectedSubjectId = $request->input('subject_id');
        $selectedSubject = $subjects->firstWhere('id', $selectedSubjectId) ?? $subjects->first();
        $today = Carbon::now()->toDateString();

        $attendances = Attendance::where('subject_id', $selectedSubject->id)->where('date', $today)->get()->keyBy('student_id');

        return view('teacher.attendance.index', compact('students', 'subjects', 'selectedSubject', 'attendances'));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if ($value !== Carbon::now()->format('Y-m-d')) {
                        $fail('Solo puedes registrar asistencia para el día de hoy.');
                    }
                },
            ],
            'attendance' => 'required|array',
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id,
                    'date' => $request->date,
                ],
                [
                    'status' => $status,
                ],
            );
        }

        return redirect()
            ->route('teacher.attendance', [
                'subject_id' => $request->subject_id,
                'date' => $request->date,
            ])
            ->with('success', 'Asistencia guardada correctamente.');
    }

    public function messages()
    {
        $teacher = Auth::user()->teacher;
        $students = Student::all();
        $messages = Message::where('teacher_id', Auth::id())->latest()->get();

        return view('teacher.messages.index', compact('students', 'messages'));
    }

    public function createMessage()
    {
        $students = Student::with('user')->get();
        return view('teacher.messages.create', compact('students'));
    }

    public function storeMessage(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Message::create([
            'teacher_id' => Auth::id(),
            'student_id' => $validated['student_id'],
            'subject' => $validated['subject'],
            'body' => $validated['body'],
        ]);

        return redirect()->route('teacher.messages')->with('success', 'Mensaje enviado correctamente.');
    }

    public function destroyMessage(Message $message)
    {
        if ($message->teacher_id !== Auth::id()) {
            abort(403);
        }

        $message->delete();

        return redirect()->route('teacher.messages')->with('success', 'Mensaje eliminado.');
    }

    public function resources(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $course = $teacher->course()->with('subjects')->first();


        $subjects = $course ? $course->subjects : collect();

        $query = Resource::with(['course', 'subject'])
            ->where('teacher_id', $teacher->id);

        // Filtro por búsqueda
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filtro por curso (si está presente)
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filtro por asignatura
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $resources = $query->latest()->paginate(10);

        return view('teacher.resources.index', [
            'resources' => $resources,
            'course' => $course,
            'subjects' => $subjects,
            'filters' => $request->only(['search', 'subject_id']) // Mantener los filtros en la vista
        ]);
    }
    public function create()
    {
        $teacher = Auth::user()->teacher;

        $course = $teacher->course()->with('subjects')->first();
        $subjects = $course ? $course->subjects : collect();

        return view('teacher.resources.create', compact('course', 'subjects'));
    }

    public function createFromSubject(Request $request)
    {
        $subject = Subject::with('course')->findOrFail($request->subject_id);

        return view('teacher.resources.create-from-subject', compact('subject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|max:10240',
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            abort(403, 'No estás registrado como profesor');
        }

        $path = $request->file('file')->store('resources', 'public');

        Resource::create([
            'teacher_id' => $teacher->id, // Usar teacher->id en lugar de Auth::id()
            'title' => $request->title,
            'file_path' => $path,
            'course_id' => $request->course_id,
            'subject_id' => $request->subject_id,
        ]);

        return redirect()->route('teacher.resources')->with('success', 'Recurso subido correctamente.');
    }

    private function checkResourceOwnership(Resource $resource)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403, 'No estás registrado como profesor');
        }

        // Debug: Registrar información importante
        Log::info('Verificación de recurso', [
            'user_id' => Auth::id(),
            'teacher_id' => $teacher->id,
            'resource_teacher_id' => $resource->teacher_id
        ]);

        if ($resource->teacher_id != $teacher->id) {
            abort(403, 'No tienes permiso para este recurso. ' .
                'Dueño: Profesor ' . $resource->teacher_id .
                ' | Tú: Profesor ' . $teacher->id);
        }
    }

    public function download(Resource $resource)
    {
        $teacher = Auth::user()->teacher;

        // Permiso especial para recursos de seeding
        if (app()->environment('local') && $resource->teacher_id != $teacher->id) {
            Log::warning('Acceso especial a recurso de seeding', [
                'resource_id' => $resource->id,
                'expected_teacher' => $teacher->id,
                'actual_teacher' => $resource->teacher_id
            ]);
            // Permitir descarga solo en entorno local
            return response()->download(Storage::disk('public')->path($resource->file_path));
        }

        // Verificación normal para producción
        $this->checkResourceOwnership($resource);

        if (!Storage::disk('public')->exists($resource->file_path)) {
            abort(404, 'Archivo no encontrado');
        }

        $filePath = Storage::disk('public')->path($resource->file_path);

        return response()->download(
            $filePath,
            $resource->title . '.' . pathinfo($filePath, PATHINFO_EXTENSION)
        );
    }

    public function destroy(Resource $resource)
    {
        if ($resource->teacher_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('public')->delete($resource->file_path);
        $resource->delete();

        return redirect()->route('teacher.resources')->with('success', 'Recurso eliminado.');
    }

    public function subjects()
    {
        $teacher = Auth::user()->teacher;

        // Buscamos el curso del que es tutor (donde el teacher_id coincide)
        $course = Course::where('teacher_id', $teacher->id)->first();

        if (!$course) {
            return view('teacher.subjects.index', ['subjects' => collect()]);
        }

        // Ahora buscamos las asignaturas de ese curso
        $subjects = Subject::where('course_id', $course->id)->get();

        return view('teacher.subjects.index', compact('subjects', 'course'));
    }

    public function viewSubmission(Task $task, TaskSubmission $submission)
    {
        $teacher = Auth::user()->teacher;
        if (
            $task->subject->course_id !== $teacher->course->id ||
            $submission->task_id !== $task->id
        ) {
            abort(403, 'No tienes permiso para ver esta entrega');
        }

        $filePath = Storage::disk('public')->path($submission->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'Archivo no encontrado');
        }

        return response()->download($filePath);
    }

    public function showSubject($id)
    {
        $subject = Subject::with(['resources', 'course', 'tasks'])->findOrFail($id);

        // Get students for this subject's course
        $students = $subject->course ? $subject->course->students()->with('user')->get() : collect();
        $subject->students_count = $students->count();


        return view('teacher.subjects.show', compact(
            'subject',
            'students',
        ));
    }

    public function tasks(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $course = $teacher->course;
        $subjects = $course ? $course->subjects : collect();

        $tasks = Task::with(['subject', 'submissions'])
            ->where('teacher_id', $teacher->id)
            ->when($request->subject_id, function ($query) use ($request) {
                return $query->where('subject_id', $request->subject_id);
            })
            ->latest()
            ->get();

        return view('teacher.tasks.index', [
            'tasks' => $tasks,
            'subjects' => $subjects,
            'currentSubject' => $request->subject_id
        ]);
    }

    public function createTask(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $teacherId = $teacher->id;
        $subjects = $teacher->course?->subjects ?? collect();

        // Si ya se ha seleccionado una asignatura
        $selectedSubjectId = $request->input('subject_id');


        $resources = [];
        if ($selectedSubjectId) {
            $resources = Resource::where('subject_id', $selectedSubjectId)->get();
        }

        return view('teacher.tasks.create', compact('subjects', 'resources', 'selectedSubjectId'));
    }

    public function resourcesBySubject(Subject $subject)
    {
        $resources = $subject->resources()->select('id', 'title')->get();
        return response()->json($resources);
    }



    public function storeTask(Request $request)
    {
        $teacher = Auth::user()->teacher; // Obtenemos el modelo Teacher

        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today', // ¡No permite fechas pasadas!
        ]);
        $task = Task::create([
            'subject_id' => $validated['subject_id'],
            'teacher_id' => $teacher->id, // Asumiendo que $teacher ya está definido
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deadline' => Carbon::parse($validated['deadline'])->format('Y-m-d H:i:s'), // Formato MySQL
        ]);

        // Relacionar recursos usando attachedResources
        if ($request->has('resource_ids')) {
            $task->attachedResources()->sync($request->resource_ids);
        }

        return redirect()->route('teacher.tasks')->with('success', 'Tarea creada correctamente.');
    }

    public function showTask(Task $task)
    {
        $teacher = Auth::user()->teacher;

        // Verificar que la tarea pertenece al curso del profesor
        if ($task->subject->course_id !== $teacher->course->id) {
            abort(403, 'No tienes permiso para ver esta tarea');
        }

        $task->load(['subject', 'submissions.student.user']);

        return view('teacher.tasks.show', compact('task'));
    }

    public function editTask(Task $task)
    {
        $teacher = Auth::user()->teacher;
        $subjects = $teacher->course?->subjects ?? collect();

        // Proteger si no hay asignatura
        $resources = $task->subject
            ? $task->subject->resources()->get()
            : collect();

        return view('teacher.tasks.edit', compact('task', 'subjects', 'resources'));
    }

    public function updateTask(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'resource_ids' => 'nullable|array',
            'resource_ids.*' => 'exists:resources,id'
        ]);

        $task->update([
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
        ]);

        // Actualizar recursos usando attachedResources
        if ($request->has('resource_ids')) {
            $task->attachedResources()->sync($request->resource_ids);
        } else {
            $task->attachedResources()->detach();
        }

        return redirect()->route('teacher.tasks')->with('success', 'Tarea actualizada correctamente.');
    }



    public function destroyTask(Task $task)
    {
        $this->authorizeTask($task);
        $task->delete();

        return redirect()->route('teacher.tasks')->with('success', 'Tarea eliminada.');
    }

    protected function authorizeTask(Task $task)
    {
        if ($task->teacher_id !== Auth::id()) {
            abort(403, 'No tienes permiso para acceder a esta tarea');
        }
    }

    public function chatIndex()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->back()->with('error', 'No tienes perfil de profesor');
        }

        $chats = Chat::with(['student.user', 'messages' => function ($query) {
            $query->latest()->take(1);
        }])
            ->where('teacher_id', $teacher->id)
            ->latest('updated_at')
            ->get();

        return view('teacher.chat.index', compact('chats'));
    }

    public function createChat()
    {
        $students = Student::with('user')->get();
        return view('teacher.chat.create', compact('students'));
    }

    public function storeChat(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $teacher = Auth::user()->teacher;

        $chat = Chat::firstOrCreate([
            'teacher_id' => $teacher->id,
            'student_id' => $request->student_id,
        ]);

        return redirect()->route('teacher.chat.show', $chat->id);
    }

    public function showChat($chatId)
    {
        $teacher = Auth::user()->teacher;

        $chat = Chat::with(['student.user', 'messages' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])
            ->where('id', $chatId)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        return view('teacher.chat.show', compact('chat'));
    }

    public function getMessages(Chat $chat)
    {
        $teacher = Auth::user()->teacher;

        if ($chat->teacher_id !== $teacher->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $chat->load(['messages.sender', 'student.user']);

        return view('teacher.chat.messages', [
            'messages' => $chat->messages,
            'chat' => $chat
        ]);
    }

    public function sendMessage(Request $request, $chatId)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $chat = Chat::where('id', $chatId)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $message = ChatMessage::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'message' => $request->input('message'),
        ]);

        $chat->touch();

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function deleteChat($chatId)
    {
        $user = Auth::user();

        if ($user->role === 'teacher') {
            $owner = $user->teacher;
            $chat = Chat::where('id', $chatId)
                ->where('teacher_id', $owner->id)
                ->firstOrFail();
        } elseif ($user->role === 'student') {
            $owner = $user->student;
            $chat = Chat::where('id', $chatId)
                ->where('student_id', $owner->id)
                ->firstOrFail();
        } else {
            abort(403, 'No autorizado');
        }

        // Eliminar todos los mensajes relacionados
        $chat->messages()->delete();

        // Eliminar el chat
        $chat->delete();

        return back()->with('success', 'Chat eliminado correctamente.');
    }
}
