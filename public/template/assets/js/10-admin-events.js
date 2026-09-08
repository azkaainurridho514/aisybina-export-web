/* ==========================================================================
 * ADMIN — EVENT BINDINGS & INITIALIZATION
 * --------------------------------------------------------------------------
 * Semua event listener halaman admin dikumpulkan di sini.
 * ========================================================================== */

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

