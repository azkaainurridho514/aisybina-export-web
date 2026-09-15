/* ==========================================================================
 * ADMIN — DASHBOARD
 * --------------------------------------------------------------------------
 * Mengambil statistik dari GET /admin/dashboard.
 * ========================================================================== */

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

