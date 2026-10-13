@extends('layouts.app')
@section('title', $product->name . ' from Indonesia for Export')
@section('description', \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 150) ?: 'Request a quotation for ' . $product->name . ' from Aisybina Export.')
@push('styles')
    <style>
        /* ==========================================================================
   ADDITION — Product detail page
   Tempel di paling bawah file CSS yang sudah ada. Tidak mengubah aturan lama.
   ========================================================================== */

/* Breadcrumb ------------------------------------------------------------- */
.pd-top { padding-bottom: 0; }

.pd-breadcrumb {
  list-style: none;
  display: flex;
  flex-wrap: wrap;
  gap: 0.35rem 0.6rem;
  padding: 0;
  margin: 0;
  font-size: 0.88rem;
  color: var(--forest-soft);
}

.pd-breadcrumb li + li::before {
  content: "/";
  margin-right: 0.6rem;
  color: var(--line-strong);
}

.pd-breadcrumb a { text-decoration: none; color: var(--forest-soft); }
.pd-breadcrumb a:hover { color: var(--forest); text-decoration: underline; }
.pd-breadcrumb li[aria-current="page"] { color: var(--forest); font-weight: 600; }

/* Overview layout -------------------------------------------------------- */
.pd-overview { padding-top: 1.5rem; padding-bottom: var(--gap); }

@media (min-width: 992px) {
  .pd-gallery { position: sticky; top: 110px; }
}

/* Gallery ---------------------------------------------------------------- */
.pd-main {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  aspect-ratio: 1 / 1;
  padding: 0;
  background-color: #f4f4f4;
  border: 1px solid var(--line);
  border-radius: var(--radius) var(--radius) var(--radius) 4px;
  overflow: hidden;
  cursor: zoom-in;
}

.pd-main img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  display: block;
}

.pd-main:hover { border-color: var(--forest); }

.pd-zoom-hint {
  position: absolute;
  right: 0.8rem;
  bottom: 0.8rem;
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  font-size: 0.78rem;
  font-weight: 600;
  color: var(--forest);
  background-color: var(--cream);
  border: 1px solid var(--line);
  border-radius: 999px;
  padding: 0.3rem 0.7rem;
}

.pd-main-empty {
  flex-direction: column;
  gap: 0.5rem;
  cursor: default;
  color: var(--forest-soft);
  background-color: var(--cream-dim);
}
.pd-main-empty i { font-size: 2.2rem; color: var(--gold); }
.pd-main-empty:hover { border-color: var(--line); }

/* Thumbnail strip: selalu 5 thumbnail terlihat, sisanya digeser dengan panah */
.pd-thumbs-wrap {
  --thumb-gap: 0.6rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-top: 0.75rem;
}

.pd-thumbs {
  display: flex;
  gap: var(--thumb-gap);
  flex: 1 1 auto;
  min-width: 0;
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  scrollbar-width: none;
  padding: 2px;
}
.pd-thumbs::-webkit-scrollbar { display: none; }

.pd-thumbs-nav {
  flex: 0 0 auto;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  font-size: 0.85rem;
  color: var(--forest);
  background-color: var(--cream);
  border: 1px solid var(--line-strong);
  border-radius: 50%;
  transition: background-color 0.2s ease, border-color 0.2s ease, opacity 0.2s ease;
}
.pd-thumbs-nav:hover:not(:disabled) { border-color: var(--forest); background-color: var(--cream-dim); }
.pd-thumbs-nav:disabled { opacity: 0.35; cursor: default; }

.pd-thumb {
  flex: 0 0 calc((100% - (4 * var(--thumb-gap))) / 5);
  aspect-ratio: 1 / 1;
  scroll-snap-align: start;
  padding: 0;
  background-color: #f4f4f4;
  border: 2px solid transparent;
  outline: 1px solid var(--line);
  outline-offset: -1px;
  border-radius: 12px;
  overflow: hidden;
  opacity: 0.7;
  transition: opacity 0.2s ease, border-color 0.2s ease;
}

.pd-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.pd-thumb:hover { opacity: 1; }
.pd-thumb.is-active { opacity: 1; border-color: var(--forest); }

/* Info column ------------------------------------------------------------ */
.pd-info h1 { font-size: clamp(1.8rem, 3.2vw, 2.6rem); }

.pd-desc { font-size: 1.02rem; max-width: 60ch; margin-bottom: 1.75rem; }


.pd-actions { display: flex; flex-wrap: wrap; gap: 0.75rem; }

@media (max-width: 575.98px) {
  .pd-actions .btn { width: 100%; justify-content: center; }
}

.pd-note {
  display: flex;
  align-items: flex-start;
  gap: 0.6rem;
  margin: 1.25rem 0 0;
  font-size: 0.88rem;
}
.pd-note i { color: var(--gold); margin-top: 0.15rem; }

/* Options ---------------------------------------------------------------- */
.option-card {
  height: 100%;
  background-color: var(--cream);
  border: 1px solid var(--line);
  border-radius: var(--radius) var(--radius) var(--radius) 4px;
  padding: 1.5rem;
}

.option-card h3 { font-size: 1.08rem; margin-bottom: 0.35rem; }
.option-desc { font-size: 0.9rem; margin-bottom: 1rem; }

.option-list { list-style: none; padding: 0; margin: 0; }
.option-list li {
  display: flex;
  align-items: flex-start;
  gap: 0.6rem;
  padding: 0.6rem 0;
  border-top: 1px solid var(--line);
  font-size: 0.94rem;
  color: var(--forest);
}
.option-list li i { color: var(--gold); font-size: 1.05rem; line-height: 1.5; }

.pd-specs {
  /* next version */
  /* display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr)); */
  border-bottom: 1px solid var(--line);
  margin-bottom: 1.75rem;
}

.pd-spec {
  padding: 0.8rem 0;
  border-top: 1px solid var(--line);
}
/* next version */
/* .pd-spec:nth-child(odd)  { padding-right: 1rem; }
.pd-spec:nth-child(even) { padding-left: 1rem; } */

.pd-spec .label {
  display: block;
  font-size: 0.8rem;
  color: var(--forest-soft);
  margin-bottom: 0.15rem;
}

.pd-spec .value {
  display: block;
  font-weight: 600;
  font-size: 0.98rem;
  line-height: 1.35;
}
    </style>
@endpush
@section('main')

  @php
      $images   = $product->images;
      $category = $product->category;
  @endphp

  <section class="section-tight pd-top" style="margin-top: 82px;">
    <div class="container">
      <nav aria-label="Breadcrumb">
        <ol class="pd-breadcrumb">
          <li><a href="/">Home</a></li>
          <li><a href="/products">Products</a></li>
          @if ($category)
            <li><a href="/category/{{ $category->slug }}">{{ $category->name }}</a></li>
          @endif
          <li aria-current="page">{{ $product->name }}</li>
        </ol>
      </nav>
    </div>
  </section>

  <section class="pd-overview">
    <div class="container">
      <div class="row g-4 g-lg-5">
        <div class="col-lg-6" data-aos="fade-up">
          <div class="pd-gallery">
            @if ($images->count() > 0)
              <button type="button" class="pd-main" id="pdMain"
                      data-bs-toggle="modal" data-bs-target="#pdZoomModal"
                      aria-label="Enlarge photo of {{ $product->name }}">
                <img id="pdMainImg" src="{{ asset($images->first()->path) }}" alt="{{ $product->name }}">
                <span class="pd-zoom-hint"><i class="bi bi-arrows-fullscreen"></i> Enlarge</span>
              </button>

              @if ($images->count() > 1)
                <div class="pd-thumbs-wrap {{ $images->count() > 5 ? 'has-nav' : '' }}">
                  @if ($images->count() > 5)
                    <button type="button" class="pd-thumbs-nav" id="pdThumbsPrev" aria-label="Previous photos">
                      <i class="bi bi-chevron-left"></i>
                    </button>
                  @endif

                  <div class="pd-thumbs" id="pdThumbs" role="tablist" aria-label="Product photos">
                    @foreach ($images as $i => $img)
                      <button type="button"
                              class="pd-thumb {{ $i === 0 ? 'is-active' : '' }}"
                              data-src="{{ asset($img->path) }}"
                              aria-label="Show photo {{ $i + 1 }} of {{ $images->count() }}"
                              aria-selected="{{ $i === 0 ? 'true' : 'false' }}">
                        <img src="{{ asset($img->path) }}" alt="" loading="lazy">
                      </button>
                    @endforeach
                  </div>

                  @if ($images->count() > 5)
                    <button type="button" class="pd-thumbs-nav" id="pdThumbsNext" aria-label="Next photos">
                      <i class="bi bi-chevron-right"></i>
                    </button>
                  @endif
                </div>
              @endif
            @else
              <div class="pd-main pd-main-empty">
                <i class="bi bi-box-seam"></i>
                <span>{{ $product->name }}</span>
              </div>
            @endif
          </div>
        </div>

        {{-- Info --}}
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="80">
          <div class="pd-info">
            @if ($category)
              <a href="/category/{{ $category->slug }}" class="pill-tag text-decoration-none">
                <i class="bi bi-box-seam"></i>{{ $category->name }}
              </a>
            @endif

            <h1 class="mb-3">{{ $product->name }}</h1>

            @if (!empty($product->description))
              <p class="pd-desc">{!! ($product->description) !!}</p>
            @endif

            <div class="pd-specs">
                @if ($category)
                  <div class="pd-spec">
                    <span class="label">Category</span>
                    <span class="value">{{ $category->name }}</span>
                  </div>
                @endif
                <div class="pd-spec">
                  <span class="label">Origin</span>
                  <span class="value">Indonesia</span>
                </div>
                <div class="pd-spec">
                  <span class="label">Order type</span>
                  <span class="value">Export and bulk orders</span>
                </div>
                {{-- next version --}}
                {{-- <div class="pd-spec">
                  <span class="label">HS code</span>
                  <span class="value">0901.21</span> 
                </div>
                <div class="pd-spec">
                  <span class="label">Minimum order</span>
                  <span class="value">1 x 20ft container</span> 
                </div>
                <div class="pd-spec">
                  <span class="label">Lead time</span>
                  <span class="value">14-21 days</span> 
                </div>
                <div class="pd-spec">
                  <span class="label">Shelf life</span>
                  <span class="value">12 months</span> 
                </div>
                <div class="pd-spec">
                  <span class="label">Port of loading</span>
                  <span class="value">Tanjung Perak, Surabaya</span> 
                </div>
                <div class="pd-spec">
                  <span class="label">Payment terms</span>
                  <span class="value">T/T, L/C at sight</span> 
                </div>
                  <div class="pd-spec">
                  <span class="label">Incoterms</span>
                  <span class="value">FOB, CIF</span> 
                </div> --}}
              </div>

            <div class="pd-actions">
              <a href="/contact?product={{ $product->name }}" class="btn btn-forest btn-arrow">Request a quote</a>
              @if ($category)
                <a href="/category/{{ $category->slug }}" class="btn btn-outline">Back to {{ $category->name }}</a>
              @endif
            </div>

            <p class="pd-note">
              <i class="bi bi-chat-dots"></i>
              Tell us your quantity and destination port, and we will reply with a quotation.
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>

  @if (!empty($options) && count($options) > 0)
    <section class="section bg-cream-dim pd-options">
      <div class="container">
        <div class="row mb-4">
          <div class="col-lg-7" data-aos="fade-up">
            <span class="pill-tag"><i class="bi bi-sliders"></i>Specifications</span>
            <h2 class="mb-2">Available options</h2>
            <p class="mb-0">What you can choose when ordering {{ $product->name }}.</p>
          </div>
        </div>

        <div class="row gy-4">
          @foreach ($options as $option)
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
              <div class="option-card">
                <h3>{{ $option->title }}</h3>
                @if (!empty($option->description))
                  <p class="option-desc">{!! $option->description !!}</p>
                @endif

                @if (count($option->items) > 0)
                  <ul class="option-list">
                    @foreach ($option->items as $item)
                      <li><i class="bi bi-check2"></i><span>{!! $item->description !!}</span></li>
                    @endforeach
                  </ul>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  @if (isset($related) && $related->isNotEmpty())
    <section class="section">
      <div class="container">
        <div class="row mb-4">
          <div class="col-lg-7" data-aos="fade-up">
            <h2 class="mb-2">More from {{ $category->name ?? 'this category' }}</h2>
          </div>
        </div>

        <div class="row gy-4">
          @foreach ($related as $item)
            <div class="col-6 col-lg-4" data-aos="fade-up">
              <div class="crop-card">
                <a href="/product/{{ $item->slug }}" class="crop-media text-decoration-none" tabindex="-1" aria-hidden="true">
                  <div class="frame-square">
                    <div class="frame-inner {{ $item->images->isEmpty() ? 'frame-empty' : '' }}">
                      @if ($item->images->isNotEmpty())
                        <img src="{{ asset($item->images->first()->path) }}" alt="{{ $item->name }}" loading="lazy">
                      @else
                        <i class="bi bi-box-seam"></i><span>{{ $item->name }}</span>
                      @endif
                    </div>
                  </div>
                </a>
                <div class="crop-body">
                  <h3>{{ $item->name }}</h3>
                  <p>{!! \Illuminate\Support\Str::limit($item->description ?? '', 90) !!}</p>
                  <a href="/product/{{ $item->slug }}" class="crop-link">
                    View detail <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <section class="section bg-cream-dim">
    <div class="container text-center container-narrow" data-aos="fade-up">
      <h2 class="mb-3">{{ $footer->footer_product_heading ?? '' }}</h2>
      <p class="mb-4">{!! quill_inline($footer->footer_product_subheading ?? '') !!}</p>
      <a href="/contact?product={{ $product->name }}" class="btn btn-forest btn-arrow">{{ $footer->footer_product_button ?? 'Request a Product' }}</a>
    </div>
  </section>

  @if ($images->count() > 0)
    <div class="modal fade photo-modal" id="pdZoomModal" tabindex="-1" aria-hidden="true" aria-label="{{ $product->name }} photo">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <button type="button" class="btn-close modal-close-custom" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body p-0">
            <div class="frame-wide">
              <img id="pdZoomImg" src="{{ asset($images->first()->path) }}" alt="{{ $product->name }}">
            </div>
            <p class="carousel-caption-label mb-0">{{ $product->name }}</p>
          </div>
        </div>
      </div>
    </div>
  @endif

  <script>
    (function () {
      var mainImg = document.getElementById('pdMainImg');
      var zoomImg = document.getElementById('pdZoomImg');
      var thumbs  = document.querySelectorAll('.pd-thumb');
      if (!mainImg || !thumbs.length) return;

      thumbs.forEach(function (thumb) {
        thumb.addEventListener('click', function () {
          var src = thumb.getAttribute('data-src');
          mainImg.src = src;
          if (zoomImg) zoomImg.src = src;
          thumbs.forEach(function (t) {
            t.classList.remove('is-active');
            t.setAttribute('aria-selected', 'false');
          });
          thumb.classList.add('is-active');
          thumb.setAttribute('aria-selected', 'true');
        });
      });

      // Panah kiri/kanan untuk list thumbnail (hanya ada kalau foto > 5)
      var strip = document.getElementById('pdThumbs');
      var prev  = document.getElementById('pdThumbsPrev');
      var next  = document.getElementById('pdThumbsNext');

      if (strip && prev && next) {
        function updateNav() {
          var max = strip.scrollWidth - strip.clientWidth;
          prev.disabled = strip.scrollLeft <= 2;
          next.disabled = strip.scrollLeft >= max - 2;
        }

        function page(dir) {
          strip.scrollBy({ left: dir * strip.clientWidth, behavior: 'smooth' });
        }

        prev.addEventListener('click', function () { page(-1); });
        next.addEventListener('click', function () { page(1); });
        strip.addEventListener('scroll', updateNav, { passive: true });
        window.addEventListener('resize', updateNav);
        updateNav();
      }
    })();
  </script>
@endsection