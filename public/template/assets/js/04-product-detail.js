/* ==========================================================================
 * ADMIN — PRODUCT DETAIL
 * --------------------------------------------------------------------------
 * Detail produk, carousel foto, dan preview lightbox.
 * Data gambar mengikuti tabel product_images: id, product_id, path.
 * ========================================================================== */

/* ==========================================================================
   5b. PRODUCT DETAIL MODAL — read-only view: full info + photo carousel
   with click-to-preview lightbox. Reads straight from the Laravel product detail response so
   it always reflects whatever was last saved in the Add/Edit gallery.
   ========================================================================== */

var productDetailModalEl = document.getElementById("productDetailModal");
var productDetailModal = productDetailModalEl ? new bootstrap.Modal(productDetailModalEl) : null;

function openProductDetailModal(id) {
  if (!productDetailModal) return;
  $("#productDetailModalTitle").text("Detail Produk");
  $("#productDetailModalBody").html(loadingRowsHtml());
  productDetailModal.show();

  api.request("get", "products", { id: id }).done(function (row) {
    var category = row.category || categoryCache.find(function (c) { return c.id === row.category_id; });
    var images = (row.images || []).filter(function (pi) { return pi && pi.path; }).map(function (pi) {
      return { id: pi.id, product_id: pi.product_id, path: productImageUrl(pi.path) };
    });

    $("#productDetailModalTitle").text(row.name);
    $("#productDetailModalBody").html(buildProductDetailHtml(row, category, images));
  }).fail(function (err) {
    $("#productDetailModalBody").html(errorRowsHtml(err && err.message));
  });
}

function buildProductDetailHtml(row, category, images) {
  var html = "";

  // ---- photo carousel ----
  if (images.length) {
    var carouselId = "productDetailCarousel";
    html += '<div class="product-detail-carousel">';
    html += '<div id="' + carouselId + '" class="carousel slide" data-bs-ride="false">';

    if (images.length > 1) {
      html += '<div class="carousel-indicators">';
      html += images.map(function (img, idx) {
        return '<button type="button" data-bs-target="#' + carouselId + '" data-bs-slide-to="' + idx + '" ' + (idx === 0 ? 'class="active" aria-current="true"' : "") + '></button>';
      }).join("");
      html += "</div>";
    }

    html += '<div class="carousel-inner">';
    html += images.map(function (img, idx) {
      return '<div class="carousel-item' + (idx === 0 ? " active" : "") + '">' +
        '<img src="' + img.path + '" alt="' + escapeHtml(row.name) + '" data-lightbox-src="' + img.path + '" />' +
        "</div>";
    }).join("");
    html += "</div>";

    if (images.length > 1) {
      html += '<button class="carousel-control-prev" type="button" data-bs-target="#' + carouselId + '" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>';
      html += '<button class="carousel-control-next" type="button" data-bs-target="#' + carouselId + '" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>';
    }

    html += "</div></div>";

    if (images.length > 1) {
      html += '<div class="product-detail-thumbstrip">';
      html += images.map(function (img, idx) {
        return '<img src="' + img.path + '" alt="" class="' + (idx === 0 ? "active" : "") + '" data-bs-target="#' + carouselId + '" data-bs-slide-to="' + idx + '" />';
      }).join("");
      html += "</div>";
    }
  } else {
    html += '<div class="product-detail-carousel"><div class="product-detail-carousel-empty"><i class="bi bi-image"></i></div></div>';
  }

  // ---- info ----
  html += '<div class="product-detail-info"><dl>';
  html += "<dt>Nama Produk</dt><dd>" + escapeHtml(row.name || "—") + "</dd>";
  html += "<dt>Kategori</dt><dd>" + (category ? '<span class="product-detail-badge">' + escapeHtml(category.name) + "</span>" : "—") + "</dd>";
  html += "<dt>Deskripsi</dt><dd>" + escapeHtml(row.description || "—").replace(/\n/g, "<br>") + "</dd>";
  html += "<dt>Jumlah Foto</dt><dd>" + images.length + " foto</dd>";
  html += "</dl></div>";

  return html;
}

