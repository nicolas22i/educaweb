<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Perfil de Usuario - TFG</title>

  <!-- CSS de Cropper.js -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  @include('profile.partials.styles')
</head>

<body>
  <div class="container">
    @include('profile.partials._header')

    <div class="profile-container floating">
      @include('profile.partials._sidebar')

      <div class="profile-content">
        <!-- Contenido dinámico -->
        <div id="personal-info" class="tab-content active">
          @include('profile.partials.personal-info')
        </div>

        <div id="change-password" class="tab-content">
          @include('profile.partials.update-password-form')
        </div>

        <div id="delete-account" class="tab-content">
          @include('profile.partials.delete-user-form')
        </div>

        <!-- Modal para recortar -->
        @include('profile.partials._crop-modal')
      </div>
    </div>
  </div>

  <!-- JS de Cropper.js -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Manejo de pestañas
      const status = '{{ session("status") }}';
      const hasPasswordErrors = @json($errors->updatePassword->any());

      // Cambiar a pestaña de contraseña si es necesario
      if (status === 'password-updated' || hasPasswordErrors) {
        switchToTab('change-password');
      }

      // Navegación por pestañas - PARA EL MENÚ LATERAL
      const sidebarLinks = document.querySelectorAll('.sidebar-nav a[data-tab]');
      sidebarLinks.forEach(link => {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          const tabId = this.getAttribute('data-tab');
          if (tabId) switchToTab(tabId);
        });
      });

      // Navegación por pestañas - PARA EL MENÚ SUPERIOR (si existe)
      const navLinks = document.querySelectorAll('.nav-link[data-tab]');
      navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          const tabId = this.getAttribute('data-tab');
          if (tabId) switchToTab(tabId);
        });
      });

      // Función para cambiar de pestaña
      function switchToTab(tabId) {
        // Desactivar todas las pestañas
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));

        // Desactivar todos los enlaces
        document.querySelectorAll('.sidebar-nav a').forEach(link => link.classList.remove('active'));
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));

        // Activar la pestaña seleccionada
        document.querySelector(`#${tabId}`)?.classList.add('active');

        // Activar el enlace correspondiente en el sidebar
        document.querySelector(`.sidebar-nav a[data-tab="${tabId}"]`)?.classList.add('active');

        // Activar el enlace correspondiente en el menú superior (si existe)
        document.querySelector(`.nav-link[data-tab="${tabId}"]`)?.classList.add('active');
      }

      // Gestión de imagen de perfil 
      const profileImageContainer = document.getElementById('profile-image-container');
      const fileInput = document.getElementById('file-input');
      let cropper, currentFile;

      if (profileImageContainer) {
        profileImageContainer.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function (e) {
          const file = e.target.files[0];
          if (!file) return;

          if (!file.type.match('image.*')) {
            showAlert('danger', 'Por favor, selecciona una imagen válida (JPEG, PNG, etc.)');
            return;
          }

          currentFile = file;
          const reader = new FileReader();

          reader.onload = function (e) {
            const imageToCrop = document.getElementById('imageToCrop');
            imageToCrop.src = e.target.result;
            document.getElementById('cropModal').style.display = 'flex';

            if (cropper) cropper.destroy();
            cropper = new Cropper(imageToCrop, {
              aspectRatio: 1,
              viewMode: 1,
              autoCropArea: 0.8,
              responsive: true,
            });
          };

          reader.readAsDataURL(file);
        });

        document.getElementById('cancelCrop')?.addEventListener('click', function () {
          document.getElementById('cropModal').style.display = 'none';
          if (cropper) cropper.destroy();
          fileInput.value = '';
        });

        document.getElementById('confirmCrop')?.addEventListener('click', function () {
          if (!cropper) return;

          cropper.getCroppedCanvas().toBlob((blob) => {
            const croppedFile = new File([blob], currentFile.name, {
              type: currentFile.type,
              lastModified: Date.now(),
            });

            document.getElementById('cropModal').style.display = 'none';
            if (cropper) cropper.destroy();

            const reader = new FileReader();
            reader.onload = (e) => {
              document.getElementById('profile-image').src = e.target.result;
              updateProfileImage(croppedFile);
            };
            reader.readAsDataURL(blob);
          }, currentFile.type);
        });
      }

      function updateProfileImage(file) {
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('profile_image', file);

        fetch('{{ route("profile.image.update") }}', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          credentials: 'include',
          body: formData
        })
          .then(response => {
            if (!response.ok) throw new Error('Error en la petición');
            return response.json();
          })
          .then(data => {
            if (data.success) {
              document.getElementById('profile-image').src = data.profile_image_url;
              showAlert('success', 'Imagen actualizada correctamente');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Error al actualizar la imagen');
          });
      }

      function showAlert(type, message, autoRemove = true) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        alertDiv.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle mr-2"></i>${message}`;

        const profileContent = document.querySelector('.profile-content');
        if (profileContent) {
          profileContent.insertBefore(alertDiv, profileContent.firstChild);

          if (autoRemove) {
            setTimeout(() => alertDiv.remove(), 5000);
          }
        }
      }
    });
  </script>
</body>

</html>