<style>
  :root {
    --primary: #4361ee;
    --secondary: #5e17eb;
    --primary-dark: #3853d8;
    --secondary-dark: #4c12c2;
    --success: #2ecc71;
    --danger: #e63946;
    --light: #f8f9fa;
    --dark: #212529;
    --shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    --border-radius: 12px;
    --transition: all 0.3s ease;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 100vh;
    margin: 0;
    padding: 20px;
    background-color: #f5f7fa;
    color: #333;
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
  }

  /* Fondo moderno con gradiente y formas geométricas */
  body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(67, 97, 238, 0.08) 0%, rgba(94, 23, 235, 0.08) 100%);
    z-index: -1;
  }

  /* Formas decorativas de fondo */
  body::after {
    content: "";
    position: fixed;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(67, 97, 238, 0.05) 0%, transparent 70%);
    z-index: -1;
  }

  .container {
    max-width: 1200px;
    width: 100%;
    margin: 2rem auto;
    padding: 0 20px;
  }

  header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    padding: 20px 30px;
    border-radius: var(--border-radius);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    box-shadow: var(--shadow);
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  header::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    transform: rotate(30deg);
  }

  .header-logo {
    height: 45px;
    margin-right: 15px;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
  }

  .header-content {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 1;
  }

  .header-actions {
    display: flex;
    gap: 15px;
    position: relative;
    z-index: 1;
  }

  .action-btn {
    background-color: rgba(255, 255, 255, 0.15);
    color: white;
    border: none;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    backdrop-filter: blur(5px);
  }

  .action-btn:hover {
    background-color: rgba(255, 255, 255, 0.25);
    transform: translateY(-3px);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
  }

  .action-btn.danger:hover {
    background-color: rgba(230, 57, 70, 0.8);
  }

  .profile-container {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 30px;
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    margin: 0 auto;
    max-width: 1100px;
    position: relative;
  }

  .profile-sidebar {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    padding: 40px 25px;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    overflow: hidden;
  }

  .profile-sidebar::before {
    content: "";
    position: absolute;
    bottom: -50px;
    right: -50px;
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
  }

  .profile-image-container {
    position: relative;
    margin-bottom: 25px;
    cursor: pointer;
    transition: var(--transition);
    z-index: 1;
  }

  .profile-image-container:hover {
    transform: scale(1.05);
  }

  .profile-image {
    width: 170px;
    height: 170px;
    border-radius: 50%;
    object-fit: cover;
    border: 6px solid rgba(255, 255, 255, 0.8);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    transition: var(--transition);
  }

  .profile-image-container:hover .profile-image {
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
  }

  .profile-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: var(--transition);
  }

  .profile-image-container:hover .profile-image-overlay {
    opacity: 1;
  }

  .profile-image-overlay i {
    color: white;
    font-size: 28px;
  }

  .profile-name {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 8px;
    text-align: center;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    position: relative;
    z-index: 1;
  }

  .profile-role {
    display: inline-block;
    background-color: rgba(255, 255, 255, 0.15);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 14px;
    margin-bottom: 35px;
    backdrop-filter: blur(5px);
    position: relative;
    z-index: 1;
  }

  .sidebar-nav {
    width: 100%;
    margin-top: 20px;
    position: relative;
    z-index: 1;
  }

  .sidebar-nav a,
  .sidebar-nav button {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 14px 16px;
    color: #fff;
    text-decoration: none;
    border-radius: var(--border-radius);
    margin-bottom: 12px;
    transition: var(--transition);
    text-align: left;
    font-size: 16px;
    border: none;
    background: transparent;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(5px);
  }

  .sidebar-nav a::before,
  .sidebar-nav button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: var(--transition);
  }

  .sidebar-nav a:hover::before,
  .sidebar-nav button:hover::before {
    left: 100%;
  }

  .sidebar-nav a:hover,
  .sidebar-nav a.active,
  .sidebar-nav button:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
  }

  .sidebar-nav a.active {
    background-color: rgba(255, 255, 255, 0.2);
    border-left: 4px solid white;
  }

  .sidebar-nav a i,
  .sidebar-nav button i {
    margin-right: 12px;
    width: 20px;
    text-align: center;
  }

  .sidebar-nav .danger-btn {
    background-color: rgba(230, 57, 70, 0.2);
    color: #ff8a8a;
    margin-top: 10px;
  }

  .sidebar-nav .danger-btn:hover {
    background-color: rgba(230, 57, 70, 0.3);
  }

  .profile-content {
    padding: 35px;
    background-color: #fff;
    position: relative;
  }

  .profile-content::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100" fill="none" opacity="0.03"><path d="M0 0h100v100H0z"/><path d="M20 20h20v20H20zM60 20h20v20H60zM20 60h20v20H20zM60 60h20v20H60z" fill="%234361ee"/></svg>');
    opacity: 0.05;
    z-index: 0;
  }

  .content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 18px;
    border-bottom: 2px solid #f0f0f0;
    text-align: center;
    position: relative;
    z-index: 1;
  }

  .content-title {
    font-size: 28px;
    background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 600;
    position: relative;
    display: inline-block;
  }

  .content-title::after {
    content: "";
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: 3px;
  }

  .btn {
    padding: 12px 26px;
    border: none;
    border-radius: var(--border-radius);
    cursor: pointer;
    font-weight: 600;
    transition: var(--transition);
    font-size: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    z-index: 1;
  }

  .btn::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: var(--transition);
    z-index: -1;
  }

  .btn:hover::before {
    left: 100%;
  }

  .btn i {
    margin-right: 8px;
  }


  .btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(94, 23, 235, 0.2);
  }

  .btn-success {
    background-color: var(--success);
    color: white;
  }

  .btn-danger {
    background-color: var(--danger);
    color: white;
  }

  .btn:hover {
    opacity: 0.95;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .btn-sm {
    padding: 8px 16px;
    font-size: 14px;
  }

  .form-card {
    background-color: #fff;
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 25px;
    transition: var(--transition);
    max-width: 650px;
    margin-left: auto;
    margin-right: auto;
    position: relative;
    z-index: 1;
    border: 1px solid rgba(0, 0, 0, 0.05);
  }

  .form-card:hover {
    box-shadow: 0 5px 20px rgba(67, 97, 238, 0.1);
  }

  .form-header {
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
    text-align: center;
  }

  .form-header h3 {
    font-size: 20px;
    color: var(--primary);
    position: relative;
  }

  .form-header h3::after {
    content: "";
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
  }

  .form-group {
    margin-bottom: 25px;
    position: relative;
  }

  label {
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
    font-weight: 500;
    color: var(--dark);
  }

  input,
  select {
    width: 100%;
    padding: 14px 18px;
    border: 1px solid #ddd;
    border-radius: var(--border-radius);
    font-size: 15px;
    transition: var(--transition);
    background-color: #f9f9f9;
  }

  input:focus,
  select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    background-color: #fff;
  }

  .info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin: 30px 0;
  }

  .info-item {
    padding: 12px 18px;
    background-color: #f8f9fa;
    border-radius: var(--border-radius);
    border-left: 3px solid var(--primary);
    text-align: left;
    transition: var(--transition);
  }

  .info-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
  }

  .info-label {
    display: block;
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 6px;
  }

  .info-value {
    font-weight: 500;
    color: var(--dark);
  }

  .form-footer {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 30px;
  }

  .text-center {
    text-align: center;
  }

  .flex.justify-center {
    display: flex;
    justify-content: center;
  }

  .max-w-md {
    max-width: 28rem;
    /* 448px */
  }

  .mx-auto {
    margin-left: auto;
    margin-right: auto;
  }

  .alert {
    padding: 15px !important;
    border-radius: var(--border-radius) !important;
    margin: 0 auto 20px;
    color: #721c24;
    border: 1px solid #f5c6cb;
    max-width: 650px;
    text-align: center;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(5px);
    list-style: none !important;
  }

  .alert::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(248, 215, 218, 0.8);
    z-index: -1;
  }

  .alert-success {
    color: #155724;
    border: 1px solid #c3e6cb;
  }

  .alert-success::before {
    background-color: rgba(212, 237, 218, 0.8);
  }

  .tab-content {
    display: none;
    animation: fadeIn 0.3s ease;
    position: relative;
    z-index: 1;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .tab-content.active {
    display: block;
  }

  #file-input {
    display: none;
  }

  .text-danger {
    color: var(--danger);
    font-size: 14px;
    margin-top: 5px;
    text-align: center;
  }

  .text-danger i {
    margin-right: 5px;
  }

  .verification-sent {
    font-size: 13px;
    color: var(--success);
    margin-top: 10px;
    text-align: center;
  }

  /* Modal para recortar */
  #cropModal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.85);
    z-index: 1000;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px);
  }

  #cropModal>div {
    background: white;
    padding: 25px;
    border-radius: 12px;
    max-width: 90%;
    width: 600px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    position: relative;
  }

  #cropModal>div::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(94, 23, 235, 0.05) 100%);
    z-index: -1;
  }

  #imageContainer {
    max-height: 70vh;
    max-width: 100%;
    margin-bottom: 20px;
  }

  #cropModal button {
    margin: 0 8px;
    min-width: 120px;
  }

  /* Animaciones adicionales */
  @keyframes float {

    0%,
    100% {
      transform: translateY(0);
    }

    50% {
      transform: translateY(-10px);
    }
  }

  /* Efecto de ondas en el sidebar */
  .wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100px;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
    background-size: cover;
    background-repeat: no-repeat;
    opacity: 0.5;
  }

  @media (max-width: 768px) {
    .profile-container {
      grid-template-columns: 1fr;
    }

    .info-grid {
      grid-template-columns: 1fr;
    }

    .profile-content {
      padding: 25px 20px;
    }

    .form-card {
      padding: 20px;
    }

    .profile-sidebar {
      padding: 30px 20px;
    }

    .header-content h1 {
      font-size: 20px;
    }

    body::after {
      display: none;
    }
  }
</style>