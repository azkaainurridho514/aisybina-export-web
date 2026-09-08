/* ==========================================================================
 * ADMIN — API CONFIGURATION & REQUEST CLIENT
 * --------------------------------------------------------------------------
 * Menangani seluruh komunikasi JavaScript dengan route Laravel /admin.
 * Route disesuaikan dengan routes yang diberikan:
 *   GET/POST/PUT/DELETE /admin/categories
 *   GET/POST/PUT/DELETE /admin/products
 *   GET/DELETE          /admin/inquiries
 *   GET/POST/PUT/DELETE /admin/business-hours
 *   GET/POST/PUT/DELETE /admin/our-process
 *   GET/POST/PUT/DELETE /admin/choose-us
 *   GET/POST/PUT/DELETE /admin/about-items
 *   GET/PUT             /admin/site-content/{table}
 *   GET                 /admin/dashboard
 *
 * Catatan:
 * - Auth menggunakan session Laravel.
 * - CSRF diambil dari meta tag Blade.
 * - Upload gambar produk menggunakan multipart/form-data.
 * ========================================================================== */

var ADMIN_API_BASE = window.ADMIN_API_BASE || "/admin";

/* --------------------------------------------------------------------------
 * Laravel route map
 * -------------------------------------------------------------------------- */
var API_ROUTES = {
  dashboard: ADMIN_API_BASE + "/dashboard",
  categories: ADMIN_API_BASE + "/categories",
  products: ADMIN_API_BASE + "/products",
  our_process: ADMIN_API_BASE + "/our-process",
  choose_us: ADMIN_API_BASE + "/choose-us",
  about_item: ADMIN_API_BASE + "/about-items",
  business_hours: ADMIN_API_BASE + "/business-hours",
  inquiry_forms: ADMIN_API_BASE + "/inquiries"
};

/* Singleton tables yang menggunakan route /admin/site-content/{table}. */
var SITE_CONTENT_TABLES = [
  "master",
  "ask_us",
  "global_reach",
  "footer",
  "contact"
];

/* Cache kategori hanya digunakan untuk dropdown kategori produk. */
var categoryCache = [];

/* --------------------------------------------------------------------------
 * API request wrapper
 * -------------------------------------------------------------------------- */
var api = {
  request: function (action, entity, payload) {
    payload = payload || {};

    var url = API_ROUTES[entity];

    /* Login/logout berada di luar group /admin pada routes yang diberikan. */
    if (entity === "login") url = window.ADMIN_LOGIN_URL || "/login-admin-aisybina-export";
    if (entity === "logout") url = window.ADMIN_LOGOUT_URL || "/logout";

    /* Site Content menggunakan route dinamis /admin/site-content/{table}. */
    if (SITE_CONTENT_TABLES.indexOf(entity) !== -1) {
      url = ADMIN_API_BASE + "/site-content/" + encodeURIComponent(entity);
    }

    if (action === "get" && payload.id) {
      url += "/" + encodeURIComponent(payload.id);
    }

    if (action === "update" && payload.id) {
      url += "/" + encodeURIComponent(payload.id);
    }

    if (action === "delete" && payload.id) {
      url += "/" + encodeURIComponent(payload.id);
    }

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

    /* GET list menggunakan query parameter untuk search/filter/pagination. */
    if (action === "list") {
      ajaxOptions.data = payload.params || {};
    }
    /* GET detail tidak membutuhkan body. */
    else if (action === "get") {
      // Tidak ada body.
    }
    /* DELETE dikirim tanpa body; CSRF dipasang oleh $.ajaxSetup. */
    else if (action === "delete") {
      // Tidak ada body.
    }
    /* Product create/update menggunakan multipart/form-data. */
    else if (payload.formData) {
      if (action === "update") {
        payload.formData.append("_method", "PUT");
        ajaxOptions.method = "POST";
      }

      ajaxOptions.data = payload.formData;
      ajaxOptions.processData = false;
      ajaxOptions.contentType = false;
    }
    /* Request JSON biasa untuk entity selain upload. */
    else {
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

/* --------------------------------------------------------------------------
 * Laravel CSRF + session cookie
 * -------------------------------------------------------------------------- */
$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content") || ""
  },
  xhrFields: {
    withCredentials: true
  }
});
