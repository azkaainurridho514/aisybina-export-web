$(function () {
  var $viewEl = $("#inquiryModal");
  if (!$viewEl.length) return;

  var endpoint = $viewEl.data("endpoint");
  var viewModal = new bootstrap.Modal($viewEl[0]);
  var exportModal = new bootstrap.Modal($("#exportModal")[0]);

  $(document).on("click", '[data-action="view"]', function () {
    var $btn = $(this).prop("disabled", true);

    adminRequest("GET", endpoint + "/" + encodeURIComponent($btn.attr("data-id")))
      .done(function (row) {
        $viewEl.find("[data-view]").each(function () {
          var key = $(this).attr("data-view");
          var value = key === "created_at" && row.created_at
            ? new Date(row.created_at).toLocaleString("id-ID")
            : row[key];

          $(this).text(value || "—");
        });
        viewModal.show();
      })
      .fail(function (xhr) { toastError(xhr.message); })
      .always(function () { $btn.prop("disabled", false); });
  });

  $(document).on("click", '[data-action="delete"]', function () {
    var id = $(this).attr("data-id");

    confirmDelete($(this).attr("data-name")).then(function (ok) {
      if (!ok) return;

      adminRequest("DELETE", endpoint + "/" + encodeURIComponent(id))
        .done(function (res) { adminReload(res.message || "Inquiry berhasil dihapus."); })
        .fail(function (xhr) { toastError(xhr.message); });
    });
  });

  var $period = $("#exportPeriod");
  var $custom = $("#exportCustomDateFields");
  var $status = $("#exportStatus");
  var $submit = $("#exportSubmitBtn");

  function alertHtml(type, icon, text) {
    return '<div class="export-alert export-alert-' + type + '"><i class="bi bi-' + icon + '"></i> ' + escapeHtml(text) + "</div>";
  }

  function iso(d) { return d.toISOString().slice(0, 10); }

  function rangeFor(period) {
    var today = new Date();
    var from = new Date(today);

    if (period === "today") return { start_date: iso(today), end_date: iso(today) };
    if (period === "7days") { from.setDate(from.getDate() - 6); return { start_date: iso(from), end_date: iso(today) }; }
    if (period === "1month") { from.setMonth(from.getMonth() - 1); return { start_date: iso(from), end_date: iso(today) }; }
    if (period === "3months") { from.setMonth(from.getMonth() - 3); return { start_date: iso(from), end_date: iso(today) }; }
    return {}; 
  }

  $("#exportInquiryBtn").on("click", function () {
    $status.empty();
    exportModal.show();
  });

  $period.on("change", function () { $custom.toggle(this.value === "custom"); });

  $submit.on("click", function () {
    var params = {};

    if ($period.val() === "custom") {
      if (!$("#exportStartDate").val()) {
        $status.html(alertHtml("error", "exclamation-triangle", "Pilih Start Date terlebih dahulu."));
        return;
      }
      params.start_date = $("#exportStartDate").val();
      if ($("#exportEndDate").val()) params.end_date = $("#exportEndDate").val();
    } else {
      params = rangeFor($period.val());
    }

    $submit.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Mengekspor...');
    $status.html(alertHtml("loading", "arrow-repeat spin", "Menyiapkan data..."));

    adminRequest("GET", $submit.attr("data-endpoint") + "?" + $.param(params))
      .done(function (res) {
        var rows = res.data || [];

        if (!rows.length) {
          $status.html(alertHtml("error", "info-circle", "Tidak ada data pada periode ini."));
          return;
        }

        try {
          var wb = XLSX.utils.book_new();
          XLSX.utils.book_append_sheet(wb, XLSX.utils.json_to_sheet(rows), "Inquiries");
          XLSX.writeFile(wb, "inquiries-export-" + iso(new Date()) + ".xlsx");

          $status.html(alertHtml("success", "check2-circle", rows.length + " data berhasil diekspor."));
          toastSuccess("File Excel berhasil diunduh.");
        } catch (e) {
          $status.html(alertHtml("error", "exclamation-triangle", "Gagal membuat file Excel."));
        }
      })
      .fail(function (xhr) {
        $status.html(alertHtml("error", "exclamation-triangle", xhr.message || "Export gagal."));
      })
      .always(function () {
        $submit.prop("disabled", false).html('<i class="bi bi-download"></i> Export');
      });
  });
});
