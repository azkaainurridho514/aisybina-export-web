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
        <h2>Categories</h2>
        <button type="button" class="btn-admin btn-admin-forest" data-action="create">
          <i class="bi bi-plus-lg"></i> Tambah
        </button>
      </div>

      <div class="admin-table-wrap" id="categoriesTable" data-list="{{ route('admin.categories.data') }}"></div>
    </div>
  </section>
@endsection

@push('modals')
 <div class="modal fade" id="categoriesModal" tabindex="-1" aria-hidden="true" data-endpoint="{{ route('admin.categories.index') }}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 data-role="title">Tambah categories</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-admin">
          <div class="field-group">
            <label class="field-label" for="categoriesName">Name *</label>
            <input type="text" id="categoriesName" class="form-control-admin" data-field="name" maxlength="255" autocomplete="off">
          </div>
          <div class="field-group">
            <label class="field-label">Deskripsi *</label>
            <div class="quill-editor" data-field="description" style="min-height:150px;"></div>
          </div>
        </div>

        <div class="modal-footer-admin d-flex justify-content-end gap-2">
          <button type="button" class="btn-admin btn-admin-outline" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn-admin btn-admin-forest" data-role="save"><i class="bi bi-check2"></i> Simpan</button>
        </div>
      </div>
    </div>
  </div>
@endpush

@push('vendors')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dompurify@3.2.6/dist/purify.min.js"></script>
@endpush

@push('scripts')
  <script src="{{ \App\Support\Asset::v('assets/js/admin/crud.js') }}"></script>
  <script>
    AdminCrud.init({
      modal: '#categoriesModal',
      table: '#categoriesTable',
      name: 'categories',
      jumpToLastOnCreate: true,
      perPage: 10,
      empty: { icon: 'bi-bullseye', text: 'Belum ada data categories.' },
      columns: [
        { label: 'Name', render: (row, h) => h.esc(h.plain(row.name, 120)) || '—' },
        { label: 'Deskripsi', render: (row, h) => h.esc(h.plain(row.description, 120)) || '—' },
      ],
      deleteName: (row, h) => h.plain(row.description, 40),
      fields: [
        { key: 'name', label: 'Name', required: true },
        { key: 'description', label: 'Deskripsi', required: true }
      ]
    });
  </script>
@endpush