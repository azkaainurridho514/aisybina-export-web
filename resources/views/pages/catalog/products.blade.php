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