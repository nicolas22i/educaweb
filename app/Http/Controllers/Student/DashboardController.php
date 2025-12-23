<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function index()
    {
        try {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Verificar si el usuario tiene relación con un estudiante
            if (!$user->student) {
                return view('student.no-course');
            }

            // Verificar si el estudiante tiene un curso asignado
            if (!$user->student->course) {
                return view('student.no-course');
            }

            // Si llegamos aquí, el estudiante tiene curso
            $student = $user->student;
            $course = $student->course;

            // Cargar las relaciones necesarias del curso
            $course->load('subjects.resources');

            // Obtener las asignaturas del curso
            $subjects = $course->subjects;

            // Obtener las calificaciones del estudiante
            $grades = Grade::where('student_id', $student->id)->get();
            $averageGrade = $grades->isEmpty() ? 0 : $grades->avg('grade');

            // Obtener la asistencia del estudiante
            $attendances = Attendance::where('student_id', $student->id)->get();
            $totalDays = $attendances->count();
            $presentDays = $attendances->where('status', 'present')->count();
            $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 0;

            // Obtener los últimos recursos subidos
            $latestResources = Resource::whereIn('subject_id', $subjects->pluck('id'))
                ->latest()
                ->take(5)
                ->get();

            // Devolver la vista del dashboard con los datos
            return view('student.dashboard', [
                'subjects' => $subjects,
                'averageGrade' => $averageGrade,
                'attendanceRate' => $attendanceRate,
                'latestResources' => $latestResources
            ]);
        } catch (\Exception $e) {
            // En caso de error, devolver la vista sin curso
            return view('student.no-course');
        }
    }

    public function tasks(Request $request)
    {
        $student = Auth::user()->student;

        if (!$student || !$student->course) {
            abort(404, 'Estudiante o curso no encontrado');
        }

        // Obtenemos las asignaturas del curso para el filtro
        $subjects = $student->course->subjects ?? collect();

        // Query base para las tareas del curso del estudiante
        $tasksQuery = Task::whereIn('subject_id', $subjects->pluck('id'));

        // Aplicar filtro por asignatura si existe y es válida
        if ($request->filled('subject_id') && $subjects->contains('id', $request->subject_id)) {
            $tasksQuery->where('subject_id', $request->subject_id);
        }

        // Obtener las tareas ordenadas por fecha límite
        $tasks = $tasksQuery->orderBy('deadline', 'asc')->get();

        return view('student.tasks.index', [
            'tasks' => $tasks,
            'subjects' => $subjects,
            'currentSubject' => $request->subject_id
        ]);
    }


    public function showTask(Task $task)
    {
        $student = Auth::user()->student;
        $submission = $task->submissions()->where('student_id', $student->id)->first();

        return view('student.tasks.show', compact('task', 'submission'));
    }

    public function resources(Request $request)
    {
        $student = Auth::user()->student;
        $course = $student->course;
        $subjects = $course ? $course->subjects : collect();

        $query = Resource::with(['subject', 'course'])
            ->where('course_id', $course->id);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $resources = $query->latest()->get();

        return view('student.resources.index', compact('resources', 'subjects'));
    }

    public function downloadResource(Resource $resource)
    {
        $student = Auth::user()->student;

        Log::debug('Curso del recurso:', ['resource_course_id' => $resource->course_id]);
        Log::debug('Curso del estudiante:', ['student_course_id' => $student->course_id]);

        if ($resource->course_id != $student->course_id) {
            abort(403, 'No autorizado');
        }

        if (!Storage::disk('public')->exists($resource->file_path)) {
            abort(404, 'Archivo no encontrado');
        }

        $filePath = Storage::disk('public')->path($resource->file_path);
        return response()->download($filePath, $resource->title . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
    }

    public function viewSubmission(Task $task, TaskSubmission $submission)
    {
        $student = Auth::user()->student;
        if (
            $task->subject->course_id !== $student->course->id ||
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

    public function submitTask(Request $request, Task $task)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $student = Auth::user()->student;
        $file = $request->file('file');

        // Ruta de destino absoluta
        $destinationPath = storage_path('app/public/submissions');

        // Si no existe la carpeta, la crea
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }

        // Nombre único del archivo (puedes usar originalName si quieres)
        $filename = uniqid('entrega_') . '.' . $file->getClientOriginalExtension();

        // Mueve el archivo manualmente
        $file->move($destinationPath, $filename);

        // Guardamos la ruta relativa (para usar con asset())
        $relativePath = "submissions/{$filename}";

        // Guarda la entrega en la base de datos
        TaskSubmission::updateOrCreate(
            ['student_id' => $student->id, 'task_id' => $task->id],
            ['file_path' => $relativePath]
        );

        return redirect()->route('student.tasks.show', $task)->with('success', 'Tarea enviada correctamente.');
    }

    public function deleteSubmission(Task $task)
    {
        $student = Auth::user()->student;

        $submission = TaskSubmission::where('task_id', $task->id)
            ->where('student_id', $student->id)
            ->first();

        if ($submission) {
            // Eliminar el archivo si existe
            $filePath = storage_path('app/public/' . $submission->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Eliminar la entrega de la base de datos
            $submission->delete();
        }

        return redirect()->route('student.tasks.show', $task)
            ->with('success', 'Entrega eliminada correctamente. Puedes subir un nuevo archivo.');
    }



    public function subjects()
    {
        $student = Auth::user()->student;
        $course = $student->course;

        // Recuperas los subjects
        $subjects = $course->subjects;

        // Recuperas las calificaciones
        $grades = Grade::with('subject.course')
            ->where('student_id', $student->id)
            ->get();

        // Si hay un filtro por trimestre
        if (request()->has('term_id') && request('term_id') != '') {
            $termId = request('term_id');
            $grades = $grades->filter(function ($grade) use ($termId) {
                return $grade->term == $termId;
            });
        }

        // Debes pasar $subjects a la vista
        return view('student.subjects.index', compact('grades', 'subjects'));
    }

    public function showSubject($id)
    {
        $student = Auth::user()->student;

        // Obtener la calificación específica
        $grade = Grade::with('subject.course')
            ->where('id', $id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        // Obtener las tareas de la asignatura y los envíos del estudiante
        $taskSubmissions = TaskSubmission::with('task')
            ->whereHas('task', function ($query) use ($grade) {
                $query->where('subject_id', $grade->subject_id);
            })
            ->where('student_id', $student->id)
            ->latest()
            ->get();

        return view('student.subjects.show', compact('grade', 'taskSubmissions'));
    }

    public function attendances(Request $request)
    {
        $student = Auth::user()->student;

        $subjects = $student->course->subjects ?? collect();

        $query = Attendance::with('subject')
            ->where('student_id', $student->id);

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('date', [$request->from_date, $request->to_date]);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(10);

        $totalDays = $query->count();
        $presentDays = (clone $query)->where('status', 'present')->count();
        $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 0;

        return view('student.attendances.index', compact('attendances', 'subjects', 'attendanceRate'));
    }

    public function chatIndex()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->back()->with('error', 'No tienes perfil de estudiante');
        }

        $chats = Chat::with(['teacher.user', 'messages' => function ($query) {
            $query->latest()->take(1);
        }])
            ->where('student_id', $student->id)
            ->latest('updated_at')
            ->get();

        // dd($chats, $student->id, $student); 

        return view('student.chat.index', compact('chats', 'student'));
    }
    public function createChat()
    {
        $teachers = Teacher::with('user')->get();
        return view('student.chat.create', compact('teachers'));
    }

    public function storeChat(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $student = Auth::user()->student;

        $chat = Chat::firstOrCreate([
            'teacher_id' => $request->teacher_id,
            'student_id' => $student->id,
        ]);

        return redirect()->route('student.chat.show', $chat->id);
    }

    public function showChat($chatId)
    {
        $student = Auth::user()->student;

        $chat = Chat::with(['teacher.user', 'messages.sender'])
            ->where('id', $chatId)
            ->where('student_id', $student->id)
            ->firstOrFail();

        return view('student.chat.show', compact('chat'));
    }

    public function getMessages(Chat $chat)
    {
        $student = Auth::user()->student;

        // Verificar que el chat pertenece al estudiante
        if ($chat->student_id !== $student->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $chat->load(['messages.sender', 'teacher.user']);

        return view('student.chat.messages', [
            'messages' => $chat->messages,
            'chat' => $chat
        ]);
    }

    public function sendMessage(Request $request, $chatId)
    {
        $user = Auth::user();
        $student = $user->student;

        $chat = Chat::where('id', $chatId)
            ->where('student_id', $student->id)
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
