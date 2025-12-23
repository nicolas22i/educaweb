@extends('layouts.teacher')

@section('title', 'Mis Chats')

@section('dashboard-content')
<div class="mb-8">
    <p class="text-gray-600">Consulta y gestiona tus conversaciones con estudiantes</p>
</div>

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
    <strong class="font-bold">Error:</strong>
    <span class="block sm:inline">{{ session('error') }}</span>
</div>
@endif

@if(!isset($chats))
<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg mb-6" role="alert">
    <strong class="font-bold">Advertencia:</strong>
    <span class="block sm:inline">Variable $chats no definida</span>
</div>
@elseif($chats->isEmpty())
<div class="col-span-full flex flex-col items-center justify-center p-10 bg-gray-50 rounded-xl border border-gray-200">
    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
    <p class="text-xl font-medium text-gray-600 mb-2">No tienes chats disponibles</p>
    <p class="text-gray-500 text-center">Tus conversaciones con estudiantes aparecerán aquí.</p>
    <a href="{{ route('teacher.chat.create') }}" class="mt-6 inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Iniciar un nuevo chat
    </a>
</div>
@else
<div class="flex flex-wrap gap-4 mb-8">
    <div>
        <a href="{{ route('teacher.chat.create') }}"
            class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nuevo Chat
        </a>
    </div>
</div>

<div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-2">
    @foreach($chats as $chat)
    @php
    $hasUnread = $chat->unread_messages_count > 0;
    @endphp
    <div class="group relative overflow-hidden bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
        <!-- Banner superior con gradiente -->
        <div class="h-3 bg-gradient-to-r {{ $hasUnread ? 'from-blue-500 to-blue-600' : 'from-gray-300 to-gray-400' }}"></div>

        <div class="p-6">
            <!-- Contenedor flex para avatar y detalles -->
            <div class="flex items-start gap-4 mb-4">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <img src="{{ $chat->student && $chat->student->user && $chat->student->user->profile_image 
                                ? asset($chat->student->user->profile_image) 
                                : asset('images/avatar-placeholder.png') }}"
                        class="h-14 w-14 rounded-full object-cover border-2 {{ $hasUnread ? 'border-blue-400' : 'border-gray-200' }}">
                </div>

                <!-- Información del estudiante y último mensaje -->
                <div class="flex-grow">
                    <h2 class="text-xl font-bold text-gray-800 group-hover:{{ $hasUnread ? 'text-blue-600' : 'text-gray-700' }} transition-colors">
                        @if($chat->student && $chat->student->user)
                        {{ $chat->student->user->name }}
                        @else
                        Estudiante desconocido
                        @endif
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        <span class="inline-block">Última actividad: {{ $chat->updated_at->diffForHumans() }}</span>
                        @if($hasUnread)
                        <span class="ml-2 bg-blue-500 text-white text-xs rounded-full px-2 py-0.5">
                            {{ $chat->unread_messages_count }} {{ $chat->unread_messages_count == 1 ? 'nuevo' : 'nuevos' }}
                        </span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Último mensaje -->
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <p class="text-gray-600 line-clamp-2">
                    @if($chat->messages->count() > 0)
                    {{ $chat->messages->first()->message }}
                    @else
                    No hay mensajes todavía
                    @endif
                </p>
            </div>

            <div class="mt-4">
                <a href="{{ route('teacher.chat.show', $chat->id) }}"
                    class="inline-flex items-center justify-center w-full {{ $hasUnread ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-600 hover:bg-gray-700' }} text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    {{ $hasUnread ? 'Responder Mensajes' : 'Ver Conversación' }}
                </a>

                {{-- Botón de eliminar --}}
                <form action="{{ route('teacher.chat.delete', $chat->id) }}" method="POST" class="mt-2 text-right"
                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este chat y todos sus mensajes?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800 text-sm font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Eliminar Chat
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection