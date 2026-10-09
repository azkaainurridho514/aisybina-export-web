$(function () {
  var cfg = window.SITE_CONTENT;
  var $form = $("#siteContentForm");
  if (!cfg || !$form.length) return;

  var METHOD = cfg.method || "PUT";
  var MAX_SIZE = 5 * 1024 * 1024;
  var ALLOWED = ["image/jpeg", "image/png", "image/webp"];
  var $tabs = $(".admin-tab-btn");
  var state = { tab: cfg.active };
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

  function imageUrl(path) {
    if (!path) return "";
    if (/^(https?:)?\/\//i.test(path) || path.indexOf("data:") === 0) return path;
    return path.charAt(0) === "/" ? path : "/" + path.replace(/^\/+/, "");
  }

  function updateUrl(tab) {
    return cfg.updateUrl.replace("__TAB__", encodeURIComponent(tab));
  }

  // ===== Render form (markup sama seperti Blade sebelumnya) =====
  function fieldHtml(f, value) {
    var key = f[0], label = f[1], type = f[2];
    value = value == null ? "" : String(value);
    var k = escapeHtml(key);

    var html = '<div class="field-group"><label class="field-label"' +
      (type === "text" ? ' for="sc_' + k + '"' : "") + ">" + escapeHtml(label) + "</label>";

    if (type === "textarea") {
      html += '<div class="quill-editor" data-field="' + k + '" data-value="' + escapeHtml(value) + '" style="min-height:150px;"></div>';

    } else if (type === "image") {
      var src = imageUrl(value);
      var preview;

      if (value && value.indexOf("bi-") === 0) {
        preview = '<i class="bi ' + escapeHtml(value) + '"></i>';
      } else if (src) {
        preview = '<img src="' + escapeHtml(src) + '" alt="preview">';
      } else {
        preview = '<i class="bi bi-image"></i>';
      }

      html += '<div class="image-upload-box">' +
        '<div class="image-upload-preview" id="sc_preview_' + k + '">' + preview + "</div>" +
        '<div class="image-upload-controls">' +
        '<label class="btn-admin btn-admin-outline btn-image-upload-label">' +
        '<i class="bi bi-upload"></i> ' + (value ? "Ganti Gambar" : "Pilih Gambar") +
        '<input type="file" accept="image/jpeg,image/png,image/webp" class="image-upload-input" ' +
        'data-field="' + k + '" data-preview="sc_preview_' + k + '" hidden></label>' +
        '<div class="field-hint">JPG/PNG/WebP, maksimal 5 MB.</div>' +
        "</div></div>";

    } else {
      html += '<input type="text" id="sc_' + k + '" class="form-control-admin" data-field="' + k + '" value="' + escapeHtml(value) + '">';
    }

    return html + "</div>";
  }

  function render(row) {
    var fields = cfg.tabs[state.tab].fields;

    var html = fields.map(function (f) { return fieldHtml(f, row[f[0]]); }).join("");
    html += '<div class="settings-form-actions"><button type="button" class="btn-admin btn-admin-forest" id="siteContentSave">' +
      '<i class="bi bi-check2"></i> Simpan Perubahan</button></div>';

    $form.html(html);

    initQuillEditors();
    $form.find(".quill-editor").each(function () {
      var quill = $(this).data("quill");
      var value = row[$(this).attr("data-field")];
      if (!quill) return;
      if (value) { quill.root.innerHTML = DOMPurify.sanitize(value); } else { quill.setText(""); }
    });
  }

  // ===== AJAX GET: data satu tab =====
  function load(tab) {
    var id = ++reqId;

    return adminRequest("GET", cfg.listUrl + "?" + $.param({ tab: tab }))
      .done(function (res) {
        if (id !== reqId || tab !== state.tab) return;
        var row = res && typeof res === "object" && "data" in res ? res.data : res;
        render(row || {});
      })
      .fail(function (xhr) {
        if (id !== reqId) return;
        $form.html('<div class="admin-empty admin-error"><i class="bi bi-exclamation-triangle"></i><p class="mb-0">' +
          escapeHtml(xhr.message || "Gagal memuat data.") + "</p></div>");
      });
  }

  // ===== Tab (tanpa reload) =====
  function setTab(tab, push) {
    state.tab = tab;
    $tabs.each(function () { $(this).toggleClass("active", $(this).attr("data-tab") === tab); });

    if (push) history.pushState({ tab: tab }, "", cfg.indexUrl + "?" + $.param({ tab: tab }));

    $form.html('<div class="admin-loading"><i class="bi bi-arrow-repeat spin"></i> Memuat data...</div>');
    load(tab);
  }

  $tabs.on("click", function (e) {
    if (e.metaKey || e.ctrlKey || e.shiftKey || e.which === 2) return;  // buka di tab baru tetap normal
    e.preventDefault();

    var tab = $(this).attr("data-tab");
    if (tab !== state.tab) setTab(tab, true);
  });

  window.addEventListener("popstate", function () {
    var tab = new URLSearchParams(window.location.search).get("tab");
    setTab(cfg.tabs[tab] ? tab : "master", false);
  });

  setTab(state.tab, false);

  // ===== Pilih gambar: validasi + pratinjau =====
  $form.on("change", ".image-upload-input", function () {
    var file = this.files && this.files[0];
    if (!file) return;

    if (ALLOWED.indexOf(file.type) === -1) {
      toastError("Format gambar harus JPG, PNG, atau WebP.");
      this.value = "";
      return;
    }
    if (file.size > MAX_SIZE) {
      toastError("Ukuran gambar maksimal 5 MB.");
      this.value = "";
      return;
    }

    var $preview = $("#" + $(this).attr("data-preview"));
    var reader = new FileReader();
    reader.onload = function (e) { $preview.html('<img src="' + e.target.result + '" alt="preview">'); };
    reader.readAsDataURL(file);
  });

  // ===== Kumpulkan data (hanya field milik tab aktif) =====
  function buildFormData() {
    var fd = new FormData();

    cfg.tabs[state.tab].fields.forEach(function (f) {
      var key = f[0], type = f[2];
      var $el = $form.find('[data-field="' + key + '"]');

      if (type === "image") {
        var file = $el[0] && $el[0].files && $el[0].files[0];
        if (file) fd.append(key, file);
        return;
      }

      if (type === "textarea") {
        var quill = $el.data("quill");
        fd.append(key, quill && quill.getText().trim() !== "" ? quill.root.innerHTML : "");
        return;
      }

      fd.append(key, $.trim($el.val()));
    });

    return fd;
  }

  // ===== AJAX POST/PUT: simpan, lalu GET ulang =====
  $form.on("click", "#siteContentSave", function () {
    var $btn = $(this);
    var label = $btn.html();
    var tab = state.tab;

    $btn.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Menyimpan...');

    adminUpload(METHOD, updateUrl(tab), buildFormData())
      .done(function (res) {
        var msg = res.message || "Data berhasil disimpan.";

        if (tab !== state.tab) { toastSuccess(msg); return; }   // pengguna sudah pindah tab

        load(tab).always(function () { toastSuccess(msg); });
      })
      .fail(function (xhr) {
        toastError(xhr.message);
        $btn.prop("disabled", false).html(label);
      });
  });
});