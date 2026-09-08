/* ==========================================================================
 * ADMIN — GENERIC CRUD RENDERER
 * --------------------------------------------------------------------------
 * Table + modal untuk entity CRUD: categories, products, our_process,
 * choose_us, about_item, dan business_hours.
 * ========================================================================== */

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
  html += '<div class="field-hint">JPG/PNG/WebP. Yang bisa di masukan.</div>';
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

function buildSiteContentFormData(entityKey, data) {
  var formData = new FormData();

  var imageFields = [
    "icon",
    "image",
    "global_reach_image",
    "global_reach_icon_item_1",
    "global_reach_icon_item_2",
    "global_reach_icon_item_3"
  ];

  Object.keys(data || {}).forEach(function (key) {
    if (imageFields.indexOf(key) !== -1) return;

    formData.append(
      key,
      data[key] == null ? "" : data[key]
    );
  });

  var files = pendingImageFiles[entityKey] || {};

  Object.keys(files).forEach(function (key) {
    var file = files[key];

    if (file instanceof File) {
      formData.append(key, file);
    }
  });

  return formData;
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

  var isFormData = crudState.entity === "products" || crudState.entity === "site-content";
  var action = crudState.id ? "update" : "create";
  var requestPayload = { id: crudState.id, data: data };

  $("#crudModalSave").prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Menyimpan...');

  var requestPromise = $.Deferred();
  if (isFormData) {
    var formDataPromise;

    if (crudState.entity === "products") {
      formDataPromise = buildProductFormData(data, galleryImages);
    } else if (crudState.entity === "site-content") {
      formDataPromise = Promise.resolve(
        buildSiteContentFormData(crudState.entity, data)
      );
    }

    formDataPromise
      .then(function (formData) {
        requestPayload.formData = formData;

        api.request(action, crudState.entity, requestPayload)
          .done(function (response) {
            requestPromise.resolve(response);
          })
          .fail(function (xhr) {
            requestPromise.reject(xhr);
          });
      })
      .catch(function (error) {
        requestPromise.reject({
          message: error.message || "Gagal menyiapkan data gambar."
        });
      });
    // buildProductFormData(data, galleryImages)
    //   .then(function (formData) {
    //     requestPayload.formData = formData;
    //     api.request(action, crudState.entity, requestPayload)
    //       .done(function (response) { requestPromise.resolve(response); })
    //       .fail(function (xhr) { requestPromise.reject(xhr); });
    //   })
    //   .catch(function (error) { requestPromise.reject({ message: error.message || "Gagal menyiapkan gambar produk." }); });
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

