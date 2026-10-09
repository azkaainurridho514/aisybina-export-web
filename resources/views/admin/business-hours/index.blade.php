@extends('layouts.admin')

@section('title', 'Business Hours')
@section('page_title', 'Business Hours')

@section('content')
  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>Business Hours</h1>
        <p>Jam operasional per hari, tampil di halaman Contact.</p>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card-head">
        <h2>Jadwal</h2>
        <button type="button" class="btn-admin btn-admin-forest" data-action="create">
          <i class="bi bi-plus-lg"></i> Tambah Jadwal
        </button>
      </div>

      <div class="admin-table-wrap" id="businessHourTable"
          data-list="{{ route('admin.business-hours.data') }}"></div>
    </div>
  </section>
@endsection

@push('modals')
  <div class="modal fade" id="businessHourModal" tabindex="-1" aria-hidden="true" data-endpoint="{{ route('admin.business-hours.index') }}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 data-role="title">Tambah Jadwal</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
 
        <div class="modal-body-admin">
          <div class="field-group">
            <label class="field-label" for="bhDay">Hari *</label>
            <input type="text" id="bhDay" class="form-control-admin" data-field="day" maxlength="255" autocomplete="off" placeholder="contoh: Monday">
          </div>
          <div class="field-group">
            <label class="field-label" for="bhStart">Jam Buka *</label>
            <input type="time" id="bhStart" class="form-control-admin" data-field="start_time">
          </div>
          <div class="field-group">
            <label class="field-label" for="bhEnd">Jam Tutup *</label>
            <input type="time" id="bhEnd" class="form-control-admin" data-field="end_time">
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
@endpush

@push('scripts')
  <script src="{{ \App\Support\Asset::v('assets/js/00-constants.js') }}"></script>
  <script src="{{ \App\Support\Asset::v('assets/js/admin/crud.js') }}"></script>
  <script>
    AdminCrud.init({
      modal: '#businessHourModal',
      table: '#businessHourTable',
      name: 'Jadwal',
      jumpToLastOnCreate: true,
      perPage: 10,
      empty: { icon: 'bi-clock', text: 'Belum ada data jam operasional.' },
      columns: [
        { label: 'Hari', key: 'day' },
        { label: 'Jam Buka', render: (row, h) => h.esc(String(row.start_time || '').slice(0, 5)) || '—' },
        { label: 'Jam Tutup', render: (row, h) => h.esc(String(row.end_time || '').slice(0, 5)) || '—' }
      ],
      deleteName: (row) => row.day,
      fields: [
        { key: 'day', label: 'Hari', required: true },
        { key: 'start_time', label: 'Jam Buka', required: true },
        { key: 'end_time', label: 'Jam Tutup', required: true }
      ]
    });
  </script>
@endpush
