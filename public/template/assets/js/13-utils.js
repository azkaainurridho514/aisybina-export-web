var Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 2200,
  timerProgressBar: true
});




function normalizeListResponse(response) {
  if (Array.isArray(response)) {
    return {
      rows: response,
      current_page: 1,
      last_page: 1,
      per_page: response.length || 10,
      total: response.length,
      from: response.length ? 1 : 0,
      to: response.length
    };
  }

  return {
    rows: Array.isArray(response && response.data) ? response.data : [],
    current_page: Number(response && response.current_page) || 1,
    last_page: Number(response && response.last_page) || 1,
    per_page: Number(response && response.per_page) || 10,
    total: Number(response && response.total) || 0,
    from: Number(response && response.from) || 0,
    to: Number(response && response.to) || 0
  };
}


function confirmDelete(label) {
  return Swal.fire({
    title: "Hapus data ini?",
    text: label ? '"' + label + '" akan dihapus permanen.' : "Data akan dihapus permanen.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Ya, hapus",
    cancelButtonText: "Batal",
    confirmButtonColor: "#a3402f",
    cancelButtonColor: "#52685c",
    reverseButtons: true
  }).then(function (res) { return res.isConfirmed; });
}

function toastSuccess(msg) { Toast.fire({ icon: "success", title: msg }); }
function toastError(msg) { Toast.fire({ icon: "error", title: msg || "Terjadi kesalahan." }); }

function normalizeError(xhr) {
  var response = xhr && xhr.responseJSON;
  var message = response && response.message;

  if (response && response.errors) {
    var first = Object.keys(response.errors).reduce(function (acc, key) {
      if (acc) return acc;
      var value = response.errors[key];
      return Array.isArray(value) ? value[0] : value;
    }, "");
    if (first) message = first;
  }

  if (!message && xhr && xhr.status === 419) message = "CSRF token tidak valid atau session sudah kedaluwarsa.";
  if (!message && xhr && xhr.status === 401) message = "Session login tidak valid.";
  if (!message && xhr && xhr.status === 403) message = "Anda tidak memiliki akses.";
  if (!message && xhr && xhr.status === 404) message = "Endpoint atau data tidak ditemukan.";
  return { message: message || (xhr && xhr.statusText) || "Terjadi kesalahan pada server." };
}