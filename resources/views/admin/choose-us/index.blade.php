@extends('layouts.admin')

@section('title', 'Why Choose Us')
@section('page_title', 'Why Choose Us')

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>Why Choose Us</h1>
        <p>Alasan kenapa buyer bekerja sama dengan Aisy Bina Exports.</p>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card-head">
        <h2>Daftar Alasan</h2>
        <button type="button" class="btn-admin btn-admin-forest" data-action="create">
          <i class="bi bi-plus-lg"></i> Tambah Alasan
        </button>
      </div>

      <div class="admin-table-wrap">
        @if ($items->isEmpty())
          <div class="admin-empty">
            <i class="bi bi-star"></i>
            <p class="mb-0">Belum ada data alasan.</p>
          </div>
        @else
          <table class="admin-table">
            <thead>
              <tr>
                <th>Icon</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th style="text-align:right;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($items as $item)
                <tr>
                  <td><i class="bi {{ $item->icon }}"></i></td>
                  <td>{{ $item->title }}</td>
                  <td>{{ \App\Support\Text::plain($item->description, 60) ?: '—' }}</td>
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
  <div class="modal fade" id="chooseUsModal" tabindex="-1" aria-hidden="true" data-endpoint="{{ route('admin.choose-us.index') }}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 data-role="title">Tambah Alasan</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="modal-body-admin">
          <div class="field-group">
            <label class="field-label">Icon *</label>
            <div class="icon-picker-row">
              <select class="form-select-admin icon-picker-select" data-field="icon" data-icons data-preview="#chooseUsIconPreview"></select>
              <div class="icon-picker-preview" id="chooseUsIconPreview"><i class="bi bi-question-circle" style="opacity:.3;"></i></div>
            </div>
          </div>
          <div class="field-group">
            <label class="field-label" for="chooseUsTitle">Judul *</label>
            <input type="text" id="chooseUsTitle" class="form-control-admin" data-field="title" maxlength="255" autocomplete="off">
          </div>
          <div class="field-group">
            <label class="field-label">Deskripsi</label>
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

@push('vendor')
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dompurify@3.2.6/dist/purify.min.js"></script>
@endpush

@push('scripts')
  <script src="{{ \App\Support\Asset::v('assets/js/00-constants.js') }}"></script>
  <script src="{{ \App\Support\Asset::v('assets/js/admin/crud.js') }}"></script>
  <script>
    AdminCrud.init({
      modal: '#chooseUsModal',
      name: 'Alasan',
      jumpToLastOnCreate: true,
      fields: [
        { key: 'icon', label: 'Icon', required: true },
        { key: 'title', label: 'Judul', required: true },
        { key: 'description', label: 'Deskripsi' }
      ]
    });
  </script>
@endpush
