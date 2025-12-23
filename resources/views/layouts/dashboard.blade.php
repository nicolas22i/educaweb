@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <header>
        <h1 class="text-3xl font-bold text-gray-900">@yield('title')</h1>
    </header>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        @yield('dashboard-content')
    </div>
</div>
@endsection