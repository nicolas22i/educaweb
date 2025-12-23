document.addEventListener('DOMContentLoaded', function() {
    // Tab navigation
    const navLinks = document.querySelectorAll('.nav-link');
    const tabContents = document.querySelectorAll('.tab-content');
  
    navLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const tabId = this.getAttribute('data-tab');
        if (!tabId) return;
  
        navLinks.forEach(link => link.classList.remove('active'));
        tabContents.forEach(tab => tab.classList.remove('active'));
  
        this.classList.add('active');
        document.getElementById(tabId).classList.add('active');
      });
    });
  
    // Profile image change
    const profileImageContainer = document.getElementById('profile-image-container');
    const fileInput = document.getElementById('file-input');
    const profileImage = document.getElementById('profile-image');
    const profileImageInput = document.getElementById('profile_image_input');
  
    profileImageContainer.addEventListener('click', function() {
      fileInput.click();
    });
  
    let cropper;
    let currentFile;
  
    fileInput.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (!file) return;
  
      if (!file.type.match('image.*')) {
        showAlert('danger', 'Por favor, selecciona una imagen válida (JPEG, PNG, etc.)');
        return;
      }
  
      currentFile = file;
      const reader = new FileReader();
  
      reader.onload = function(e) {
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
  
    document.getElementById('cancelCrop').addEventListener('click', function() {
      document.getElementById('cropModal').style.display = 'none';
      if (cropper) cropper.destroy();
      fileInput.value = '';
    });
  
    document.getElementById('confirmCrop').addEventListener('click', function() {
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
          profileImage.src = e.target.result;
          updateProfileImage(croppedFile);
        };
        reader.readAsDataURL(blob);
      }, currentFile.type);
    });
  
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
      alertDiv.textContent = message;
      
      const profileContent = document.querySelector('.profile-content');
      profileContent.insertBefore(alertDiv, profileContent.firstChild);
      
      if (autoRemove) {
        setTimeout(() => {
          alertDiv.remove();
        }, 5000);
      }
    }
  });