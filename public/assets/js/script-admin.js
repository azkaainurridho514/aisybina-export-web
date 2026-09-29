/* ==========================================================================
   Aisy Bina Exports — Login page script
   Butuh: jQuery, <meta name="csrf-token">, form #loginForm
   ========================================================================== */

$(function () {
  var $form = $("#loginForm");
  if (!$form.length) return;

  var csrf = $('meta[name="csrf-token"]').attr("content") || "";

  $.ajaxSetup({
    headers: { "X-CSRF-TOKEN": csrf },
    xhrFields: { withCredentials: true }
  });

  function errorMessage(xhr) {
    var res = xhr && xhr.responseJSON;
    var msg = res && res.message;

    if (res && res.errors) {
      var firstKey = Object.keys(res.errors)[0];
      var val = firstKey && res.errors[firstKey];
      if (val) msg = Array.isArray(val) ? val[0] : val;
    }

    if (!msg && xhr && xhr.status === 419) msg = "Session sudah kedaluwarsa, silakan muat ulang halaman.";
    return msg || "Email atau password salah.";
  }

  $("#togglePassword").on("click", function () {
    var $input = $("#loginPassword");
    var isText = $input.attr("type") === "text";
    $input.attr("type", isText ? "password" : "text");
    $(this).find("i").attr("class", isText ? "bi bi-eye" : "bi bi-eye-slash");
  });

  $form.on("submit", function (e) {
    e.preventDefault();

    var $btn = $("#loginSubmit");
    var $error = $("#loginError");

    $error.hide();
    $btn.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Signing in...');

    $.ajax({
      url: "/login",
      method: "POST",
      dataType: "json",
      headers: { "Accept": "application/json" },
      contentType: "application/json; charset=UTF-8",
      data: JSON.stringify({
        email: $("#loginEmail").val().trim(),
        password: $("#loginPassword").val(),
        _token: csrf
      })
    })
      .done(function () {
        window.location.href = window.ADMIN_PAGE_URL || "/admin";
      })
      .fail(function (xhr) {
        $error.text(errorMessage(xhr)).fadeIn();
      })
      .always(function () {
        $btn.prop("disabled", false).html("Sign In");
      });
  });
});