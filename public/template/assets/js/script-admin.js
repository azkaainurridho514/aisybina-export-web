/* ==========================================================================
   Aisy Bina Exports — Admin script

   Laravel integration:
   - All admin reads/writes use Laravel session authentication.
   - All state-changing requests send the CSRF token from the Blade meta tag.
   - Product images are sent as multipart/form-data.
   - Products, categories, and inquiries support server-side pagination/filtering.
   ========================================================================== */

/* ============================================================================
   1. LARAVEL API CONFIGURATION
   ============================================================================ */

var ADMIN_API_BASE = window.ADMIN_API_BASE || "/admin";

var API_ROUTES = {
  dashboard: ADMIN_API_BASE + "/dashboard",
  categories: ADMIN_API_BASE + "/categories",
  products: ADMIN_API_BASE + "/products",
  our_process: ADMIN_API_BASE + "/our-process",
  choose_us: ADMIN_API_BASE + "/choose-us",
  about_item: ADMIN_API_BASE + "/about-items",
  business_hours: ADMIN_API_BASE + "/business-hours",
  inquiry_forms: ADMIN_API_BASE + "/inquiries",
  login: "/login"
};

var SITE_CONTENT_TABLES = ["master", "ask_us", "global_reach", "footer", "contact"];

/* Cached categories are only used for the Product category dropdown.
 * Product list/detail data itself comes directly from Laravel. */
var categoryCache = [];

var Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 2200,
  timerProgressBar: true
});

function toastSuccess(msg) { Toast.fire({ icon: "success", title: msg }); }
function toastError(msg) { Toast.fire({ icon: "error", title: msg || "Terjadi kesalahan." }); }

function normalizeError(xhr) {
  var response = xhr && xhr.responseJSON;
  var message = response && response.message;

  if (response && response.errors) {
    var first = Object.keys(response.errors).reduce(function (acc, key) {
      if (acc) return acc;
      var value = response.errors[key];
      return Array.isArray(value) ? value[0] : value;
    }, "");
    if (first) message = first;
  }

  if (!message && xhr && xhr.status === 419) message = "CSRF token tidak valid atau session sudah kedaluwarsa.";
  if (!message && xhr && xhr.status === 401) message = "Session login tidak valid.";
  if (!message && xhr && xhr.status === 403) message = "Anda tidak memiliki akses.";
  if (!message && xhr && xhr.status === 404) message = "Endpoint atau data tidak ditemukan.";
  return { message: message || (xhr && xhr.statusText) || "Terjadi kesalahan pada server." };
}

/* Real Laravel AJAX wrapper. All admin requests use the current session
 * cookie and the CSRF token rendered by admin.blade.php. */
var api = {
  request: function (action, entity, payload) {
    payload = payload || {};

    var url = API_ROUTES[entity];
    if (entity === "logout") url = "/logout";
    if (SITE_CONTENT_TABLES.indexOf(entity) !== -1) {
      url = ADMIN_API_BASE + "/site-content/" + encodeURIComponent(entity);
    }

    if (action === "get" && payload.id) url += "/" + encodeURIComponent(payload.id);
    if (action === "update" && payload.id) url += "/" + encodeURIComponent(payload.id);
    if (action === "delete" && payload.id) url += "/" + encodeURIComponent(payload.id);

    var method = "GET";
    if (action === "create") method = "POST";
    if (action === "update") method = "PUT";
    if (action === "delete") method = "DELETE";

    var ajaxOptions = {
      url: url,
      method: method,
      dataType: "json",
      headers: {
        "Accept": "application/json"
      }
    };

    if (action === "list") {
      ajaxOptions.data = payload.params || {};
    } else if (action === "get") {
      // GET detail has no body.
    } else if (action === "delete") {
      // CSRF is sent globally through $.ajaxSetup below.
    } else if (payload.formData) {
      if (action === "update") {
        payload.formData.append("_method", "PUT");
        ajaxOptions.method = "POST";
      }
      ajaxOptions.data = payload.formData;
      ajaxOptions.processData = false;
      ajaxOptions.contentType = false;
    } else {
      ajaxOptions.data = payload.data || {};
      ajaxOptions.contentType = "application/json; charset=UTF-8";
      ajaxOptions.processData = false;
      ajaxOptions.data = JSON.stringify(ajaxOptions.data);
    }

    return $.ajax(ajaxOptions).fail(function (xhr) {
      var error = normalizeError(xhr);
      xhr.message = error.message;
    });
  }
};

$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content") || ""
  },
  xhrFields: { withCredentials: true }
});

function normalizeListResponse(response) {
  if (Array.isArray(response)) {
    return {
      rows: response,
      current_page: 1,
      last_page: 1,
      per_page: response.length || 10,
      total: response.length,
      from: response.length ? 1 : 0,
      to: response.length
    };
  }

  return {
    rows: Array.isArray(response && response.data) ? response.data : [],
    current_page: Number(response && response.current_page) || 1,
    last_page: Number(response && response.last_page) || 1,
    per_page: Number(response && response.per_page) || 10,
    total: Number(response && response.total) || 0,
    from: Number(response && response.from) || 0,
    to: Number(response && response.to) || 0
  };
}

function responseData(response) {
  return response && response.data !== undefined ? response.data : response;
}

function confirmDelete(label) {
  return Swal.fire({
    title: "Hapus data ini?",
    text: label ? '"' + label + '" akan dihapus permanen.' : "Data akan dihapus permanen.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Ya, hapus",
    cancelButtonText: "Batal",
    confirmButtonColor: "#a3402f",
    cancelButtonColor: "#52685c",
    reverseButtons: true
  }).then(function (res) { return res.isConfirmed; });
}

/* ==========================================================================
   2. TOAST / ALERT HELPERS
   ========================================================================== */

var ENTITIES = {
  categories: {
    label: "Kategori",
    labelPlural: "Kategori",
    icon: "bi-tag",
    columns: [
      { key: "name", label: "Nama" },
      { key: "description", label: "Deskripsi", truncate: true }
    ],
    fields: [
      { key: "name", label: "Nama Kategori", type: "text", required: true },
      { key: "description", label: "Deskripsi", type: "textarea" }
    ]
  },

  products: {
    label: "Produk",
    labelPlural: "Produk",
    icon: "bi-box-seam",
    columns: [
      { key: "image", label: "Foto", render: function (row) {
         var image = row.images && row.images.length
          ? productImageUrl(row.images[0].path)
          : productImageUrl(row.image);
          return image
            ? '<div class="admin-thumb"><img src="' + escapeHtml(image) + '" alt="" /></div>'
            : '<div class="admin-thumb"><i class="bi bi-box-seam"></i></div>';
        } },
      { key: "name", label: "Nama" },
      { key: "category_id", label: "Kategori", render: function (row) {
          var cat = row.category || categoryCache.find(function (c) { return c.id === row.category_id; });
          return cat ? cat.name : "—";
        } },
      { key: "description", label: "Deskripsi", truncate: true }
    ],
    fields: [
      { key: "images", label: "Foto Produk", type: "gallery" },
      { key: "name", label: "Nama Produk", type: "text", required: true },
      { key: "category_id", label: "Kategori", type: "select", required: true,
        options: function () { return categoryCache.map(function (c) { return { value: c.id, label: c.name }; }); } },
      { key: "description", label: "Deskripsi", type: "textarea" }
    ],
    hasDetail: true,
    note: "Foto pertama otomatis menjadi foto utama (cover) yang tampil di tabel dan halaman publik."
  },

  our_process: {
    label: "Langkah Proses",
    labelPlural: "Proses Ekspor",
    icon: "bi-signpost-split",
    columns: [{ key: "title", label: "Judul Langkah" }],
    fields: [{ key: "title", label: "Judul Langkah", type: "text", required: true }]
  },

  choose_us: {
    label: "Alasan",
    labelPlural: "Why Choose Us",
    icon: "bi-star",
    columns: [
      { key: "icon", label: "Icon", render: function (row) { return '<i class="bi ' + row.icon + '"></i>'; } },
      { key: "title", label: "Judul" },
      { key: "description", label: "Deskripsi", truncate: true }
    ],
    fields: [
      { key: "icon", label: "Icon", type: "icon-picker", required: true },
      { key: "title", label: "Judul", type: "text", required: true },
      { key: "description", label: "Deskripsi", type: "textarea" }
    ]
  },

  about_item: {
    label: "Item",
    labelPlural: "About Items",
    icon: "bi-people",
    columns: [
      { key: "icon", label: "Icon", render: function (row) { return '<i class="bi ' + row.icon + '"></i>'; } },
      { key: "title", label: "Judul" },
      { key: "description", label: "Deskripsi", truncate: true }
    ],
    fields: [
      { key: "icon", label: "Icon", type: "icon-picker", required: true },
      { key: "title", label: "Judul", type: "text", required: true },
      { key: "description", label: "Deskripsi", type: "textarea" }
    ]
  },

  business_hours: {
    label: "Jadwal",
    labelPlural: "Jam Operasional",
    icon: "bi-clock",
    columns: [
      { key: "day", label: "Hari" },
      { key: "start_time", label: "Jam Buka" },
      { key: "end_time", label: "Jam Tutup" }
    ],
    fields: [
      { key: "day", label: "Hari", type: "text", required: true, placeholder: "contoh: Monday" },
      { key: "start_time", label: "Jam Buka", type: "time", required: true },
      { key: "end_time", label: "Jam Tutup", type: "time", required: true }
    ]
  },

  inquiry_forms: {
    label: "Inquiry",
    labelPlural: "Inquiries",
    icon: "bi-envelope-open",
    readOnly: true,
    canDelete: true,
    columns: [
      { key: "created_at", label: "Tanggal" },
      { key: "fullname", label: "Nama" },
      { key: "company_name", label: "Perusahaan" },
      { key: "product_interested", label: "Produk" },
      { key: "country", label: "Negara" }
    ],
    fields: [
      { key: "created_at", label: "Tanggal", type: "text", readOnly: true },
      { key: "fullname", label: "Nama Lengkap", type: "text", readOnly: true },
      { key: "company_name", label: "Perusahaan", type: "text", readOnly: true },
      { key: "email", label: "Email", type: "text", readOnly: true },
      { key: "whatsapp", label: "WhatsApp", type: "text", readOnly: true },
      { key: "country", label: "Negara", type: "text", readOnly: true },
      { key: "product_interested", label: "Produk Diminati", type: "text", readOnly: true },
      { key: "estimated_quantity", label: "Estimasi Qty", type: "text", readOnly: true },
      { key: "message", label: "Pesan", type: "textarea", readOnly: true }
    ]
  }
};

/* ==========================================================================
   5. GENERIC CRUD RENDERER — table + modal, driven by ENTITIES config
   ========================================================================== */

/**
 * Per-table list params (search text, filters). Kept in one place so it's
 * obvious which keys later become `GET /entity?...` query parameters.
 */
var TableState = {
  products: { search: "", page: 1, per_page: 10 },
  categories: { search: "", page: 1, per_page: 10 },
  inquiry_forms: { person_name: "", company_name: "", country: "", start_date: "", end_date: "", page: 1, per_page: 10 }
};

function loadingRowsHtml() {
  return '<div class="admin-loading"><i class="bi bi-arrow-repeat spin"></i> Memuat data...</div>';
}
function emptyRowsHtml(cfg, message) {
  return '<div class="admin-empty"><i class="bi ' + cfg.icon + '"></i><p class="mb-0">' +
    escapeHtml(message || ("Belum ada data " + cfg.labelPlural.toLowerCase() + ".")) + "</p></div>";
}
function errorRowsHtml(message) {
  return '<div class="admin-empty admin-error"><i class="bi bi-exclamation-triangle"></i><p class="mb-0">' +
    escapeHtml(message || "Gagal memuat data.") + "</p></div>";
}

function renderPagination(meta, entityKey) {
  if (!meta || meta.last_page <= 1) return "";

  var html = '<div class="admin-pagination">';
  html += '<div class="admin-pagination-info">Menampilkan ' + meta.from + "–" + meta.to + " dari " + meta.total + " data</div>";
  html += '<div class="admin-pagination-buttons">';

  var prevDisabled = meta.current_page <= 1 ? "disabled" : "";
  html += '<button type="button" class="btn-icon" data-page-entity="' + entityKey + '" data-page="' + (meta.current_page - 1) + '" ' + prevDisabled + ' title="Sebelumnya"><i class="bi bi-chevron-left"></i></button>';

  var startPage = Math.max(1, meta.current_page - 2);
  var endPage = Math.min(meta.last_page, startPage + 4);
  startPage = Math.max(1, endPage - 4);

  for (var page = startPage; page <= endPage; page++) {
    html += '<button type="button" class="btn-icon admin-page-number ' + (page === meta.current_page ? "active" : "") + '" data-page-entity="' + entityKey + '" data-page="' + page + '">' + page + "</button>";
  }

  var nextDisabled = meta.current_page >= meta.last_page ? "disabled" : "";
  html += '<button type="button" class="btn-icon" data-page-entity="' + entityKey + '" data-page="' + (meta.current_page + 1) + '" ' + nextDisabled + ' title="Berikutnya"><i class="bi bi-chevron-right"></i></button>';
  html += "</div></div>";
  return html;
}

function renderTable(entityKey) {
  if (entityKey === "inquiry_forms") { renderInquiryTable(); return; }

  var cfg = ENTITIES[entityKey];
  var $wrap = $("#table-" + entityKey);
  if (!$wrap.length) return;

  $wrap.html(loadingRowsHtml());
  var params = TableState[entityKey] || {};

  api.request("list", entityKey, { params: params }).done(function (response) {
    var meta = normalizeListResponse(response);
    var rows = meta.rows;

    if (!rows.length) {
      $wrap.html(emptyRowsHtml(cfg, params.search ? "Tidak ada hasil untuk pencarian ini." : null));
      return;
    }

    var thead = "<tr>" + cfg.columns.map(function (c) { return "<th>" + c.label + "</th>"; }).join("") +
      '<th style="text-align:right;">Aksi</th></tr>';

    var tbody = rows.map(function (row) {
      var cells = cfg.columns.map(function (c) {
        var val = c.render ? c.render(row) : escapeHtml(String(row[c.key] || "—"));
        if (c.truncate && !c.render) val = escapeHtml(truncate(String(row[c.key] || ""), 60));
        return "<td>" + val + "</td>";
      }).join("");

      var actions = '<div class="admin-table-actions">';
      if (cfg.hasDetail) {
        actions += '<button class="btn-icon" data-action="detail" data-entity="' + entityKey + '" data-id="' + row.id + '" title="Lihat Detail"><i class="bi bi-eye"></i></button>';
      }
      actions += '<button class="btn-icon" data-action="' + (cfg.readOnly ? "view" : "edit") + '" data-entity="' + entityKey + '" data-id="' + row.id + '" title="' + (cfg.readOnly ? "Lihat" : "Edit") + '"><i class="bi ' + (cfg.readOnly ? "bi-eye" : "bi-pencil") + '"></i></button>';
      if (!cfg.readOnly || cfg.canDelete) {
        actions += '<button class="btn-icon danger" data-action="delete" data-entity="' + entityKey + '" data-id="' + row.id + '" title="Hapus"><i class="bi bi-trash3"></i></button>';
      }
      actions += "</div>";

      return "<tr>" + cells + "<td>" + actions + "</td></tr>";
    }).join("");

    $wrap.html('<table class="admin-table"><thead>' + thead + "</thead><tbody>" + tbody + "</tbody></table>" + renderPagination(meta, entityKey));
  }).fail(function (xhr) {
    $wrap.html(errorRowsHtml(xhr && xhr.message));
  });
}

/* ---- form field builders ------------------------------------------------- */

function fieldElId(prefix, stateKey, key) {
  return prefix + "_" + stateKey + "_" + key;
}

function buildFormFields(cfg, data, stateKey) {
  stateKey = stateKey || "default";
  data = data || {};

  return cfg.fields.map(function (f) {
    var value = data[f.key] !== undefined ? data[f.key] : "";

    if (f.type === "image") return buildImageField(f, value, stateKey);
    if (f.type === "gallery") return buildGalleryField(f, stateKey);
    if (f.type === "icon-picker") return buildIconPickerField(f, value, stateKey);
    if (f.type === "asset-select") return buildAssetSelectField(f, value, stateKey);

    var disabledAttr = f.readOnly ? "disabled" : "";
    var requiredAttr = f.required ? "required" : "";
    var html = '<div class="field-group"><label class="field-label">' + f.label + (f.required ? " *" : "") + "</label>";

    if (f.type === "textarea") {
      html += '<textarea class="form-control-admin" data-field="' + f.key + '" rows="3" ' + disabledAttr + " " + requiredAttr + ' placeholder="' + (f.placeholder || "") + '">' + escapeHtml(value) + "</textarea>";
    } else if (f.type === "select") {
      var opts = (typeof f.options === "function" ? f.options() : f.options) || [];
      html += '<select class="form-select-admin" data-field="' + f.key + '" ' + disabledAttr + " " + requiredAttr + ">";
      html += '<option value="">Pilih...</option>';
      html += opts.map(function (o) {
        return '<option value="' + o.value + '" ' + (String(o.value) === String(value) ? "selected" : "") + ">" + escapeHtml(o.label) + "</option>";
      }).join("");
      html += "</select>";
    } else {
      html += '<input type="' + (f.type || "text") + '" class="form-control-admin" data-field="' + f.key + '" value="' + escapeHtml(value) + '" placeholder="' + (f.placeholder || "") + '" ' + disabledAttr + " " + requiredAttr + " />";
    }

    html += "</div>";
    return html;
  }).join("");
}

/** File upload field: hidden input keeps `data-field` (so the existing
 *  collectFormData()/[data-field] loop still works untouched) while the
 *  real File object lives in `pendingImageFiles` for future multipart send.
 */
function buildImageField(f, value, stateKey) {
  var previewId = fieldElId("imgprev", stateKey, f.key);
  var html = '<div class="field-group">';
  html += '<label class="field-label">' + f.label + (f.required ? " *" : "") + "</label>";
  html += '<div class="image-upload-box">';
  html += '<div class="image-upload-preview" id="' + previewId + '">';
  html += value ? '<img src="' + value + '" alt="preview" />' : '<i class="bi bi-image"></i>';
  html += "</div>";
  html += '<div class="image-upload-controls">';
  html += '<label class="btn-admin btn-admin-outline btn-image-upload-label">';
  html += '<i class="bi bi-upload"></i> ' + (value ? "Ganti Gambar" : "Pilih Gambar");
  html += '<input type="file" accept="image/*" class="image-upload-input" data-image-target="' + f.key + '" data-state-key="' + stateKey + '" data-preview-target="' + previewId + '" hidden />';
  html += "</label>";
  html += '<div class="field-hint">JPG/PNG/WebP. Dikirim sebagai multipart/form-data saat terhubung ke Backend.</div>';
  html += "</div></div>";
  html += '<input type="hidden" data-field="' + f.key + '" value="' + escapeHtml(value) + '" />';
  html += "</div>";
  return html;
}

/** Multi-photo gallery field: renders current pendingGalleryImages[stateKey]
 *  as removable thumbnails + an "add" tile. Used by Products (Add/Edit).
 *  The actual File objects are kept in pendingGalleryImages so they're
 *  ready for a future multipart/form-data send; only object URLs are
 *  shown here for preview. */
function buildGalleryField(f, stateKey) {
  var html = '<div class="field-group">';
  html += '<label class="field-label">' + f.label + (f.required ? " *" : "") + "</label>";
  html += '<div class="gallery-grid" id="' + fieldElId("gallery", stateKey, f.key) + '" data-gallery-key="' + f.key + '" data-state-key="' + stateKey + '"></div>';
  html += '<div class="field-hint">Bisa unggah lebih dari satu foto. Foto pertama otomatis jadi foto utama (cover). Klik foto untuk pratinjau, klik &times; untuk hapus.</div>';
  html += "</div>";
  return html;
}

/** Re-renders the thumbnail grid for one gallery field from
 *  pendingGalleryImages[stateKey] — called on modal open and after every
 *  add/remove so the DOM always reflects current in-memory state. */
function renderGalleryThumbs(stateKey, fieldKey) {
  var $grid = $("#" + fieldElId("gallery", stateKey, fieldKey));
  if (!$grid.length) return;

  var images = (pendingGalleryImages[stateKey] && pendingGalleryImages[stateKey][fieldKey]) || [];

  var html = images.map(function (img, idx) {
    return '<div class="gallery-thumb">' +
      '<img src="' + img.path + '" alt="Foto produk" class="gallery-thumb-img" data-lightbox-src="' + img.path + '" />' +
      (idx === 0 ? '<div class="gallery-thumb-cover-badge">Cover</div>' : "") +
      '<button type="button" class="gallery-remove-btn" data-state-key="' + stateKey + '" data-field-key="' + fieldKey + '" data-index="' + idx + '" title="Hapus foto"><i class="bi bi-x"></i></button>' +
      "</div>";
  }).join("");

  html += '<label class="gallery-add-btn" title="Tambah foto">' +
    '<i class="bi bi-plus-lg"></i>' +
    '<input type="file" accept="image/*" multiple class="gallery-upload-input" data-state-key="' + stateKey + '" data-field-key="' + fieldKey + '" hidden />' +
    "</label>";

  $grid.html(html);
}

function buildIconPickerField(f, value, stateKey) {
  var previewId = fieldElId("iconprev", stateKey, f.key);
  var html = '<div class="field-group">';
  html += '<label class="field-label">' + f.label + (f.required ? " *" : "") + "</label>";
  html += '<div class="icon-picker-row">';
  html += '<select class="form-select-admin icon-picker-select" data-field="' + f.key + '" data-preview-target="' + previewId + '" ' + (f.required ? "required" : "") + ">";
  html += '<option value="">Pilih Icon...</option>';
  html += BOOTSTRAP_ICON_OPTIONS.map(function (o) {
    return '<option value="' + o.value + '" ' + (o.value === value ? "selected" : "") + ">" + escapeHtml(o.label) + "</option>";
  }).join("");
  html += "</select>";
  html += '<div class="icon-picker-preview" id="' + previewId + '">' +
    (value ? '<i class="bi ' + value + '"></i>' : '<i class="bi bi-question-circle" style="opacity:.3;"></i>') + "</div>";
  html += "</div></div>";
  return html;
}

function buildAssetSelectField(f, value, stateKey) {
  var previewId = fieldElId("assetprev", stateKey, f.key);
  var opts = ASSET_LIBRARY[f.assetGroup] || [];
  var html = '<div class="field-group">';
  html += '<label class="field-label">' + f.label + (f.required ? " *" : "") + "</label>";
  html += '<div class="icon-picker-row">';
  html += '<select class="form-select-admin asset-picker-select" data-field="' + f.key + '" data-preview-target="' + previewId + '" ' + (f.required ? "required" : "") + ">";
  html += '<option value="">Pilih...</option>';
  html += opts.map(function (o) {
    return '<option value="' + o.value + '" ' + (o.value === value ? "selected" : "") + ">" + escapeHtml(o.label) + "</option>";
  }).join("");
  html += "</select>";
  html += '<div class="asset-picker-preview" id="' + previewId + '">' +
    (value ? '<img src="' + value + '" alt="preview" />' : '<i class="bi bi-image" style="opacity:.3;"></i>') + "</div>";
  html += "</div></div>";
  return html;
}

/* ---- CRUD modal ------------------------------------------------------------ */

var crudModalEl = document.getElementById("crudModal");
var crudModal = crudModalEl ? new bootstrap.Modal(crudModalEl) : null;
var crudState = { entity: null, id: null };

/** stateKey -> { fieldKey: File } — cleared each time a modal/form opens. */
var pendingImageFiles = {};

/** stateKey -> { fieldKey: [{ path, file, productImageId }] } — in-memory
 *  gallery state for multi-photo fields (Products), cleared/reseeded each
 *  time openCrudModal runs. `productImageId` is set for images that already
 *  exist in the server response (kept so existing photos can be displayed);
 *  it's absent for newly-added files that don't have a row yet. */
var pendingGalleryImages = {};

function openCrudModal(entityKey, id) {
  var cfg = ENTITIES[entityKey];
  crudState = { entity: entityKey, id: id || null };
  pendingImageFiles.crud = {};
  pendingGalleryImages.crud = {};

  $("#crudModalDialog").toggleClass("modal-lg", entityKey === "products");
  $("#crudModalTitle").text((id ? (cfg.readOnly ? "Detail " : "Edit ") : "Tambah ") + cfg.label);
  $("#crudModalSave").toggle(!cfg.readOnly);
  $("#crudModalBody").html(loadingRowsHtml());
  crudModal.show();

  if (id) {
    api.request("get", entityKey, { id: id }).done(function (row) {
      seedGalleryFields(cfg, row, "crud");
      $("#crudModalBody").html(buildFormFields(cfg, row, "crud"));
      renderSeededGalleryThumbs(cfg, "crud");
    }).fail(function (err) {
      toastError(err.message);
      crudModal.hide();
    });
  } else {
    seedGalleryFields(cfg, {}, "crud");
    $("#crudModalBody").html(buildFormFields(cfg, {}, "crud"));
    renderSeededGalleryThumbs(cfg, "crud");
  }
}

/** Populates pendingGalleryImages[stateKey][fieldKey] from existing rows in
 *  the server response before the form is built, so buildGalleryField/
 *  renderGalleryThumbs have data to render immediately. No-op for entities
 *  without a "gallery" field. */
function seedGalleryFields(cfg, row, stateKey) {
    pendingGalleryImages[stateKey] = pendingGalleryImages[stateKey] || {};

    cfg.fields.forEach(function (f) {
        if (f.type !== "gallery") return;

        var existing = row && row.images ? row.images : [];

        pendingGalleryImages[stateKey][f.key] = existing
            .filter(function (pi) {
                return pi && pi.path;
            })
            .map(function (pi) {
                return {
                    path: productImageUrl(pi.path),
                    productImageId: pi.id,
                    existing: true
                };
            });
    });
}
/** Renders the thumbnail grid for every gallery field in this form — call
 *  once right after buildFormFields has put the (empty) grid containers
 *  into the DOM. */
function renderSeededGalleryThumbs(cfg, stateKey) {
  cfg.fields.forEach(function (f) {
    if (f.type === "gallery") renderGalleryThumbs(stateKey, f.key);
  });
}

function collectFormData() {
  var data = {};
  $("#crudModalBody [data-field]").each(function () {
    data[$(this).data("field")] = $(this).val();
  });
  return data;
}

function buildProductFormData(data, galleryImages) {
  var formData = new FormData();
  Object.keys(data).forEach(function (key) {
    if (key === "images" || key === "image") return;
    formData.append(key, data[key] == null ? "" : data[key]);
  });

  /* The Laravel ProductController replaces the product gallery when images
   * are uploaded. Therefore, when editing we re-upload the existing images
   * that the admin kept, plus any newly selected files. This makes the UI
   * behave as expected: removed/replaced images disappear, while untouched
   * images stay in the gallery. */
  var existingImages = galleryImages.filter(function (img) { return img.existing && img.path; });
  var newImages = galleryImages.filter(function (img) { return !!img.file; });

  var tasks = existingImages.map(function (img) {
    return fetch(img.path, { credentials: "same-origin" })
      .then(function (response) {
        if (!response.ok) throw new Error("Gagal membaca gambar lama.");
        return response.blob();
      })
      .then(function (blob) {
        var filename = "product-image-" + (img.productImageId || Date.now()) + "." + ((blob.type || "image/jpeg").split("/")[1] || "jpg");
        formData.append("images[]", new File([blob], filename, { type: blob.type || "image/jpeg" }));
      });
  });

  newImages.forEach(function (img) {
    formData.append("images[]", img.file);
  });

  return Promise.all(tasks).then(function () { return formData; });
}

function saveCrud() {
  var cfg = ENTITIES[crudState.entity];
  var data = collectFormData();

  var missing = cfg.fields.filter(function (f) { return f.required && f.type !== "gallery" && !data[f.key]; });
  if (missing.length) {
    toastError("Mohon lengkapi: " + missing.map(function (f) { return f.label; }).join(", "));
    return;
  }

  var galleryField = cfg.fields.find(function (f) { return f.type === "gallery"; });
  var galleryImages = [];

  if (galleryField) {
    galleryImages = (pendingGalleryImages.crud && pendingGalleryImages.crud[galleryField.key]) || [];
    if (galleryField.required && !galleryImages.length) {
      toastError("Mohon tambahkan minimal satu " + galleryField.label.toLowerCase() + ".");
      return;
    }
  }

  var isProduct = crudState.entity === "products";
  var action = crudState.id ? "update" : "create";
  var requestPayload = { id: crudState.id, data: data };

  $("#crudModalSave").prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Menyimpan...');

  var requestPromise = $.Deferred();
  if (isProduct) {
    buildProductFormData(data, galleryImages)
      .then(function (formData) {
        requestPayload.formData = formData;
        api.request(action, crudState.entity, requestPayload)
          .done(function (response) { requestPromise.resolve(response); })
          .fail(function (xhr) { requestPromise.reject(xhr); });
      })
      .catch(function (error) { requestPromise.reject({ message: error.message || "Gagal menyiapkan gambar produk." }); });
  } else {
    api.request(action, crudState.entity, requestPayload)
      .done(function (response) { requestPromise.resolve(response); })
      .fail(function (xhr) { requestPromise.reject(xhr); });
  }

  requestPromise
    .done(function () {
      toastSuccess(crudState.id ? "Data berhasil diperbarui." : "Data berhasil ditambahkan.");
      crudModal.hide();
      TableState[crudState.entity] = TableState[crudState.entity] || {};
      TableState[crudState.entity].page = 1;
      renderTable(crudState.entity);
      if (crudState.entity === "categories") loadCategoryCache();
      renderDashboardStats();
    })
    .fail(function (xhr) { toastError(xhr && xhr.message); })
    .always(function () { $("#crudModalSave").prop("disabled", false).html('<i class="bi bi-check2"></i> Simpan'); });
}

function deleteCrud(entityKey, id, label) {
  confirmDelete(label).then(function (ok) {
    if (!ok) return;
    api.request("delete", entityKey, { id: id })
      .done(function () {
        toastSuccess("Data berhasil dihapus.");
        if (TableState[entityKey]) {
          var state = TableState[entityKey];
          if (state.page > 1) state.page = state.page;
        }
        renderTable(entityKey);
        if (entityKey === "categories") loadCategoryCache();
        renderDashboardStats();
      })
      .fail(function (xhr) { toastError(xhr && xhr.message); });
  });
}

/* ==========================================================================
   5b. PRODUCT DETAIL MODAL — read-only view: full info + photo carousel
   with click-to-preview lightbox. Reads straight from the Laravel product detail response so
   it always reflects whatever was last saved in the Add/Edit gallery.
   ========================================================================== */

var productDetailModalEl = document.getElementById("productDetailModal");
var productDetailModal = productDetailModalEl ? new bootstrap.Modal(productDetailModalEl) : null;

function openProductDetailModal(id) {
  if (!productDetailModal) return;
  $("#productDetailModalTitle").text("Detail Produk");
  $("#productDetailModalBody").html(loadingRowsHtml());
  productDetailModal.show();

  api.request("get", "products", { id: id }).done(function (row) {
    var category = row.category || categoryCache.find(function (c) { return c.id === row.category_id; });
    var images = (row.images || []).filter(function (pi) { return pi && pi.image; }).map(function (pi) {
      return { id: pi.id, product_id: pi.product_id, path: productImageUrl(pi.image) };
    });

    $("#productDetailModalTitle").text(row.name);
    $("#productDetailModalBody").html(buildProductDetailHtml(row, category, images));
  }).fail(function (err) {
    $("#productDetailModalBody").html(errorRowsHtml(err && err.message));
  });
}

function buildProductDetailHtml(row, category, images) {
  var html = "";

  // ---- photo carousel ----
  if (images.length) {
    var carouselId = "productDetailCarousel";
    html += '<div class="product-detail-carousel">';
    html += '<div id="' + carouselId + '" class="carousel slide" data-bs-ride="false">';

    if (images.length > 1) {
      html += '<div class="carousel-indicators">';
      html += images.map(function (img, idx) {
        return '<button type="button" data-bs-target="#' + carouselId + '" data-bs-slide-to="' + idx + '" ' + (idx === 0 ? 'class="active" aria-current="true"' : "") + '></button>';
      }).join("");
      html += "</div>";
    }

    html += '<div class="carousel-inner">';
    html += images.map(function (img, idx) {
      return '<div class="carousel-item' + (idx === 0 ? " active" : "") + '">' +
        '<img src="' + img.path + '" alt="' + escapeHtml(row.name) + '" data-lightbox-src="' + img.path + '" />' +
        "</div>";
    }).join("");
    html += "</div>";

    if (images.length > 1) {
      html += '<button class="carousel-control-prev" type="button" data-bs-target="#' + carouselId + '" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>';
      html += '<button class="carousel-control-next" type="button" data-bs-target="#' + carouselId + '" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>';
    }

    html += "</div></div>";

    if (images.length > 1) {
      html += '<div class="product-detail-thumbstrip">';
      html += images.map(function (img, idx) {
        return '<img src="' + img.path + '" alt="" class="' + (idx === 0 ? "active" : "") + '" data-bs-target="#' + carouselId + '" data-bs-slide-to="' + idx + '" />';
      }).join("");
      html += "</div>";
    }
  } else {
    html += '<div class="product-detail-carousel"><div class="product-detail-carousel-empty"><i class="bi bi-image"></i></div></div>';
  }

  // ---- info ----
  html += '<div class="product-detail-info"><dl>';
  html += "<dt>Nama Produk</dt><dd>" + escapeHtml(row.name || "—") + "</dd>";
  html += "<dt>Kategori</dt><dd>" + (category ? '<span class="product-detail-badge">' + escapeHtml(category.name) + "</span>" : "—") + "</dd>";
  html += "<dt>Deskripsi</dt><dd>" + escapeHtml(row.description || "—").replace(/\n/g, "<br>") + "</dd>";
  html += "<dt>Jumlah Foto</dt><dd>" + images.length + " foto</dd>";
  html += "</dl></div>";

  return html;
}

/* ==========================================================================
   5c. INQUIRIES — custom table (search + date filter + export)
   ========================================================================== */

function renderInquiryTable() {
  var cfg = ENTITIES.inquiry_forms;
  var $wrap = $("#table-inquiry_forms");
  if (!$wrap.length) return;

  $wrap.html(loadingRowsHtml());

  api.request("list", "inquiry_forms", { params: TableState.inquiry_forms }).done(function (response) {
    var meta = normalizeListResponse(response);
    var rows = meta.rows;

    if (!rows.length) {
      $wrap.html(emptyRowsHtml(cfg, "Tidak ada inquiry yang cocok dengan filter ini."));
      return;
    }

    var thead = "<tr><th>Tanggal</th><th>Nama</th><th>Perusahaan</th><th>Produk</th><th>Negara</th>" +
      '<th style="text-align:right;">Aksi</th></tr>';

    var tbody = rows.map(function (row) {
      var actions = '<div class="admin-table-actions">' +
        '<button class="btn-icon" data-action="view" data-entity="inquiry_forms" data-id="' + row.id + '" title="Lihat"><i class="bi bi-eye"></i></button>' +
        '<button class="btn-icon danger" data-action="delete" data-entity="inquiry_forms" data-id="' + row.id + '" title="Hapus"><i class="bi bi-trash3"></i></button>' +
        "</div>";

      return "<tr>" +
        "<td>" + escapeHtml(formatDate(row.created_at)) + "</td>" +
        "<td>" + escapeHtml(row.fullname) + "</td>" +
        "<td>" + escapeHtml(row.company_name) + "</td>" +
        "<td>" + escapeHtml(row.product_interested) + "</td>" +
        "<td>" + escapeHtml(row.country) + "</td>" +
        "<td>" + actions + "</td>" +
        "</tr>";
    }).join("");

    $wrap.html('<table class="admin-table"><thead>' + thead + "</thead><tbody>" + tbody + "</tbody></table>" + renderPagination(meta, "inquiry_forms"));
  }).fail(function (xhr) {
    $wrap.html(errorRowsHtml(xhr && xhr.message));
  });
}

function applyInquiryFilters() {
  TableState.inquiry_forms = {
    person_name: $("#filterPersonName").val().trim(),
    company_name: $("#filterCompanyName").val().trim(),
    country: $("#filterCountry").val().trim(),
    start_date: $("#filterStartDate").val(),
    end_date: $("#filterEndDate").val(),
    page: 1,
    per_page: 10
  };
  renderInquiryTable();
}

function resetInquiryFilters() {
  $("#filterPersonName, #filterCompanyName, #filterCountry, #filterStartDate, #filterEndDate").val("");
  TableState.inquiry_forms = { person_name: "", company_name: "", country: "", start_date: "", end_date: "", page: 1, per_page: 10 };
  renderInquiryTable();
}

/* ---- Export to Excel ------------------------------------------------------- */

var exportModalEl = document.getElementById("exportModal");
var exportModal = exportModalEl ? new bootstrap.Modal(exportModalEl) : null;

function computeExportRange(period) {
  var today = new Date();
  var fmt = function (d) { return d.toISOString().slice(0, 10); };

  if (period === "today") return { start_date: fmt(today), end_date: fmt(today) };
  if (period === "7days") { var d1 = new Date(today); d1.setDate(d1.getDate() - 6); return { start_date: fmt(d1), end_date: fmt(today) }; }
  if (period === "1month") { var d2 = new Date(today); d2.setMonth(d2.getMonth() - 1); return { start_date: fmt(d2), end_date: fmt(today) }; }
  if (period === "3months") { var d3 = new Date(today); d3.setMonth(d3.getMonth() - 3); return { start_date: fmt(d3), end_date: fmt(today) }; }
  return { start_date: null, end_date: null }; // "all"
}

function downloadInquiriesAsExcel(rows) {
  var sheetData = rows.map(function (r) {
    return {
      Tanggal: r.created_at,
      Nama: r.fullname,
      Perusahaan: r.company_name,
      Email: r.email,
      WhatsApp: r.whatsapp,
      Negara: r.country,
      "Produk Diminati": r.product_interested,
      "Estimasi Qty": r.estimated_quantity,
      Pesan: r.message
    };
  });
  var ws = XLSX.utils.json_to_sheet(sheetData);
  var wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Inquiries");
  XLSX.writeFile(wb, "inquiries-export-" + new Date().toISOString().slice(0, 10) + ".xlsx");
}

function runInquiryExport() {
  var period = $("#exportPeriod").val();
  var params = {};

  if (period === "custom") {
    var start = $("#exportStartDate").val();
    var end = $("#exportEndDate").val();
    if (!start) {
      $("#exportStatus").html('<div class="export-alert export-alert-error"><i class="bi bi-exclamation-triangle"></i> Pilih Start Date terlebih dahulu.</div>');
      return;
    }
    params.start_date = start;
    if (end) params.end_date = end;
  } else {
    var range = computeExportRange(period);
    if (range.start_date) params.start_date = range.start_date;
    if (range.end_date) params.end_date = range.end_date;
  }

  var $btn = $("#exportSubmitBtn");
  $btn.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Mengekspor...');
  $("#exportStatus").html('<div class="export-alert export-alert-loading"><i class="bi bi-arrow-repeat spin"></i> Menyiapkan data...</div>');

  DataLayer.exportInquiries(params)
    .done(function (rows) {
      if (!rows.length) {
        $("#exportStatus").html('<div class="export-alert export-alert-error"><i class="bi bi-info-circle"></i> Tidak ada data pada periode ini.</div>');
        return;
      }
      try {
        downloadInquiriesAsExcel(rows);
        $("#exportStatus").html('<div class="export-alert export-alert-success"><i class="bi bi-check2-circle"></i> ' + rows.length + " data berhasil diekspor.</div>");
        toastSuccess("File Excel berhasil diunduh.");
      } catch (e) {
        $("#exportStatus").html('<div class="export-alert export-alert-error"><i class="bi bi-exclamation-triangle"></i> Gagal membuat file Excel.</div>');
      }
    })
    .fail(function (xhr) {
      $("#exportStatus").html('<div class="export-alert export-alert-error"><i class="bi bi-exclamation-triangle"></i> ' + escapeHtml((xhr && xhr.message) || "Export gagal.") + "</div>");
    })
    .always(function () {
      $btn.prop("disabled", false).html('<i class="bi bi-download"></i> Export');
    });
}

/* ==========================================================================
   6. SETTINGS FORMS (singleton tables: master, ask_us, global_reach,
   footer, contact) — plain read/update forms, no modal needed.
   ========================================================================== */

var SETTINGS_FORMS = {
  master: [
    { key: "website_name", label: "Nama Website", type: "text" },
    { key: "website_description", label: "Deskripsi Website", type: "textarea" },
    { key: "icon", label: "Icon / Logo", type: "asset-select", assetGroup: "logo" },
    { key: "heading", label: "Heading Hero", type: "text" },
    { key: "image", label: "Path Gambar Hero", type: "text" },
    { key: "about_heading", label: "Heading Section About", type: "text" },
    { key: "about_description", label: "Deskripsi Section About", type: "textarea" },
    { key: "category_heading", label: "Heading Section Kategori", type: "text" },
    { key: "category_description", label: "Deskripsi Section Kategori", type: "textarea" },
    { key: "choose_us_heading", label: "Heading Why Choose Us", type: "text" },
    { key: "our_process", label: "Heading Our Process", type: "text" }
  ],
  ask_us: [
    { key: "ask_us_title", label: "Label Kecil", type: "text" },
    { key: "ask_us_heading", label: "Heading", type: "text" },
    { key: "ask_us_description", label: "Deskripsi", type: "textarea" },
    { key: "ask_us_button", label: "Teks Tombol", type: "text" }
  ],
  global_reach: [
    { key: "global_reach_title", label: "Label Kecil", type: "text" },
    { key: "global_reach_description", label: "Deskripsi", type: "textarea" },
    { key: "global_reach_image", label: "Path Gambar Utama", type: "text" },
    { key: "global_reach_item_1", label: "Item 1 — Teks", type: "text" },
    { key: "global_reach_icon_item_1", label: "Item 1 — Icon/Gambar", type: "asset-select", assetGroup: "item-icon" },
    { key: "global_reach_item_2", label: "Item 2 — Teks", type: "text" },
    { key: "global_reach_icon_item_2", label: "Item 2 — Icon/Gambar", type: "asset-select", assetGroup: "item-icon" },
    { key: "global_reach_item_3", label: "Item 3 — Teks", type: "text" },
    { key: "global_reach_icon_item_3", label: "Item 3 — Icon/Gambar", type: "asset-select", assetGroup: "item-icon" }
  ],
  footer: [
    { key: "footer_home_heading", label: "Home — Heading CTA", type: "text" },
    { key: "footer_home_subheading", label: "Home — Subheading CTA", type: "textarea" },
    { key: "footer_home_button", label: "Home — Teks Tombol", type: "text" },
    { key: "footer_product_heading", label: "Products — Heading CTA", type: "text" },
    { key: "footer_product_subheading", label: "Products — Subheading CTA", type: "textarea" },
    { key: "footer_product_button", label: "Products — Teks Tombol", type: "text" }
  ],
  contact: [
    { key: "product_heading", label: "Heading Halaman Product", type: "text" },
    { key: "product_subheading", label: "Subheading Halaman Product", type: "textarea" },
    { key: "heading", label: "Heading Halaman Contact", type: "text" },
    { key: "subheading", label: "Subheading Halaman Contact", type: "textarea" },
    { key: "email", label: "Email", type: "text" },
    { key: "whatsapp", label: "Nomor WhatsApp", type: "text" },
    { key: "location", label: "Lokasi", type: "text" },
    { key: "instagram", label: "Link Instagram", type: "text" },
    { key: "facebook", label: "Link Facebook", type: "text" },
    { key: "tiktok", label: "Link TikTok", type: "text" },
    { key: "youtube", label: "Link YouTube", type: "text" }
  ]
};

function renderSettingsForm(entityKey) {
  var $wrap = $("#settings-" + entityKey);
  if (!$wrap.length) return;

  pendingImageFiles[entityKey] = {};
  $wrap.html(loadingRowsHtml());

  api.request("get", entityKey).done(function (data) {
    $wrap.html(
      '<div class="settings-form">' +
        buildFormFields({ fields: SETTINGS_FORMS[entityKey] }, data, entityKey) +
        '<div class="settings-form-actions"><button type="button" class="btn-admin btn-admin-forest" data-save-settings="' + entityKey + '"><i class="bi bi-check2"></i> Simpan Perubahan</button></div>' +
      "</div>"
    );
  }).fail(function (err) {
    $wrap.html(errorRowsHtml(err && err.message));
  });
}

function saveSettings(entityKey) {
  var $wrap = $("#settings-" + entityKey);
  var data = {};
  $wrap.find("[data-field]").each(function () { data[$(this).data("field")] = $(this).val(); });

  var $btn = $wrap.find("[data-save-settings]");
  $btn.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Menyimpan...');

  DataLayer.updateSiteContent(entityKey, data)
    .done(function () { toastSuccess("Pengaturan berhasil disimpan."); })
    .fail(function (xhr) { toastError(xhr && xhr.message); })
    .always(function () { $btn.prop("disabled", false).html('<i class="bi bi-check2"></i> Simpan Perubahan'); });
}

/* ==========================================================================
   7. DATA LAYER — named handlers matching the future Laravel endpoints.
   These are thin wrappers around api.request(). When the backend is ready,
   only api.request()'s body needs to change to a real $.ajax call — nothing
   here or in the screens that call these functions needs to change.
   ========================================================================== */

var DataLayer = {
  getProducts: function (params) { return api.request("list", "products", { params: params }); },
  getProductDetail: function (id) { return api.request("get", "products", { id: id }); },
  createProduct: function (formData) { return api.request("create", "products", { formData: formData }); },
  updateProduct: function (id, formData) { return api.request("update", "products", { id: id, formData: formData }); },
  deleteProduct: function (id) { return api.request("delete", "products", { id: id }); },

  getCategories: function (params) { return api.request("list", "categories", { params: params }); },

  getInquiries: function (params) { return api.request("list", "inquiry_forms", { params: params }); },
  getInquiryDetail: function (id) { return api.request("get", "inquiry_forms", { id: id }); },
  deleteInquiry: function (id) { return api.request("delete", "inquiry_forms", { id: id }); },

  updateSiteContent: function (table, data) { return api.request("update", table, { data: data }); },

  exportInquiries: function (params) {
    var deferred = $.Deferred();
    var rows = [];
    var page = 1;
    var perPage = 100;

    function loadPage() {
      var requestParams = $.extend({}, params || {}, { page: page, per_page: perPage });
      api.request("list", "inquiry_forms", { params: requestParams })
        .done(function (response) {
          var meta = normalizeListResponse(response);
          rows = rows.concat(meta.rows);
          if (meta.last_page > page) {
            page++;
            loadPage();
          } else {
            deferred.resolve(rows);
          }
        })
        .fail(function (xhr) { deferred.reject(xhr); });
    }

    loadPage();
    return deferred.promise();
  }
};

function loadCategoryCache() {
  return api.request("list", "categories", { params: { per_page: 100, page: 1 } })
    .done(function (response) {
      var meta = normalizeListResponse(response);
      categoryCache = meta.rows.slice();
    });
}

/* ==========================================================================
   8. DASHBOARD STATS
   ========================================================================== */

function renderDashboardStats() {
  api.request("get", "dashboard").done(function (data) {
    $("#statProducts").text(Number(data.products) || 0);
    $("#statCategories").text(Number(data.categories) || 0);
    $("#statInquiries").text(Number(data.inquiries) || 0);
    $("#statProcess").text(Number(data.process) || 0);
  }).fail(function () {
    $("#statProducts, #statCategories, #statInquiries, #statProcess").text("—");
  });
}

/* ==========================================================================
   9. HELPERS
   ========================================================================== */

function productImageUrl(path) {
  if (!path) return "";
  if (/^(https?:)?\/\//i.test(path) || path.indexOf("data:") === 0 || path.indexOf("blob:") === 0) return path;
  if (path.charAt(0) === "/") return path;
  if (path.indexOf("storage/") === 0) return "/" + path;
  return "/storage/" + path.replace(/^\/+/, "");
}

function formatDate(value) {
  if (!value) return "—";
  var d = new Date(value);
  if (isNaN(d.getTime())) return value;
  return d.toLocaleString("id-ID", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit"
  });
}

function escapeHtml(str) {
  return String(str == null ? "" : str).replace(/[&<>"']/g, function (m) {
    return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[m];
  });
}

function truncate(str, len) { return str.length > len ? str.slice(0, len) + "…" : str; }

/** Full-size click-to-preview overlay, shared by the product gallery
 *  upload thumbnails and the product detail carousel/thumbstrip. */
function openLightbox(src) {
  if (!src) return;
  $("#imageLightboxImg").attr("src", src);
  $("#imageLightbox").addClass("show");
}
function closeLightbox() {
  $("#imageLightbox").removeClass("show");
  $("#imageLightboxImg").attr("src", "");
}

/* ==========================================================================
   10. NAVIGATION (sidebar section switching + Site Content sub-tabs)
   ========================================================================== */

function showSection(sectionKey) {
  $(".admin-section").removeClass("active");
  $("#section-" + sectionKey).addClass("active");
  $(".admin-nav-link").removeClass("active");
  $('.admin-nav-link[data-section="' + sectionKey + '"]').addClass("active");
  $("#adminPageTitle").text($('.admin-nav-link[data-section="' + sectionKey + '"]').data("title") || "Dashboard");

  // lazy-render the section's data the first time it's opened
  if (sectionKey === "dashboard") renderDashboardStats();
  if (ENTITIES[sectionKey]) renderTable(sectionKey);
  if (sectionKey === "site-content") {
    var activeTab = $(".admin-tab-btn.active").data("tab") || "master";
    renderSettingsForm(activeTab);
  }

  $(".admin-sidebar").removeClass("open");
  $(".admin-sidebar-backdrop").removeClass("show");
}

/* ==========================================================================
   11. INIT (admin.html only — guarded so this file can be shared safely)
   ========================================================================== */

$(function () {
  if (!$(".admin-shell").length) return; // not on admin.html

  // Dashboard is loaded immediately; other sections are lazy-loaded when opened.
  renderDashboardStats();
  loadCategoryCache();

  // sidebar navigation
  $(".admin-nav-link").on("click", function () {
    showSection($(this).data("section"));
  });

  // site-content sub-tabs
  $(".admin-tab-btn").on("click", function () {
    var tab = $(this).data("tab");
    $(".admin-tab-btn").removeClass("active");
    $(this).addClass("active");
    $(".admin-tab-panel").removeClass("active");
    $("#tab-" + tab).addClass("active");
    renderSettingsForm(tab);
  });

  // open add modal
  $("[data-add-entity]").on("click", function () {
    openCrudModal($(this).data("add-entity"), null);
  });

  // table row actions (event delegation, since rows are re-rendered)
  $(document).on("click", "[data-action]", function () {
    var action = $(this).data("action");
    var entity = $(this).data("entity");
    var id = String($(this).data("id"));

    if (action === "detail") {
      openProductDetailModal(id);
    } else if (action === "edit" || action === "view") {
      openCrudModal(entity, id);
    } else if (action === "delete") {
      var label = "";
      deleteCrud(entity, id, label);
    }
  });

  $("#crudModalSave").on("click", saveCrud);

  // settings save buttons (event delegation, rendered dynamically)
  $(document).on("click", "[data-save-settings]", function () {
    saveSettings($(this).data("save-settings"));
  });

  // ---- image upload preview (products, hero, global reach main image) ----
  $(document).on("change", ".image-upload-input", function () {
    var file = this.files && this.files[0];
    if (!file) return;

    var targetKey = $(this).data("image-target");
    var stateKey = $(this).data("state-key");
    var previewTargetId = $(this).data("preview-target");
    var url = URL.createObjectURL(file);

    pendingImageFiles[stateKey] = pendingImageFiles[stateKey] || {};
    pendingImageFiles[stateKey][targetKey] = file; // kept for future multipart/form-data send

    $("#" + previewTargetId).html('<img src="' + url + '" alt="preview" />');
    $(this).closest(".image-upload-box").find('input[type="hidden"][data-field="' + targetKey + '"]').val(url);
  });

  // ---- gallery upload (Products — add one or more photos) ----
  $(document).on("change", ".gallery-upload-input", function () {
    var files = this.files;
    if (!files || !files.length) return;

    var stateKey = $(this).data("state-key");
    var fieldKey = $(this).data("field-key");
    pendingGalleryImages[stateKey] = pendingGalleryImages[stateKey] || {};
    pendingGalleryImages[stateKey][fieldKey] = pendingGalleryImages[stateKey][fieldKey] || [];

    Array.prototype.forEach.call(files, function (file) {
      pendingGalleryImages[stateKey][fieldKey].push({ path: URL.createObjectURL(file), file: file });
    });

    renderGalleryThumbs(stateKey, fieldKey);
  });

  // ---- gallery remove photo ----
  $(document).on("click", ".gallery-remove-btn", function () {
    var stateKey = $(this).data("state-key");
    var fieldKey = $(this).data("field-key");
    var index = $(this).data("index");
    if (pendingGalleryImages[stateKey] && pendingGalleryImages[stateKey][fieldKey]) {
      pendingGalleryImages[stateKey][fieldKey].splice(index, 1);
    }
    renderGalleryThumbs(stateKey, fieldKey);
  });

  // ---- click any photo (gallery thumb, detail carousel, detail thumbstrip) to preview ----
  $(document).on("click", "[data-lightbox-src]", function () {
    openLightbox($(this).data("lightbox-src"));
  });
  $(document).on("slid.bs.carousel", "#productDetailCarousel", function (e) {
    $(this).closest(".modal-body-admin").find(".product-detail-thumbstrip img")
      .removeClass("active").eq(e.to).addClass("active");
  });
  $("#imageLightboxClose, #imageLightbox").on("click", function (e) {
    if (e.target === this || $(e.target).closest("#imageLightboxClose").length) closeLightbox();
  });
  $(document).on("keydown", function (e) {
    if (e.key === "Escape") closeLightbox();
  });

  // ---- icon picker live preview (Why Choose Us / About Items) ----
  $(document).on("change", ".icon-picker-select", function () {
    var val = $(this).val();
    var previewTargetId = $(this).data("preview-target");
    $("#" + previewTargetId).html(val ? '<i class="bi ' + val + '"></i>' : '<i class="bi bi-question-circle" style="opacity:.3;"></i>');
  });

  // ---- asset picker live preview (Home icon/logo, Global Reach items) ----
  $(document).on("change", ".asset-picker-select", function () {
    var val = $(this).val();
    var previewTargetId = $(this).data("preview-target");
    $("#" + previewTargetId).html(val ? '<img src="' + val + '" alt="preview" />' : '<i class="bi bi-image" style="opacity:.3;"></i>');
  });

  // ---- product / category search ----
  $("#searchProducts").on("input", function () {
    TableState.products.search = $(this).val().trim();
    TableState.products.page = 1;
    renderTable("products");
  });
  $("#searchCategories").on("input", function () {
    TableState.categories.search = $(this).val().trim();
    TableState.categories.page = 1;
    renderTable("categories");
  });

  // server-side pagination
  $(document).on("click", "[data-page-entity]", function () {
    if ($(this).prop("disabled")) return;
    var entity = $(this).data("page-entity");
    var page = Number($(this).data("page"));
    if (!TableState[entity] || !page || page < 1) return;
    TableState[entity].page = page;
    renderTable(entity);
  });

  // ---- inquiry filters ----
  $("#applyInquiryFilter").on("click", applyInquiryFilters);
  $("#resetInquiryFilter").on("click", resetInquiryFilters);

  // ---- export to excel ----
  $("#exportInquiryBtn").on("click", function () {
    $("#exportStatus").empty();
    $("#exportPeriod").val("all");
    $("#exportCustomDateFields").hide();
    $("#exportStartDate, #exportEndDate").val("");
    if (exportModal) exportModal.show();
  });
  $("#exportPeriod").on("change", function () {
    $("#exportCustomDateFields").toggle($(this).val() === "custom");
  });
  $("#exportSubmitBtn").on("click", runInquiryExport);

  // mobile sidebar toggle
  $("#sidebarToggle").on("click", function () {
    $(".admin-sidebar").addClass("open");
    $(".admin-sidebar-backdrop").addClass("show");
  });
  $(".admin-sidebar-backdrop").on("click", function () {
    $(".admin-sidebar").removeClass("open");
    $(".admin-sidebar-backdrop").removeClass("show");
  });

  // logout
  $("#logoutBtn").on("click", function (e) {
    e.preventDefault();
    Swal.fire({
      title: "Keluar dari admin?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Ya, keluar",
      cancelButtonText: "Batal",
      confirmButtonColor: "#1f3b2e",
      cancelButtonColor: "#52685c"
    }).then(function (res) {
      if (res.isConfirmed) {
        api.request("create", "logout", {}).done(function () {
          window.location.href = window.ADMIN_LOGIN_URL || "/login-admin-aisybina-export";
        }).fail(function (xhr) {
          toastError(xhr && xhr.message);
        });
      }
    });
  });
});

/* ==========================================================================
   12. LOGIN PAGE LOGIC
   ========================================================================== */

$(function () {
  var $form = $("#loginForm");
  if (!$form.length) return;

  $("#togglePassword").on("click", function () {
    var $input = $("#loginPassword");
    var isText = $input.attr("type") === "text";
    $input.attr("type", isText ? "password" : "text");
    $(this).find("i").attr("class", isText ? "bi bi-eye" : "bi bi-eye-slash");
  });

  $form.on("submit", function (e) {
    e.preventDefault();

    var email = $("#loginEmail").val().trim();
    var password = $("#loginPassword").val();
    var $btn = $("#loginSubmit");
    var $error = $("#loginError");

    $error.hide();
    $btn.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Signing in...');

    api.request("create", "login", {
      data: { email: email, password: password , _token: $('meta[name="csrf-token"]').attr("content")}
    })
      .done(function () {
        window.location.href = window.ADMIN_PAGE_URL || "/admin";
      })
      .fail(function (xhr) {
        $error.text((xhr && xhr.message) || "Email atau password salah.").fadeIn();
      })
      .always(function () {
        $btn.prop("disabled", false).html("Sign In");
      });
  });
});










