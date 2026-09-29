
$(function () {
  var $container = $("#categoryContainer");
  if (!$container.length) return; 

  var endpoint = document.currentScript
    ? document.currentScript.getAttribute("data-endpoint")
    : "/products/data";

  $.ajax({
    url: endpoint,
    method: "GET",
    dataType: "json",
    success: renderCatalog,
    error: function (xhr) {
      console.error("Gagal ambil data produk:", xhr.status, xhr.responseText);
      $container.html(
        '<section class="section"><div class="container text-center text-muted">' +
        "Gagal memuat produk. Silakan muat ulang halaman." +
        "</div></section>"
      );
    }
  });

  function renderCatalog(data) {
    var categories = data.categories || [];
    var products = data.products || [];

    var categoryHtml = "";
    var modalHtml = "";
    var globalIndex = 0;

    if (categories.length === 0) {
      categoryHtml =
        '<section class="section"><div class="container text-center" data-aos="fade-up">' +
        '<div class="empty-category"><i class="bi bi-box-seam"></i>' +
        "<p>There are no products available at this time.</p></div></div></section>";
    } else {
      categories.forEach(function (category) {
        var categoryProducts = products.filter(function (p) {
          return p.category_id === category.id;
        });

        if (categoryProducts.length === 0) return; // skip kategori kosong

        var productsHtml = "";

        categoryProducts.forEach(function (product) {
          var carouselId = "catProdCarousel" + globalIndex;
          var modalId = "catProdModal" + globalIndex;
          var images = product.images && product.images.length ? product.images : [];

          var slidesHtml = "";
          var indicatorsHtml = "";

          if (images.length > 0) {
            images.forEach(function (img, i) {
              slidesHtml +=
                '<div class="carousel-item ' + (i === 0 ? "active" : "") + '">' +
                '<div class="frame-square"><div class="frame-inner photo-trigger" ' +
                'data-bs-toggle="modal" data-bs-target="#' + modalId + '" data-slide-index="' + i + '" ' +
                'role="button" tabindex="0" aria-label="Preview photo ' + (i + 1) + " of " + product.name + '">' +
                '<img src="' + img.path + '" alt="' + product.name + '" loading="lazy"></div></div></div>';
              indicatorsHtml +=
                '<button type="button" data-bs-target="#' + carouselId + '" data-bs-slide-to="' + i + '" ' +
                'class="' + (i === 0 ? "active" : "") + '" aria-label="Photo ' + (i + 1) + '"></button>';
            });
          } else {
            slidesHtml =
              '<div class="carousel-item active"><div class="frame-square">' +
              '<div class="frame-inner frame-empty"><i class="bi bi-box-seam"></i><span>' + product.name + "</span></div></div></div>";
          }

          productsHtml +=
            '<div class="col-6 col-lg-4" data-aos="fade-up"><div class="crop-card"><div class="crop-media">' +
            '<div id="' + carouselId + '" class="carousel slide crop-carousel" data-bs-ride="false">' +
            '<div class="carousel-inner">' + slidesHtml + "</div>" +
            (images.length > 1
              ? '<button class="carousel-control-prev" type="button" data-bs-target="#' + carouselId + '" data-bs-slide="prev" aria-label="Previous photo">' +
                '<span class="carousel-arrow"><i class="bi bi-chevron-left"></i></span></button>' +
                '<button class="carousel-control-next" type="button" data-bs-target="#' + carouselId + '" data-bs-slide="next" aria-label="Next photo">' +
                '<span class="carousel-arrow"><i class="bi bi-chevron-right"></i></span></button>' +
                '<div class="carousel-indicators crop-indicators">' + indicatorsHtml + "</div>"
              : "") +
            "</div></div><div class=\"crop-body\"><h3>" + product.name + "</h3><p>" + (product.description || "") + "</p>" +
            '<a href="/contact" class="crop-link">Start inquiry <i class="bi bi-arrow-right"></i></a></div></div></div>';

          var modalSlidesHtml = "";
          if (images.length > 0) {
            images.forEach(function (img, i) {
              modalSlidesHtml +=
                '<div class="carousel-item ' + (i === 0 ? "active" : "") + '"><div class="frame-wide">' +
                '<img src="' + img.path + '" alt="' + product.name + '" loading="lazy"></div></div>';
            });
          } else {
            modalSlidesHtml =
              '<div class="carousel-item active"><div class="frame-wide frame-empty">' +
              '<i class="bi bi-box-seam"></i><span>' + product.name + "</span></div></div>";
          }

          modalHtml +=
            '<div class="modal fade photo-modal" id="' + modalId + '" tabindex="-1" aria-hidden="true" aria-labelledby="' + modalId + 'Label">' +
            '<div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content">' +
            '<button type="button" class="btn-close modal-close-custom" data-bs-dismiss="modal" aria-label="Close"></button>' +
            '<div class="modal-body p-0"><div id="' + modalId + 'Carousel" class="carousel slide" data-bs-ride="false">' +
            '<div class="carousel-inner">' + modalSlidesHtml + "</div>" +
            (images.length > 1
              ? '<button class="carousel-control-prev" type="button" data-bs-target="#' + modalId + 'Carousel" data-bs-slide="prev" aria-label="Previous photo">' +
                '<span class="carousel-arrow"><i class="bi bi-chevron-left"></i></span></button>' +
                '<button class="carousel-control-next" type="button" data-bs-target="#' + modalId + 'Carousel" data-bs-slide="next" aria-label="Next photo">' +
                '<span class="carousel-arrow"><i class="bi bi-chevron-right"></i></span></button>'
              : "") +
            '</div><p id="' + modalId + 'Label" class="carousel-caption-label mb-0">' + product.name + "</p></div></div></div></div>";

          globalIndex++;
        });

        var sectionClass = (categoryHtml.split("<section").length - 1) % 2 === 1 ? "" : " bg-cream-dim";

        categoryHtml +=
          '<section class="section' + sectionClass + '"><div class="container">' +
          '<div class="row mb-4"><div class="col-lg-7" data-aos="fade-up">' +
          '<span class="pill-tag"><i class="bi bi-box-seam"></i>' + category.name + "</span>" +
          "<h2 class=\"mb-2\">" + category.name + "</h2>" +
          '<p class="mb-0">' + (category.description || "") + "</p></div></div>" +
          '<div class="row gy-4">' + productsHtml + "</div></div></section>";
      });
    }

    $container.html(categoryHtml);
    $("#productModalContainer").html(modalHtml);
  }
});