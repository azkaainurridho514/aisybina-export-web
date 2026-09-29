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

      <div class="admin-table-wrap">
        @if ($items->isEmpty())
          <div class="admin-empty">
            <i class="bi bi-clock"></i>
            <p class="mb-0">Belum ada data jam operasional.</p>
          </div>
        @else
          <table class="admin-table">
            <thead>
              <tr>
                <th>Hari</th>
                <th>Jam Buka</th>
                <th>Jam Tutup</th>
                <th style="text-align:right;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($items as $item)
                <tr>
                  <td>{{ $item->day }}</td>
                  <td>{{ substr((string) $item->start_time, 0, 5) }}</td>
                  <td>{{ substr((string) $item->end_time, 0, 5) }}</td>
                  <td>
                    <div class="admin-table-actions">
                      <button type="button" class="btn-icon" data-action="edit" data-id="{{ $item->id }}" title="Edit">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button type="button" class="btn-icon danger" data-action="delete"
                              data-id="{{ $item->id }}" data-name="{{ $item->day }}" title="Hapus">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          @include('admin.partials.pagination', ['paginator' => $items])
        @endif
      </div>
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

@push('scripts')
  <script src="{{ \App\Support\Asset::v('assets/js/admin/crud.js') }}"></script>
  <script>
    AdminCrud.init({
      modal: '#businessHourModal',
      name: 'Jadwal',
      jumpToLastOnCreate: true,
      fields: [
        { key: 'day', label: 'Hari', required: true },
        { key: 'start_time', label: 'Jam Buka', required: true },
        { key: 'end_time', label: 'Jam Tutup', required: true }
      ]
    });
  </script>
@endpush
