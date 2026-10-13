@extends('layouts.app')
@section('title', $category->name . ' from Indonesia for Export')
@section('description', 'Explore quality Indonesian '. $category->name .' for export, sourced from trusted suppliers across Indonesia. Discover '. $category->name .' products at Aisybina Export.')
@section('main')
  <section class="section-tight" style="margin-top: 82px;">
    <div class="container" data-aos="fade-up">
        <div class="pill-tag">
            <i class="bi bi-box-seam"></i>
            {{ $category->name }}
        </div>
    </div>
  </section>
  
  @php
      $globalIndex = 0;
      $sectionCount = 0;
  @endphp
  <div id="productContainer">
   @if ($products->isEmpty())
        <section class="section my-5">
            <div class="container text-center" data-aos="fade-up">
                <div class="empty-product">
                    <i class="bi bi-box-seam"></i>
                    <p>There are no products available at this time.</p>
                </div>
            </div>
        </section>
    @else
        <div class="container mb-5">
          <div class="row gy-4">
                @foreach ($products as $product)
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
                                <a href="/product/{{ $product->slug }}" class="crop-link">
                                    View detail <i class="bi bi-arrow-right"></i>
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
      </section>
      @php $sectionCount++; @endphp
    @endif
  </div>

  <div id="productModalContainer">
    @stack('product-modals')
  </div>
@endsection