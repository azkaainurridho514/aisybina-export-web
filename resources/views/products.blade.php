@extends('layouts.app')
@section('title', 'Products')
@section('description', 'Discover quality Indonesian products available for global buyers through Aisybina Export.')
@section('main')
  <section class="section-tight" style="margin-top: 82px;">
    <div class="container" data-aos="fade-up">
        <div class="pill-tag">
            <i class="bi bi-box-seam"></i>
            Our Products
        </div>
        <h1 class="mb-3">
            {{ $contact->product_heading ?? '' }}
        </h1>
        <p class="lead mb-0" style="max-width: 660px;">
            {!! quill_inline($contact->product_subheading ?? '') !!}
        </p>
    </div>
  </section>

  @php
      $groupedProducts = $products->groupBy('category_id');
      $globalIndex = 0;
      $sectionCount = 0;
  @endphp

  <div id="categoryContainer">
    @if ($products->isEmpty())
        <section class="section">
            <div class="container text-center" data-aos="fade-up">
                <div class="empty-category">
                    <i class="bi bi-box-seam"></i>
                    <p>There are no products available at this time.</p>
                </div>
            </div>
        </section>
    @else
        @foreach ($categories as $category)
            @php
                $categoryProducts = $groupedProducts->get($category->id, collect());
            @endphp

            @continue($categoryProducts->isEmpty())

            <section class="section{{ $sectionCount % 2 === 0 ? ' bg-cream-dim' : '' }}">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col-lg-7" data-aos="fade-up">
                            <span class="pill-tag"><i class="bi bi-box-seam"></i>{{ $category->name }}</span>
                            <h2 class="mb-2">{{ $category->name }}</h2>
                            <p class="mb-0">{!! $category->description ?? '' !!}</p>
                        </div>
                    </div>

                    <div class="row gy-4">
                        @foreach ($categoryProducts as $product)
                            @php
                                $carouselId = 'catProdCarousel' . $globalIndex;
                                $modalId    = 'catProdModal' . $globalIndex;
                                $images     = $product->images;
                            @endphp

                            <div class="col-6 col-lg-4" data-aos="fade-up">
                                <div class="crop-card">
                                    <div class="crop-media">
                                        <div id="{{ $carouselId }}" class="carousel slide crop-carousel" data-bs-ride="false">
                                            <div class="carousel-inner">
                                                @forelse ($images as $i => $img)
                                                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                                        <div class="frame-square">
                                                            <div class="frame-inner photo-trigger"
                                                                 data-bs-toggle="modal"
                                                                 data-bs-target="#{{ $modalId }}"
                                                                 data-slide-index="{{ $i }}"
                                                                 role="button" tabindex="0"
                                                                 aria-label="Preview photo {{ $i + 1 }} of {{ $product->name }}">
                                                                <img src="{{ asset($img->path) }}" alt="{{ $product->name }}" loading="lazy">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="carousel-item active">
                                                        <div class="frame-square">
                                                            <div class="frame-inner frame-empty">
                                                                <i class="bi bi-box-seam"></i><span>{{ $product->name }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>

                                            @if ($images->count() > 1)
                                                <button class="carousel-control-prev" type="button"
                                                        data-bs-target="#{{ $carouselId }}" data-bs-slide="prev" aria-label="Previous photo">
                                                    <span class="carousel-arrow"><i class="bi bi-chevron-left"></i></span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                        data-bs-target="#{{ $carouselId }}" data-bs-slide="next" aria-label="Next photo">
                                                    <span class="carousel-arrow"><i class="bi bi-chevron-right"></i></span>
                                                </button>
                                                <div class="carousel-indicators crop-indicators">
                                                    @foreach ($images as $i => $img)
                                                        <button type="button"
                                                                data-bs-target="#{{ $carouselId }}"
                                                                data-bs-slide-to="{{ $i }}"
                                                                class="{{ $i === 0 ? 'active' : '' }}"
                                                                aria-label="Photo {{ $i + 1 }}"></button>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="crop-body">
                                        <h3>{{ $product->name }}</h3>
                                        <p>{!! $product->description ?? '' !!}</p>
                                        <a href="/category/{{ $category->slug }}" class="crop-link">
                                            View category <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @push('product-modals')
                                <div class="modal fade photo-modal" id="{{ $modalId }}" tabindex="-1"
                                     aria-hidden="true" aria-labelledby="{{ $modalId }}Label">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <button type="button" class="btn-close modal-close-custom"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            <div class="modal-body p-0">
                                                <div id="{{ $modalId }}Carousel" class="carousel slide" data-bs-ride="false">
                                                    <div class="carousel-inner">
                                                        @forelse ($images as $i => $img)
                                                            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                                                <div class="frame-wide">
                                                                    <img src="{{ asset($img->path) }}" alt="{{ $product->name }}" loading="lazy">
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="carousel-item active">
                                                                <div class="frame-wide frame-empty">
                                                                    <i class="bi bi-box-seam"></i><span>{{ $product->name }}</span>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                    </div>

                                                    @if ($images->count() > 1)
                                                        <button class="carousel-control-prev" type="button"
                                                                data-bs-target="#{{ $modalId }}Carousel" data-bs-slide="prev" aria-label="Previous photo">
                                                            <span class="carousel-arrow"><i class="bi bi-chevron-left"></i></span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button"
                                                                data-bs-target="#{{ $modalId }}Carousel" data-bs-slide="next" aria-label="Next photo">
                                                            <span class="carousel-arrow"><i class="bi bi-chevron-right"></i></span>
                                                        </button>
                                                    @endif
                                                </div>
                                                <p id="{{ $modalId }}Label" class="carousel-caption-label mb-0">{{ $product->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endpush

                            @php $globalIndex++; @endphp
                        @endforeach
                    </div>
                </div>
            </section>

            @php $sectionCount++; @endphp
        @endforeach
    @endif
  </div>

  <div id="productModalContainer">
    @stack('product-modals')
  </div>

  <section class="section bg-cream-dim">
    <div class="container text-center container-narrow" data-aos="fade-up">
      <h2 class="mb-3">{{ $footer->footer_product_heading ?? '' }}</h2>
      <p class="mb-4">{!! quill_inline($footer->footer_product_subheading ?? '') !!}</p>
      <a href="/contact" class="btn btn-forest btn-arrow">{{ $footer->footer_product_button ?? 'Request a Product' }}</a>
    </div>
  </section>
@endsection
{{-- @section('main')
  <section class="section-tight" style="margin-top: 82px;">
    <div class="container" data-aos="fade-up">
        <div class="pill-tag">
            <i class="bi bi-box-seam"></i>
            Our Products
        </div>
        <h1 class="mb-3">
            {{ $contact->product_heading ?? '' }}
        </h1>
        <p class="lead mb-0" style="max-width: 660px;">
            {!! quill_inline($contact->product_subheading ?? '') !!}
        </p>
    </div>
  </section>
  <div id="categoryContainer">
    <section class="section">
      <div class="container text-center text-muted">
        <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div>
        Loading products…
      </div>
    </section>
  </div>

  <div id="productModalContainer"></div>
  <section class="section bg-cream-dim">
    <div class="container text-center container-narrow" data-aos="fade-up">
      <h2 class="mb-3">{{ $footer->footer_product_heading ?? '' }}</h2>
      <p class="mb-4">{!! quill_inline($footer->footer_product_subheading ?? '') !!}</p>
      <a href="/contact" class="btn btn-forest btn-arrow">{{ $footer->footer_product_button ?? 'Request a Product' }}</a>
    </div>
  </section>
@endsection --}}

@push('scripts')
  {{-- <script src="{{ asset('assets/js/pages/products.js') }}" data-endpoint="{{ route('products.data') }}"></script> --}}
@endpush