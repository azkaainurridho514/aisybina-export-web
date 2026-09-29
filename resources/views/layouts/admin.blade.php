<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') | Aisy Bina Exports</title>
  <meta name="robots" content="noindex, nofollow">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script>
    window.ADMIN = {
      base: @json(url('/admin')),
      loginUrl: @json(url('/login-admin-aisybina-export')),
      logoutUrl: @json(url('/logout'))
    };
  </script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  {{-- Aset yang belum ada di public/assets memakai CDN dulu. --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ \App\Support\Asset::v('assets/css/style-admin.css') }}">
  @stack('styles')

  <style>
    /* Tambahan untuk halaman berbasis server (link asli, bukan div/button) */
    a.admin-nav-link, .admin-pagination a.btn-icon { text-decoration: none; }
    .admin-pagination { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 1rem 0 0; flex-wrap: wrap; }
    .admin-pagination-info { color: var(--forest-soft, #52685c); font-size: .875rem; }
    .admin-pagination-buttons { display: flex; align-items: center; gap: .35rem; }
    .admin-page-number { min-width: 36px; justify-content: center; }
    .admin-page-number.active { background: var(--forest, #1f3b2e); color: #fff; border-color: var(--forest, #1f3b2e); }
    .admin-pagination .btn-icon:disabled { opacity: .45; cursor: not-allowed; }
    .admin-search-form { margin: 0; }
  </style>
</head>
<body>
@php
  $authUser = auth()->user();
  $userName = $authUser->name ?? 'Admin';
  $initials = strtoupper(mb_substr(trim($userName), 0, 2));
@endphp

  <div class="admin-shell">

    @include('admin.partials.sidebar')

    <div class="admin-content">

      <header class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
          <button type="button" class="admin-sidebar-toggle" id="sidebarToggle" aria-label="Buka menu"><i class="bi bi-list"></i></button>
          <div class="admin-topbar-title">@yield('page_title', 'Dashboard')</div>
        </div>

        <div class="admin-user dropdown">
          <div data-bs-toggle="dropdown" aria-expanded="false" class="d-flex align-items-center gap-2" role="button">
            <div class="admin-user-avatar">{{ $initials }}</div>
            <div class="d-none d-sm-block">
              <div class="admin-user-name">{{ $userName }}</div>
              <div class="admin-user-role">Site Owner</div>
            </div>
            <i class="bi bi-chevron-down d-none d-sm-inline" style="font-size:0.75rem;color:var(--forest-soft);"></i>
          </div>
          <ul class="dropdown-menu dropdown-menu-end mt-2">
            <li><a class="dropdown-item" href="#" id="logoutBtn"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </div>
      </header>

      <main class="admin-main">
        @yield('content')
      </main>
    </div>
  </div>

  @stack('modals')

  {{-- Vendor (CDN). Versi dikunci agar tidak berubah sendiri. --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.all.min.js"></script>
  @stack('vendor')

  <script src="{{ \App\Support\Asset::v('assets/js/13-utils.js') }}"></script>
  <script src="{{ \App\Support\Asset::v('assets/js/admin/common.js') }}"></script>
  @stack('scripts')
</body>
</html>
