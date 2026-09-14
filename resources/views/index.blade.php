<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title id="titleWeb"></title>
  <meta name="description" content="Connects global buyers with quality products sourced from trusted suppliers across Indonesia.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <link rel="icon" type="image/png" id="iconTab">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="{{ asset("template/assets/css/style.css") }}">
  <style>

    .hero-banner {
      position: relative;
      overflow: hidden;
      min-height: 74vh;
      display: flex;
      align-items: center;
      background-color: var(--forest);
      background-image: var(--hero-bg-image, none);
      background-size: cover;
      background-position: center;
    }

    /* Gradient overlay: strong forest on the text side, fading out toward the
      photo so the picture still reads clearly on the right/bottom. Works even
      with no photo set, since it just sits on the forest fallback color. */
    .hero-banner-overlay {
      position: absolute;
      inset: 0;
      background:
        linear-gradient(100deg, rgba(22, 40, 31, 0.94) 0%, rgba(22, 40, 31, 0.78) 40%, rgba(22, 40, 31, 0.25) 70%, rgba(22, 40, 31, 0.05) 100%),
        linear-gradient(0deg, rgba(22, 40, 31, 0.55) 0%, rgba(22, 40, 31, 0) 35%);
      z-index: 0;
    }

    /* Soft blurred gold blob — the one modern accent, kept subtle */
    .hero-banner-glow {
      position: absolute;
      width: 420px;
      height: 420px;
      top: -140px;
      right: -120px;
      background: radial-gradient(circle, rgba(185, 139, 62, 0.4), transparent 70%);
      filter: blur(6px);
      z-index: 0;
      pointer-events: none;
    }

    .hero-banner .container { position: relative; z-index: 1; }
    .hero-banner .pill-tag.on-forest { margin-bottom: 1.25rem; }

    /* Outline button readable on a dark/photo background */
    .btn-outline-light {
      border-radius: 999px;
      font-weight: 600;
      font-size: 0.95rem;
      padding: 0.85rem 1.7rem;
      display: inline-flex;
      align-items: center;
      gap: 0.55rem;
      background-color: transparent;
      border: 1px solid rgba(250, 246, 236, 0.45);
      color: var(--cream);
      transition: border-color 0.2s ease, background-color 0.2s ease, transform 0.2s ease;
    }
    .btn-outline-light:hover {
      border-color: var(--cream);
      background-color: rgba(250, 246, 236, 0.08);
      color: var(--cream);
      transform: translateY(-1px);
    }
    .hero-banner-fade {
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      height: 120px;
      background: linear-gradient(
        180deg,
        rgba(240, 233, 216, 0)     0%,
        rgba(240, 233, 216, 0.005) 8.3%,
        rgba(240, 233, 216, 0.035) 16.7%,
        rgba(240, 233, 216, 0.1)   25%,
        rgba(240, 233, 216, 0.21)  33.3%,
        rgba(240, 233, 216, 0.35)  41.7%,
        rgba(240, 233, 216, 0.5)   50%,
        rgba(240, 233, 216, 0.65)  58.3%,
        rgba(240, 233, 216, 0.79)  66.7%,
        rgba(240, 233, 216, 0.9)   75%,
        rgba(240, 233, 216, 0.97)  83.3%,
        rgba(240, 233, 216, 0.995) 91.7%,
        var(--cream-dim)           100%
      );
      z-index: 1;
      pointer-events: none;
    }
    @media (max-width: 767.98px) {
      .hero-banner-fade { height: 80px; }
    }
  </style>
</head>
<body>

  @include('layouts.navbar')

  <main>

    <!-- HERO -->
    <section class="hero-banner section-tight" id="heroBanner" style="margin-top: 82px; --hero-bg-image: url('{{ asset('images/website/bg_header.png') }}');">
      <div class="hero-banner-overlay"></div>
      <div class="hero-banner-glow"></div>
      <div class="hero-banner-fade"></div>

      <div class="container position-relative">
        <div class="row">
          <div class="col-lg-7" data-aos="fade-up">
              <span class="pill-tag on-forest"><i class="bi bi-compass"></i>Welcome</span>
              <h1 id="heroHeading" class="mb-4" style="font-size: clamp(2.4rem, 4.5vw, 3.7rem); color: var(--cream);"></h1>
              <p id="heroDescription" class="lead mb-4 text-on-forest" style="max-width: 480px;"></p>
            <div>
              <a href="/products" class="btn btn-cream btn-arrow me-2 mb-2">See Our Categories</a>
              <a href="/contact" class="btn btn-outline-light mb-2">Start an Inquiry</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- WHO WE ARE -->
    <section class="section bg-cream-dim" id="who-we-are">
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
    <section class="section" id="products">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-7" data-aos="fade-up">
            <span class="pill-tag"><i class="bi bi-box-seam"></i>Our Products</span>
            <h2 id="categoryHeading" class="mb-3"></h2>
            <p id="categoryDescription"></p>
          </div>
        </div>
        <div class="row gy-4" id="productList"></div>
      </div>
    </section>
    <div id="productModalContainer"></div>

    <!-- CUSTOM SOURCING (export tag moment) -->
    <section class="section bg-forest text-center bg-cream-dim">
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
          <div class="col-lg-6" data-aos="fade-right" id="globalReachImage">
            {{-- <div class="frame-wide">
              <div class="frame-inner" id="globalReachImage">
              </div>
            </div> --}}
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
  <script src="https://cdn.jsdelivr.net/npm/dompurify@3.2.6/dist/purify.min.js"></script>
  <script src="{{ asset("template/assets/js/13-utils.js") }}"></script>
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

      $("#titleWeb").html(DOMPurify.sanitize(master.website_name|| ""));

      // ===== HERO =====
      renderQuillContent(
          "#heroHeading",
          master.heading
      );

      renderQuillContent(
          "#heroDescription",
          master.website_description
      );

      // ===== WHO WE ARE =====
      $("#aboutHeading").text(master.about_heading || "");
      renderQuillContent(
          "#aboutDescription",
          master.about_description
      );

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
      renderQuillContent(
          "#categoryDescription",
          master.category_description
      );

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

      // $("#productList").html(DOMPurify.sanitize(productHtml));
      renderQuillContent("#productList", productHtml)
      $("#productModalContainer").html(modalHtml);

      // ===== ASK US =====
      $("#askUsTitle").text(askUs.ask_us_title || "");
      $("#askUsTagMain").html(DOMPurify.sanitize(askUs.ask_us_heading || ""));
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
      renderQuillContent("#chooseUsList", chooseUsHtml);

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
      renderQuillContent("#globalReachDescription", globalReach.global_reach_description || "")

      if(globalReach.global_reach_image != ""){
        renderPhoto("#globalReachImage", globalReach.global_reach_image, "");
        // $("#globalReachImage").append(`<img src="${globalReach.global_reach_image}" alt="" class="w-100 h-100" style="object-fit:cover; border-radius: 10px;">`);
      }

      let reachHtml = "";
      [1, 2, 3].forEach(function (i) {
        const label = globalReach["global_reach_item_" + i];
        const icon  = globalReach["global_reach_icon_item_" + i];
        if (label) {
          reachHtml += `<li><i class="bi ${icon || 'bi-check2'}"></i>${label}</li>`;
        }
      });
      $("#globalReachList").html(DOMPurify.sanitize(reachHtml));

      // ===== FOOTER / FINAL CTA =====
      $("#finalCtaHeading").text(footer.footer_home_heading || "");
      renderQuillContent("#finalCtaSubheading", footer.footer_home_subheading || "");
      $("#finalCtaButton").text(footer.footer_home_button || "");

      // ===== WHATSAPP FLOAT =====
      if (contact.whatsapp) {
          const waNumber = contact.whatsapp.replace(/[^0-9]/g, "");

          const waText = encodeURIComponent(
              `Hello ${master.website_name}, I am interested in sourcing products from Indonesia. I would like to discuss my requirements.`
          );

          $("#whatsappFloat").attr(
              "href",
              `https://wa.me/${waNumber}?text=${waText}`
          );
      }else{
          $("#whatsappFloat").hide();
      }

      // ===== TITLE PAGE (opsional) =====
      if (master.website_name) {
        document.title = master.website_name;
      }
    }

    function renderPhoto(wrapSelector, src, alt) {
      if (!src) return;
      $(wrapSelector).html('<img src="' + src + '" alt="' + (alt || "") + '" style="width:100%;height:300px;object-fit:cover;display:block;border-radius:var(--radius) var(--radius) var(--radius) 4px;">');
    }
  });
  </script>
</body>
</html>
