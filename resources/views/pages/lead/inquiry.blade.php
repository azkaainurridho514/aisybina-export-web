<section class="admin-section" id="section-inquiry_forms">
    <div class="admin-section-head">
        <div>
            <h1>Inquiries</h1>
            <p>Data kiriman form kontak dari calon buyer. Baca saja — hapus setelah ditindaklanjuti.</p>
        </div>
        </div>
        <div class="admin-card">
        <div class="admin-card-head">
            <h2>Daftar Inquiry</h2>
            <button class="btn-admin btn-admin-outline" id="exportInquiryBtn"><i class="bi bi-file-earmark-excel"></i> Export to Excel</button>
        </div>

        <div class="admin-filter-bar" id="inquiryFilterBar">
            <div class="admin-filter-field">
            <label class="field-label">Nama Orang</label>
            <input type="text" class="form-control-admin" id="filterPersonName" placeholder="cari nama...">
            </div>
            <div class="admin-filter-field">
            <label class="field-label">Nama Perusahaan</label>
            <input type="text" class="form-control-admin" id="filterCompanyName" placeholder="cari perusahaan...">
            </div>
            <div class="admin-filter-field">
            <label class="field-label">Negara</label>
            <input type="text" class="form-control-admin" id="filterCountry" placeholder="cari negara...">
            </div>
            <div class="admin-filter-field">
            <label class="field-label">Start Date</label>
            <input type="date" class="form-control-admin" id="filterStartDate">
            </div>
            <div class="admin-filter-field">
            <label class="field-label">End Date <span class="field-hint-inline">(opsional)</span></label>
            <input type="date" class="form-control-admin" id="filterEndDate">
            </div>
            <div class="admin-filter-actions">
            <button class="btn-admin btn-admin-forest" id="applyInquiryFilter"><i class="bi bi-funnel"></i> Terapkan</button>
            <button class="btn-admin btn-admin-outline" id="resetInquiryFilter">Reset</button>
            </div>
        </div>

        <div class="admin-table-wrap" id="table-inquiry_forms"></div>
    </div>
</section>



<!-- ===================== EXPORT INQUIRY MODAL ===================== -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
            <h5>Export Inquiries to Excel</h5>
            <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-admin">
            <div class="field-group">
            <label class="field-label">Periode Data</label>
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
                <label class="field-label">Start Date</label>
                <input type="date" class="form-control-admin" id="exportStartDate">
                </div>
                <div class="col-6">
                <label class="field-label">End Date</label>
                <input type="date" class="form-control-admin" id="exportEndDate">
                </div>
            </div>
            </div>

            <div id="exportStatus"></div>
        </div>
        <div class="modal-footer-admin d-flex justify-content-end gap-2">
            <button type="button" class="btn-admin btn-admin-outline" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn-admin btn-admin-forest" id="exportSubmitBtn"><i class="bi bi-download"></i> Export</button>
        </div>
        </div>
    </div>
</div>