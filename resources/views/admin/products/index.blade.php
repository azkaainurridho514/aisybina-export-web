@extends('layouts.admin')

@section('title', 'Products')
@section('page_title', 'Products')

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>Products</h1>
        <p>Produk di dalam tiap kategori.</p>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card-head">
        <h2>Daftar Produk</h2>
        <div class="admin-head-actions">
          <form id="productSearchForm" class="admin-search-form" autocomplete="off">
            <div class="admin-search-box">
              <i class="bi bi-search"></i>
              <input type="text" id="productSearch" class="form-control-admin admin-search-input"
                     placeholder="Cari nama produk..." autocomplete="off">
            </div>
          </form>

          <a href="#" id="productSearchReset" class="btn-admin btn-admin-ghost" style="display:none;">Reset</a>

          <button type="button" class="btn-admin btn-admin-forest" data-action="create">
            <i class="bi bi-plus-lg"></i> Tambah Produk
          </button>
        </div>
      </div>

      <div class="admin-table-wrap" id="productTable"
           data-list="{{ route('admin.products.data') }}"></div>
    </div>
  </section>
@endsection

@push('modals')
  {{-- Tambah / ubah --}}
  <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true" data-endpoint="{{ route('admin.products.index') }}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 id="productModalTitle">Tambah Produk</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="modal-body-admin">
          <div class="field-group">
            <label class="field-label">Foto Produk</label>
            <div class="gallery-grid" id="productGallery"></div>
            <div class="field-hint">Bisa unggah lebih dari satu foto. Foto pertama otomatis jadi foto utama (cover). Klik foto untuk pratinjau, klik &times; untuk hapus.</div>
          </div>
          <div class="field-group">
            <label class="field-label" for="productName">Nama Produk *</label>
            <input type="text" id="productName" class="form-control-admin" maxlength="255" autocomplete="off">
          </div>
          <div class="field-group">
            <label class="field-label" for="productCategory">Kategori *</label>
            <select id="productCategory" class="form-select-admin">
              <option value="">Pilih...</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="field-group">
            <label class="field-label">Options</label>
            <div id="productOptions" class="d-flex flex-column gap-2">
              @forelse ($options as $option)
                <label class="d-flex align-items-center gap-2 mb-0">
                  <input type="checkbox" class="form-check-input mt-0" value="{{ $option->id }}">
                  <span>{{ $option->title }}</span>
                </label>
              @empty
                <div class="field-hint">Belum ada option. Buat dulu di menu Options.</div>
              @endforelse
            </div>
          </div>
          <div class="field-group">
            <label class="field-label">Deskripsi</label>
            <div class="quill-editor" id="productDescription" style="min-height:150px;"></div>
          </div>
        </div>

        <div class="modal-footer-admin d-flex justify-content-end gap-2">
          <button type="button" class="btn-admin btn-admin-outline" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn-admin btn-admin-forest" id="productSave"><i class="bi bi-check2"></i> Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="productDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 id="productDetailTitle">Detail Produk</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-admin" id="productDetailBody"></div>
        <div class="modal-footer-admin d-flex justify-content-end gap-2">
          <button type="button" class="btn-admin btn-admin-outline" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <div class="image-lightbox" id="imageLightbox">
    <button type="button" class="image-lightbox-close" id="imageLightboxClose" aria-label="Close"><i class="bi bi-x-lg"></i></button>
    <img src="" alt="Preview" id="imageLightboxImg">
  </div>
@endpush

@push('vendors')
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dompurify@3.2.6/dist/purify.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('scripts')
  <script src="{{ \App\Support\Asset::v('assets/js/00-constants.js') }}"></script>
  <script src="{{ \App\Support\Asset::v('assets/js/admin/products.js') }}"></script>
@endpush