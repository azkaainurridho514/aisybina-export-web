<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | Aisy Bina Exports</title>
  <meta name="robots" content="noindex, nofollow">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset("assets/css/style-admin.css") }}">
</head>
<body>

  <div class="auth-page">
    <div class="auth-card">
      <div class="auth-brand">Aisy Bina<span class="brand-dot">.</span></div>
      <p class="auth-sub">Sign in to manage your website content.</p>

      <div class="auth-error" id="loginError"></div>

      <form id="loginForm" novalidate>
        <div class="field-group">
          <label class="field-label" for="loginEmail">Email</label>
          <input type="email" id="loginEmail" class="form-control-admin" placeholder="admin@aisybina-exports.com" required autofocus>
        </div>

        <div class="field-group">
          <label class="field-label" for="loginPassword">Password</label>
          <div class="auth-password-wrap">
            <input type="password" id="loginPassword" class="form-control-admin" placeholder="••••••••" required>
            <button type="button" class="auth-toggle-pass" id="togglePassword" aria-label="Show password">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-admin btn-admin-forest w-100" id="loginSubmit">Sign In</button>
      </form>

      <p class="auth-footnote">Demo: admin@aisybina-exports.com / aisybina123</p>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset("assets/js/script-admin.js") }}"></script>
</body>
</html>
