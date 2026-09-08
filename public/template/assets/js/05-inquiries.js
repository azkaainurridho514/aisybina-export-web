/* ==========================================================================
 * ADMIN — INQUIRIES
 * --------------------------------------------------------------------------
 * List inquiry, filter, pagination, detail, delete, dan export Excel.
 * Table: inquiry_forms.
 * ========================================================================== */

/* ==========================================================================
   5c. INQUIRIES — custom table (search + date filter + export)
   ========================================================================== */

function renderInquiryTable() {
  var cfg = ENTITIES.inquiry_forms;
  var $wrap = $("#table-inquiry_forms");
  if (!$wrap.length) return;

  $wrap.html(loadingRowsHtml());

  api.request("list", "inquiry_forms", { params: TableState.inquiry_forms }).done(function (response) {
    var meta = normalizeListResponse(response);
    var rows = meta.rows;

    if (!rows.length) {
      $wrap.html(emptyRowsHtml(cfg, "Tidak ada inquiry yang cocok dengan filter ini."));
      return;
    }

    var thead = "<tr><th>Tanggal</th><th>Nama</th><th>Perusahaan</th><th>Produk</th><th>Negara</th>" +
      '<th style="text-align:right;">Aksi</th></tr>';

    var tbody = rows.map(function (row) {
      var actions = '<div class="admin-table-actions">' +
        '<button class="btn-icon" data-action="view" data-entity="inquiry_forms" data-id="' + row.id + '" title="Lihat"><i class="bi bi-eye"></i></button>' +
        '<button class="btn-icon danger" data-action="delete" data-entity="inquiry_forms" data-id="' + row.id + '" title="Hapus"><i class="bi bi-trash3"></i></button>' +
        "</div>";

      return "<tr>" +
        "<td>" + escapeHtml(formatDate(row.created_at)) + "</td>" +
        "<td>" + escapeHtml(row.fullname) + "</td>" +
        "<td>" + escapeHtml(row.company_name) + "</td>" +
        "<td>" + escapeHtml(row.product_interested) + "</td>" +
        "<td>" + escapeHtml(row.country) + "</td>" +
        "<td>" + actions + "</td>" +
        "</tr>";
    }).join("");

    $wrap.html('<table class="admin-table"><thead>' + thead + "</thead><tbody>" + tbody + "</tbody></table>" + renderPagination(meta, "inquiry_forms"));
  }).fail(function (xhr) {
    $wrap.html(errorRowsHtml(xhr && xhr.message));
  });
}

function applyInquiryFilters() {
  TableState.inquiry_forms = {
    person_name: $("#filterPersonName").val().trim(),
    company_name: $("#filterCompanyName").val().trim(),
    country: $("#filterCountry").val().trim(),
    start_date: $("#filterStartDate").val(),
    end_date: $("#filterEndDate").val(),
    page: 1,
    per_page: 10
  };
  renderInquiryTable();
}

function resetInquiryFilters() {
  $("#filterPersonName, #filterCompanyName, #filterCountry, #filterStartDate, #filterEndDate").val("");
  TableState.inquiry_forms = { person_name: "", company_name: "", country: "", start_date: "", end_date: "", page: 1, per_page: 10 };
  renderInquiryTable();
}

/* ---- Export to Excel ------------------------------------------------------- */

var exportModalEl = document.getElementById("exportModal");
var exportModal = exportModalEl ? new bootstrap.Modal(exportModalEl) : null;

function computeExportRange(period) {
  var today = new Date();
  var fmt = function (d) { return d.toISOString().slice(0, 10); };

  if (period === "today") return { start_date: fmt(today), end_date: fmt(today) };
  if (period === "7days") { var d1 = new Date(today); d1.setDate(d1.getDate() - 6); return { start_date: fmt(d1), end_date: fmt(today) }; }
  if (period === "1month") { var d2 = new Date(today); d2.setMonth(d2.getMonth() - 1); return { start_date: fmt(d2), end_date: fmt(today) }; }
  if (period === "3months") { var d3 = new Date(today); d3.setMonth(d3.getMonth() - 3); return { start_date: fmt(d3), end_date: fmt(today) }; }
  return { start_date: null, end_date: null }; // "all"
}

function downloadInquiriesAsExcel(rows) {
  var sheetData = rows.map(function (r) {
    return {
      Tanggal: r.created_at,
      Nama: r.fullname,
      Perusahaan: r.company_name,
      Email: r.email,
      WhatsApp: r.whatsapp,
      Negara: r.country,
      "Produk Diminati": r.product_interested,
      "Estimasi Qty": r.estimated_quantity,
      Pesan: r.message
    };
  });
  var ws = XLSX.utils.json_to_sheet(sheetData);
  var wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Inquiries");
  XLSX.writeFile(wb, "inquiries-export-" + new Date().toISOString().slice(0, 10) + ".xlsx");
}

function runInquiryExport() {
  var period = $("#exportPeriod").val();
  var params = {};

  if (period === "custom") {
    var start = $("#exportStartDate").val();
    var end = $("#exportEndDate").val();
    if (!start) {
      $("#exportStatus").html('<div class="export-alert export-alert-error"><i class="bi bi-exclamation-triangle"></i> Pilih Start Date terlebih dahulu.</div>');
      return;
    }
    params.start_date = start;
    if (end) params.end_date = end;
  } else {
    var range = computeExportRange(period);
    if (range.start_date) params.start_date = range.start_date;
    if (range.end_date) params.end_date = range.end_date;
  }

  var $btn = $("#exportSubmitBtn");
  $btn.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Mengekspor...');
  $("#exportStatus").html('<div class="export-alert export-alert-loading"><i class="bi bi-arrow-repeat spin"></i> Menyiapkan data...</div>');

  DataLayer.exportInquiries(params)
    .done(function (rows) {
      if (!rows.length) {
        $("#exportStatus").html('<div class="export-alert export-alert-error"><i class="bi bi-info-circle"></i> Tidak ada data pada periode ini.</div>');
        return;
      }
      try {
        downloadInquiriesAsExcel(rows);
        $("#exportStatus").html('<div class="export-alert export-alert-success"><i class="bi bi-check2-circle"></i> ' + rows.length + " data berhasil diekspor.</div>");
        toastSuccess("File Excel berhasil diunduh.");
      } catch (e) {
        $("#exportStatus").html('<div class="export-alert export-alert-error"><i class="bi bi-exclamation-triangle"></i> Gagal membuat file Excel.</div>');
      }
    })
    .fail(function (xhr) {
      $("#exportStatus").html('<div class="export-alert export-alert-error"><i class="bi bi-exclamation-triangle"></i> ' + escapeHtml((xhr && xhr.message) || "Export gagal.") + "</div>");
    })
    .always(function () {
      $btn.prop("disabled", false).html('<i class="bi bi-download"></i> Export');
    });
}

