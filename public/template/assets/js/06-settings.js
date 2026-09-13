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
    { key: "website_slug", label: "Slug Website", type: "text" },
    { key: "logo", label: "Logo Website", type: "image" },
    { key: "heading", label: "Judul Utama", type: "textarea" },
    { key: "image", label: "Gambar Judul Utama", type: "image" },
    { key: "about_heading", label: "Judul Section Tentang Kami", type: "text" },
    { key: "about_description", label: "Deskripsi Section Tentang Kami", type: "textarea" },
    { key: "category_heading", label: "Judul Section Produk", type: "text" },
    { key: "category_description", label: "Deskripsi Section Produk", type: "textarea" },
    { key: "choose_us_heading", label: "Judul Mengapa Memilih Kami", type: "text" },
    { key: "our_process", label: "Judul Proses Kami", type: "text" }
  ],

  about: [
    { key: "intro_title", label: "Judul Tentang Perusahaan", type: "text" },
    { key: "intro_description", label: "Deskripsi Tentang Perusahaan", type: "textarea" },
    { key: "image_intro", label: "Gambar Tentang Perusahaan", type: "image" },
    { key: "vision_description", label: "Deskripsi Visi", type: "textarea" },
    { key: "image_vision", label: "Gambar Visi", type: "image" },
    { key: "image_mission", label: "Gambar Misi", type: "image" },
    { key: "value_description", label: "Deskripsi Value Kami", type: "textarea" },
    { key: "image_value", label: "Gambar Value Kami", type: "image" }
  ],

  ask_us: [
    { key: "ask_us_title", label: "Label Kecil", type: "text" },
    { key: "ask_us_heading", label: "Judul", type: "text" },
    { key: "ask_us_description", label: "Deskripsi", type: "textarea" },
    { key: "ask_us_button", label: "Teks Tombol", type: "text" }
  ],

  global_reach: [
    { key: "global_reach_title", label: "Label Kecil", type: "text" },
    { key: "global_reach_description", label: "Deskripsi", type: "textarea" },
    { key: "global_reach_image", label: "Gambar Utama", type: "image" },
    { key: "global_reach_item_1", label: "Item 1 — Teks", type: "text" },
    { key: "global_reach_icon_item_1", label: "Item 1 — Ikon", type: "icon-picker", assetGroup: "item-icon" },
    { key: "global_reach_item_2", label: "Item 2 — Teks", type: "text" },
    { key: "global_reach_icon_item_2", label: "Item 2 — Ikon", type: "icon-picker", assetGroup: "item-icon" },
    { key: "global_reach_item_3", label: "Item 3 — Teks", type: "text" },
    { key: "global_reach_icon_item_3", label: "Item 3 — Ikon", type: "icon-picker", assetGroup: "item-icon" }
  ],

  footer: [
    { key: "footer_home_heading", label: "Judul Footer halaman Home", type: "text" },
    { key: "footer_home_subheading", label: "Subjudul Footer halaman Home", type: "textarea" },
    { key: "footer_home_button", label: "Teks Tombol Footer halaman Home", type: "text" },
    { key: "footer_product_heading", label: "Judul Footer Halaman Produk", type: "text" },
    { key: "footer_product_subheading", label: "Subjudul Footer Halaman Produk", type: "textarea" },
    { key: "footer_product_button", label: "Teks Tombol Footer Halaman Produk", type: "text" }
  ],

  contact: [
    { key: "product_heading", label: "Judul Halaman Produk", type: "text" },
    { key: "product_subheading", label: "Subjudul Halaman Produk", type: "textarea" },
    { key: "heading", label: "Judul Halaman Kontak", type: "text" },
    { key: "subheading", label: "Subjudul Halaman Kontak", type: "textarea" },
    { key: "email", label: "Email", type: "text" },
    { key: "whatsapp", label: "Nomor WhatsApp", type: "text" },
    { key: "location", label: "Lokasi", type: "text" },
    { key: "instagram", label: "Tautan Instagram", type: "text" },
    { key: "facebook", label: "Tautan Facebook", type: "text" },
    { key: "tiktok", label: "Tautan TikTok", type: "text" },
    { key: "youtube", label: "Tautan YouTube", type: "text" }
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
    initQuillEditors();
  }).fail(function (err) {
    $wrap.html(errorRowsHtml(err && err.message));
  });
}

function saveSettings(entityKey) {

  var $wrap = $("#settings-" + entityKey);
  var data = {};

  $wrap.find("[data-field]").each(function () {

    var key = $(this).data("field");

    if ($(this).hasClass("quill-editor")) {
      var editor = $(this).data("quill");
      data[key] = editor ? editor.root.innerHTML : "";
    } else if ($(this).is("input[type='file']")) {
      return;
    } else {
      data[key] = $(this).val();
    }

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

// function saveSettings(entityKey) {
//   var $wrap = $("#settings-" + entityKey);

//   var data = {};

//   $wrap.find("[data-field]").each(function () {
//     var key = $(this).data("field");
//     data[key] = $(this).val();
//   });

//   // WAJIB FormData
//   var formData = new FormData();

//   // field gambar Site Content
//   var imageFields = [
//     "icon",
//     "image",
//     "global_reach_image",
//     "global_reach_icon_item_1",
//     "global_reach_icon_item_2",
//     "global_reach_icon_item_3"
//   ];

//   // Masukkan field biasa
//   Object.keys(data).forEach(function (key) {
//     if (imageFields.indexOf(key) !== -1) {
//       return;
//     }

//     formData.append(
//       key,
//       data[key] == null ? "" : data[key]
//     );
//   });

//   // Masukkan FILE gambar yang dipilih
//   var files = pendingImageFiles[entityKey] || {};

//   Object.keys(files).forEach(function (key) {
//     var file = files[key];

//     if (file instanceof File) {
//       formData.append(key, file);
//     }
//   });

//   var $btn = $wrap.find("[data-save-settings]");

//   $btn
//     .prop("disabled", true)
//     .html('<i class="bi bi-arrow-repeat spin"></i> Menyimpan...');

//   DataLayer.updateSiteContent(entityKey, formData)
//     .done(function () {
//       toastSuccess("Pengaturan berhasil disimpan.");
//     })
//     .fail(function (xhr) {
//       toastError(
//         xhr && xhr.responseJSON
//           ? xhr.responseJSON.message
//           : "Gagal menyimpan pengaturan."
//       );
//     })
//     .always(function () {
//       $btn
//         .prop("disabled", false)
//         .html('<i class="bi bi-check2"></i> Simpan Perubahan');
//     });
// }
