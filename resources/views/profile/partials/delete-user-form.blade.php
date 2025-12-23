<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Eliminar Cuenta') }}
        </h2>
    </header>

    <div class="flex justify-center mt-6"> <!-- Contenedor flex centrado -->
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="btn btn-primary"
            style="margin-bottom: 15px">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ __('Iniciar') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <!-- Título y descripción centrados -->
            <div class="text-center mb-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('¿Estás seguro de que quieres eliminar tu cuenta?') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 mx-auto max-w-md">
                    {{ __('Esta acción no se puede deshacer. Todos tus datos serán eliminados permanentemente.') }}
                </p>
            </div>

            <!-- Campo de contraseña alineado a la izquierda -->
            <div class="text-left"> <!-- Cambio clave aquí -->
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                    placeholder="{{ __('Ingresa tu contraseña para confirmar') }}" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <!-- Botones centrados -->
            <div class="form-footer justify-center mt-6">
                <button type="button" x-on:click="$dispatch('close')" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    {{ __('Cancelar') }}
                </button>

                <button type="submit" class="btn btn-danger ml-3">
                    <i class="fas fa-trash-alt mr-2"></i>
                    {{ __('Eliminar Cuenta') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>