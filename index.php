<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Sistem Login</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <style>
    body {
      background: linear-gradient(135deg, #f7fbfd 0%, #e8f4fd 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .login-container {
      max-width: 420px;
      width: 100%;
      padding: 0 1rem;
    }

    .login-card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(46, 128, 156, 0.15);
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(10px);
      overflow: hidden;
    }

    .login-header {
      background: linear-gradient(135deg, #2E809C, #3a9bb8);
      color: white;
      padding: 2rem 1.5rem;
      text-align: center;
      position: relative;
    }

    .login-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
      opacity: 0.3;
    }

    .login-title {
      font-size: 1.75rem;
      font-weight: 700;
      margin: 0;
      position: relative;
      z-index: 1;
    }

    .login-subtitle {
      font-size: 0.9rem;
      opacity: 0.9;
      margin: 0.5rem 0 0 0;
      position: relative;
      z-index: 1;
    }

    .login-body {
      padding: 2rem 1.5rem;
    }

    .form-label {
      font-weight: 600;
      color: #2E809C;
      margin-bottom: 0.5rem;
    }

    .input-group-custom {
      position: relative;
      
    }

    .input-icon {
      position: absolute;
      left: 15px;
      top: 70%;
      transform: translateY(-50%);
      color: #2E809C;
      font-size: 1.1rem;
      z-index: 2;
    }

    .form-control {
      border: 2px solid #2E809C;
      border-radius: 12px;
      padding: 0.75rem 1rem 0.75rem 3rem;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.8);
    }

    .form-control:focus {
      border-color: #2E809C;
      box-shadow: 0 0 0 3px rgba(46, 128, 156, 0.1);
      background: white;
      transform: translateY(-1px);
    }

    .form-control::placeholder {
      color: #6c757d;
      opacity: 0.7;
    }

    .form-check {
      margin: 1rem 0;
    }

    .form-check-label {
      color: #495057;
      font-weight: 500;
      cursor: pointer;
    }

    .form-check-input:checked {
      background-color: #2E809C;
      border-color: #2E809C;
    }

    .btn-login {
      background: linear-gradient(135deg, #2E809C, #3a9bb8);
      border: none;
      border-radius: 12px;
      margin-top: 1rem;
      padding: 0.875rem 2rem;
      font-weight: 600;
      font-size: 1rem;
      color: white;
      width: 100%;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(46, 128, 156, 0.3);
    }

    .btn-login:hover {
      background: linear-gradient(135deg, #245a6b, #2d8a9c);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(46, 128, 156, 0.4);
      color: white;
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .login-footer {
      text-align: center;
      padding: 1rem 1.5rem 1.5rem;
      color: #6c757d;
      font-size: 0.9rem;
    }

    .login-footer a {
      color: #2E809C;
      text-decoration: none;
      font-weight: 600;
    }

    .login-footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 576px) {
      .login-container {
        padding: 0 0.5rem;
      }

      .login-header {
        padding: 1.5rem 1rem;
      }

      .login-title {
        font-size: 1.5rem;
      }

      .login-body {
        padding: 1.5rem 1rem;
      }
    }

    /* Animation for card entrance */
    .login-card {
      animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h1 class="login-title">
          <i class="bi bi-shop me-2"></i> LOGIN
        </h1>
        <p class="login-subtitle">Masuk ke akun Anda</p>
      </div>

      <div class="login-body">
        <form action="backend/querySql/proses_login.php" method="POST">
          <div class="input-group-custom">
            <label for="username" class="form-label">Username</label>
            <i class="bi bi-person-circle input-icon"></i>
            <input
              type="text"
              class="form-control"
              id="username"
              name="username"
              placeholder="Masukkan username"
              required />
          </div>

          <div class="input-group-custom">
            <label for="password" class="form-label">Password</label>
            <i class="bi bi-lock-fill input-icon"></i>
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
              placeholder="Masukkan password"
              required />
          </div>

          

          <button type="submit" class="btn btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
          </button>
        </form>
      </div>

      <div class="login-footer">
        <p>&copy; 2024 Sistem Kasir. Semua hak dilindungi.</p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
