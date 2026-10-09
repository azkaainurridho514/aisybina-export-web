@extends('layouts.admin')

@section('title', 'Site Content')
@section('page_title', 'Site Content')

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
  <style>a.admin-tab-btn { text-decoration: none; display: inline-flex; align-items: center; }</style>
@endpush

@section('content')
  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>Site Content</h1>
        <p>Teks yang tampil di halaman publik. Setiap tab mewakili satu tabel pengaturan (satu baris data).</p>
      </div>
    </div>

    <div class="admin-tabs">
      @foreach ($tabs as $key => $item)
        <a class="admin-tab-btn {{ $key === $active ? 'active' : '' }}"
           data-tab="{{ $key }}"
           href="{{ route('admin.site-content.index', ['tab' => $key]) }}">{{ $item['label'] }}</a>
      @endforeach
    </div>

    <div class="admin-card" style="padding: 1.5rem;">
      <div class="settings-form" id="siteContentForm"></div>
    </div>
  </section>
@endsection

@push('vendors')
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dompurify@3.2.6/dist/purify.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('scripts')
  <script>
    window.SITE_CONTENT = {
      active: @json($active),
      tabs: @json($tabs),
      method: 'PUT',
      indexUrl: @json(route('admin.site-content.index')),
      listUrl: @json(route('admin.site-content.data')),
      updateUrl: @json(route('admin.site-content.update', '__TAB__'))
    };
  </script>
  <script src="{{ \App\Support\Asset::v('assets/js/admin/site-content.js') }}"></script>
@endpush