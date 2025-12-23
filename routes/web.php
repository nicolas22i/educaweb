<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\ChatController as ChatController;


Route::get('/', function () {
    return view('auth.landing');
})->middleware('guest')->name('home');

require __DIR__ . '/auth.php';

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'teacher':
            return redirect()->route('teacher.dashboard');
        case 'student':
            return redirect()->route('student.dashboard');
        default:
            return redirect('/');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.image.update');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login')->with('status', 'Sesión cerrada.');
});


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // USUARIOS
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminDashboardController::class, 'createUser'])->name('users.create');
        Route::post('/users/store', [AdminDashboardController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminDashboardController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminDashboardController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminDashboardController::class, 'destroyUser'])->name('users.destroy');

        // CURSOS
        Route::get('/courses', [AdminDashboardController::class, 'courses'])->name('courses');
        Route::get('/courses/create', [AdminDashboardController::class, 'createCourse'])->name('courses.create');
        Route::post('/courses/store', [AdminDashboardController::class, 'storeCourse'])->name('courses.store');
        Route::get('/courses/{id}/edit', [AdminDashboardController::class, 'editCourse'])->name('courses.edit');
        Route::put('/courses/{id}', [AdminDashboardController::class, 'updateCourse'])->name('courses.update');
        Route::delete('/courses/{id}', [AdminDashboardController::class, 'destroyCourse'])->name('courses.destroy');

        // ASIGNATURAS
        Route::get('/subjects', [AdminDashboardController::class, 'subjects'])->name('subjects');
        Route::get('/subjects/create', [AdminDashboardController::class, 'createSubject'])->name('subjects.create');
        Route::post('/subjects/store', [AdminDashboardController::class, 'storeSubject'])->name('subjects.store');
        Route::get('/subjects/{id}/edit', [AdminDashboardController::class, 'editSubject'])->name('subjects.edit');
        Route::put('/subjects/{id}', [AdminDashboardController::class, 'updateSubject'])->name('subjects.update');
        Route::delete('/subjects/{id}', [AdminDashboardController::class, 'destroySubject'])->name('subjects.destroy');

        // PROFESORES
        Route::get('/teachers', [AdminDashboardController::class, 'teachers'])->name('teachers');
        Route::get('/teachers/create', [AdminDashboardController::class, 'createTeacher'])->name('teachers.create');
        Route::post('/teachers/store', [AdminDashboardController::class, 'storeTeacher'])->name('teachers.store');
        Route::get('/teachers/{id}/edit', [AdminDashboardController::class, 'editTeacher'])->name('teachers.edit');
        Route::put('/teachers/{id}', [AdminDashboardController::class, 'updateTeacher'])->name('teachers.update');
        Route::delete('/teachers/{id}', [AdminDashboardController::class, 'destroyTeacher'])->name('teachers.destroy');

        // ESTUDIANTES
        Route::get('/students', [AdminDashboardController::class, 'students'])->name('students');
        Route::get('/students/create', [AdminDashboardController::class, 'createStudent'])->name('students.create');
        Route::post('/students/store', [AdminDashboardController::class, 'storeStudent'])->name('students.store');
        Route::get('/students/{id}/edit', [AdminDashboardController::class, 'editStudent'])->name('students.edit');
        Route::put('/students/{id}', [AdminDashboardController::class, 'updateStudent'])->name('students.update');
        Route::delete('/students/{id}', [AdminDashboardController::class, 'destroyStudent'])->name('students.destroy');
    });

// Rutas para Profesor
Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

        Route::get('/courses', [TeacherDashboardController::class, 'courses'])->name('courses');

        Route::get('/grades', [TeacherDashboardController::class, 'grades'])->name('grades');
        Route::get('/grades/edit', [TeacherDashboardController::class, 'editGrades'])->name('grades.edit');
        Route::post('/grades/store', [TeacherDashboardController::class, 'storeGrades'])->name('grades.store');
        Route::post('/grades/update/{student_id}/{subject_id}', [TeacherDashboardController::class, 'updateGrade'])->name('grades.update');


        Route::get('/attendance', [TeacherDashboardController::class, 'attendance'])->name('attendance');
        Route::post('/attendance/store', [TeacherDashboardController::class, 'storeAttendance'])->name('attendance.store');

        Route::get('/students', [TeacherDashboardController::class, 'students'])->name('students');
        Route::get('/students/{student}', [TeacherDashboardController::class, 'showStudent'])->name('students.show');


        Route::get('/subjects', [TeacherDashboardController::class, 'subjects'])->name('subjects');
        Route::get('/subjects/{subject}', [TeacherDashboardController::class, 'showSubject'])->name('subjects.show');

        Route::get('/resources', [TeacherDashboardController::class, 'resources'])->name('resources');
        Route::get('/resources/create', [TeacherDashboardController::class, 'create'])->name('resources.create');
        Route::get('/resources/create/from-subject', [TeacherDashboardController::class, 'createFromSubject'])->name('resources.create.from-subject');
        Route::post('/resources/store', [TeacherDashboardController::class, 'store'])->name('resources.store');
        Route::get('/resources/{resource}/download', [TeacherDashboardController::class, 'download'])->name('resources.download');
        Route::delete('/resources/{resource}', [TeacherDashboardController::class, 'destroy'])->name('resources.destroy');


        Route::get('/tasks', [TeacherDashboardController::class, 'tasks'])->name('tasks');
        Route::get('/tasks/create', [TeacherDashboardController::class, 'createTask'])->name('tasks.create');
        Route::post('/tasks/store', [TeacherDashboardController::class, 'storeTask'])->name('tasks.store');
        Route::get('/tasks/{task}', [TeacherDashboardController::class, 'showTask'])->name('tasks.show');
        Route::get('/tasks/{task}/edit', [TeacherDashboardController::class, 'editTask'])->name('tasks.edit');
        Route::put('/tasks/{task}', [TeacherDashboardController::class, 'updateTask'])->name('tasks.update');
        Route::delete('/tasks/{task}', [TeacherDashboardController::class, 'destroyTask'])->name('tasks.destroy');
        Route::get('/tasks/{task}/submissions/{submission}', [TeacherDashboardController::class, 'viewSubmission'])->name('tasks.submissions.view');
        Route::put('/tasks/{task}/submissions/{submission}/grade', [TeacherDashboardController::class, 'gradeSubmission'])->name('tasks.submissions.grade')
            ->missing(function () {
                abort(404);
            });

        Route::get('/resources/by-subject/{subject}', [TeacherDashboardController::class, 'resourcesBySubject']);
        Route::get('/teacher/subjects/{subject}/resources', [TeacherDashboardController::class, 'resourcesBySubject']);

        Route::get('/chat', [TeacherDashboardController::class, 'chatIndex'])->name('chat.index');
        Route::get('/chat/create', [TeacherDashboardController::class, 'createChat'])->name('chat.create');
        Route::post('/chat', [TeacherDashboardController::class, 'storeChat'])->name('chat.store');
        Route::get('/chat/{chat}', [TeacherDashboardController::class, 'showChat'])->name('chat.show');
         Route::get('/chat/{chat}/messages', [TeacherDashboardController::class, 'getMessages'])->name('chat.messages');
        Route::post('/chat/{chat}/message', [TeacherDashboardController::class, 'sendMessage'])->name('chat.send');
        Route::delete('/chat/{chat}/delete', [TeacherDashboardController::class, 'deleteChat'])->name('chat.delete');
    });

// Rutas para Estudiante

Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/no-course', function () {
            return view('student.no-course');
        })->name('no-course');
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        Route::get('/courses', [StudentDashboardController::class, 'courses'])->name('courses');

        Route::get('/attendances', [StudentDashboardController::class, 'attendances'])->name('attendances');

        Route::get('/subjects', [StudentDashboardController::class, 'subjects'])->name('subjects');
        Route::get('/subjects/{id}', [StudentDashboardController::class, 'showSubject'])->name('subjects.show');

        Route::get('/resources', [StudentDashboardController::class, 'resources'])->name('resources');
        Route::get('/resources/{resource}/download', [StudentDashboardController::class, 'downloadResource'])->name('resources.download');

        Route::get('/tasks', [StudentDashboardController::class, 'tasks'])->name('tasks');
        Route::get('/tasks/{task}', [StudentDashboardController::class, 'showTask'])->name('tasks.show');
        Route::post('/tasks/{task}/submit', [StudentDashboardController::class, 'submitTask'])->name('tasks.submit');
        Route::delete('/tasks/{task}/submission', [StudentDashboardController::class, 'deleteSubmission'])->name('tasks.deleteSubmission');
        Route::get('/tasks/{task}/submissions/{submission}', [StudentDashboardController::class, 'viewSubmission'])->name('tasks.submissions.view');

        Route::get('/chat', [StudentDashboardController::class, 'chatIndex'])->name('chat');
        Route::get('/chat/create', [StudentDashboardController::class, 'createChat'])->name('chat.create');
        Route::post('/chat', [StudentDashboardController::class, 'storeChat'])->name('chat.store');
        Route::get('/chat/{chat}', [StudentDashboardController::class, 'showChat'])->name('chat.show');
        Route::get('/chat/{chat}/messages', [StudentDashboardController::class, 'getMessages'])->name('chat.messages');
        Route::post('/chat/{chat}/message', [StudentDashboardController::class, 'sendMessage'])->name('chat.send');
        Route::delete('/chat/{chat}/delete', [StudentDashboardController::class, 'deleteChat'])->name('chat.delete');
    });
