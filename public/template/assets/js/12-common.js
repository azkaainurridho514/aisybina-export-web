/* ==========================================================================
 * ADMIN — SHARED FUNCTIONS
 * --------------------------------------------------------------------------
 * Fungsi yang dipakai lintas section ditaruh paling bawah sesuai struktur
 * yang diminta: toast, error parser, response normalizer, HTML helper,
 * image URL, date formatter, dan lightbox.
 * ========================================================================== */

/* ==========================================================================
   9. HELPERS
   ========================================================================== */

function productImageUrl(path) {
    if (!path) return "";

    if (
        /^(https?:)?\/\//i.test(path) ||
        path.indexOf("data:") === 0 ||
        path.indexOf("blob:") === 0
    ) {
        return path;
    }

    if (path.charAt(0) === "/") {
        return path;
    }

    return "/" + path.replace(/^\/+/, "");
}

function formatDate(value) {
  if (!value) return "—";
  var d = new Date(value);
  if (isNaN(d.getTime())) return value;
  return d.toLocaleString("id-ID", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit"
  });
}

function escapeHtml(str) {
  return String(str == null ? "" : str).replace(/[&<>"']/g, function (m) {
    return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[m];
  });
}

function truncate(str, len) { return str.length > len ? str.slice(0, len) + "…" : str; }

/** Full-size click-to-preview overlay, shared by the product gallery
 *  upload thumbnails and the product detail carousel/thumbstrip. */
function openLightbox(src) {
  if (!src) return;
  $("#imageLightboxImg").attr("src", src);
  $("#imageLightbox").addClass("show");
}
function closeLightbox() {
  $("#imageLightbox").removeClass("show");
  $("#imageLightboxImg").attr("src", "");
}

