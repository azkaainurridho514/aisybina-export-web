/* ==========================================================================
 * ADMIN — ENTITY CONFIGURATION
 * --------------------------------------------------------------------------
 * Konfigurasi tabel/form untuk entity yang memiliki CRUD.
 * ========================================================================== */

var ENTITIES = {
  /* ------------------------------------------------------------------------
   * Categories — /admin/categories
   * ------------------------------------------------------------------------ */
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

  /* ------------------------------------------------------------------------
   * Products — /admin/products
   * ------------------------------------------------------------------------ */
  products: {
    label: "Produk",
    labelPlural: "Produk",
    icon: "bi-box-seam",
    columns: [
      {
        key: "image",
        label: "Foto",
        render: function (row) {
          var image = row.images && row.images.length
          ? productImageUrl(row.images[0].path)
          : productImageUrl(row.image);

          return image
            ? '<div class="admin-thumb"><img src="' + escapeHtml(image) + '" alt="" /></div>'
            : '<div class="admin-thumb"><i class="bi bi-box-seam"></i></div>';
        }
      },
      { key: "name", label: "Nama" },
      {
        key: "category_id",
        label: "Kategori",
        render: function (row) {
          var cat = row.category || categoryCache.find(function (c) {
            return c.id === row.category_id;
          });

          return cat ? cat.name : "—";
        }
      },
      { key: "description", label: "Deskripsi", truncate: true }
    ],
    fields: [
      { key: "images", label: "Foto Produk", type: "gallery" },
      { key: "name", label: "Nama Produk", type: "text", required: true },
      {
        key: "category_id",
        label: "Kategori",
        type: "select",
        required: true,
        options: function () {
          return categoryCache.map(function (c) {
            return { value: c.id, label: c.name };
          });
        }
      },
      { key: "description", label: "Deskripsi", type: "textarea" }
    ],
    hasDetail: true,
    note: "Foto pertama otomatis menjadi foto utama (cover) yang tampil di tabel dan halaman publik."
  },

  /* ------------------------------------------------------------------------
   * Our Process — /admin/our-process
   * Table: our_process
   * ------------------------------------------------------------------------ */
  our_process: {
    label: "Langkah Proses",
    labelPlural: "Proses Ekspor",
    icon: "bi-signpost-split",
    columns: [
      { key: "title", label: "Judul Langkah" }
    ],
    fields: [
      { key: "title", label: "Judul Langkah", type: "text", required: true }
    ]
  },

  /* ------------------------------------------------------------------------
   * Choose Us — /admin/choose-us
   * Table: choose_us
   * ------------------------------------------------------------------------ */
  choose_us: {
    label: "Alasan",
    labelPlural: "Why Choose Us",
    icon: "bi-star",
    columns: [
      {
        key: "icon",
        label: "Icon",
        render: function (row) {
          return '<i class="bi ' + escapeHtml(row.icon || "") + '"></i>';
        }
      },
      { key: "title", label: "Judul" },
      { key: "description", label: "Deskripsi", truncate: true }
    ],
    fields: [
      { key: "icon", label: "Icon", type: "icon-picker", required: true },
      { key: "title", label: "Judul", type: "text", required: true },
      { key: "description", label: "Deskripsi", type: "textarea" }
    ]
  },

  /* ------------------------------------------------------------------------
   * About Items — /admin/about-items
   * Table: about_item
   * ------------------------------------------------------------------------ */
  about_item: {
    label: "Item",
    labelPlural: "About Items",
    icon: "bi-people",
    columns: [
      {
        key: "icon",
        label: "Icon",
        render: function (row) {
          return '<i class="bi ' + escapeHtml(row.icon || "") + '"></i>';
        }
      },
      { key: "title", label: "Judul" },
      { key: "description", label: "Deskripsi", truncate: true }
    ],
    fields: [
      { key: "icon", label: "Icon", type: "icon-picker", required: true },
      { key: "title", label: "Judul", type: "text", required: true },
      { key: "description", label: "Deskripsi", type: "textarea" }
    ]
  },

  /* ------------------------------------------------------------------------
   * Business Hours — /admin/business-hours
   * Table: bussiness_hours
   * ------------------------------------------------------------------------ */
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
      {
        key: "day",
        label: "Hari",
        type: "text",
        required: true,
        placeholder: "contoh: Monday"
      },
      { key: "start_time", label: "Jam Buka", type: "time", required: true },
      { key: "end_time", label: "Jam Tutup", type: "time", required: true }
    ]
  },

  /* ------------------------------------------------------------------------
   * Inquiries — /admin/inquiries
   * Table: inquiry_forms
   * Read-only selain delete.
   * ------------------------------------------------------------------------ */
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

/* --------------------------------------------------------------------------
 * Pagination/search state
 * -------------------------------------------------------------------------- */
var TableState = {
  products: {
    search: "",
    page: 1,
    per_page: 10
  },
  categories: {
    search: "",
    page: 1,
    per_page: 10
  },
  inquiry_forms: {
    person_name: "",
    company_name: "",
    country: "",
    start_date: "",
    end_date: "",
    page: 1,
    per_page: 10
  }
};
