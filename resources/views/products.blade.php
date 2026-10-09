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
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/pages/products.js') }}" data-endpoint="{{ route('products.data') }}"></script>
@endpush