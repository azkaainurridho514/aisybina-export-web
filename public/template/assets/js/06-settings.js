/* ==========================================================================
 * ADMIN — SITE CONTENT SETTINGS
 * --------------------------------------------------------------------------
 * Form singleton untuk master, ask_us, global_reach, footer, contact.
 * Route: /admin/site-content/{table}.
 * ========================================================================== */

/* ==========================================================================
   6. SETTINGS FORMS (singleton tables: master, ask_us, global_reach,
   footer, contact) — plain read/update forms, no modal needed.
   ========================================================================== */

var SETTINGS_FORMS = {
  master: [
    { key: "website_name", label: "Nama Website", type: "text" },
    { key: "website_description", label: "Deskripsi Website", type: "textarea" },
    { key: "website_slug", label: "Website Slug", type: "text" },
    { key: "icon", label: "Logo Website", type: "image"},
    { key: "heading", label: "Heading", type: "textarea" },
    { key: "image", label: "Gambar Heading", type: "image" },
    { key: "about_heading", label: "Heading Section About", type: "text" },
    { key: "about_description", label: "Deskripsi Section About", type: "textarea" },
    { key: "category_heading", label: "Heading Section Product", type: "text" },
    { key: "category_description", label: "Deskripsi Section Product", type: "textarea" },
    { key: "choose_us_heading", label: "Heading Why Choose Us", type: "text" },
    { key: "our_process", label: "Heading Our Process", type: "text" }
  ],
  ask_us: [
    { key: "ask_us_title", label: "Label Kecil", type: "text" },
    { key: "ask_us_heading", label: "Heading", type: "text" },
    { key: "ask_us_description", label: "Deskripsi", type: "textarea"},
    { key: "ask_us_button", label: "Teks Tombol", type: "text" }
  ],
  global_reach: [
    { key: "global_reach_title", label: "Label Kecil", type: "text" },
    { key: "global_reach_description", label: "Deskripsi", type: "textarea" },
    { key: "global_reach_image", label: "Path Gambar Utama", type: "image" },
    { key: "global_reach_item_1", label: "Item 1 — Teks", type: "text" },
    { key: "global_reach_icon_item_1", label: "Item 1 — Icon", type: "icon-picker", assetGroup: "item-icon" },
    { key: "global_reach_item_2", label: "Item 2 — Teks", type: "text" },
    { key: "global_reach_icon_item_2", label: "Item 2 — Icon", type: "icon-picker", assetGroup: "item-icon" },
    { key: "global_reach_item_3", label: "Item 3 — Teks", type: "text" },
    { key: "global_reach_icon_item_3", label: "Item 3 — Icon", type: "icon-picker", assetGroup: "item-icon" }
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

// function saveSettings(entityKey) {
//   var $wrap = $("#settings-" + entityKey);
//   var data = {};
//   $wrap.find("[data-field]").each(function () { data[$(this).data("field")] = $(this).val(); });

//   var $btn = $wrap.find("[data-save-settings]");
//   $btn.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Menyimpan...');

//   DataLayer.updateSiteContent(entityKey, data)
//     .done(function () { toastSuccess("Pengaturan berhasil disimpan."); })
//     .fail(function (xhr) { toastError(xhr && xhr.message); })
//     .always(function () { $btn.prop("disabled", false).html('<i class="bi bi-check2"></i> Simpan Perubahan'); });
// }


function saveSettings(entityKey) {
  var $wrap = $("#settings-" + entityKey);

  var data = {};

  $wrap.find("[data-field]").each(function () {
    var key = $(this).data("field");
    data[key] = $(this).val();
  });

  // WAJIB FormData
  var formData = new FormData();

  // field gambar Site Content
  var imageFields = [
    "icon",
    "image",
    "global_reach_image",
    "global_reach_icon_item_1",
    "global_reach_icon_item_2",
    "global_reach_icon_item_3"
  ];

  // Masukkan field biasa
  Object.keys(data).forEach(function (key) {
    if (imageFields.indexOf(key) !== -1) {
      return;
    }

    formData.append(
      key,
      data[key] == null ? "" : data[key]
    );
  });

  // Masukkan FILE gambar yang dipilih
  var files = pendingImageFiles[entityKey] || {};

  Object.keys(files).forEach(function (key) {
    var file = files[key];

    if (file instanceof File) {
      formData.append(key, file);
    }
  });

  var $btn = $wrap.find("[data-save-settings]");

  $btn
    .prop("disabled", true)
    .html('<i class="bi bi-arrow-repeat spin"></i> Menyimpan...');

  DataLayer.updateSiteContent(entityKey, formData)
    .done(function () {
      toastSuccess("Pengaturan berhasil disimpan.");
    })
    .fail(function (xhr) {
      toastError(
        xhr && xhr.responseJSON
          ? xhr.responseJSON.message
          : "Gagal menyimpan pengaturan."
      );
    })
    .always(function () {
      $btn
        .prop("disabled", false)
        .html('<i class="bi bi-check2"></i> Simpan Perubahan');
    });
}
