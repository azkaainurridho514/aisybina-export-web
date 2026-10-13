$(function () {
  var $modalEl = $("#productModal");
  var $wrap = $("#productTable");
  if (!$modalEl.length || !$wrap.length) return;

  var endpoint = $modalEl.data("endpoint");
  var listUrl = $wrap.data("list");
  var modal = new bootstrap.Modal($modalEl[0]);
  var detailModal = new bootstrap.Modal($("#productDetailModal")[0]);
  var $title = $("#productModalTitle");
  var $name = $("#productName");
  var $category = $("#productCategory");
  var $gallery = $("#productGallery");
  var $options = $("#productOptions");
  var $save = $("#productSave");
  var $search = $("#productSearch");
  var $reset = $("#productSearchReset");
  var saveLabel = '<i class="bi bi-check2"></i> Simpan';
  var editingId = null;
  var gallery = [];

  var state = { page: 1, last: 1, search: "" };
  var rows = [];
  var reqId = 0;

  // ===== Toast sukses (kanan atas) =====
  var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true
  });
  function toastSuccess(msg) { Toast.fire({ icon: "success", title: msg }); }

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

  function plain(html, limit) {
    var t = $("<div>").html(DOMPurify.sanitize(html || "")).text().replace(/\s+/g, " ").trim();
    return limit && t.length > limit ? t.slice(0, limit) + "…" : t;
  }

  // ===== Tabel (dirender dari AJAX GET) =====
  function pageItem(p, label, disabled, active) {
    return '<li class="page-item' + (disabled ? " disabled" : "") + (active ? " active" : "") +
      '"><a class="page-link" href="#" data-page="' + p + '">' + label + "</a></li>";
  }

  function renderPagination() {
    var last = state.last, cur = state.page;
    if (last <= 1) return "";

    var html = '<nav class="mt-3"><ul class="pagination justify-content-end mb-0">';
    html += pageItem(cur - 1, "&laquo;", cur === 1, false);

    var prev = 0;
    for (var i = 1; i <= last; i++) {
      if (i === 1 || i === last || Math.abs(i - cur) <= 2) {
        if (i - prev > 1) html += '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>';
        html += pageItem(i, i, false, i === cur);
        prev = i;
      }
    }

    html += pageItem(cur + 1, "&raquo;", cur === last, false);
    return html + "</ul></nav>";
  }

  function render() {
    if (!rows.length) {
      $wrap.html(
        '<div class="admin-empty"><i class="bi bi-box-seam"></i><p class="mb-0">' +
        (state.search ? "Tidak ada hasil untuk pencarian ini." : "Belum ada data produk.") +
        "</p></div>"
      );
      return;
    }

    var html = '<table class="admin-table"><thead><tr>' +
      "<th>Foto</th><th>Nama</th><th>Kategori</th><th>Deskripsi</th>" +
      '<th style="text-align:right;">Aksi</th></tr></thead><tbody>';

    rows.forEach(function (p) {
      var first = (p.images || []).filter(function (pi) { return pi && pi.path; })[0];
      var cover = first ? imageUrl(first.path) : "";
      var id = escapeHtml(p.id);

      html += "<tr>" +
        '<td><div class="admin-thumb">' +
        (cover ? '<img src="' + escapeHtml(cover) + '" alt="">' : '<i class="bi bi-box-seam"></i>') +
        "</div></td>" +
        "<td>" + escapeHtml(p.name) + "</td>" +
        "<td>" + (p.category ? escapeHtml(p.category.name) : "—") + "</td>" +
        "<td>" + (escapeHtml(plain(p.description, 60)) || "—") + "</td>" +
        '<td><div class="admin-table-actions">' +
        '<button type="button" class="btn-icon" data-action="detail" data-id="' + id + '" title="Lihat Detail"><i class="bi bi-eye"></i></button>' +
        '<button type="button" class="btn-icon" data-action="edit" data-id="' + id + '" title="Edit"><i class="bi bi-pencil"></i></button>' +
        '<button type="button" class="btn-icon danger" data-action="delete" data-id="' + id + '" data-name="' + escapeHtml(p.name) + '" title="Hapus"><i class="bi bi-trash3"></i></button>' +
        "</div></td></tr>";
    });

    $wrap.html(html + "</tbody></table>" + renderPagination());
  }

  // ===== AJAX GET: daftar produk (awal, search, pagination, setelah simpan/hapus) =====
  function load() {
    var id = ++reqId;
    var qs = $.param({ page: state.page, search: state.search });

    return adminRequest("GET", listUrl + "?" + qs)
      .done(function (res) {
        if (id !== reqId) return;
        var p = res.data || res;
        rows = p.data || [];
        state.page = p.current_page || 1;
        state.last = p.last_page || 1;
        render();
      })
      .fail(function (xhr) {
        if (id === reqId) toastError(xhr.message || "Gagal memuat data.");
      });
  }

  $wrap.html('<div class="admin-empty"><i class="bi bi-arrow-repeat spin"></i><p class="mb-0">Memuat data...</p></div>');
  load();

  $wrap.on("click", "[data-page]", function (e) {
    e.preventDefault();
    if ($(this).closest(".page-item").hasClass("disabled")) return;
    state.page = parseInt($(this).attr("data-page"), 10);
    load();
  });

  // ===== Pencarian =====
  function doSearch() {
    state.search = $.trim($search.val());
    state.page = 1;
    $reset.css("display", state.search ? "" : "none");
    load();
  }

  var searchTimer;
  $("#productSearchForm").on("submit", function (e) { e.preventDefault(); clearTimeout(searchTimer); doSearch(); });
  $search.on("input", function () { clearTimeout(searchTimer); searchTimer = setTimeout(doSearch, 400); });
  $reset.on("click", function (e) { e.preventDefault(); $search.val(""); doSearch(); });

  // ===== Galeri foto (UI sama seperti sebelumnya) =====
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

  // ===== Modal tambah / edit =====
  function openModal(row) {
    editingId = row ? row.id : null;
    $title.text(row ? "Edit Produk" : "Tambah Produk");
    $name.val(row ? row.name : "");
    $category.val(row ? row.category_id : "");
    setDescription(row ? row.description : "");
    var optionIds = ((row && row.options) || []).map(function (o) { return o.id; });
      $options.find('input[type="checkbox"]').each(function () {
        $(this).prop("checked", optionIds.indexOf(this.value) !== -1);
    });

    gallery = ((row && row.images) || [])
      .filter(function (pi) { return pi && pi.path; })
      .map(function (pi) { return { url: imageUrl(pi.path), file: null, id: pi.id, existing: true }; });

    renderGallery();
    renderOptions((row && row.options) || []);
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
    var n = 0;
    $options.find(".option-row").each(function () {
      var title = $.trim($(this).find(".option-title").val());
      if (!title) return;               // baris kosong dilewati
      var id = $(this).find(".option-id").val();
      if (id) fd.append("options[" + n + "][id]", id);
      fd.append("options[" + n + "][title]", title);
      fd.append("options[" + n + "][description]", $.trim($(this).find(".option-desc").val()));
      n++;
    });

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

  // ===== AJAX POST / PUT: simpan =====
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
            var msg = res.message || "Data berhasil disimpan.";

            if (!isEdit) {
              // sama seperti sebelumnya: tambah data kembali ke halaman 1 tanpa filter
              state.page = 1;
              state.search = "";
              $search.val("");
              $reset.css("display", "none");
            }

            modal.hide();
            $save.prop("disabled", false).html(saveLabel);
            load().done(function () { toastSuccess(msg); });
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

  function optionRow(o) {
    o = o || {};
    return '<div class="option-row d-flex gap-2 align-items-start">' +
      '<input type="hidden" class="option-id" value="' + escapeHtml(o.id || "") + '">' +
      '<div class="flex-grow-1 d-flex flex-column gap-2">' +
        '<input type="text" class="form-control-admin option-title" maxlength="255" placeholder="Judul option" value="' + escapeHtml(o.title || "") + '">' +
        '<textarea class="form-control-admin option-desc" rows="2" placeholder="Deskripsi option">' + escapeHtml(o.description || "") + "</textarea>" +
      "</div>" +
      '<button type="button" class="btn-icon danger" data-remove-option title="Hapus"><i class="bi bi-trash3"></i></button>' +
      "</div>";
  }

  function renderOptions(list) {
    $options.html((list || []).map(optionRow).join(""));
  }

  $("#productOptionAdd").on("click", function () {
    var $row = $(optionRow()).appendTo($options);
    $row.find(".option-title").trigger("focus");
  });

  $options.on("click", "[data-remove-option]", function () {
    $(this).closest(".option-row").remove();
  });

  // ===== Detail (baca saja) =====
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
    var optionList = (row.options || []).map(function (o) {
      return '<div class="product-detail-option">' +
        '<div class="fw-semibold">' + escapeHtml(o.title) + "</div>" +
        (o.description
          ? '<div class="text-muted small" style="white-space:pre-line;">' + escapeHtml(o.description) + "</div>"
          : "") +
        "</div>";
    }).join("");
    html += '<div class="product-detail-info"><dl>' +
      "<dt>Nama Produk</dt><dd>" + escapeHtml(row.name || "—") + "</dd>" +
      "<dt>Kategori</dt><dd>" + (row.category ? '<span class="product-detail-badge">' + escapeHtml(row.category.name) + "</span>" : "—") + "</dd>" +
      "<dt>Options</dt><dd>" + (optionList ? '<div class="d-flex flex-column gap-2">' + optionList + "</div>" : "—") + "</dd>" + 
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

  // ===== AJAX DELETE =====
  $(document).on("click", '[data-action="delete"]', function () {
    var id = $(this).attr("data-id");

    confirmDelete($(this).attr("data-name")).then(function (ok) {
      if (!ok) return;

      adminRequest("DELETE", endpoint + "/" + encodeURIComponent(id))
        .done(function (res) {
          var msg = res.message || "Data berhasil dihapus.";
          load().done(function () { toastSuccess(msg); });  // server otomatis mundur halaman jika kosong
        })
        .fail(function (xhr) { toastError(xhr.message); });
    });
  });
});