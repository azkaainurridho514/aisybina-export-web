<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title id="titleWeb"></title>
  <meta name="description" content="Aisy Bina Exports connects global buyers with quality products sourced from trusted suppliers across Indonesia.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="{{ asset("template/assets/css/style.css") }}">
</head>
<body>

  @include('layouts.navbar')

  <main>

    <!-- HERO -->
    <section class="section-tight" style="margin-top: 82px;">
      <div class="container">
        <div class="row align-items-center gy-5">
          <div class="col-lg-6" data-aos="fade-up">
            <span class="pill-tag"><i class="bi bi-compass"></i>Sourced in Indonesia</span>
            <h1 id="heroHeading" class="mb-4" style="font-size: clamp(2.4rem, 4.5vw, 3.7rem);"></h1>
            <p id="heroDescription" class="lead mb-4" style="max-width: 460px;"></p>
            <div>
              <a href="/products" class="btn btn-forest btn-arrow me-2 mb-2">See Our Categories</a>
              <a href="/contact" class="btn btn-outline mb-2">Start an Inquiry</a>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-left">
            <div class="frame-tall" id="heroImageWrap">
              {{-- <div class="frame-inner"><i class="bi bi-basket"></i><span>Sourcing &amp; export photography — placeholder</span></div> --}}
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- WHO WE ARE -->
    <section class="section" id="who-we-are">
      <div class="container">
        <div class="row gy-4 mb-4">
          <div class="col-lg-6" data-aos="fade-up">
            <span class="pill-tag"><i class="bi bi-people"></i>About Us</span>
            <h2 id="aboutHeading"></h2>
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <p id="aboutDescription"></p>
          </div>
        </div>
        <div id="aboutItemList" data-aos="fade-up"></div>
    </section>

    <!-- PRODUCT CATEGORIES -->
    <section class="section bg-cream-dim" id="products">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-7" data-aos="fade-up">
            <span class="pill-tag"><i class="bi bi-box-seam"></i>Our Products</span>
            <h2 id="categoryHeading" class="mb-3"></h2>
            <p>Each category below represents a network of producers we already work with &mdash; and a starting point if you need something more specific.</p>
          </div>
        </div>
        <div class="row gy-4" id="productList"></div>
      </div>
    </section>
    <div id="productModalContainer"></div>

    <!-- CUSTOM SOURCING (export tag moment) -->
    <section class="section bg-forest text-center">
      <div class="container container-narrow" data-aos="fade-up">
        <div class="export-tag mb-4">
          <span class="tag-eyebrow" id="askUsTitle"></span>
          <span class="tag-main" id="askUsTagMain"></span>
        </div>
        <h2 id="askUsHeading" class="mb-3" style="color: var(--cream);"></h2>
        <p id="askUsDescription" class="text-on-forest mb-4"></p>
        <a href="/contact" id="askUsButton" class="btn btn-cream btn-arrow"></a>
      </div>
    </section>

    <!-- WHY CHOOSE US -->
    <section class="section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-7" data-aos="fade-up">
            <span class="pill-tag"><i class="bi bi-star"></i>Why Choose Us</span>
            <h2 id="chooseUsHeading"></h2>
          </div>
        </div>
        <div class="row gy-4" id="chooseUsList"></div>
      </div>
    </section>

    <!-- EXPORT PROCESS -->
    <section class="section bg-cream-dim">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-7" data-aos="fade-up">
            <span class="pill-tag"><i class="bi bi-signpost-split"></i>Our Process</span>
            <h2 id="ourProcessHeading"></h2>
          </div>
        </div>
        <div class="row gy-4 timeline" id="ourProcessList">
          <div class="timeline-line d-none d-lg-block"></div>
        </div>
      </div>
    </section>

    <!-- GLOBAL REACH -->
    <section class="section">
      <div class="container">
        <div class="row align-items-center gy-5">
          <div class="col-lg-6" data-aos="fade-right">
            <div class="frame-wide">
              <div class="frame-inner" id="globalReachImage">
                {{-- <i class="bi bi-globe-asia-australia"></i>
                <span>Global export &amp; logistics photography — placeholder</span> --}}
              </div>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-left">
            <span class="pill-tag"><i class="bi bi-signpost-2"></i>Global Reach</span>
            <h2 id="globalReachTitle" class="mb-3"></h2>
            <p id="globalReachDescription" class="mb-0"></p>
            <ul class="reach-list" id="globalReachList"></ul>
          </div>
        </div>
      </div>
    </section>

    <!-- FINAL CTA -->
    <section class="section bg-forest text-center">
      <div class="container container-narrow" data-aos="fade-up">
        <h2 id="finalCtaHeading" class="mb-3" style="color: var(--cream);"></h2>
        <p id="finalCtaSubheading" class="text-on-forest mb-4"></p>
        <a href="/contact" id="finalCtaButton" class="btn btn-cream btn-arrow"></a>
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
  <script src="{{ asset("template/assets/js/script.js") }}"></script>
  @stack('scripts')
  <script>
  $(function () {
    $.ajax({
      url: "/get-data/master/home",
      method: "GET",
      dataType: "json",
      success: function (data) {
        renderHome(data);
        renderNavbarBrand(data.master);
        renderFooter(data.master, data.contact);
      },
      error: function (xhr) {
        console.error("Gagal ambil data home:", xhr.status, xhr.responseText);
      }
    });

    function renderHome(data) {
      const master       = data.master || {};
      const askUs        = data.ask_us || {};
      const globalReach  = data.global_reach || {};
      const footer       = data.footer || {};
      const products     = data.products || [];
      const aboutItems   = data.about_item || [];
      const ourProcess   = data.our_process || [];
      const chooseUs     = data.choose_us || [];
      const contact      = data.contact || {};

      $("#titleWeb").html(master.website_name|| "");

      // ===== HERO =====
      $("#heroHeading").html(master.heading || "");
      $("#heroDescription").text(master.website_description || "");
      if (master.image) {
        $("#heroImageWrap").html(`<img src="${master.image}" alt="${master.website_name || ''}" class="w-100 h-100" style="object-fit:cover; border-radius: 10px;">`);
      }

      // ===== WHO WE ARE =====
      $("#aboutHeading").text(master.about_heading || "");
      $("#aboutDescription").text(master.about_description || "");

      let aboutHtml = "";
      aboutItems.forEach(function (item) {
        aboutHtml += `
          <div class="value-row">
            <div class="value-icon"><i class="bi ${item.icon || 'bi-check2'}"></i></div>
            <div>
              <h3>${item.title || ''}</h3>
              <p>${item.description || ''}</p>
            </div>
          </div>`;
      });
      $("#aboutItemList").html(aboutHtml);

      // ===== PRODUCTS / CATEGORIES =====
      $("#categoryHeading").text(master.category_heading || "");
      $("#categoryDescription").text(master.category_description || "");

      let productHtml = "";
      let modalHtml = "";

      products.forEach(function (product, index) {
        const carouselId = "productCarousel" + index;
        const modalId     = "productModal" + index;
        const images = product.images && product.images.length ? product.images : [];

        // ---- Slides untuk card kecil di grid ----
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
                      aria-label="Preview photo ${i + 1} of ${product.name}"
                      style="background:url('${img.path}') center/cover;">
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
                <div class="frame-inner"><i class="bi bi-box-seam"></i><span>${product.name}</span></div>
              </div>
            </div>`;
        }

        productHtml += `
          <div class="col-6 col-lg-3" data-aos="fade-up">
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
                <p>${product.description}</p>
                <a href="/products" class="crop-link">View category <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>`;

        $(document).on("click", ".photo-trigger", function () {
          const targetModal = $(this).data("bs-target");
          const slideIndex  = $(this).data("slide-index") || 0;
          const modalCarousel = $(targetModal + " .carousel");

          const carouselInstance = bootstrap.Carousel.getOrCreateInstance(modalCarousel[0]);
          carouselInstance.to(slideIndex);
        });

        // ---- Modal foto besar untuk produk ini ----
        let modalSlidesHtml = "";
        if (images.length > 0) {
          images.forEach(function (img, i) {
            modalSlidesHtml += `
              <div class="carousel-item ${i === 0 ? 'active' : ''}">
                <div class="frame-wide">
                  <div class="frame-inner" style="background:url('${img.path}') center/cover;"></div>
                </div>
              </div>`;
          });
        } else {
          modalSlidesHtml = `
            <div class="carousel-item active">
              <div class="frame-wide"><div class="frame-inner"><i class="bi bi-box-seam"></i><span>${product.name}</span></div></div>
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
      });

      $("#productList").html(productHtml);
      $("#productModalContainer").html(modalHtml);

      // ===== ASK US =====
      $("#askUsTitle").text(askUs.ask_us_title || "");
      $("#askUsTagMain").html(askUs.ask_us_heading || "");
      $("#askUsHeading").text(askUs.ask_us_heading || "");
      $("#askUsDescription").text(askUs.ask_us_description || "");
      $("#askUsButton").text(askUs.ask_us_button || "");

      // ===== WHY CHOOSE US =====
      $("#chooseUsHeading").text(master.choose_us_heading || "");

      let chooseUsHtml = "";
      chooseUs.forEach(function (item) {
        chooseUsHtml += `
          <div class="col-md-6 col-lg-3" data-aos="fade-up">
            <div class="reason">
              <div class="value-icon"><i class="bi ${item.icon || 'bi-check2'}"></i></div>
              <h3>${item.title || ''}</h3>
              <p>${item.description || ''}</p>
            </div>
          </div>`;
      });
      $("#chooseUsList").html(chooseUsHtml);

      // ===== OUR PROCESS =====
      $("#ourProcessHeading").text(master.our_process || "");

      let processHtml = "";
      ourProcess.forEach(function (step, index) {
        processHtml += `
          <div class="col-6 col-lg" data-aos="fade-up">
            <div class="timeline-step">
              <span class="timeline-dot">${index + 1}</span>
              <h3>${step.title || ''}</h3>
            </div>
          </div>`;
      });
      $("#ourProcessList").append(processHtml);

      // ===== GLOBAL REACH =====
      $("#globalReachTitle").text(globalReach.global_reach_title || "");
      $("#globalReachDescription").text(globalReach.global_reach_description || "");
      if(globalReach.global_reach_image != ""){
        $("#globalReachImage").append(`<img src="${globalReach.global_reach_image}" alt="" class="w-100 h-100" style="object-fit:cover; border-radius: 10px;">`);
      }

      let reachHtml = "";
      [1, 2, 3].forEach(function (i) {
        const label = globalReach["global_reach_item_" + i];
        const icon  = globalReach["global_reach_icon_item_" + i];
        if (label) {
          reachHtml += `<li><i class="bi ${icon || 'bi-check2'}"></i>${label}</li>`;
        }
      });
      $("#globalReachList").html(reachHtml);

      // ===== FOOTER / FINAL CTA =====
      $("#finalCtaHeading").text(footer.footer_home_heading || "");
      $("#finalCtaSubheading").text(footer.footer_home_subheading || "");
      $("#finalCtaButton").text(footer.footer_home_button || "");

      // ===== WHATSAPP FLOAT =====
      if (contact.whatsapp) {
        const waNumber = contact.whatsapp.replace(/[^0-9]/g, "");
        // if (waNumber.startsWith("0")) {
        //   waNumber = "62" + waNumber.substring(1);
        // }
        const waText = encodeURIComponent(
          `Hello ${master.website_name}, I am interested in sourcing products from Indonesia. I would like to discuss my requirements.`
        );
        $("#whatsappFloat").attr("href", `https://wa.me/${waNumber}?text=${waText}`);
      }

      // ===== TITLE PAGE (opsional) =====
      if (master.website_name) {
        document.title = master.website_name;
      }
    }
  });
  </script>
</body>
</html>
