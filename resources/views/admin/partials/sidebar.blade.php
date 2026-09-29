@php
  $menu = [
    [
      'label' => null, 'items' => [
        [
          'Dashboard', 
          'bi-grid-1x2', 
          'admin.dashboard', 
          'admin.dashboard'],
        ]
    ],
    [
      'label' => 'Site Content', 
      'items' => [
        [
          'Home & Pages', 
          'bi-file-earmark-text', 
          'admin.site-content.index', 
          'admin.site-content.*'
          ],
      ]
    ],
    [
      'label' => 'Catalog', 
      'items' => [
        [
          'Categories', 
          'bi-tag', 
          'admin.categories.index', 
          'admin.categories.*'
        ],
        [
          'Products', 
          'bi-box-seam', 
          'admin.products.index', 
          'admin.products.*'
        ],
      ]
    ],
    [ 
      'label' => 'Content Blocks', 
      'items' => [
        [
          'Our Mission', 
          'bi-bullseye', 
          'admin.our-mission.index', 
          'admin.our-mission.*'
        ],
        [
          'Our Value', 
          'bi-gem', 
          'admin.our-value.index', 
          'admin.our-value.*'
        ],
        [
          'Export Process', 
          'bi-signpost-split', 
          'admin.our-process.index', 
          'admin.our-process.*'
        ],
        [
          'Why Choose Us', 
          'bi-star', 
          'admin.choose-us.index', 
          'admin.choose-us.*'
        ],
        [
          'About Items', 
          'bi-people', 
          'admin.about-items.index', 
          'admin.about-items.*'
        ],
        [
          'Business Hours', 
          'bi-clock', 
          'admin.business-hours.index', 
          'admin.business-hours.*'
        ],
      ]
    ],
    [
      'label' => 'Leads', 
      'items' => [
        [
          'Inquiries', 
          'bi-envelope-open', 
          'admin.inquiries.index', 
          'admin.inquiries.*'
        ],
      ]
    ],
  ];
@endphp

<aside class="admin-sidebar" id="adminSidebar">
  <div class="admin-sidebar-brand">
    Aisy Bina<span class="brand-dot">.</span>
    <small>Admin Panel</small>
  </div>

  <nav class="admin-nav">
    @foreach ($menu as $group)
      @if ($group['label'])
        <div class="admin-nav-label">{{ $group['label'] }}</div>
      @endif

      @foreach ($group['items'] as [$label, $icon, $routeName, $pattern])
        <a class="admin-nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}"
           href="{{ \Illuminate\Support\Facades\Route::has($routeName) ? route($routeName) : url('/admin') }}">
          <i class="bi {{ $icon }}"></i> {{ $label }}
        </a>
      @endforeach
    @endforeach
  </nav>

  <div class="admin-sidebar-foot">Aisy Bina Exports &copy; {{ date('Y') }}</div>
</aside>

<div class="admin-sidebar-backdrop"></div>
