$(function () {
  var $wrap = $("#inquiryTable");
  var $modalEl = $("#inquiryModal");
  if (!$wrap.length || !$modalEl.length) return;

  var listUrl = $wrap.data("list");
  var endpoint = $modalEl.data("endpoint");
  var viewModal = new bootstrap.Modal($modalEl[0]);
  var exportModal = new bootstrap.Modal($("#exportModal")[0]);

  var $filter = $("#inquiryFilterForm");
  var FILTER_KEYS = ["fullname", "company_name", "country", "start_date", "end_date"];

  var $exportPeriod = $("#exportPeriod");
  var $exportCustom = $("#exportCustomDateFields");
  var $exportStatus = $("#exportStatus");
  var $exportBtn = $("#exportSubmitBtn");
  var exportLabel = $exportBtn.html();

  var state = { page: 1, last: 1, filters: {} };
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

  // ===== Helpers =====
  function pad(n) { return n < 10 ? "0" + n : String(n); }

  function ymd(d) {
    return d.getFullYear() + "-" + pad(d.getMonth() + 1) + "-" + pad(d.getDate());
  }

  function dateLabel(row) {
    if (row.created_at_label) return row.created_at_label;
    if (!row.created_at) return "—";
    var d = new Date(row.created_at);
    if (isNaN(d.getTime())) return "—";
    return pad(d.getDate()) + "/" + pad(d.getMonth() + 1) + "/" + d.getFullYear() + " " + pad(d.getHours()) + ":" + pad(d.getMinutes());
  }

  function hasFilters() { return Object.keys(state.filters).length > 0; }

  // ===== Tabel =====
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
        '<div class="admin-empty"><i class="bi bi-envelope-open"></i><p class="mb-0">' +
        (hasFilters() ? "Tidak ada inquiry yang cocok dengan filter ini." : "Belum ada inquiry masuk.") +
        "</p></div>"
      );
      return;
    }

    var html = '<table class="admin-table"><thead><tr>' +
      "<th>Tanggal</th><th>Nama</th><th>Perusahaan</th><th>Produk</th><th>Negara</th>" +
      '<th style="text-align:right;">Aksi</th></tr></thead><tbody>';

    rows.forEach(function (r) {
      var id = escapeHtml(r.id);

      html += "<tr>" +
        "<td>" + escapeHtml(dateLabel(r)) + "</td>" +
        "<td>" + (escapeHtml(r.fullname) || "—") + "</td>" +
        "<td>" + (escapeHtml(r.company_name) || "—") + "</td>" +
        "<td>" + (escapeHtml(r.product_interested) || "—") + "</td>" +
        "<td>" + (escapeHtml(r.country) || "—") + "</td>" +
        '<td><div class="admin-table-actions">' +
        '<button type="button" class="btn-icon" data-action="view" data-id="' + id + '" title="Lihat"><i class="bi bi-eye"></i></button>' +
        '<button type="button" class="btn-icon danger" data-action="delete" data-id="' + id + '" data-name="' + escapeHtml(r.fullname) + '" title="Hapus"><i class="bi bi-trash3"></i></button>' +
        "</div></td></tr>";
    });

    $wrap.html(html + "</tbody></table>" + renderPagination());
  }

  // ===== AJAX GET: daftar inquiry (awal, filter, pagination, setelah hapus) =====
  function load() {
    var id = ++reqId;
    var qs = $.param($.extend({ page: state.page }, state.filters));

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

  // ===== Filter =====
  function readFilters() {
    var f = {};
    FILTER_KEYS.forEach(function (k) {
      var v = $.trim($filter.find('[name="' + k + '"]').val());
      if (v) f[k] = v;
    });
    return f;
  }

  $filter.on("submit", function (e) {
    e.preventDefault();

    var f = readFilters();
    if (f.start_date && f.end_date && f.start_date > f.end_date) {
      toastError("Start Date tidak boleh setelah End Date.");
      return;
    }

    state.filters = f;
    state.page = 1;
    load();
  });

  $("#inquiryFilterReset").on("click", function (e) {
    e.preventDefault();
    $filter[0].reset();
    $filter.find("input").val("");
    state.filters = {};
    state.page = 1;
    load();
  });

  // ===== AJAX GET: detail (baca saja) =====
  $wrap.on("click", '[data-action="view"]', function () {
    var $btn = $(this).prop("disabled", true);

    adminRequest("GET", endpoint + "/" + encodeURIComponent($btn.attr("data-id")))
      .done(function (res) {
        var row = res.data || res;

        $modalEl.find("[data-view]").each(function () {
          var key = $(this).attr("data-view");
          var value = key === "created_at" ? dateLabel(row) : row[key];
          $(this).text(value ? value : "—");
        });

        viewModal.show();
      })
      .fail(function (xhr) { toastError(xhr.message); })
      .always(function () { $btn.prop("disabled", false); });
  });

  // ===== AJAX DELETE =====
  $wrap.on("click", '[data-action="delete"]', function () {
    var id = $(this).attr("data-id");

    confirmDelete($(this).attr("data-name")).then(function (ok) {
      if (!ok) return;

      adminRequest("DELETE", endpoint + "/" + encodeURIComponent(id))
        .done(function (res) {
          var msg = res.message || "Inquiry berhasil dihapus.";
          load().done(function () { toastSuccess(msg); });  // server otomatis mundur halaman jika kosong
        })
        .fail(function (xhr) { toastError(xhr.message); });
    });
  });

  // ===== Export Excel =====
  function setStatus(text, isError) {
    $exportStatus.html(text ? '<div class="field-hint mt-2"' + (isError ? ' style="color:#c0392b;"' : "") + ">" + escapeHtml(text) + "</div>" : "");
  }

  function exportRange() {
    var period = $exportPeriod.val();
    var today = new Date();
    var start = null;

    if (period === "all") return { params: {} };

    if (period === "today") {
      start = today;
    } else if (period === "7days") {
      start = new Date(today); start.setDate(start.getDate() - 6);
    } else if (period === "1month") {
      start = new Date(today); start.setMonth(start.getMonth() - 1);
    } else if (period === "3months") {
      start = new Date(today); start.setMonth(start.getMonth() - 3);
    } else if (period === "custom") {
      var s = $("#exportStartDate").val();
      var e = $("#exportEndDate").val();

      if (!s) return { error: "Start Date wajib diisi." };
      if (e && s > e) return { error: "Start Date tidak boleh setelah End Date." };

      var params = { start_date: s };
      if (e) params.end_date = e;
      return { params: params };
    }

    return { params: { start_date: ymd(start), end_date: ymd(today) } };
  }

  $exportPeriod.on("change", function () {
    $exportCustom.toggle($(this).val() === "custom");
    setStatus("");
  });

  $("#exportInquiryBtn").on("click", function () {
    setStatus("");
    exportModal.show();
  });

  $exportBtn.on("click", function () {
    if (typeof XLSX === "undefined") {
      toastError("Library Excel belum termuat. Muat ulang halaman.");
      return;
    }

    var range = exportRange();
    if (range.error) { setStatus(range.error, true); return; }

    setStatus("");
    $exportBtn.prop("disabled", true).html('<i class="bi bi-arrow-repeat spin"></i> Mengambil data...');

    var url = $exportBtn.data("endpoint");
    var qs = $.param(range.params);

    adminRequest("GET", qs ? url + "?" + qs : url)
      .done(function (res) {
        var list = res.data || res;

        if (!list.length) {
          setStatus("Tidak ada data pada periode ini.", true);
          return;
        }

        var ws = XLSX.utils.json_to_sheet(list);
        var headers = Object.keys(list[0]);

        ws["!cols"] = headers.map(function (h) {
          var max = String(h).length;
          list.forEach(function (r) {
            var len = String(r[h] == null ? "" : r[h]).length;
            if (len > max) max = len;
          });
          return { wch: Math.min(max + 2, 60) };
        });

        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Inquiries");
        XLSX.writeFile(wb, "inquiries_" + ymd(new Date()) + ".xlsx");

        exportModal.hide();
        toastSuccess(list.length + " data berhasil diexport.");
      })
      .fail(function (xhr) { setStatus(xhr.message || "Gagal mengambil data export.", true); })
      .always(function () { $exportBtn.prop("disabled", false).html(exportLabel); });
  });
});