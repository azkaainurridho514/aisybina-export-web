$(function () {
  var $modalEl = $("#productModal");
  if (!$modalEl.length) return;

  var endpoint = $modalEl.data("endpoint");
  var modal = new bootstrap.Modal($modalEl[0]);
  var detailModal = new bootstrap.Modal($("#productDetailModal")[0]);
  var $title = $("#productModalTitle");
  var $name = $("#productName");
  var $category = $("#productCategory");
  var $gallery = $("#productGallery");
  var $save = $("#productSave");
  var saveLabel = '<i class="bi bi-check2"></i> Simpan';
  var editingId = null;
  var gallery = [];

  initQuillEditors();
  var quill = $("#productDescription").data("quill");

  function setDescription(html) {
    if (html) { quill.root.innerHTML = DOMPurify.sanitize(html); } else { quill.setText(""); }
  }

  function getDescription() {
    return quill.getText().trim() === "" ? "" : quill.root.innerHTML;
  }

  function imageUrl(path) {
    if (!path) return "";
    if (/^(https?:)?\/\//i.test(path) || path.indexOf("data:") === 0 || path.indexOf("blob:") === 0) return path;
    return path.charAt(0) === "/" ? path : "/" + path.replace(/^\/+/, "");
  }

  function renderGallery() {
    var html = gallery.map(function (img, i) {
      return '<div class="gallery-thumb">' +
        '<img src="' + escapeHtml(img.url) + '" alt="Foto produk" class="gallery-thumb-img" data-lightbox-src="' + escapeHtml(img.url) + '">' +
        (i === 0 ? '<div class="gallery-thumb-cover-badge">Cover</div>' : "") +
        '<button type="button" class="gallery-remove-btn" data-index="' + i + '" title="Hapus foto"><i class="bi bi-x"></i></button>' +
        "</div>";
    }).join("");

    html += '<label class="gallery-add-btn" title="Tambah foto"><i class="bi bi-plus-lg"></i>' +
      '<input type="file" accept="image/*" multiple class="gallery-upload-input" hidden></label>';

    $gallery.html(html);
  }

  $gallery.on("change", ".gallery-upload-input", function () {
    Array.prototype.forEach.call(this.files || [], function (file) {
      gallery.push({ url: URL.createObjectURL(file), file: file, id: null, existing: false });
    });
    renderGallery();
  });

  $gallery.on("click", ".gallery-remove-btn", function () {
    var removed = gallery.splice(Number($(this).attr("data-index")), 1)[0];
    if (removed && removed.file) URL.revokeObjectURL(removed.url);
    renderGallery();
  });

  $(document).on("click", "[data-lightbox-src]", function () {
    $("#imageLightboxImg").attr("src", $(this).attr("data-lightbox-src"));
    $("#imageLightbox").addClass("show");
  });

  function closeLightbox() {
    $("#imageLightbox").removeClass("show");
    $("#imageLightboxImg").attr("src", "");
  }

  $("#imageLightboxClose").on("click", closeLightbox);
  $("#imageLightbox").on("click", function (e) { if (e.target === this) closeLightbox(); });
  $(document).on("keydown", function (e) { if (e.key === "Escape") closeLightbox(); });


  function openModal(row) {
    editingId = row ? row.id : null;
    $title.text(row ? "Edit Produk" : "Tambah Produk");
    $name.val(row ? row.name : "");
    $category.val(row ? row.category_id : "");
    setDescription(row ? row.description : "");

    gallery = ((row && row.images) || [])
      .filter(function (pi) { return pi && pi.path; })
      .map(function (pi) { return { url: imageUrl(pi.path), file: null, id: pi.id, existing: true }; });

    renderGallery();
    modal.show();
  }

  $modalEl.on("shown.bs.modal", function () { $name.trigger("focus"); });

  $(document).on("click", '[data-action="create"]', function () { openModal(null); });

  $(document).on("click", '[data-action="edit"]', function () {
    var $btn = $(this).prop("disabled", true);

    adminRequest("GET", endpoint + "/" + encodeURIComponent($btn.attr("data-id")))
      .done(function (row) { openModal(row); })
      .fail(function (xhr) { toastError(xhr.message); })
      .always(function () { $btn.prop("disabled", false); });
  });
  
  function buildFormData() {
    var fd = new FormData();
    fd.append("name", $.trim($name.val()));
    fd.append("category_id", $category.val());
    fd.append("description", getDescription());

    var files = gallery.map(function (img) {
      if (img.file) return Promise.resolve(img.file);

      return fetch(img.url, { credentials: "same-origin" })
        .then(function (res) {
          if (!res.ok) throw new Error("Gagal membaca foto lama.");
          return res.blob();
        })
        .then(function (blob) {
          var type = blob.type || "image/jpeg";
          return new File([blob], "product-image-" + (img.id || Date.now()) + "." + (type.split("/")[1] || "jpg"), { type: type });
        });
    });

    return Promise.all(files).then(function (list) {
      list.forEach(function (file) { fd.append("images[]", file); });
      return fd;
    });
  }

  function save() {
    if (!$.trim($name.val())) {
      toastError("Nama produk wajib diisi.");
      $name.trigger("focus");
      return;
    }
    if (!$category.val()) {
      toastError("Kategori wajib dipilih.");
      $category.trigger("focus");
      return;
    }

    var isEdit = editingId !== null;
    var url = isEdit ? endpoint + "/" + encodeURIComponent(editingId) : endpoint;

    $save.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Menyimpan...');

    buildFormData()
      .then(function (fd) {
        return adminUpload(isEdit ? "PUT" : "POST", url, fd)
          .done(function (res) {
            adminReload(res.message || "Data berhasil disimpan.", isEdit ? null : window.location.pathname);
          });
      })
      .catch(function (err) {
        toastError((err && err.message) || "Gagal menyimpan produk.");
        $save.prop("disabled", false).html(saveLabel);
      });
  }

  $save.on("click", save);
  $name.on("keydown", function (e) {
    if (e.key === "Enter") { e.preventDefault(); save(); }
  });

  function detailHtml(row) {
    var images = (row.images || []).filter(function (pi) { return pi && pi.path; }).map(function (pi) { return imageUrl(pi.path); });
    var id = "productDetailCarousel";
    var html = "";

    if (images.length) {
      html += '<div class="product-detail-carousel"><div id="' + id + '" class="carousel slide" data-bs-ride="false">';

      if (images.length > 1) {
        html += '<div class="carousel-indicators">' + images.map(function (src, i) {
          return '<button type="button" data-bs-target="#' + id + '" data-bs-slide-to="' + i + '"' + (i === 0 ? ' class="active" aria-current="true"' : "") + "></button>";
        }).join("") + "</div>";
      }

      html += '<div class="carousel-inner">' + images.map(function (src, i) {
        return '<div class="carousel-item' + (i === 0 ? " active" : "") + '"><img src="' + escapeHtml(src) + '" alt="' + escapeHtml(row.name) + '" data-lightbox-src="' + escapeHtml(src) + '"></div>';
      }).join("") + "</div>";

      if (images.length > 1) {
        html += '<button class="carousel-control-prev" type="button" data-bs-target="#' + id + '" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>' +
          '<button class="carousel-control-next" type="button" data-bs-target="#' + id + '" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>';
      }

      html += "</div></div>";

      if (images.length > 1) {
        html += '<div class="product-detail-thumbstrip">' + images.map(function (src, i) {
          return '<img src="' + escapeHtml(src) + '" alt="" class="' + (i === 0 ? "active" : "") + '" data-bs-target="#' + id + '" data-bs-slide-to="' + i + '">';
        }).join("") + "</div>";
      }
    } else {
      html += '<div class="product-detail-carousel"><div class="product-detail-carousel-empty"><i class="bi bi-image"></i></div></div>';
    }

    var description = $("<div>").html(DOMPurify.sanitize(row.description || "")).text().trim();

    html += '<div class="product-detail-info"><dl>' +
      "<dt>Nama Produk</dt><dd>" + escapeHtml(row.name || "—") + "</dd>" +
      "<dt>Kategori</dt><dd>" + (row.category ? '<span class="product-detail-badge">' + escapeHtml(row.category.name) + "</span>" : "—") + "</dd>" +
      "<dt>Deskripsi</dt><dd>" + (description ? escapeHtml(description).replace(/\n/g, "<br>") : "—") + "</dd>" +
      "<dt>Jumlah Foto</dt><dd>" + images.length + " foto</dd>" +
      "</dl></div>";

    return html;
  }

  $(document).on("click", '[data-action="detail"]', function () {
    var $body = $("#productDetailBody");

    $("#productDetailTitle").text("Detail Produk");
    $body.html('<div class="admin-loading"><i class="bi bi-arrow-repeat spin"></i> Memuat data...</div>');
    detailModal.show();

    adminRequest("GET", endpoint + "/" + encodeURIComponent($(this).attr("data-id")))
      .done(function (row) {
        $("#productDetailTitle").text(row.name);
        $body.html(detailHtml(row));
      })
      .fail(function (xhr) {
        $body.html('<div class="admin-empty admin-error"><i class="bi bi-exclamation-triangle"></i><p class="mb-0">' + escapeHtml(xhr.message) + "</p></div>");
      });
  });

  $(document).on("click", '[data-action="delete"]', function () {
    var id = $(this).attr("data-id");

    confirmDelete($(this).attr("data-name")).then(function (ok) {
      if (!ok) return;

      adminRequest("DELETE", endpoint + "/" + encodeURIComponent(id))
        .done(function (res) { adminReload(res.message || "Data berhasil dihapus."); })
        .fail(function (xhr) { toastError(xhr.message); });
    });
  });
});
