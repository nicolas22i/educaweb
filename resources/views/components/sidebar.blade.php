<div class="h-screen w-64 bg-gray-800 text-white fixed left-0 top-0 overflow-y-auto">
    <div class="p-4 border-b border-gray-700">
        <h2 class="text-2xl font-bold">{{ config('app.name') }}</h2>
    </div>
    
    @php
        $user = Auth::user();
    @endphp

    <nav class="mt-4">
        @switch($user->role)
            @case('admin')
                <x-sidebar-admin-menu />
                @break
            
            @case('teacher')
                <x-sidebar-teacher-menu />
                @break
            
            @case('student')
                <x-sidebar-student-menu />
                @break
        @endswitch
    </nav>
</div>
