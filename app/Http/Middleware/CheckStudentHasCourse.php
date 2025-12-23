<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStudentHasCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Verificar si el usuario tiene estudiante asociado
        if (!$user->student) {
            return view('student.no-course');
        }
        
        // Verificar si el estudiante tiene curso asignado
        if (!$user->student->course) {
            return view('student.no-course');
        }
        
        // Si tiene curso, permitir continuar
        return $next($request);
    }
}