@extends('layouts.teacher')

@section('dashboard-content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <!-- Encabezado -->
    <div class="flex items-center justify-between mb-6 p-4 bg-white/80 backdrop-blur-sm rounded-xl shadow-sm">
        <div class="flex items-center">
            <a href="{{ route('teacher.chat.index') }}" class="text-blue-600 hover:text-blue-800 mr-4 transition-colors">
                <i class="bi bi-arrow-left text-xl"></i>
            </a>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <img src="{{ $chat->student->user->profile_image ? asset($chat->student->user->profile_image) : asset('images/avatar-placeholder.png') }}" 
                         class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Chat con {{ $chat->student->user->name }}</h2>
                    <p class="text-xs text-gray-500">
                        {{ $chat->student->course->name ?? 'Sin curso asignado' }}
                    </p>
                </div>
            </div>
        </div>
        
        <form action="{{ route('teacher.chat.delete', $chat->id) }}" method="POST"
              onsubmit="return confirm('¿Estás seguro de que deseas eliminar este chat?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                <i class="bi bi-trash mr-1"></i> Eliminar
            </button>
        </form>
    </div>

    <!-- Área de mensajes -->
    <div id="messages-container" class="bg-gradient-to-b from-blue-50 to-gray-50 rounded-2xl shadow-inner p-4 mb-4" style="height: 65vh; overflow-y: auto;">
        @include('teacher.chat.messages', ['chat' => $chat, 'messages' => $chat->messages])
    </div>

    <!-- Formulario de mensaje con AJAX -->
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

<style>
    /* Efecto de scroll personalizado */
    [style*="height: 65vh"]::-webkit-scrollbar {
        width: 6px;
    }
    [style*="height: 65vh"]::-webkit-scrollbar-track {
        background: rgba(0,0,0,0.05);
        border-radius: 10px;
    }
    [style*="height: 65vh"]::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.1);
        border-radius: 10px;
    }
</style>

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
        
        fetch("{{ route('teacher.chat.send', $chat->id) }}", {
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
        fetch("{{ route('teacher.chat.messages', $chat->id) }}", {
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