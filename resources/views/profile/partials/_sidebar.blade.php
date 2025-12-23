<div class="profile-sidebar">
  <div class="wave"></div>
  <div class="profile-image-container" id="profile-image-container">
    <img src="{{ Auth::user()->profile_image ? Auth::user()->profile_image : asset('images/avatar-placeholder.png') }}"
      alt="Foto de perfil" class="profile-image" id="profile-image">
    <div class="profile-image-overlay">
      <i class="fas fa-camera"></i>
    </div>
    <input type="file" id="file-input" name="profile_image" accept="image/*">
  </div>
  <h2 class="profile-name">{{ Auth::user()->name }}</h2>
  <span class="profile-role">
    @switch(Auth::user()->role)
      @case('admin') ADMINISTRADOR @break
      @case('teacher') PROFESOR @break
      @case('student') ESTUDIANTE @break
      @default {{ Auth::user()->role }}
    @endswitch
  </span>

  <div class="sidebar-nav">
    <a href="#" class="nav-link active" data-tab="personal-info">
      <i class="fas fa-user"></i> Información Personal
    </a>
    <a href="#" class="nav-link" data-tab="change-password">
      <i class="fas fa-key"></i> Cambiar Contraseña
    </a>
    <a href="#" class="nav-link danger-btn" data-tab="delete-account">
      <i class="fas fa-trash-alt"></i> Eliminar Cuenta
    </a>
  </div>
</div>