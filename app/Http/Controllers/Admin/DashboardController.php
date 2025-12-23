<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTeachers = Teacher::count();
        $totalStudents = Student::count();
        $totalSubjects = Subject::count();
        $activeCourses = Course::count();
        $newUsersLastMonth = User::where('created_at', '>=', now()->subMonth())->count();


        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'activeCourses' => $activeCourses,
            'totalTeachers' => $totalTeachers,
            'totalStudents' => $totalStudents,
            'totalSubjects' => $totalSubjects,
            'newUsersLastMonth' => $newUsersLastMonth,
        ]);
    }


    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,teacher,student',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users')->with('success', 'Usuario creado correctamente.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,teacher,student',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Usuario eliminado correctamente.');
    }


    public function courses()
    {
        $courses = Course::with('teacher')->paginate(10);
        $teachers = \App\Models\Teacher::with('user')->get();

        return view('admin.courses.index', compact('courses', 'teachers'));
    }


    public function createCourse()
    {
        // Profesores sin curso asignado
        $teachers = Teacher::whereDoesntHave('courses')->get();

        return view('admin.courses.create', compact('teachers'));
    }

    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'teacher_id' => 'nullable|exists:teachers,id',
            'academic_year' => 'required|string|max:20',
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses')->with('success', 'Curso creado correctamente.');
    }

    public function editCourse($id)
    {
        $course = Course::findOrFail($id);

        // Solo los profesores que no están asignados o el actual
        $teachers = Teacher::whereDoesntHave('courses')
            ->orWhere('id', $course->teacher_id)
            ->get();

        return view('admin.courses.edit', compact('course', 'teachers'));
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'teacher_id' => 'nullable|exists:teachers,id',
            'academic_year' => 'required|string|max:20',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroyCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.courses')->with('success', 'Curso eliminado correctamente.');
    }

    public function students()
    {
        $students = Student::with('user')->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function createStudent()
    {
        $users = User::where('role', 'student')->whereDoesntHave('student')->get();
        $courses = Course::all();
        return view('admin.students.create', compact('users', 'courses'));
    }

    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required',
            'student_code' => 'required|string|unique:students,student_code',
            'date_of_birth' => 'required|date',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Student::create($validated);

        return redirect()->route('admin.students')->with('success', 'Estudiante creado correctamente.');
    }

    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        $courses = Course::all();
        $users = User::where('role', 'student')
            ->where(function ($query) use ($student) {
                $query->whereDoesntHave('student')
                    ->orWhere('id', $student->user_id);
            })
            ->get();

        return view('admin.students.edit', compact('student', 'users', 'courses'));
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'student_code' => ['required', Rule::unique('students')->ignore($student->id)],
            'date_of_birth' => 'required|date|before_or_equal:2015-12-31',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $student->update($validated);

        return redirect()->route('admin.students')->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroyStudent($id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;

        $student->delete();
        $user->delete();

        return redirect()->route('admin.students')->with('success', 'Estudiante eliminado.');
    }

    public function subjects(Request $request)
    {
        $query = Subject::with('course');

        if ($request->has('course_id') && $request->course_id != '') {
            $query->where('course_id', $request->course_id);
        }

        $subjects = $query->paginate(10);
        $courses = Course::all(); // Para mostrar los filtros

        return view('admin.subjects.index', compact('subjects', 'courses'));
    }

    public function createSubject()
    {
        $courses = Course::all();
        return view('admin.subjects.create', compact('courses'));
    }

    public function storeSubject(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
        ]);

        Subject::create($validated);

        return redirect()->route('admin.subjects')->with('success', 'Asignatura creada correctamente.');
    }

    public function editSubject($id)
    {
        $subject = Subject::findOrFail($id);
        $courses = Course::all();
        return view('admin.subjects.edit', compact('subject', 'courses'));
    }

    public function updateSubject(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
        ]);

        $subject->update($validated);

        return redirect()->route('admin.subjects')->with('success', 'Asignatura actualizada correctamente.');
    }

    public function destroySubject($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('admin.subjects')->with('success', 'Asignatura eliminada correctamente.');
    }

    public function teachers()
    {
        $teachers = Teacher::with('user')->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function createTeacher()
    {
        $users = User::where('role', 'teacher')->whereDoesntHave('teacher')->get();
        return view('admin.teachers.create', compact('users'));
    }

    public function storeTeacher(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'teacher_code' => 'required|string|unique:teachers,teacher_code',
            'specialization' => 'required|string|max:100',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        Teacher::create($validated);

        return redirect()->route('admin.teachers')->with('success', 'Profesor creado correctamente.');
    }

    public function editTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);

        // Traer usuarios con rol "teacher" que no estén asignados a ningún profesor, o incluir el actual
        $users = User::where('role', 'teacher')
            ->where(function ($query) use ($teacher) {
                $query->whereDoesntHave('teacher')
                    ->orWhere('id', $teacher->user_id);
            })
            ->get();

        return view('admin.teachers.edit', compact('teacher', 'users'));
    }


    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'teacher_code' => ['required', Rule::unique('teachers')->ignore($teacher->id)],
            'specialization' => 'required|string|max:100',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $teacher->update($validated); // Ahora se incluye el user_id

        return redirect()->route('admin.teachers')->with('success', 'Profesor actualizado correctamente.');
    }


    public function destroyTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('admin.teachers')->with('success', 'Profesor eliminado correctamente.');
    }
}
