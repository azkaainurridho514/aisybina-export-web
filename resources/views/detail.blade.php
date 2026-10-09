@extends('layouts.app')
@section('title', '{PRODUCT} from Indonesia for Export')
@section('description', 'Discover quality {PRODUCT} from Indonesia for export, sourced from trusted suppliers. Learn about {PRODUCT} details and export availability at Aisybina Export.')
@section('main')
  <section class="section-tight" style="margin-top: 82px;">
    <div class="container" data-aos="fade-up">
        <div class="pill-tag">
            <i class="bi bi-box-seam"></i>
            {{-- Nama produk --}}
        </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/pages/products.js') }}" data-endpoint="{{ route('products.data') }}"></script>
@endpush