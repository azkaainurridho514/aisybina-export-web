STRUKTUR JS ADMIN (setelah refactor ke Blade)
=============================================

Layout: resources/views/layouts/admin.blade.php
Semua halaman admin memuat, berurutan:
  1. 13-utils.js          toast, confirmDelete, normalizeError, initQuillEditors
  2. admin/common.js      CSRF, adminRequest, adminUpload, escapeHtml, adminReload,
                          flash toast, sidebar mobile, logout
  3. (per halaman, lewat @push('scripts'))

Per halaman:
  Categories       admin/categories.js
  Products         admin/products.js
  Inquiries        admin/inquiries.js        (+ SheetJS lewat @push('vendor'))
  Site Content     admin/site-content.js
  Our Mission, Our Value, Export Process, Why Choose Us, About Items,
  Business Hours   admin/crud.js  + AdminCrud.init({...}) di view masing-masing
                   (Why Choose Us & About Items juga memuat 00-constants.js
                    untuk daftar ikon)

Halaman login masih memakai: 01-api.js, 11-login.js.

DINONAKTIFKAN (seluruh isi dikomentari, aman dihapus setelah dicek):
  02-entities.js, 03-crud.js, 04-product-detail.js, 05-inquiries.js,
  06-settings.js, 07-data-layer.js, 08-dashboard.js, 09-navigation.js,
  10-admin-events.js, 12-common.js
Sebagian dikomentari:
  00-constants.js  (ASSET_LIBRARY), 01-api.js (route entity), 13-utils.js
  (normalizeListResponse, renderQuillContent, renderQuillInline)

Tidak disentuh (halaman publik): script.js, pages/products.js
