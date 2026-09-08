/* ==========================================================================
 * ADMIN — NAVIGATION
 * --------------------------------------------------------------------------
 * Sidebar section switching dan Site Content sub-tabs.
 * ========================================================================== */

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

