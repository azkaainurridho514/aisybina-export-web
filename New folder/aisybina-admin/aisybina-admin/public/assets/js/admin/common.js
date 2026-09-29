/* ==========================================================================
 * ADMIN — common.js
 * --------------------------------------------------------------------------
 * Dimuat di SEMUA halaman admin (lewat layouts/admin.blade.php).
 * Butuh: jQuery, Bootstrap, SweetAlert2, dan 13-utils.js (toast, normalizeError).
 * Berisi: setup CSRF, pembungkus request JSON, flash-toast setelah reload,
 *         sidebar mobile, dan logout.
 * ========================================================================== */

(function ($) {
  "use strict";

  var csrf = $('meta[name="csrf-token"]').attr("content") || "";
  $.ajaxSetup({ headers: { "X-CSRF-TOKEN": csrf } });

  /**
   * Request JSON ke server. Mengembalikan jqXHR; pada .fail, xhr.message
   * berisi pesan yang sudah dirapikan (validasi Laravel, 419, 404, dst).
   */
  window.adminRequest = function (method, url, data) {
    var options = {
      url: url,
      method: method,
      dataType: "json",
      headers: { Accept: "application/json" }
    };

    if (data !== undefined) {
      options.data = JSON.stringify(data);
      options.contentType = "application/json; charset=UTF-8";
      options.processData = false;
    }

    return $.ajax(options).fail(function (xhr) {
      xhr.message = normalizeError(xhr).message;
    });
  };

  /**
   * Simpan pesan lalu muat ulang halaman; toast tampil setelah halaman baru
   * terbuka. Isi `url` untuk pindah halaman (mis. kembali ke halaman 1),
   * kosongkan untuk memuat ulang URL yang sama (search & halaman terjaga).
   */
  window.adminReload = function (message, url) {
    try { sessionStorage.setItem("admin_flash", message || ""); } catch (e) { /* abaikan */ }
    if (url) { window.location.href = url; } else { window.location.reload(); }
  };

  // Session habis: arahkan ke login.
  $(document).ajaxError(function (event, xhr) {
    if (xhr.status === 401 && window.ADMIN) {
      window.location.href = window.ADMIN.loginUrl;
    }
  });

  $(function () {
    // Toast dari aksi sebelum reload.
    try {
      var flash = sessionStorage.getItem("admin_flash");
      if (flash) {
        sessionStorage.removeItem("admin_flash");
        toastSuccess(flash);
      }
    } catch (e) { /* abaikan */ }

    // Sidebar di layar kecil.
    $("#sidebarToggle").on("click", function () {
      $(".admin-sidebar").addClass("open");
      $(".admin-sidebar-backdrop").addClass("show");
    });
    $(".admin-sidebar-backdrop").on("click", function () {
      $(".admin-sidebar").removeClass("open");
      $(".admin-sidebar-backdrop").removeClass("show");
    });

    // Logout.
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
        if (!res.isConfirmed) return;

        adminRequest("POST", window.ADMIN.logoutUrl, {})
          .done(function () { window.location.href = window.ADMIN.loginUrl; })
          .fail(function (xhr) {
            // 200 = server membalas non-JSON (logout tetap berhasil); 419 = session sudah habis.
            if (xhr.status === 200 || xhr.status === 419) {
              window.location.href = window.ADMIN.loginUrl;
            } else {
              toastError(xhr.message);
            }
          });
      });
    });
  });
})(jQuery);
