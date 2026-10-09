@extends('layouts.admin')

@section('title', 'Inquiries')
@section('page_title', 'Inquiries')

@section('content')
  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>Inquiries</h1>
        <p>Data kiriman form kontak dari calon buyer. Baca saja — hapus setelah ditindaklanjuti.</p>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card-head">
        <h2>Daftar Inquiry</h2>
        <button type="button" class="btn-admin btn-admin-outline" id="exportInquiryBtn">
          <i class="bi bi-file-earmark-excel"></i> Export to Excel
        </button>
      </div>

      <form id="inquiryFilterForm" class="admin-filter-bar" autocomplete="off">
        <div class="admin-filter-field">
          <label class="field-label" for="filterFullname">Nama Orang</label>
          <input type="text" id="filterFullname" name="fullname" class="form-control-admin" placeholder="cari nama...">
        </div>
        <div class="admin-filter-field">
          <label class="field-label" for="filterCompany">Nama Perusahaan</label>
          <input type="text" id="filterCompany" name="company_name" class="form-control-admin" placeholder="cari perusahaan...">
        </div>
        <div class="admin-filter-field">
          <label class="field-label" for="filterCountry">Negara</label>
          <input type="text" id="filterCountry" name="country" class="form-control-admin" placeholder="cari negara...">
        </div>
        <div class="admin-filter-field">
          <label class="field-label" for="filterStart">Start Date</label>
          <input type="date" id="filterStart" name="start_date" class="form-control-admin">
        </div>
        <div class="admin-filter-field">
          <label class="field-label" for="filterEnd">End Date <span class="field-hint-inline">(opsional)</span></label>
          <input type="date" id="filterEnd" name="end_date" class="form-control-admin">
        </div>
        <div class="admin-filter-actions">
          <button type="submit" class="btn-admin btn-admin-forest"><i class="bi bi-funnel"></i> Terapkan</button>
          <a href="#" id="inquiryFilterReset" class="btn-admin btn-admin-outline">Reset</a>
        </div>
      </form>

      <div class="admin-table-wrap" id="inquiryTable"
           data-list="{{ route('admin.inquiries.data') }}"></div>
    </div>
  </section>
@endsection

@push('modals')
  {{-- Detail (baca saja) --}}
  <div class="modal fade" id="inquiryModal" tabindex="-1" aria-hidden="true" data-endpoint="{{ route('admin.inquiries.index') }}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5>Detail Inquiry</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-admin">
          <div class="product-detail-info">
            <dl>
              @foreach ([
                'created_at' => 'Tanggal', 'fullname' => 'Nama Lengkap', 'company_name' => 'Perusahaan',
                'email' => 'Email', 'whatsapp' => 'WhatsApp', 'country' => 'Negara',
                'product_interested' => 'Produk Diminati', 'estimated_quantity' => 'Estimasi Qty', 'message' => 'Pesan',
              ] as $key => $label)
                <dt>{{ $label }}</dt>
                <dd data-view="{{ $key }}" style="white-space:pre-line;">—</dd>
              @endforeach
            </dl>
          </div>
        </div>
        <div class="modal-footer-admin d-flex justify-content-end gap-2">
          <button type="button" class="btn-admin btn-admin-outline" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Export --}}
  <div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5>Export Inquiries to Excel</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-admin">
          <div class="field-group">
            <label class="field-label" for="exportPeriod">Periode Data</label>
            <select class="form-select-admin" id="exportPeriod">
              <option value="all" selected>All Data</option>
              <option value="today">Today</option>
              <option value="7days">Last 7 Days</option>
              <option value="1month">Last 1 Month</option>
              <option value="3months">Last 3 Months</option>
              <option value="custom">Custom Date</option>
            </select>
          </div>

          <div id="exportCustomDateFields" style="display:none;">
            <div class="row g-2">
              <div class="col-6">
                <label class="field-label" for="exportStartDate">Start Date</label>
                <input type="date" class="form-control-admin" id="exportStartDate">
              </div>
              <div class="col-6">
                <label class="field-label" for="exportEndDate">End Date</label>
                <input type="date" class="form-control-admin" id="exportEndDate">
              </div>
            </div>
          </div>

          <div id="exportStatus"></div>
        </div>
        <div class="modal-footer-admin d-flex justify-content-end gap-2">
          <button type="button" class="btn-admin btn-admin-outline" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn-admin btn-admin-forest" id="exportSubmitBtn" data-endpoint="{{ route('admin.inquiries.export') }}">
            <i class="bi bi-download"></i> Export
          </button>
        </div>
      </div>
    </div>
  </div>
@endpush

@push('vendors')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('scripts')
  <script src="{{ \App\Support\Asset::v('assets/js/admin/inquiries.js') }}"></script>
@endpush