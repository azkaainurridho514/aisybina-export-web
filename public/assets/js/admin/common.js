(function ($) {
  "use strict";

  var csrf = $('meta[name="csrf-token"]').attr("content") || "";
  $.ajaxSetup({ headers: { "X-CSRF-TOKEN": csrf } });

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

  window.adminUpload = function (method, url, formData) {
    if (method !== "POST") { formData.append("_method", method); }

    return $.ajax({
      url: url,
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      headers: { Accept: "application/json" }
    }).fail(function (xhr) {
      xhr.message = normalizeError(xhr).message;
    });
  };

  window.escapeHtml = function (str) {
    return String(str == null ? "" : str).replace(/[&<>"']/g, function (m) {
      return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[m];
    });
  };

  window.adminReload = function (message, url) {
    try { sessionStorage.setItem("admin_flash", message || ""); } catch (e) {}
    if (url) { window.location.href = url; } else { window.location.reload(); }
  };

  $(document).ajaxError(function (event, xhr) {
    if (xhr.status === 401 && window.ADMIN) {
      window.location.href = window.ADMIN.loginUrl;
    }
  });

  $(function () {
    try {
      var flash = sessionStorage.getItem("admin_flash");
      if (flash) {
        sessionStorage.removeItem("admin_flash");
        toastSuccess(flash);
      }
    } catch (e) {  }

    $("#sidebarToggle").on("click", function () {
      $(".admin-sidebar").addClass("open");
      $(".admin-sidebar-backdrop").addClass("show");
    });
    $(".admin-sidebar-backdrop").on("click", function () {
      $(".admin-sidebar").removeClass("open");
      $(".admin-sidebar-backdrop").removeClass("show");
    });

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
