@if($messages->isEmpty())
<div class="h-full flex flex-col items-center justify-center">
    <div class="bg-white p-6 rounded-xl shadow-sm text-center max-w-md">
        <i class="bi bi-chat-square-text text-4xl text-gray-300 mb-3"></i>
        <p class="text-gray-500 font-medium">No hay mensajes aún</p>
        <p class="text-sm text-gray-400 mt-1">Envía el primer mensaje para iniciar la conversación</p>
    </div>
</div>
@else
<div class="space-y-3">
    @foreach($messages as $message)
    <div class="flex {{ $message->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
        <div class="flex max-w-xs lg:max-w-md">
            @if($message->sender_id != Auth::id())
            <div class="flex-shrink-0 mr-2 self-end">
                <img src="{{ $chat->student->user->profile_image ? asset($chat->student->user->profile_image) : asset('images/avatar-placeholder.png') }}" 
                     class="w-8 h-8 rounded-full object-cover border border-gray-200 shadow-sm">
            </div>
            @endif

            <div class="{{ $message->sender_id == Auth::id() ? 'bg-blue-600 text-white' : 'bg-white text-gray-800' }} rounded-2xl px-4 py-2 shadow-sm">
                <p class="text-sm">{!! nl2br(e($message->message)) !!}</p>
                <p class="text-xs mt-1 {{ $message->sender_id == Auth::id() ? 'text-blue-100' : 'text-gray-400' }} text-right">
                    {{ $message->created_at->format('H:i') }}
                    @if($message->sender_id == Auth::id())
                    <i class="bi bi-check2-all ml-1 {{ $message->read_at ? 'text-blue-300' : 'text-gray-400' }}"></i>
                    @endif
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
    @endforeach
</div>
@endif