@extends('layouts.admin')

@section('title', 'Our Mission')
@section('page_title', 'Our Mission')

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>Our Mission</h1>
        <p>Poin-poin misi perusahaan yang tampil di halaman About.</p>
      </div>
    </div>
    <div class="admin-card">
      <div class="admin-card-head">
        <h2>Mission</h2>
        <button type="button" class="btn-admin btn-admin-forest" data-action="create">
          <i class="bi bi-plus-lg"></i> Tambah
        </button>
      </div>

      <div class="admin-table-wrap" id="missionTable" data-list="{{ route('admin.our-mission.data') }}"></div>
    </div>
  </section>
@endsection

@push('modals')
 <div class="modal fade" id="missionModal" tabindex="-1" aria-hidden="true" data-endpoint="{{ route('admin.our-mission.index') }}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 data-role="title">Tambah Mission</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="modal-body-admin">
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
      modal: '#missionModal',
      table: '#missionTable',
      name: 'Mission',
      jumpToLastOnCreate: true,
      perPage: 10,
      empty: { icon: 'bi-bullseye', text: 'Belum ada data mission.' },
      columns: [
        { label: 'Deskripsi', render: (row, h) => h.esc(h.plain(row.description, 120)) || '—' }
      ],
      deleteName: (row, h) => h.plain(row.description, 40),
      fields: [
        { key: 'description', label: 'Deskripsi', required: true }
      ]
    });
  </script>
@endpush
