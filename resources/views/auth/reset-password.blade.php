<x-guest-layout>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-white to-blue-100 px-4">
        <div class="max-w-md w-full bg-white shadow-xl rounded-lg p-8 border border-blue-200">
            {{-- Logo --}}
            <img src="{{ asset('images/educaweb-logo.png') }}" alt="EducaWeb" class="w-24 mx-auto mb-6">

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Restablecer Contraseña</h2>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="'Correo electrónico'" />
                    <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required
                        class="w-full border-gray-300 rounded-md shadow-sm mt-1" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Nueva contraseña --}}
                <div>
                    <x-input-label for="password" :value="'Nueva Contraseña'" />
                    <x-text-input id="password" type="password" name="password" required
                        class="w-full border-gray-300 rounded-md shadow-sm mt-1" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Confirmar contraseña --}}
                <div>
                    <x-input-label for="password_confirmation" :value="'Confirmar Contraseña'" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full border-gray-300 rounded-md shadow-sm mt-1" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition">
                        Restablecer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
