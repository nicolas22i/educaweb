@extends('layouts.student')

@section('dashboard-content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <!-- Encabezado -->
    <div class="flex items-center justify-between mb-6 p-4 bg-white/80 backdrop-blur-sm rounded-xl shadow-sm">
        <div class="flex items-center">
            <a href="{{ route('student.chat') }}" class="text-blue-600 hover:text-blue-800 mr-4 transition-colors">
                <i class="bi bi-arrow-left text-xl"></i>
            </a>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <img src="{{ $chat->teacher->user->profile_image ? asset($chat->teacher->user->profile_image) : asset('images/avatar-placeholder.png') }}"
                        class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Chat con {{ $chat->teacher->user->name }}</h2>
                    <p class="text-xs text-gray-500">En línea</p>
                </div>
            </div>
        </div>
        
        <form action="{{ route('teacher.chat.delete', $chat->id) }}" method="POST"
            onsubmit="return confirm('¿Estás seguro de que deseas eliminar este chat?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800 text-sm font-medium bg-red-50 px-3 py-1 rounded-lg">
                <i class="bi bi-trash mr-1"></i> Eliminar chat
            </button>
        </form>
    </div>

    <!-- Área de mensajes segura -->
    <div id="messages-container" class="bg-gradient-to-b from-blue-50 to-gray-50 rounded-2xl shadow-inner p-4 mb-4" style="height: 65vh; overflow-y: auto;">
        @if($chat->messages->isEmpty())
        <div class="h-full flex flex-col items-center justify-center">
            <div class="bg-white p-6 rounded-xl shadow-sm text-center max-w-md">
                <i class="bi bi-chat-square-text text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500 font-medium">No hay mensajes aún</p>
                <p class="text-sm text-gray-400 mt-1">Envía el primer mensaje para iniciar la conversación</p>
            </div>
        </div>
        @else
        <div class="space-y-3">
            @foreach($chat->messages as $message)
                @if($message->sender_id == Auth::id() || $message->sender_id == $chat->teacher->user_id)
                <div class="flex {{ $message->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                    <div class="flex max-w-xs lg:max-w-md">
                        @if($message->sender_id != Auth::id())
                        <div class="flex-shrink-0 mr-2 self-end">
                            <img src="{{ $chat->teacher->user->profile_image ? asset($chat->teacher->user->profile_image) : asset('images/avatar-placeholder.png') }}"
                                class="w-8 h-8 rounded-full object-cover border border-gray-200 shadow-sm">
                        </div>
                        @endif

                        <div class="{{ $message->sender_id == Auth::id() ? 'bg-blue-600 text-white' : 'bg-white text-gray-800' }} rounded-2xl px-4 py-2 shadow-sm">
                            <p class="text-sm">{!! nl2br(e($message->message)) !!}</p>
                            <p class="text-xs mt-1 {{ $message->sender_id == Auth::id() ? 'text-blue-100' : 'text-gray-400' }} text-right">
                                {{ \Carbon\Carbon::parse($message->created_at)->translatedFormat('H:i · d M') }}
                            </p>
                        </div>

                        @if($message->sender_id == Auth::id())
                        <div class="flex-shrink-0 ml-2 self-end">
                            <img src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('images/avatar-placeholder.png') }}"
                                class="w-8 h-8 rounded-full object-cover border border-gray-200 shadow-sm">
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @endif
    </div>

    <!-- Formulario seguro -->
    <form id="message-form" class="flex space-x-2">
        @csrf
        <input type="text" id="message-input" name="message"
            class="flex-1 border-0 bg-white rounded-xl shadow-sm px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400"
            placeholder="Escribe un mensaje..."
            required>
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 rounded-xl shadow-md transition-all transform hover:scale-105 active:scale-95">
            <i class="bi bi-send-fill"></i>
        </button>
    </form>
</div>

<script>
    // Auto-scroll al final de los mensajes
    function scrollToBottom() {
        const messageArea = document.getElementById('messages-container');
        messageArea.scrollTop = messageArea.scrollHeight;
    }

    // Enviar mensaje con AJAX
    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();
        
        if (message === '') return;
        
        fetch("{{ route('student.chat.send', $chat->id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ 
                message: message
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                checkForNewMessages();
            }
        })
        .catch(error => {
            console.error('Error al enviar mensaje:', error.error || error.message);
        });
    });

    // Verificar nuevos mensajes
    function checkForNewMessages() {
        fetch("{{ route('student.chat.messages', $chat->id) }}", {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.text();
        })
        .then(html => {
            document.getElementById('messages-container').innerHTML = html;
            scrollToBottom();
        })
        .catch(error => {
            console.error('Error al cargar mensajes:', error.error || error.message);
            // Intenta recargar la página si hay un error persistente
            if (error.error && error.error.includes("No query results")) {
                window.location.reload();
            }
        });
    }

    // Iniciar el chequeo periódico
    document.addEventListener('DOMContentLoaded', function() {
        scrollToBottom();
        setInterval(checkForNewMessages, 3000);
    });
</script>
@endsection