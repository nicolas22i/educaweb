<header>
  <div class="header-content">
    <img src="{{ asset('images/educaweb-logo.png') }}" alt="Educaweb Logo" class="header-logo">
    <h1>Panel de Usuario</h1>
  </div>
  <div class="header-actions">
    <a href="{{ route('dashboard') }}" class="action-btn" title="Volver al Dashboard">
      <i class="fas fa-th-large"></i>
    </a>
    <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('¿Cerrar sesión?')">
      @csrf
      <button type="submit" class="action-btn danger" title="Cerrar sesión">
        <i class="fas fa-sign-out-alt"></i>
      </button>
    </form>
  </div>
</header>