<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $master->website_name ?? '' }}</title>
  <meta name="description" content="Connects global buyers with quality products sourced from trusted suppliers across Indonesia.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="icon" type="image/png" href="{{ $master->logo ?? '' }}">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .hero-banner {
      position: relative;
      overflow: hidden;
      min-height: 74vh;
      display: flex;
      align-items: center;
      background-color: var(--forest);
      background-image: var(--hero-bg-image, none);
      background-size: cover;
      background-position: center;
    }
    .hero-banner-overlay {
      position: absolute;
      inset: 0;
      background:
        linear-gradient(100deg, rgba(22, 40, 31, 0.94) 0%, rgba(22, 40, 31, 0.78) 40%, rgba(22, 40, 31, 0.25) 70%, rgba(22, 40, 31, 0.05) 100%),
        linear-gradient(0deg, rgba(22, 40, 31, 0.55) 0%, rgba(22, 40, 31, 0) 35%);
      z-index: 0;
    }
    .hero-banner-glow {
      position: absolute;
      width: 420px;
      height: 420px;
      top: -140px;
      right: -120px;
      background: radial-gradient(circle, rgba(185, 139, 62, 0.4), transparent 70%);
      filter: blur(6px);
      z-index: 0;
      pointer-events: none;
    }
    .hero-banner .container { position: relative; z-index: 1; }
    .hero-banner .pill-tag.on-forest { margin-bottom: 1.25rem; }
    .btn-outline-light {
      border-radius: 999px;
      font-weight: 600;
      font-size: 0.95rem;
      padding: 0.85rem 1.7rem;
      display: inline-flex;
      align-items: center;
      gap: 0.55rem;
      background-color: transparent;
      border: 1px solid rgba(250, 246, 236, 0.45);
      color: var(--cream);
      transition: border-color 0.2s ease, background-color 0.2s ease, transform 0.2s ease;
    }
    .btn-outline-light:hover {
      border-color: var(--cream);
      background-color: rgba(250, 246, 236, 0.08);
      color: var(--cream);
      transform: translateY(-1px);
    }
    .hero-banner-fade {
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      height: 120px;
      background: linear-gradient(
        180deg,
        rgba(240, 233, 216, 0)     0%,
        rgba(240, 233, 216, 0.005) 8.3%,
        rgba(240, 233, 216, 0.035) 16.7%,
        rgba(240, 233, 216, 0.1)   25%,
        rgba(240, 233, 216, 0.21)  33.3%,
        rgba(240, 233, 216, 0.35)  41.7%,
        rgba(240, 233, 216, 0.5)   50%,
        rgba(240, 233, 216, 0.65)  58.3%,
        rgba(240, 233, 216, 0.79)  66.7%,
        rgba(240, 233, 216, 0.9)   75%,
        rgba(240, 233, 216, 0.97)  83.3%,
        rgba(240, 233, 216, 0.995) 91.7%,
        var(--cream-dim)           100%
      );
      z-index: 1;
      pointer-events: none;
    }
    @media (max-width: 767.98px) {
      .hero-banner-fade { height: 80px; }
    }
  </style>
</head>
<body>

  @include('layouts.navbar', ['master' => $master])

  <main>

    <!-- HERO -->
    <section class="hero-banner section-tight" style="margin-top: 82px; --hero-bg-image: url('{{ asset('images/website/bg_header.png') }}');">
      <div class="hero-banner-overlay"></div>
      <div class="hero-banner-glow"></div>
      <div class="hero-banner-fade"></div>

      <div class="container position-relative">
        <div class="row">
          <div class="col-lg-7" data-aos="fade-up">
            <span class="pill-tag on-forest"><i class="bi bi-compass"></i>Welcome</span>
            <h1 class="mb-4" style="font-size: clamp(2.4rem, 4.5vw, 3.7rem); color: var(--cream);">{!! quill_inline($master->heading ?? '') !!}</h1>
            <p class="lead mb-4 text-on-forest" style="max-width: 480px;">{!! quill_inline($master->website_description ?? '') !!}</p>
            <div>
              <a href="/products" class="btn btn-cream btn-arrow me-2 mb-2">See Our Categories</a>
              <a href="/contact" class="btn btn-outline-light mb-2">Start an Inquiry</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- WHO WE ARE -->
    <section class="section bg-cream-dim" id="who-we-are">
      <div class="container">
        <div class="row gy-4 mb-4">
          <div class="col-lg-6" data-aos="fade-up">
            <span class="pill-tag"><i class="bi bi-people"></i>About Us</span>
            <h2>{{ $master->about_heading ?? '' }}</h2>
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <p>{!! quill_inline($master->about_description ?? '') !!}</p>
          </div>
        </div>
        <div data-aos="fade-up">
          @foreach ($aboutItems as $item)
            <div class="value-row">
              <div class="value-icon"><i class="bi {{ $item->icon ?: 'bi-check2' }}"></i></div>
              <div>
                <h3>{{ $item->title ?? '' }}</h3>
                <p>{{ $item->description ?? '' }}</p>
              </div>
            </div>
          @endforeach
        </div>
    </section>

    <!-- PRODUCT CATEGORIES -->
    <section class="section" id="products">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-7" data-aos="fade-up">
            <span class="pill-tag"><i class="bi bi-box-seam"></i>Our Products</span>
            <h2 class="mb-3">{{ $master->category_heading ?? '' }}</h2>
            <p>{!! quill_inline($master->category_description ?? '') !!}</p>
          </div>
        </div>
        <div class="row gy-4" id="productList">
          @foreach ($products as $index => $product)
            @php
              $carouselId = 'productCarousel' . $index;
              $modalId = 'productModal' . $index;
              $images = $product->images ?? collect();
            @endphp
            <div class="col-6 col-lg-3" data-aos="fade-up">
              <div class="crop-card">
                <div class="crop-media">
                  <div id="{{ $carouselId }}" class="carousel slide crop-carousel" data-bs-ride="false">
                    <div class="carousel-inner">
                      @if ($images->count())
                        @foreach ($images as $i => $img)
                          <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                            <div class="frame-square">
                              <div class="frame-inner photo-trigger"
                                   data-bs-toggle="modal"
                                   data-bs-target="#{{ $modalId }}"
                                   data-slide-index="{{ $i }}"
                                   role="button" tabindex="0"
                                   aria-label="Preview photo {{ $i + 1 }} of {{ $product->name }}">
                                <img src="{{ $img->path }}" alt="{{ $product->name }}" loading="lazy">
                              </div>
                            </div>
                          </div>
                        @endforeach
                      @else
                        <div class="carousel-item active">
                          <div class="frame-square">
                            <div class="frame-inner frame-empty"><i class="bi bi-box-seam"></i><span>{{ $product->name }}</span></div>
                          </div>
                        </div>
                      @endif
                    </div>
                    @if ($images->count() > 1)
                      <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev" aria-label="Previous photo">
                        <span class="carousel-arrow"><i class="bi bi-chevron-left"></i></span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next" aria-label="Next photo">
                        <span class="carousel-arrow"><i class="bi bi-chevron-right"></i></span>
                      </button>
                      <div class="carousel-indicators crop-indicators">
                        @foreach ($images as $i => $img)
                          <button type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-label="Photo {{ $i + 1 }}"></button>
                        @endforeach
                      </div>
                    @endif
                  </div>
                </div>
                <div class="crop-body">
                  <h3>{{ $product->name }}</h3>
                  <p>{!! $product->description !!}</p>
                  <a href="/products" class="crop-link">View category <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <div id="productModalContainer">
      @foreach ($products as $index => $product)
        @php
          $modalId = 'productModal' . $index;
          $images = $product->images ?? collect();
        @endphp
        <div class="modal fade photo-modal" id="{{ $modalId }}" tabindex="-1" aria-hidden="true" aria-labelledby="{{ $modalId }}Label">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <button type="button" class="btn-close modal-close-custom" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body p-0">
                <div id="{{ $modalId }}Carousel" class="carousel slide" data-bs-ride="false">
                  <div class="carousel-inner">
                    @if ($images->count())
                      @foreach ($images as $i => $img)
                        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                          <div class="frame-wide">
                            <img src="{{ $img->path }}" alt="{{ $product->name }}" loading="lazy">
                          </div>
                        </div>
                      @endforeach
                    @else
                      <div class="carousel-item active">
                        <div class="frame-wide frame-empty"><i class="bi bi-box-seam"></i><span>{{ $product->name }}</span></div>
                      </div>
                    @endif
                  </div>
                  @if ($images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $modalId }}Carousel" data-bs-slide="prev" aria-label="Previous photo">
                      <span class="carousel-arrow"><i class="bi bi-chevron-left"></i></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#{{ $modalId }}Carousel" data-bs-slide="next" aria-label="Next photo">
                      <span class="carousel-arrow"><i class="bi bi-chevron-right"></i></span>
                    </button>
                  @endif
                </div>
                <p id="{{ $modalId }}Label" class="carousel-caption-label mb-0">{{ $product->name }}</p>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- CUSTOM SOURCING -->
    <section class="section bg-forest text-center bg-cream-dim">
      <div class="container container-narrow" data-aos="fade-up">
        <div class="export-tag mb-4">
          <span class="tag-eyebrow">{{ $askUs->ask_us_title ?? '' }}</span>
          <span class="tag-main">{!! $askUs->ask_us_heading ?? '' !!}</span>
        </div>
        <h2 class="mb-3" style="color: var(--cream);">{{ $askUs->ask_us_heading ?? '' }}</h2>
        <p class="text-on-forest mb-4">{{ $askUs->ask_us_description ?? '' }}</p>
        <a href="/contact" class="btn btn-cream btn-arrow">{{ $askUs->ask_us_button ?? '' }}</a>
      </div>
    </section>

    <!-- WHY CHOOSE US -->
    <section class="section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-7" data-aos="fade-up">
            <span class="pill-tag"><i class="bi bi-star"></i>Why Choose Us</span>
            <h2>{{ $master->choose_us_heading ?? '' }}</h2>
          </div>
        </div>
        <div class="row gy-4">
          @foreach ($chooseUs as $item)
            <div class="col-md-6 col-lg-3" data-aos="fade-up">
              <div class="reason">
                <div class="value-icon"><i class="bi {{ $item->icon ?: 'bi-check2' }}"></i></div>
                <h3>{{ $item->title ?? '' }}</h3>
                <p>{{ $item->description ?? '' }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- EXPORT PROCESS -->
    <section class="section bg-cream-dim">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-7" data-aos="fade-up">
            <span class="pill-tag"><i class="bi bi-signpost-split"></i>Our Process</span>
            <h2>{{ $master->our_process ?? '' }}</h2>
          </div>
        </div>
        <div class="row gy-4 timeline">
          <div class="timeline-line d-none d-lg-block"></div>
          @foreach ($ourProcess as $index => $step)
            <div class="col-6 col-lg" data-aos="fade-up">
              <div class="timeline-step">
                <span class="timeline-dot">{{ $index + 1 }}</span>
                <h3>{{ $step->title ?? '' }}</h3>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- GLOBAL REACH -->
    <section class="section">
      <div class="container">
        <div class="row align-items-center gy-5">
          <div class="col-lg-6" data-aos="fade-right">
            @if (!empty($globalReach->global_reach_image))
              <img src="{{ $globalReach->global_reach_image }}" alt="" class="w-100 h-100" style="object-fit:cover; border-radius: 10px;">
            @endif
          </div>
          <div class="col-lg-6" data-aos="fade-left">
            <span class="pill-tag"><i class="bi bi-signpost-2"></i>Global Reach</span>
            <h2 class="mb-3">{{ $globalReach->global_reach_title ?? '' }}</h2>
            <p class="mb-0">{!! quill_inline($globalReach->global_reach_description ?? '') !!}</p>
            <ul class="reach-list">
              @for ($i = 1; $i <= 3; $i++)
                @php
                  $label = $globalReach->{'global_reach_item_' . $i} ?? null;
                  $icon = $globalReach->{'global_reach_icon_item_' . $i} ?? 'bi-check2';
                @endphp
                @if ($label)
                  <li><i class="bi {{ $icon }}"></i>{{ $label }}</li>
                @endif
              @endfor
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- FINAL CTA -->
    <section class="section bg-forest text-center">
      <div class="container container-narrow" data-aos="fade-up">
        <h2 class="mb-3" style="color: var(--cream);">{{ $footer->footer_home_heading ?? '' }}</h2>
        <p class="text-on-forest mb-4">{!! quill_inline($footer->footer_home_subheading ?? '') !!}</p>
        <a href="/contact" class="btn btn-cream btn-arrow">{{ $footer->footer_home_button ?? '' }}</a>
      </div>
    </section>

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
  @stack('scripts')
</body>
</html>