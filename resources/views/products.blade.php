<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title id="titleWeb"></title>
  <meta name="description" content="Browse the product categories Aisy Bina Exports sources from trusted suppliers across Indonesia.">
  <link rel="icon" type="image/png" id="iconTab">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">
</head>
<body>

  @include('layouts.navbar')

  <main>

    <section class="section-tight" style="margin-top: 82px;">
      <div class="container" data-aos="fade-up">
        <span class="pill-tag"><i class="bi bi-box-seam"></i>Our Products</span>
        <h1 class="mb-3" id="pageHeading"></h1>
        <p class="lead mb-0" style="max-width: 660px;" id="pageSubheading"></p>
      </div>
    </section>

    <div id="categoryContainer"></div>

    <div id="productModalContainer"></div>

    <section class="section bg-cream-dim">
      <div class="container text-center container-narrow" data-aos="fade-up">
        <h2 class="mb-3" id="ctaHeading"></h2>
        <p class="mb-4" id="ctaSubheading"></p>
        <a href="/contact" class="btn btn-forest btn-arrow" id="ctaButton"></a>
      </div>
    </section>

  </main>

  @include('layouts.footer')

  <a href="#" id="whatsappFloat" class="whatsapp-float" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <i class="bi bi-whatsapp"></i>
  </a>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dompurify@3.2.6/dist/purify.min.js"></script>
  <script src="{{ asset("assets/js/13-utils.js") }}"></script>
  <script src="{{ asset("assets/js/script.js") }}"></script>
  @stack('scripts')
  <script>
  $(function () {
    // Ambil 2 endpoint sekaligus: page_desc/footer/master + categories/products
    $.when(
      $.ajax({ url: "/get-data/master/product", method: "GET", dataType: "json" }),
      $.ajax({ url: "/get-data/products", method: "GET", dataType: "json" })
    ).done(function (pageRes, productsRes) {
      const pageData     = pageRes[0];     // { page_desc, footer, master }
      const productsData = productsRes[0]; // { categories, products }
      renderProductPage(pageData, productsData);
    }).fail(function (xhr) {
      console.error("Gagal ambil data products page:", xhr.status, xhr.responseText);
    });

    function renderProductPage(pageData, productsData) {
      const pageDesc    = pageData.page_desc || {};
      const footer      = pageData.footer || {};
      const master      = pageData.master || {};
      const categories  = productsData.categories || [];
      const products    = productsData.products || [];

      // ===== HERO =====
      $("#pageHeading").text(pageDesc.product_heading);
      renderQuillContent("#pageSubheading", pageDesc.product_subheading || "");

      // ===== PAGE TITLE =====
      if (master.website_name) {
        document.title = "Products | " + master.website_name;
      }

      // ===== KATEGORI + PRODUK (dikelompokkan) =====
      let categoryHtml = "";
      let modalHtml = "";
      let globalIndex = 0; // index unik untuk id carousel & modal antar semua produk

      if (categories.length === 0) {
        categoryHtml = `
          <section class="section">
            <div class="container text-center" data-aos="fade-up">
              <div class="empty-category">
                <i class="bi bi-box-seam"></i>
                <p>There are no products available at this time.</p>
              </div>
            </div>
          </section>`;
      }else{
        categories.forEach(function (category) {
          const categoryProducts = products.filter(function (p) {
            return p.category_id === category.id;
          });
  
          // skip kategori yang tidak punya produk sama sekali
          if (categoryProducts.length === 0) return;
  
          let productsHtml = "";
  
          categoryProducts.forEach(function (product) {
            const carouselId = "catProdCarousel" + globalIndex;
            const modalId     = "catProdModal" + globalIndex;
            const images = product.images && product.images.length ? product.images : [];
  
            // ---- Slides card kecil ----
            let slidesHtml = "";
            let indicatorsHtml = "";
  
             if (images.length > 0) {
                images.forEach(function (img, i) {
                  slidesHtml += `
                    <div class="carousel-item ${i === 0 ? 'active' : ''}">
                      <div class="frame-square">
                        <div class="frame-inner photo-trigger"
                            data-bs-toggle="modal"
                            data-bs-target="#${modalId}"
                            data-slide-index="${i}"
                            role="button" tabindex="0"
                            aria-label="Preview photo ${i + 1} of ${product.name}">
                          <img src="${img.path}" alt="${product.name}" loading="lazy">
                        </div>
                      </div>
                    </div>`;
                  indicatorsHtml += `
                    <button type="button" data-bs-target="#${carouselId}" data-bs-slide-to="${i}" class="${i === 0 ? 'active' : ''}" aria-label="Photo ${i + 1}"></button>`;
                });
            } else {
              slidesHtml = `
                <div class="carousel-item active">
                  <div class="frame-square">
                    <div class="frame-inner frame-empty"><i class="bi bi-box-seam"></i><span>${product.name}</span></div>
                  </div>
                </div>`;
            }
  
            productsHtml += `
              <div class="col-6 col-lg-4" data-aos="fade-up">
                <div class="crop-card">
                  <div class="crop-media">
                    <div id="${carouselId}" class="carousel slide crop-carousel" data-bs-ride="false">
                      <div class="carousel-inner">${slidesHtml}</div>
                      ${images.length > 1 ? `
                      <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev" aria-label="Previous photo">
                        <span class="carousel-arrow"><i class="bi bi-chevron-left"></i></span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next" aria-label="Next photo">
                        <span class="carousel-arrow"><i class="bi bi-chevron-right"></i></span>
                      </button>
                      <div class="carousel-indicators crop-indicators">${indicatorsHtml}</div>` : ''}
                    </div>
                  </div>
                  <div class="crop-body">
                    <h3>${product.name}</h3>
                    <p>${renderQuillInline(product.description)}</p>
                    <a href="/contact" class="crop-link">Start inquiry <i class="bi bi-arrow-right"></i></a>
                  </div>
                </div>
              </div>`;
  
            // ---- Modal foto besar ----
            
            let modalSlidesHtml = "";
            if (images.length > 0) {
              images.forEach(function (img, i) {
                modalSlidesHtml += `
                  <div class="carousel-item ${i === 0 ? 'active' : ''}">
                    <div class="frame-wide">
                      <img src="${img.path}" alt="${product.name}" loading="lazy">
                    </div>
                  </div>`;
              });
            } else {
              modalSlidesHtml = `
                <div class="carousel-item active">
                  <div class="frame-wide frame-empty"><i class="bi bi-box-seam"></i><span>${product.name}</span></div>
                </div>`;
            }
  
            modalHtml += `
              <div class="modal fade photo-modal" id="${modalId}" tabindex="-1" aria-hidden="true" aria-labelledby="${modalId}Label">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <button type="button" class="btn-close modal-close-custom" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body p-0">
                      <div id="${modalId}Carousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">${modalSlidesHtml}</div>
                        ${images.length > 1 ? `
                        <button class="carousel-control-prev" type="button" data-bs-target="#${modalId}Carousel" data-bs-slide="prev" aria-label="Previous photo">
                          <span class="carousel-arrow"><i class="bi bi-chevron-left"></i></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#${modalId}Carousel" data-bs-slide="next" aria-label="Next photo">
                          <span class="carousel-arrow"><i class="bi bi-chevron-right"></i></span>
                        </button>` : ''}
                      </div>
                      <p id="${modalId}Label" class="carousel-caption-label mb-0">${product.name}</p>
                    </div>
                  </div>
                </div>
              </div>`;
  
            globalIndex++;
          });
  
          // Selang-seling background section (genap = cream-dim, ganjil = putih), meniru desain asli
          const sectionClass = (categoryHtml.split('<section').length - 1) % 2 === 1 ? '' : ' bg-cream-dim';
  
          categoryHtml += `
            <section class="section${sectionClass}">
              <div class="container">
                <div class="row mb-4">
                  <div class="col-lg-7" data-aos="fade-up">
                    <span class="pill-tag"><i class="bi bi-box-seam"></i>${category.name}</span>
                    <h2 class="mb-2">${category.name}</h2>
                    <p class="mb-0">${renderQuillInline(category.description || '')}</p>
                  </div>
                </div>
                <div class="row gy-4">${productsHtml}</div>
              </div>
            </section>`;
        });
      }


      $("#categoryContainer").html(categoryHtml);
      $("#productModalContainer").html(modalHtml);

      // Sinkronkan slide modal dengan slide yang diklik di card
      $(document).on("click", ".photo-trigger", function () {
        const targetModal = $(this).data("bs-target");
        const slideIndex  = $(this).data("slide-index") || 0;
        const modalCarousel = $(targetModal + " .carousel");
        const carouselInstance = bootstrap.Carousel.getOrCreateInstance(modalCarousel[0]);
        carouselInstance.to(slideIndex);
      });

      // ===== CTA BAWAH =====
      $("#ctaHeading").text(footer.footer_product_heading);
      renderQuillContent("#ctaSubheading", footer.footer_product_subheading || "");
      $("#ctaButton").text(footer.footer_product_button || "Request a Product");

      // ===== WHATSAPP FLOAT =====
      if (pageDesc.whatsapp) {
        const waNumber = pageDesc.whatsapp.replace(/[^0-9]/g, "");
        // if (waNumber.startsWith("0")) {
        //   waNumber = "62" + waNumber.substring(1);
        // }
        const waText = encodeURIComponent(
          `Hello ${master.website_name}, I am interested in sourcing products from Indonesia. I would like to discuss my requirements.`
        );
        $("#whatsappFloat").attr("href", `https://wa.me/${waNumber}?text=${waText}`);
      }else{
          $("#whatsappFloat").hide();
      }

      // ===== NAVBAR & FOOTER =====
      renderNavbarBrand(master);
      renderFooter(master, pageDesc); // pageDesc sudah berisi field contact (email, whatsapp, dll)
    }
  });
  </script>
</body>
</html>
