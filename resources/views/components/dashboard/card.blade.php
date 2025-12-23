@props(['color' => 'blue', 'title', 'value'])

<div
    class="bg-white border-l-4 border-{{ $color }}-500 p-6 rounded-lg shadow-md hover:shadow-lg transition-all flex justify-between items-center">
    <div>
        <h2 class="text-sm font-bold text-gray-600 uppercase">{{ $title }}</h2>
        <p class="text-4xl font-extrabold text-{{ $color }}-600 mt-2">{{ $value }}</p>
    </div>
    <div>
        {{ $icon }}
    </div>
</div>
