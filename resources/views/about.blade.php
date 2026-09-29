<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $master->website_name ? 'About | ' . $master->website_name : 'About' }}</title>
  <meta name="description" content="Learn about Aisy Bina Exports — our story, vision, mission, and the values that guide how we source products from Indonesia.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ $master->logo ?? '' }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <style>
    #missionList li { align-items: flex-start; }
    #missionList li i { margin-top: 0.2rem; }
    .value-card { height: 100%; }
  </style>
</head>
<body>

  @include('layouts.navbar', ['master' => $master])

  <main>

    <!-- ===================== HERO ===================== -->
    <section class="section-tight" style="margin-top: 82px;">
      <div class="container" data-aos="fade-up">
        <span class="pill-tag"><i class="bi bi-building"></i>About Us</span>
        <h1 class="mb-3">{{ $master->about_heading ?? '' }}</h1>
        <p class="lead mb-0" style="max-width: 660px;">{!! quill_inline($master->about_description ?? '') !!}</p>
      </div>
    </section>

    <!-- ===================== ABOUT COMPANY ===================== -->
    <section class="section pt-0">
      <div class="container">
        <div class="row gy-5 align-items-center">
          <div class="col-lg-5" data-aos="fade-right">
            <div class="frame-tall">
              @if (!empty($about->image_intro))
                <img src="{{ $about->image_intro }}" alt="About {{ $master->website_name ?? 'us' }}" style="width:100%;height:100%;object-fit:cover;display:block;border-radius:var(--radius) var(--radius) var(--radius) 4px;">
              @else
                <div class="frame-inner"><i class="bi bi-image"></i><span>Company photo</span></div>
              @endif
            </div>
          </div>
          <div class="col-lg-7" data-aos="fade-left">
            <h2 class="mb-3">{{ $about->intro_title ?? 'Unlimited Creativity, Endless Innovation' }}</h2>
            <div>
              @if (!empty($about->intro_description))
                @foreach (preg_split('/\n\s*\n/', $about->intro_description) as $paragraph)
                  <p>{!! $paragraph !!}</p>
                @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== OUR VISION ===================== -->
    <section class="section bg-forest" data-aos="fade-up">
      <div class="container">
        <div class="row align-items-center gy-5">
          <div class="col-lg-6">
            <span class="pill-tag on-forest"><i class="bi bi-binoculars"></i>Our Vision</span>
            <h2 class="mb-3" style="color: var(--cream);">Our Vision</h2>
            <p class="text-on-forest mb-0">{!! quill_inline($about->vision_description ?? '') !!}</p>
          </div>
          <div class="col-lg-6">
            <div class="frame-wide">
              @if (!empty($about->image_vision))
                <img src="{{ $about->image_vision }}" alt="Our vision" style="width:100%;height:100%;object-fit:cover;display:block;border-radius:var(--radius) var(--radius) var(--radius) 4px;">
              @else
                <div class="frame-inner"><i class="bi bi-image"></i><span>Vision photo</span></div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== OUR MISSION ===================== -->
    <section class="section">
      <div class="container">
        <div class="row gy-5 align-items-start">
          <div class="col-lg-5" data-aos="fade-right">
            <div class="frame-square">
              @if (!empty($about->image_mission))
                <img src="{{ $about->image_mission }}" alt="Our products" style="width:100%;height:100%;object-fit:cover;display:block;border-radius:var(--radius) var(--radius) var(--radius) 4px;">
              @else
                <div class="frame-inner"><i class="bi bi-image"></i><span>Product photo</span></div>
              @endif
            </div>
          </div>
          <div class="col-lg-7" data-aos="fade-left">
            <span class="pill-tag"><i class="bi bi-flag"></i>Our Mission</span>
            <h2 class="mb-4">Our Mission</h2>
            <ul class="reach-list" id="missionList">
              @foreach ($aboutMissions as $idx => $mission)
                <li data-aos="fade-up" data-aos-delay="{{ $idx * 75 }}">
                  <i class="bi bi-check2-circle"></i>
                  <span>{!! quill_inline($mission->description) !!}</span>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== OUR VALUE ===================== -->
    <section class="section bg-cream-dim">
      <div class="container">
        <div class="row align-items-center gy-4 mb-5" data-aos="fade-up">
          <div class="col-lg-7">
            <span class="pill-tag"><i class="bi bi-gem"></i>Our Value</span>
            <h2 class="mb-3">Our Value</h2>
            <p class="mb-0" style="max-width: 520px;">{!! quill_inline($about->value_description ?? '') !!}</p>
          </div>
          <div class="col-lg-5">
            <div class="frame-wide">
              @if (!empty($about->image_value))
                <img src="{{ $about->image_value }}" alt="Inside our workshop" style="width:100%;height:100%;object-fit:cover;display:block;border-radius:var(--radius) var(--radius) var(--radius) 4px;">
              @else
                <div class="frame-inner"><i class="bi bi-image"></i><span>Workshop photo</span></div>
              @endif
            </div>
          </div>
        </div>
        <div class="row g-4" id="valueGrid">
          @foreach ($aboutValues as $idx => $value)
            <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $idx * 75 }}">
              <div class="value-card">
                <div class="timeline-dot mb-3">{{ $idx + 1 }}</div>
                <h3>{{ $value->title }}</h3>
                <p>{!! quill_inline($value->description) !!}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

  </main>

  @include('layouts.footer', ['master' => $master, 'contact' => $pageDesc])

  <a href="{{ !empty($pageDesc->whatsapp) ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $pageDesc->whatsapp) . '?text=' . urlencode("Hello " . ($master->website_name ?? '') . ", I'd like to know more about your company.") : '#' }}"
     id="whatsappFloat"
     class="whatsapp-float @if (empty($pageDesc->whatsapp)) d-none @endif"
     target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <i class="bi bi-whatsapp"></i>
  </a>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  @stack('scripts')
  <!-- Tidak ada AJAX di halaman ini lagi — semua sudah SSR di atas. -->
</body>
</html>