<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900">Mi Perfil</h2>
  </header>

  @if (session('success'))
    <div class="alert alert-success">
    <i class="fas fa-check-circle mr-2"></i>
    {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-error">
    <ul class="error-list" style="list-style: none; padding-left: 0;">
      @foreach ($errors->all() as $error)
      <li style="list-style-type: none;">
      <i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}
      </li>
    @endforeach
    </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
    @csrf

    <div>
      <label for="name" class="block font-medium text-gray-700 mb-1">Nombre</label>
      <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required autofocus autocomplete="name"
        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring focus:ring-blue-200 bg-white" />
    </div>

    <div>
      <label for="email" class="block font-medium text-gray-700 mb-1">Email</label>
      <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required autocomplete="username"
        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring focus:ring-blue-200 bg-white" />
    </div>

    {{-- Espacio entre el bloque de inputs y la info adicional --}}
    <div class="mt-8">
      <div class="info-grid">
        <div class="info-item">
          <span class="info-label">Fecha de creación</span>
          <span class="info-value">{{ Auth::user()->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Última actualización</span>
          <span class="info-value">{{ Auth::user()->updated_at->format('d/m/Y H:i') }}</span>
        </div>
      </div>
    </div>

    <input type="hidden" id="profile_image_input" name="profile_image">

    <div class="form-footer justify-start">
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Guardar
      </button>
    </div>
  </form>
</section>