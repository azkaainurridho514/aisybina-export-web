/* ==========================================================================
 * ADMIN — LOGIN PAGE
 * --------------------------------------------------------------------------
 * Logic login hanya aktif ketika #loginForm tersedia.
 * ========================================================================== */

/* ==========================================================================
   12. LOGIN PAGE LOGIC
   ========================================================================== */

$(function () {
  var $form = $("#loginForm");
  if (!$form.length) return;

  $("#togglePassword").on("click", function () {
    var $input = $("#loginPassword");
    var isText = $input.attr("type") === "text";
    $input.attr("type", isText ? "password" : "text");
    $(this).find("i").attr("class", isText ? "bi bi-eye" : "bi bi-eye-slash");
  });

  $form.on("submit", function (e) {
    e.preventDefault();

    var email = $("#loginEmail").val().trim();
    var password = $("#loginPassword").val();
    var $btn = $("#loginSubmit");
    var $error = $("#loginError");

    $error.hide();
    $btn.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Signing in...');

    api.request("create", "login", {
      data: { email: email, password: password , _token: $('meta[name="csrf-token"]').attr("content")}
    })
      .done(function () {
        window.location.href = window.ADMIN_PAGE_URL || "/admin";
      })
      .fail(function (xhr) {
        $error.text((xhr && xhr.message) || "Email atau password salah.").fadeIn();
      })
      .always(function () {
        $btn.prop("disabled", false).html("Sign In");
      });
  });
});










