<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $master->website_name ? 'Products | ' . $master->website_name : 'Products' }}</title>
  <meta name="description" content="Browse the product categories Aisy Bina Exports sources from trusted suppliers across Indonesia.">
  <link rel="icon" type="image/png" href="{{ $master->logo ?? '' }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

  @include('layouts.navbar', ['master' => $master])

  <main>

    {{-- Hero: SSR, langsung dari controller --}}
    <section class="section-tight" style="margin-top: 82px;">
      <div class="container" data-aos="fade-up">
        <span class="pill-tag"><i class="bi bi-box-seam"></i>Our Products</span>
        <h1 class="mb-3">{{ $pageDesc->product_heading ?? '' }}</h1>
        <p class="lead mb-0" style="max-width: 660px;">{!! quill_inline($pageDesc->product_subheading ?? '') !!}</p>
      </div>
    </section>

    {{--
      Katalog kategori + produk TETAP AJAX (keputusan yang sudah diambil
      sebelumnya), diisi oleh assets/js/pages/products.js lewat
      GET /products/data. Loading state sederhana ditampilkan dulu
      supaya tidak kosong total sebelum JS jalan.
    --}}
    <div id="categoryContainer">
      <section class="section">
        <div class="container text-center text-muted">
          <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div>
          Loading products…
        </div>
      </section>
    </div>

    <div id="productModalContainer"></div>

    {{-- CTA: SSR --}}
    <section class="section bg-cream-dim">
      <div class="container text-center container-narrow" data-aos="fade-up">
        <h2 class="mb-3">{{ $footer->footer_product_heading ?? '' }}</h2>
        <p class="mb-4">{!! quill_inline($footer->footer_product_subheading ?? '') !!}</p>
        <a href="/contact" class="btn btn-forest btn-arrow">{{ $footer->footer_product_button ?? 'Request a Product' }}</a>
      </div>
    </section>

  </main>

  @include('layouts.footer', ['master' => $master, 'contact' => $pageDesc])

  <a href="{{ !empty($pageDesc->whatsapp) ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $pageDesc->whatsapp) . '?text=' . urlencode('Hello ' . ($master->website_name ?? '') . ", I am interested in sourcing products from Indonesia. I would like to discuss my requirements.") : '#' }}"
     id="whatsappFloat"
     class="whatsapp-float @if (empty($pageDesc->whatsapp)) d-none @endif"
     target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <i class="bi bi-whatsapp"></i>
  </a>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>

  {{--
    JS katalog produk HANYA di-load di halaman ini, pakai @push/@stack
    seperti yang diminta. File assets/js/pages/products.js tidak pernah
    ikut ter-load di Home/About/Contact karena tidak ada @push('scripts')
    di file-file itu. Kalau nanti semua halaman pindah ke satu layout
    bersama (@extends), stack ini tinggal dipindah ke layout tanpa
    mengubah baris @push di bawah.
  --}}
  @push('scripts')
    <script src="{{ asset('assets/js/pages/products.js') }}" data-endpoint="{{ route('products.data') }}"></script>
  @endpush
  @stack('scripts')
</body>
</html>