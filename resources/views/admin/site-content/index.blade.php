@extends('layouts.admin')

@section('title', 'Site Content')
@section('page_title', 'Site Content')

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
  <style>a.admin-tab-btn { text-decoration: none; display: inline-flex; align-items: center; }</style>
@endpush

@section('content')
  @php
    $tab = $tabs[$active];
    $imageUrl = function ($path) {
      if (! $path) return null;
      return preg_match('~^(https?:)?//~', $path) ? $path : asset(ltrim($path, '/'));
    };
  @endphp

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
           href="{{ route('admin.site-content.index', ['tab' => $key]) }}">{{ $item['label'] }}</a>
      @endforeach
    </div>

    <div class="admin-card" style="padding: 1.5rem;">
      <div class="settings-form" id="siteContentForm" data-endpoint="{{ route('admin.site-content.update', $active) }}">

        @foreach ($tab['fields'] as [$key, $label, $type])
          @php $value = data_get($data, $key, ''); @endphp

          <div class="field-group">
            <label class="field-label" @if ($type === 'text') for="sc_{{ $key }}" @endif>{{ $label }}</label>

            @if ($type === 'textarea')
              <div class="quill-editor" data-field="{{ $key }}" data-value="{{ $value }}" style="min-height:150px;"></div>

            @elseif ($type === 'image')
              @php $src = $imageUrl($value); @endphp
              <div class="image-upload-box">
                <div class="image-upload-preview" id="sc_preview_{{ $key }}">
                  @if ($value && \Illuminate\Support\Str::startsWith($value, 'bi-'))
                    <i class="bi {{ $value }}"></i>
                  @elseif ($src)
                    <img src="{{ $src }}" alt="preview">
                  @else
                    <i class="bi bi-image"></i>
                  @endif
                </div>
                <div class="image-upload-controls">
                  <label class="btn-admin btn-admin-outline btn-image-upload-label">
                    <i class="bi bi-upload"></i> {{ $value ? 'Ganti Gambar' : 'Pilih Gambar' }}
                    <input type="file" accept="image/jpeg,image/png,image/webp" class="image-upload-input"
                           data-field="{{ $key }}" data-preview="sc_preview_{{ $key }}" hidden>
                  </label>
                  <div class="field-hint">JPG/PNG/WebP, maksimal 5 MB.</div>
                </div>
              </div>

            @else
              <input type="text" id="sc_{{ $key }}" class="form-control-admin" data-field="{{ $key }}" value="{{ $value }}">
            @endif
          </div>
        @endforeach

        <div class="settings-form-actions">
          <button type="button" class="btn-admin btn-admin-forest" id="siteContentSave">
            <i class="bi bi-check2"></i> Simpan Perubahan
          </button>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('vendor')
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dompurify@3.2.6/dist/purify.min.js"></script>
@endpush

@push('scripts')
  <script src="{{ \App\Support\Asset::v('assets/js/admin/site-content.js') }}"></script>
@endpush
