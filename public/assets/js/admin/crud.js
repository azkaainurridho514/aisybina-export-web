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

  window.AdminCrud = {
    init: function (cfg) {
      $(function () {
        var $modalEl = $(cfg.modal);
        if (!$modalEl.length) return;

        var endpoint = $modalEl.data("endpoint");
        var modal = new bootstrap.Modal($modalEl[0]);
        var $title = $modalEl.find('[data-role="title"]');
        var $save = $modalEl.find('[data-role="save"]');
        var editingId = null;

        if ($modalEl.find(".quill-editor").length) initQuillEditors();
        setupIconSelects($modalEl);

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

        $(document).on("click", '[data-action="edit"]', function () {
          var $btn = $(this).prop("disabled", true);

          adminRequest("GET", endpoint + "/" + encodeURIComponent($btn.attr("data-id")))
            .done(function (row) { openModal(row); })
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
              var target = null;

              if (!isEdit) {
                target = window.location.pathname + (cfg.jumpToLastOnCreate ? "?page=999999" : "");
              }

              adminReload(res.message || "Data berhasil disimpan.", target);
            })
            .fail(function (xhr) {
              toastError(xhr.message);
              $save.prop("disabled", false).html(SAVE_LABEL);
            });
        }

        $save.on("click", save);
        $modalEl.on("keydown", 'input[type="text"]', function (e) {
          if (e.key === "Enter") { e.preventDefault(); save(); }
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
    }
  };
})(jQuery);
