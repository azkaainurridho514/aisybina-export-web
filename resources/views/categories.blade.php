@extends('layouts.app')
@section('title', '{CATEGORY} from Indonesia for Export')
@section('description', 'Explore quality Indonesian {CATEGORY} for export, sourced from trusted suppliers across Indonesia. Discover {CATEGORY} products at Aisybina Export.')
@section('main')
  <section class="section-tight" style="margin-top: 82px;">
    <div class="container" data-aos="fade-up">
        <div class="pill-tag">
            <i class="bi bi-box-seam"></i>
            {{-- nama kategori --}}
        </div>
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

  <div id="productModalContainer"></div>\
  </section>
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/pages/products.js') }}" data-endpoint="{{ route('products.data') }}"></script>
@endpush