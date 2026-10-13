
(function ($) {
  "use strict";

  if (!window.AdminCrud) {
    console.error("crud-list.js: crud.js harus dimuat lebih dulu.");
    return;
  }
  AdminCrud.listField = function (key, opts) {
    opts = opts || {};

    var columns = opts.columns || [{
      prop: opts.prop || "description",
      placeholder: opts.placeholder || "Isi item...",
      maxlength: opts.maxlength || 255
    }];
    var minRows = opts.minRows == null ? 1 : opts.minRows;

    var boxSel = '[data-field="' + key + '"]';
    var ns = ".listField_" + key;

    function $box($scope) { return ($scope || $(document)).find(boxSel); }

    function buildRow(item) {
      var $row = $('<div class="list-row d-flex gap-2 mb-2 align-items-start"></div>');
      $row.attr("data-id", item.id || "");

      var $inputs = $('<div class="flex-grow-1 d-flex flex-column gap-2"></div>');
      columns.forEach(function (c) {
        var $el = c.type === "textarea"
          ? $('<textarea class="form-control-admin" rows="2"></textarea>')
          : $('<input type="text" class="form-control-admin" autocomplete="off">');

        $el.attr({ "data-prop": c.prop, placeholder: c.placeholder || "", maxlength: c.maxlength || 255 })
           .val(item[c.prop] == null ? "" : item[c.prop]);
        $inputs.append($el);
      });

      $row.append($inputs).append(
        '<button type="button" class="btn-icon danger" data-list-remove title="Hapus">' +
        '<i class="bi bi-x-lg"></i></button>'
      );
      return $row;
    }

    function addRow($container, item, focus, $after) {
      var $row = buildRow(item || {});
      if ($after && $after.length) $after.after($row); else $container.append($row);
      if (focus) $row.find("[data-prop]").first().trigger("focus");
      return $row;
    }

    function fillMinRows($container) {
      while ($container.children(".list-row").length < minRows) addRow($container, {}, false);
    }

    $(document).off(ns)
      .on("click" + ns, '[data-list-add="' + key + '"]', function () {
        addRow($box($(this).closest(".modal, body")), {}, true);
      })
      .on("click" + ns, boxSel + " [data-list-remove]", function () {
        var $c = $(this).closest(boxSel);
        $(this).closest(".list-row").remove();
        fillMinRows($c);
      })
      .on("keydown" + ns, boxSel + ' input[type="text"]', function (e) {
        if (e.key !== "Enter") return;
        e.preventDefault();
        var $row = $(this).closest(".list-row");
        addRow($row.closest(boxSel), {}, true, $row);
      });

    return {
      get: function ($modal) {
        var out = [];
        $box($modal).children(".list-row").each(function () {
          var item = { id: $(this).attr("data-id") || null };
          var filled = false;

          $(this).find("[data-prop]").each(function () {
            var v = $.trim($(this).val());
            if (v) filled = true;
            item[$(this).attr("data-prop")] = v;
          });

          if (filled) out.push(item);   
        });
        return out;
      },

      set: function ($modal, value) {
        var $c = $box($modal).empty();
        (Array.isArray(value) ? value : []).forEach(function (it) { addRow($c, it, false); });
        fillMinRows($c);
      }
    };
  };

})(jQuery);