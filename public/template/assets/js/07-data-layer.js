/* ==========================================================================
 * ADMIN — DATA LAYER
 * --------------------------------------------------------------------------
 * Wrapper bernama untuk akses API tiap entity.
 * ========================================================================== */

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

  updateSiteContent: function (table, formData) { return api.request("update", table, {  formData: formData }); },
  // updateSiteContent: function (table, data) { return api.request("update", table, { data: data }); },
  
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

