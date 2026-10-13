@extends('layouts.admin')

@section('title', 'Options')
@section('page_title', 'Options')

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>Options</h1>
        <p>Opsi pada produk.</p>
      </div>
    </div>
    <div class="admin-card">
      <div class="admin-card-head">
        <h2>Options</h2>
        <button type="button" class="btn-admin btn-admin-forest" data-action="create">
          <i class="bi bi-plus-lg"></i> Tambah
        </button>
      </div>

      <div class="admin-table-wrap" id="optionTable" data-list="{{ route('admin.options.data') }}"></div>
    </div>
  </section>
@endsection

@push('modals')
  {{-- ===== Modal Tambah / Edit ===== --}}
  <div class="modal fade" id="optionModal" tabindex="-1" aria-hidden="true" data-endpoint="{{ route('admin.options.index') }}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 data-role="title">Tambah Opsi</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="modal-body-admin">
          <div class="field-group">
            <label class="field-label">Title *</label>
            <input type="text" class="form-control-admin" data-field="title" maxlength="255" autocomplete="off">
          </div>

          <div class="field-group">
            <label class="field-label">Deskripsi *</label>
            <div class="quill-editor" data-field="description" style="min-height:150px;"></div>
          </div>

          <div class="field-group">
            <label class="field-label">Items *</label>
            <div data-field="items"></div>
            <button type="button" class="btn-admin btn-admin-outline mt-1" data-list-add="items">
              <i class="bi bi-plus-lg"></i> Tambah item
            </button>
          </div>
        </div>

        <div class="modal-footer-admin d-flex justify-content-end gap-2">
          <button type="button" class="btn-admin btn-admin-outline" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn-admin btn-admin-forest" data-role="save"><i class="bi bi-check2"></i> Simpan</button>
        </div>
      </div>
    </div>
  </div>

  {{-- ===== Modal View ===== --}}
  <div class="modal fade" id="optionViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5>Detail Opsi</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="modal-body-admin">
          <div class="field-group">
            <label class="field-label">Title</label>
            <div id="viewTitle" class="fw-semibold"></div>
          </div>
          <div class="field-group">
            <label class="field-label">Deskripsi</label>
            <div id="viewDescription"></div>
          </div>
          <div class="field-group mb-0">
            <label class="field-label">Items <span id="viewCount" class="text-muted"></span></label>
            <ul id="viewItems" class="mb-0 ps-3"></ul>
          </div>
        </div>

        <div class="modal-footer-admin d-flex justify-content-end gap-2">
          <button type="button" class="btn-admin btn-admin-outline" data-bs-dismiss="modal">Tutup</button>
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
  <script src="{{ asset('assets/js/admin/crud.js') }}"></script>
  <script src="{{ asset('assets/js/admin/crud-list.js') }}"></script>
  <script>
    AdminCrud.init({
      modal: '#optionModal',
      table: '#optionTable',
      name: 'Option',
      jumpToLastOnCreate: true,
      submitOnEnter: false,
      perPage: 10,
      empty: { icon: 'bi-bullseye', text: 'Belum ada data option.' },

      columns: [
        { label: 'Title', render: (row, h) => h.esc(h.plain(row.title, 120)) || '—' },
        { label: 'Deskripsi', render: (row, h) => h.esc(h.plain(row.description, 80)) || '—' },
        {
          label: 'Items',
          render: (row, h) => {
            var items = row.items || [];
            if (!items.length) return '—';
            var chips = items.slice(0, 3).map(i =>
              '<span class="badge text-bg-light border me-1">' + h.esc(h.plain(i.description, 30)) + '</span>'
            ).join('');
            var more = items.length > 3 ? '<span class="text-muted small">+' + (items.length - 3) + '</span>' : '';
            return chips + more;
          }
        },
      ],

      rowActions: (row, h) =>
        '<button type="button" class="btn-icon" data-action="view" data-id="' + h.esc(row.id) + '" title="Lihat">' +
        '<i class="bi bi-eye"></i></button>',

      deleteName: (row, h) => h.plain(row.title, 40),

      fields: [
        { key: 'title', label: 'Title', required: true },
        { key: 'description', label: 'Deskripsi', required: true },
        { key: 'items', label: 'Items', required: true,
          ...AdminCrud.listField('items', { placeholder: 'Contoh: 25 kg polypropylene bag' }) },
      ]
    });

    // ===== Modal View =====
    (function ($) {
      var $view = $('#optionViewModal');
      var viewModal = new bootstrap.Modal($view[0]);
      var endpoint = $('#optionModal').data('endpoint');

      function esc(s) { return $('<div>').text(s == null ? '' : s).html(); }

      $('#optionTable').on('click', '[data-action="view"]', function () {
        var $btn = $(this).prop('disabled', true);

        adminRequest('GET', endpoint + '/' + encodeURIComponent($btn.attr('data-id')))
          .done(function (res) {
            var row = res.data || res;
            var items = row.items || [];

            $('#viewTitle').text(row.title || '—');
            $('#viewDescription').html(DOMPurify.sanitize(row.description || '') || '—');
            $('#viewCount').text('(' + items.length + ')');
            $('#viewItems').html(
              items.length
                ? items.map(i => '<li>' + esc(i.description) + '</li>').join('')
                : '<li class="text-muted list-unstyled">Belum ada item.</li>'
            );

            viewModal.show();
          })
          .fail(function (xhr) { toastError(xhr.message || 'Gagal memuat detail.'); })
          .always(function () { $btn.prop('disabled', false); });
      });
    })(jQuery);
  </script>
@endpush