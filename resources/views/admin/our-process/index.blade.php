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
        <h2>Daftar Langkah</h2>
        <button type="button" class="btn-admin btn-admin-forest" data-action="create">
          <i class="bi bi-plus-lg"></i> Tambah Langkah
        </button>
      </div>

      <div class="admin-table-wrap">
        @if ($items->isEmpty())
          <div class="admin-empty">
            <i class="bi bi-signpost-split"></i>
            <p class="mb-0">Belum ada data langkah proses.</p>
          </div>
        @else
          <table class="admin-table">
            <thead>
              <tr>
                <th>Judul Langkah</th>
                <th style="text-align:right;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($items as $item)
                <tr>
                  <td>{{ $item->title }}</td>
                  <td>
                    <div class="admin-table-actions">
                      <button type="button" class="btn-icon" data-action="edit" data-id="{{ $item->id }}" title="Edit">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button type="button" class="btn-icon danger" data-action="delete"
                              data-id="{{ $item->id }}" data-name="{{ $item->title }}" title="Hapus">
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
  <div class="modal fade" id="processModal" tabindex="-1" aria-hidden="true" data-endpoint="{{ route('admin.our-process.index') }}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 data-role="title">Tambah Langkah Proses</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="modal-body-admin">
          <div class="field-group">
            <label class="field-label" for="processTitle">Judul Langkah *</label>
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

@push('scripts')
  <script src="{{ \App\Support\Asset::v('assets/js/admin/crud.js') }}"></script>
  <script>
    AdminCrud.init({
      modal: '#processModal',
      name: 'Langkah Proses',
      jumpToLastOnCreate: true,
      fields: [
        { key: 'title', label: 'Judul Langkah', required: true }
      ]
    });
  </script>
@endpush
