$(function () {
  var $form = $("#siteContentForm");
  if (!$form.length) return;

  var $save = $("#siteContentSave");
  var saveLabel = '<i class="bi bi-check2"></i> Simpan Perubahan';

  initQuillEditors();
  $form.find(".quill-editor").each(function () {
    var quill = $(this).data("quill");
    if (quill) quill.root.innerHTML = DOMPurify.sanitize(quill.root.innerHTML);
  });
  $form.on("change", ".image-upload-input", function () {
    var file = this.files && this.files[0];
    if (!file) return;

    $("#" + $(this).attr("data-preview")).html('<img src="' + URL.createObjectURL(file) + '" alt="preview">');
  });
  $save.on("click", function () {
    var fd = new FormData();

    $form.find("[data-field]").each(function () {
      var key = $(this).attr("data-field");

      if ($(this).hasClass("quill-editor")) {
        var quill = $(this).data("quill");
        fd.append(key, quill.getText().trim() === "" ? "" : quill.root.innerHTML);
      } else if ($(this).is('input[type="file"]')) {
        if (this.files && this.files[0]) fd.append(key, this.files[0]);
      } else {
        fd.append(key, $(this).val());
      }
    });

    $save.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Menyimpan...');

    adminUpload("PUT", $form.data("endpoint"), fd)
      .done(function (res) { toastSuccess(res.message || "Pengaturan berhasil disimpan."); })
      .fail(function (xhr) { toastError(xhr.message); })
      .always(function () { $save.prop("disabled", false).html(saveLabel); });
  });
});
