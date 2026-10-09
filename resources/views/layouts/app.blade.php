<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') | {{ ($master->website_name ?? '') }}</title>
  <meta name="description"
      content="@yield('description', 'Connects global buyers with quality products sourced from trusted suppliers across Indonesia.')">

  <meta property="og:title"
        content="@yield('title') | {{ $master->website_name ?? '' }}">
  <meta property="og:description"
        content="Connects global buyers with quality products sourced from trusted suppliers across Indonesia.">
  <meta property="og:url"
        content="@yield('canonical', url()->current())">
  <meta property="og:type"
        content="website">
  <meta property="og:site_name"
        content="{{ $master->website_name ?? '' }}">


  <meta name="robots" content="index, follow">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="icon" type="image/png" href="{{ $master->logo ?? '' }}">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  @stack('styles')
</head>
<body>

  @include('layouts.navbar', ['master' => $master])

  <main>
    @yield('main')
  </main>

  @include('layouts.footer', ['master' => $master, 'contact' => $contact])

  <a href="{{ !empty($contact->whatsapp) ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $contact->whatsapp) . '?text=' . urlencode('Hello ' . ($master->website_name ?? '') . ", I am interested in sourcing products from Indonesia. I would like to discuss my requirements.") : '#' }}"
     id="whatsappFloat"
     class="whatsapp-float @if (empty($contact->whatsapp)) d-none @endif"
     target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <i class="bi bi-whatsapp"></i>
  </a>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  @stack('vendors')
  @stack('scripts')
</body>
</html>