@extends('layouts.admin')

@section('title', 'Export Process')
@section('page_title', 'Export Process')

@section('content')
  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>Export Process</h1>
        <p>Langkah-langkah proses ekspor yang tampil sebagai timeline di homepage.</p>
      </div>
    </div>
    <div class="admin-card">
    <div class="admin-card-head">
      <h2>Process</h2>
      <button type="button" class="btn-admin btn-admin-forest" data-action="create">
        <i class="bi bi-plus-lg"></i> Tambah
      </button>
    </div>

    <div class="admin-table-wrap" id="processTable" data-list="{{ route('admin.our-process.data') }}"></div>
  </div>
</section>
@endsection

@push('modals')
 <div class="modal fade" id="processModal" tabindex="-1" aria-hidden="true" data-endpoint="{{ route('admin.our-process.index') }}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 data-role="title">Tambah process</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="modal-body-admin">
          <div class="field-group">
            <label class="field-label" for="processTitle">Title *</label>
            <input type="text" id="processTitle" class="form-control-admin" data-field="title" maxlength="255" autocomplete="off">
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
      modal: '#processModal',
      table: '#processTable',
      name: 'process',
      jumpToLastOnCreate: true,
      perPage: 10,
      empty: { icon: 'bi-bullseye', text: 'Belum ada data process.' },
      columns: [
        { label: 'Title', render: (row, h) => h.esc(h.plain(row.title, 120)) || '—' }
      ],
      deleteName: (row, h) => h.plain(row.title, 40),
      fields: [
        { key: 'title', label: 'Title', required: true }
      ]
    });
  </script>
@endpush
