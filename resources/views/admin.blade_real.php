<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Aisy Bina Exports</title>
  <meta name="robots" content="noindex, nofollow">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset("template/assets/css/style-admin.css") }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>
<body>

  <div class="admin-shell">

    <!-- ===================== SIDEBAR ===================== -->
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="admin-sidebar-brand">
        Aisy Bina<span class="brand-dot">.</span>
        <small>Admin Panel</small>
      </div>

      <nav class="admin-nav">
        <div class="admin-nav-link active" data-section="dashboard" data-title="Dashboard">
          <i class="bi bi-grid-1x2"></i> Dashboard
        </div>

        <div class="admin-nav-label">Site Content</div>
        <div class="admin-nav-link" data-section="site-content" data-title="Site Content">
          <i class="bi bi-file-earmark-text"></i> Home &amp; Pages
        </div>

        <div class="admin-nav-label">Catalog</div>
        <div class="admin-nav-link" data-section="categories" data-title="Categories">
          <i class="bi bi-tag"></i> Categories
        </div>
        <div class="admin-nav-link" data-section="products" data-title="Products">
          <i class="bi bi-box-seam"></i> Products
        </div>

        <div class="admin-nav-label">Content Blocks</div>
        <div class="admin-nav-link" data-section="our_process" data-title="Export Process">
          <i class="bi bi-signpost-split"></i> Export Process
        </div>
        <div class="admin-nav-link" data-section="choose_us" data-title="Why Choose Us">
          <i class="bi bi-star"></i> Why Choose Us
        </div>
        <div class="admin-nav-link" data-section="about_item" data-title="About Items">
          <i class="bi bi-people"></i> About Items
        </div>
        <div class="admin-nav-link" data-section="business_hours" data-title="Business Hours">
          <i class="bi bi-clock"></i> Business Hours
        </div>

        <div class="admin-nav-label">Leads</div>
        <div class="admin-nav-link" data-section="inquiry_forms" data-title="Inquiries">
          <i class="bi bi-envelope-open"></i> Inquiries
        </div>
      </nav>

      <div class="admin-sidebar-foot">Aisy Bina Exports &copy; 2026</div>
    </aside>

    <div class="admin-sidebar-backdrop"></div>

    <!-- ===================== CONTENT ===================== -->
    <div class="admin-content">

      <header class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
          <button class="admin-sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>
          <div class="admin-topbar-title" id="adminPageTitle">Dashboard</div>
        </div>

        <div class="admin-user dropdown">
          <div data-bs-toggle="dropdown" aria-expanded="false" class="d-flex align-items-center gap-2">
            <div class="admin-user-avatar">AB</div>
            <div class="d-none d-sm-block">
              <div class="admin-user-name">Admin</div>
              <div class="admin-user-role">Site Owner</div>
            </div>
            <i class="bi bi-chevron-down d-none d-sm-inline" style="font-size:0.75rem;color:var(--forest-soft);"></i>
          </div>
          <ul class="dropdown-menu dropdown-menu-end mt-2">
            <li><a class="dropdown-item" href="#" id="logoutBtn"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </div>
      </header>

      <main class="admin-main">

        <!-- ===================== DASHBOARD ===================== -->
        <section class="admin-section active" id="section-dashboard">
          <div class="admin-section-head">
            <div>
              <h1>Selamat datang kembali.</h1>
              <p>Ringkasan singkat konten dan aktivitas website Aisy Bina Exports.</p>
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
              <div class="stat-card">
                <div class="stat-card-icon"><i class="bi bi-box-seam"></i></div>
                <div class="stat-card-value" id="statProducts">0</div>
                <div class="stat-card-label">Total Produk</div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="stat-card">
                <div class="stat-card-icon"><i class="bi bi-tag"></i></div>
                <div class="stat-card-value" id="statCategories">0</div>
                <div class="stat-card-label">Total Kategori</div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="stat-card">
                <div class="stat-card-icon"><i class="bi bi-envelope-open"></i></div>
                <div class="stat-card-value" id="statInquiries">0</div>
                <div class="stat-card-label">Inquiry Masuk</div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="stat-card">
                <div class="stat-card-icon"><i class="bi bi-signpost-split"></i></div>
                <div class="stat-card-value" id="statProcess">0</div>
                <div class="stat-card-label">Langkah Proses</div>
              </div>
            </div>
          </div>

          <div class="admin-card">
            <div class="admin-card-head">
              <h2>Cara pakai template ini</h2>
            </div>
            <div class="admin-table-wrap" style="padding: 1.3rem;">
              <p class="mb-2"><strong>Site Content</strong> berisi teks singleton (hero, about, footer, contact) — cukup edit lalu simpan, tidak ada tambah/hapus baris.</p>
              <p class="mb-2"><strong>Categories, Products, Export Process, Why Choose Us, About Items, Business Hours</strong> adalah data berbentuk daftar — bisa tambah, edit, dan hapus baris lewat tombol di kanan atas tiap tabel.</p>
              <p class="mb-0"><strong>Inquiries</strong> bersifat baca-saja (data kiriman form kontak), dengan opsi hapus setelah ditindaklanjuti.</p>
            </div>
          </div>
        </section>

        <!-- ===================== SITE CONTENT (singleton tabs) ===================== -->
        <section class="admin-section" id="section-site-content">
          <div class="admin-section-head">
            <div>
              <h1>Site Content</h1>
              <p>Teks yang tampil di halaman publik. Setiap tab mewakili satu tabel pengaturan (satu baris data).</p>
            </div>
          </div>

          <div class="admin-tabs">
            <button class="admin-tab-btn active" data-tab="master">Home</button>
            <button class="admin-tab-btn" data-tab="ask_us">Ask Us</button>
            <button class="admin-tab-btn" data-tab="global_reach">Global Reach</button>
            <button class="admin-tab-btn" data-tab="footer">Footer</button>
            <button class="admin-tab-btn" data-tab="contact">Contact</button>
          </div>

          <div class="admin-card" style="padding: 1.5rem;">
            <div class="admin-tab-panel active" id="tab-master"><div id="settings-master"></div></div>
            <div class="admin-tab-panel" id="tab-ask_us"><div id="settings-ask_us"></div></div>
            <div class="admin-tab-panel" id="tab-global_reach"><div id="settings-global_reach"></div></div>
            <div class="admin-tab-panel" id="tab-footer"><div id="settings-footer"></div></div>
            <div class="admin-tab-panel" id="tab-contact"><div id="settings-contact"></div></div>
          </div>
        </section>

        <!-- ===================== CATEGORIES ===================== -->
        <section class="admin-section" id="section-categories">
          <div class="admin-section-head">
            <div>
              <h1>Categories</h1>
              <p>Kategori produk yang tampil di halaman Products.</p>
            </div>
          </div>
          <div class="admin-card">
            <div class="admin-card-head">
              <h2>Daftar Kategori</h2>
              <div class="admin-head-actions">
                <div class="admin-search-box">
                  <i class="bi bi-search"></i>
                  <input type="text" class="form-control-admin admin-search-input" id="searchCategories" placeholder="Cari nama kategori...">
                </div>
                <button class="btn-admin btn-admin-forest" data-add-entity="categories"><i class="bi bi-plus-lg"></i> Tambah Kategori</button>
              </div>
            </div>
            <div class="admin-table-wrap" id="table-categories"></div>
          </div>
        </section>

        <!-- ===================== PRODUCTS ===================== -->
        <section class="admin-section" id="section-products">
          <div class="admin-section-head">
            <div>
              <h1>Products</h1>
              <p>Produk di dalam tiap kategori.</p>
            </div>
          </div>
          <div class="admin-card">
            <div class="admin-card-head">
              <h2>Daftar Produk</h2>
              <div class="admin-head-actions">
                <div class="admin-search-box">
                  <i class="bi bi-search"></i>
                  <input type="text" class="form-control-admin admin-search-input" id="searchProducts" placeholder="Cari nama produk...">
                </div>
                <button class="btn-admin btn-admin-forest" data-add-entity="products"><i class="bi bi-plus-lg"></i> Tambah Produk</button>
              </div>
            </div>
            <div class="admin-table-wrap" id="table-products"></div>
          </div>
        </section>

        <!-- ===================== EXPORT PROCESS ===================== -->
        <section class="admin-section" id="section-our_process">
          <div class="admin-section-head">
            <div>
              <h1>Export Process</h1>
              <p>Langkah-langkah proses ekspor yang tampil sebagai timeline di homepage.</p>
            </div>
          </div>
          <div class="admin-card">
            <div class="admin-card-head">
              <h2>Daftar Langkah</h2>
              <button class="btn-admin btn-admin-forest" data-add-entity="our_process"><i class="bi bi-plus-lg"></i> Tambah Langkah</button>
            </div>
            <div class="admin-table-wrap" id="table-our_process"></div>
          </div>
        </section>

        <!-- ===================== WHY CHOOSE US ===================== -->
        <section class="admin-section" id="section-choose_us">
          <div class="admin-section-head">
            <div>
              <h1>Why Choose Us</h1>
              <p>Empat alasan kenapa buyer bekerja sama dengan Aisy Bina Exports.</p>
            </div>
          </div>
          <div class="admin-card">
            <div class="admin-card-head">
              <h2>Daftar Alasan</h2>
              <button class="btn-admin btn-admin-forest" data-add-entity="choose_us"><i class="bi bi-plus-lg"></i> Tambah Alasan</button>
            </div>
            <div class="admin-table-wrap" id="table-choose_us"></div>
          </div>
        </section>

        <!-- ===================== ABOUT ITEMS ===================== -->
        <section class="admin-section" id="section-about_item">
          <div class="admin-section-head">
            <div>
              <h1>About Items</h1>
              <p>Tiga poin nilai di section "Who We Are".</p>
            </div>
          </div>
          <div class="admin-card">
            <div class="admin-card-head">
              <h2>Daftar Item</h2>
              <button class="btn-admin btn-admin-forest" data-add-entity="about_item"><i class="bi bi-plus-lg"></i> Tambah Item</button>
            </div>
            <div class="admin-table-wrap" id="table-about_item"></div>
          </div>
        </section>

        <!-- ===================== BUSINESS HOURS ===================== -->
        <section class="admin-section" id="section-business_hours">
          <div class="admin-section-head">
            <div>
              <h1>Business Hours</h1>
              <p>Jam operasional per hari, tampil di halaman Contact.</p>
            </div>
          </div>
          <div class="admin-card">
            <div class="admin-card-head">
              <h2>Jadwal</h2>
              <button class="btn-admin btn-admin-forest" data-add-entity="business_hours"><i class="bi bi-plus-lg"></i> Tambah Jadwal</button>
            </div>
            <div class="admin-table-wrap" id="table-business_hours"></div>
          </div>
        </section>

        <!-- ===================== INQUIRIES ===================== -->
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

      </main>
    </div>
  </div>

  <!-- ===================== SHARED CRUD MODAL ===================== -->
  <div class="modal fade" id="crudModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="crudModalDialog">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 id="crudModalTitle">Tambah Data</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-admin" id="crudModalBody"></div>
        <div class="modal-footer-admin d-flex justify-content-end gap-2">
          <button type="button" class="btn-admin btn-admin-outline" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn-admin btn-admin-forest" id="crudModalSave"><i class="bi bi-check2"></i> Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ===================== PRODUCT DETAIL MODAL ===================== -->
  <div class="modal fade" id="productDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content modal-content-admin">
        <div class="modal-header-admin d-flex align-items-center justify-content-between">
          <h5 id="productDetailModalTitle">Detail Produk</h5>
          <button type="button" class="btn-icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-admin" id="productDetailModalBody"></div>
        <div class="modal-footer-admin d-flex justify-content-end gap-2">
          <button type="button" class="btn-admin btn-admin-outline" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ===================== IMAGE LIGHTBOX PREVIEW ===================== -->
  <div class="image-lightbox" id="imageLightbox">
    <button type="button" class="image-lightbox-close" id="imageLightboxClose" aria-label="Close"><i class="bi bi-x-lg"></i></button>
    <img src="" alt="Preview" id="imageLightboxImg">
  </div>

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

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{asset('template/assets/js/script-admin.js')}}"></script>
</body>
</html>