/* ==========================================================================
 * ADMIN — categories.js
 * --------------------------------------------------------------------------
 * Hanya dimuat di halaman /admin/categories.
 * Daftar, pencarian, dan pagination dirender server (Blade). File ini hanya
 * mengurus modal tambah/ubah dan hapus lewat AJAX, lalu memuat ulang halaman.
 * ========================================================================== */

$(function () {
  var $modalEl = $("#categoryModal");
  if (!$modalEl.length) return;

  var endpoint = $modalEl.data("endpoint");
  var modal = new bootstrap.Modal($modalEl[0]);
  var $title = $("#categoryModalTitle");
  var $name = $("#categoryName");
  var $save = $("#categorySave");
  var saveLabel = '<i class="bi bi-check2"></i> Simpan';
  var editingId = null;

  // Editor deskripsi (fungsi initQuillEditors ada di 13-utils.js).
  initQuillEditors();
  var quill = $("#categoryDescription").data("quill");

  function setDescription(html) {
    if (html) {
      quill.root.innerHTML = DOMPurify.sanitize(html);
    } else {
      quill.setText("");
    }
  }

  function getDescription() {
    return quill.getText().trim() === "" ? "" : quill.root.innerHTML;
  }

  function openModal(row) {
    editingId = row ? row.id : null;
    $title.text(row ? "Edit Kategori" : "Tambah Kategori");
    $name.val(row ? row.name : "");
    setDescription(row ? row.description : "");
    modal.show();
  }

  $modalEl.on("shown.bs.modal", function () { $name.trigger("focus"); });

  // ---- Tambah ----
  $(document).on("click", '[data-action="create"]', function () {
    openModal(null);
  });

  // ---- Edit: ambil data satu kategori (JSON) lalu isi modal ----
  $(document).on("click", '[data-action="edit"]', function () {
    var $btn = $(this).prop("disabled", true);

    adminRequest("GET", endpoint + "/" + encodeURIComponent($btn.attr("data-id")))
      .done(function (row) { openModal(row); })
      .fail(function (xhr) { toastError(xhr.message); })
      .always(function () { $btn.prop("disabled", false); });
  });

  // ---- Simpan ----
  function save() {
    var name = $.trim($name.val());
    if (!name) {
      toastError("Nama kategori wajib diisi.");
      $name.trigger("focus");
      return;
    }

    var isEdit = editingId !== null;
    var url = isEdit ? endpoint + "/" + encodeURIComponent(editingId) : endpoint;

    $save.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Menyimpan...');

    adminRequest(isEdit ? "PUT" : "POST", url, { name: name, description: getDescription() })
      .done(function (res) {
        // Data baru tampil di halaman 1 (urut terbaru); ubah data tetap di halaman yang sama.
        adminReload(res.message || "Data berhasil disimpan.", isEdit ? null : window.location.pathname);
      })
      .fail(function (xhr) {
        toastError(xhr.message);
        $save.prop("disabled", false).html(saveLabel);
      });
  }

  $save.on("click", save);
  $name.on("keydown", function (e) {
    if (e.key === "Enter") { e.preventDefault(); save(); }
  });

  // ---- Hapus ----
  $(document).on("click", '[data-action="delete"]', function () {
    var id = $(this).attr("data-id");
    var label = $(this).attr("data-name");

    confirmDelete(label).then(function (ok) {
      if (!ok) return;

      adminRequest("DELETE", endpoint + "/" + encodeURIComponent(id))
        .done(function (res) { adminReload(res.message || "Data berhasil dihapus."); })
        .fail(function (xhr) { toastError(xhr.message); });
    });
  });
});
