@extends('layouts.admin')

@section('title', 'About Items')
@section('page_title', 'About Items')

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>About Items</h1>
        <p>Poin nilai di section "Who We Are".</p>
      </div>
    </div>

    <div class="admin-card">
          <div class="admin-card-head">
      <h2>About Items</h2>
      <button type="button" class="btn-admin btn-admin-forest" data-action="create">
        <i class="bi bi-plus-lg"></i> Tambah
      </button>
    </div>

    <div class="admin-table-wrap" id="aboutItemsTable" data-list="{{ route('admin.about-items.data') }}"></div>
  </div>
</section>
@endsection

@push('modals')
  <div class="modal fade" id="aboutItemsModal" tabindex="-1" aria-hidden="true" data-endpoint="{{ route('admin.about-items.index') }}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 data-role="title">Tambah aboutItems</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="modal-body-admin">
          <div class="field-group">
            <label class="field-label">Icon *</label>
            <div class="icon-picker-row">
              <select class="form-select-admin icon-picker-select" data-field="icon" data-icons data-preview="#aboutItemsIconPreview"></select>
              <div class="icon-picker-preview" id="aboutItemsIconPreview"><i class="bi bi-question-circle" style="opacity:.3;"></i></div>
            </div>
          </div>
          <div class="field-group">
            <label class="field-label" for="aboutItemsTitle">Title *</label>
            <input type="text" id="aboutItemsTitle" class="form-control-admin" data-field="title" maxlength="255" autocomplete="off">
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
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dompurify@3.2.6/dist/purify.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('scripts')
  <script src="{{ \App\Support\Asset::v('assets/js/00-constants.js') }}"></script>
  <script src="{{ \App\Support\Asset::v('assets/js/admin/crud.js') }}"></script>
  <script>
    AdminCrud.init({
      modal: '#aboutItemsModal',
      table: '#aboutItemsTable',
      name: 'Alasan',
      jumpToLastOnCreate: true,
      perPage: 10,
      empty: { icon: 'bi-star', text: 'Belum ada data alasan.' },
      columns: [
        { label: 'Icon', render: (row, h) => '<i class="bi ' + h.esc(row.icon) + '"></i>' },
        { label: 'Judul', key: 'title' },
        { label: 'Deskripsi', render: (row, h) => h.esc(h.plain(row.description, 60)) || '—' }
      ],
      deleteName: (row) => row.title,
      fields: [
        { key: 'icon', label: 'Icon', required: true },
        { key: 'title', label: 'Judul', required: true },
        { key: 'description', label: 'Deskripsi' }
      ]
    });
  </script>
@endpush
