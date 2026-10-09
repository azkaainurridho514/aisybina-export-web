(function ($) {
  "use strict";
  var SAVE_LABEL = '<i class="bi bi-check2"></i> Simpan';
  function setupIconSelects($modal) {
    var $selects = $modal.find("select[data-icons]");
    if (!$selects.length) return;

    var seen = {};
    var html = '<option value="">Pilih icon...</option>';

    (typeof BOOTSTRAP_ICON_OPTIONS !== "undefined" ? BOOTSTRAP_ICON_OPTIONS : []).forEach(function (o) {
      if (seen[o.value]) return;
      seen[o.value] = true;
      html += '<option value="' + escapeHtml(o.value) + '">' + escapeHtml(o.label) + "</option>";
    });

    $selects.html(html);

    $modal.on("change", "select[data-icons]", function () {
      $($(this).data("preview")).html('<i class="bi ' + (this.value || "bi-question-circle") + '"></i>');
    });
  }
  // NEW
  window.AdminCrud = {
    init: function (cfg) {
      $(function () {
        var $modalEl = $(cfg.modal);
        var $wrap = $(cfg.table);
        if (!$modalEl.length || !$wrap.length) return;

        var endpoint = $modalEl.data("endpoint");              
        var listUrl = cfg.listUrl || $wrap.data("list");     
        var perPage = cfg.perPage || 10;

        var modal = new bootstrap.Modal($modalEl[0]);
        var $title = $modalEl.find('[data-role="title"]');
        var $save = $modalEl.find('[data-role="save"]');
        var saveLabel = $save.html();
        var editingId = null;
        var rows = [];
        var page = 1;

        var Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 2500,
          timerProgressBar: true
        });
        function toastSuccess(msg) { Toast.fire({ icon: "success", title: msg }); }

        function esc(s) {
          return String(s == null ? "" : s)
            .replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;").replace(/'/g, "&#39;");
        }
        function plain(html, limit) {
          var t = $("<div>").html(DOMPurify.sanitize(html || "")).text().replace(/\s+/g, " ").trim();
          return limit && t.length > limit ? t.slice(0, limit) + "…" : t;
        }
        var H = { esc: esc, plain: plain };

        if ($modalEl.find(".quill-editor").length) initQuillEditors();
        setupIconSelects($modalEl);

        function totalPages() { return Math.max(1, Math.ceil(rows.length / perPage)); }

        function renderPagination() {
          var total = totalPages();
          if (total <= 1) return "";
          var html = '<nav class="mt-3"><ul class="pagination justify-content-end mb-0">';
          html += '<li class="page-item ' + (page === 1 ? "disabled" : "") + '"><a class="page-link" href="#" data-page="' + (page - 1) + '">&laquo;</a></li>';
          for (var i = 1; i <= total; i++) {
            html += '<li class="page-item ' + (i === page ? "active" : "") + '"><a class="page-link" href="#" data-page="' + i + '">' + i + "</a></li>";
          }
          html += '<li class="page-item ' + (page === total ? "disabled" : "") + '"><a class="page-link" href="#" data-page="' + (page + 1) + '">&raquo;</a></li>';
          return html + "</ul></nav>";
        }

        function render() {
          if (!rows.length) {
            var e = cfg.empty || {};
            $wrap.html(
              '<div class="admin-empty"><i class="bi ' + esc(e.icon || "bi-inbox") + '"></i>' +
              '<p class="mb-0">' + esc(e.text || "Belum ada data.") + "</p></div>"
            );
            return;
          }

          page = Math.min(Math.max(page, 1), totalPages());
          var slice = rows.slice((page - 1) * perPage, page * perPage);

          var html = '<table class="admin-table"><thead><tr>';
          cfg.columns.forEach(function (c) { html += "<th>" + esc(c.label) + "</th>"; });
          html += '<th style="text-align:right;">Aksi</th></tr></thead><tbody>';

          slice.forEach(function (row) {
            html += "<tr>";
            cfg.columns.forEach(function (c) {
              var cell = c.render ? c.render(row, H) : esc(row[c.key]) || "—";
              html += "<td>" + cell + "</td>";
            });

            var delName = cfg.deleteName ? cfg.deleteName(row, H) : (row.title || row.name || "");
            html +=
              '<td><div class="admin-table-actions">' +
              '<button type="button" class="btn-icon" data-action="edit" data-id="' + esc(row.id) + '" title="Edit"><i class="bi bi-pencil"></i></button>' +
              '<button type="button" class="btn-icon danger" data-action="delete" data-id="' + esc(row.id) + '" data-name="' + esc(delName) + '" title="Hapus"><i class="bi bi-trash3"></i></button>' +
              "</div></td></tr>";
          });

          html += "</tbody></table>" + renderPagination();
          $wrap.html(html);
        }

        function load() {
          return adminRequest("GET", listUrl)
            .done(function (res) {
              rows = Array.isArray(res) ? res : (res.data || []);
              render();
            })
            .fail(function (xhr) { toastError(xhr.message || "Gagal memuat data."); });
        }

        $wrap.html('<div class="admin-empty"><i class="bi bi-arrow-repeat spin"></i><p class="mb-0">Memuat data...</p></div>');
        load();

        $wrap.on("click", "[data-page]", function (e) {
          e.preventDefault();
          if ($(this).closest(".page-item").hasClass("disabled")) return;
          page = parseInt($(this).attr("data-page"), 10);
          render();
        });

        function $field(key) { return $modalEl.find('[data-field="' + key + '"]'); }

        function getValue(f) {
          var $el = $field(f.key);
          if ($el.hasClass("quill-editor")) {
            var quill = $el.data("quill");
            return quill.getText().trim() === "" ? "" : quill.root.innerHTML;
          }
          return $.trim($el.val());
        }

        function setValue(f, value) {
          var $el = $field(f.key);
          value = value == null ? "" : value;

          if ($el.hasClass("quill-editor")) {
            var quill = $el.data("quill");
            if (value) { quill.root.innerHTML = DOMPurify.sanitize(value); } else { quill.setText(""); }
            return;
          }

          if ($el.attr("type") === "time") value = String(value).slice(0, 5);

          if ($el.is("select") && value && !$el.find("option").filter(function () { return this.value === value; }).length) {
            $el.append(new Option(value, value));
          }
          $el.val(value).trigger("change");
        }

        function openModal(row) {
          editingId = row ? row.id : null;
          $title.text((row ? "Edit " : "Tambah ") + cfg.name);
          cfg.fields.forEach(function (f) { setValue(f, row ? row[f.key] : ""); });
          modal.show();
        }

        $modalEl.on("shown.bs.modal", function () {
          $modalEl.find("input.form-control-admin, select.form-select-admin").first().trigger("focus");
        });

        $(document).on("click", '[data-action="create"]', function () { openModal(null); });

        $wrap.on("click", '[data-action="edit"]', function () {
          var $btn = $(this).prop("disabled", true);

          adminRequest("GET", endpoint + "/" + encodeURIComponent($btn.attr("data-id")))
            .done(function (row) { openModal(row.data || row); })
            .fail(function (xhr) { toastError(xhr.message); })
            .always(function () { $btn.prop("disabled", false); });
        });

        function save() {
          var payload = {};
          var missing = [];

          cfg.fields.forEach(function (f) {
            payload[f.key] = getValue(f);
            if (f.required && !payload[f.key]) missing.push(f.label || f.key);
          });

          if (missing.length) {
            toastError("Mohon lengkapi: " + missing.join(", "));
            return;
          }

          var isEdit = editingId !== null;
          var url = isEdit ? endpoint + "/" + encodeURIComponent(editingId) : endpoint;

          $save.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Menyimpan...');

          adminRequest(isEdit ? "PUT" : "POST", url, payload)
            .done(function (res) {
              var msg = res.message || "Data berhasil disimpan.";
              modal.hide();

              load().done(function () {
                if (!isEdit && cfg.jumpToLastOnCreate) { page = totalPages(); render(); }
                toastSuccess(msg);
              });
            })
            .fail(function (xhr) { toastError(xhr.message); })
            .always(function () { $save.prop("disabled", false).html(saveLabel); });
        }

        $save.on("click", save);
        $modalEl.on("keydown", 'input[type="text"]', function (e) {
          if (e.key === "Enter") { e.preventDefault(); save(); }
        });

        // ===== AJAX DELETE =====
        $wrap.on("click", '[data-action="delete"]', function () {
          var id = $(this).attr("data-id");

          confirmDelete($(this).attr("data-name")).then(function (ok) {
            if (!ok) return;

            adminRequest("DELETE", endpoint + "/" + encodeURIComponent(id))
              .done(function (res) {
                var msg = res.message || "Data berhasil dihapus.";
                load().done(function () { toastSuccess(msg); });
              })
              .fail(function (xhr) { toastError(xhr.message); });
          });
        });
      });
    }
  };

})(jQuery);
