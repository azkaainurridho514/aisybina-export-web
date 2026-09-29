@extends('layouts.admin')

@section('title', 'Categories')
@section('page_title', 'Categories')

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>Categories</h1>
        <p>Kategori produk yang tampil di halaman Products.</p>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card-head">
        <h2>Daftar Kategori</h2>
        <div class="admin-head-actions">
          <form method="GET" action="{{ route('admin.categories.index') }}" class="admin-search-form">
            <div class="admin-search-box">
              <i class="bi bi-search"></i>
              <input type="text" name="search" value="{{ $search }}" class="form-control-admin admin-search-input"
                     placeholder="Cari nama kategori..." autocomplete="off">
            </div>
          </form>

          @if ($search !== '')
            <a href="{{ route('admin.categories.index') }}" class="btn-admin btn-admin-ghost">Reset</a>
          @endif

          <button type="button" class="btn-admin btn-admin-forest" data-action="create">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
          </button>
        </div>
      </div>

      <div class="admin-table-wrap">
        @if ($categories->isEmpty())
          <div class="admin-empty">
            <i class="bi bi-tag"></i>
            <p class="mb-0">{{ $search !== '' ? 'Tidak ada hasil untuk pencarian ini.' : 'Belum ada data kategori.' }}</p>
          </div>
        @else
          <table class="admin-table">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th style="text-align:right;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($categories as $category)
                @php
                  // Deskripsi tersimpan sebagai HTML dari editor; di tabel cukup teks polos.
                  $plain = html_entity_decode(strip_tags((string) $category->description), ENT_QUOTES | ENT_HTML5);
                @endphp
                <tr>
                  <td>{{ $category->name }}</td>
                  <td>{{ $plain !== '' ? \Illuminate\Support\Str::limit(trim($plain), 60) : '—' }}</td>
                  <td>
                    <div class="admin-table-actions">
                      <button type="button" class="btn-icon" data-action="edit" data-id="{{ $category->id }}" title="Edit">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button type="button" class="btn-icon danger" data-action="delete"
                              data-id="{{ $category->id }}" data-name="{{ $category->name }}" title="Hapus">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          @include('admin.partials.pagination', ['paginator' => $categories])
        @endif
      </div>
    </div>
  </section>
@endsection

@push('modals')
  <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true" data-endpoint="{{ url('/admin/categories') }}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 id="categoryModalTitle">Tambah Kategori</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="modal-body-admin">
          <div class="field-group">
            <label class="field-label" for="categoryName">Nama Kategori *</label>
            <input type="text" id="categoryName" class="form-control-admin" maxlength="255" autocomplete="off">
          </div>
          <div class="field-group">
            <label class="field-label">Deskripsi</label>
            <div class="quill-editor" id="categoryDescription" style="min-height:150px;"></div>
          </div>
        </div>

        <div class="modal-footer-admin d-flex justify-content-end gap-2">
          <button type="button" class="btn-admin btn-admin-outline" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn-admin btn-admin-forest" id="categorySave"><i class="bi bi-check2"></i> Simpan</button>
        </div>
      </div>
    </div>
  </div>
@endpush

@push('vendor')
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dompurify@3.2.6/dist/purify.min.js"></script>
@endpush

@push('scripts')
  <script src="{{ \App\Support\Asset::v('assets/js/admin/categories.js') }}"></script>
@endpush
