<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title id="titleWeb"></title>
  <meta name="description" content="Learn about Aisy Bina Exports — our story, vision, mission, and the values that guide how we source products from Indonesia.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="{{ asset("template/assets/css/style.css") }}">

  <style>
    #missionList li { align-items: flex-start; }
    #missionList li i { margin-top: 0.2rem; }
    .value-card { height: 100%; }
  </style>
</head>
<body>

  @include('layouts.navbar')

  <main>

    <!-- ===================== HERO ===================== -->
    <section class="section-tight" style="margin-top: 82px;">
      <div class="container" data-aos="fade-up">
        <span class="pill-tag"><i class="bi bi-building"></i>About Us</span>
        <h1 class="mb-3" id="pageHeading"></h1>
        <p class="lead mb-0" style="max-width: 660px;" id="pageSubheading"></p>
      </div>
    </section>

    <!-- ===================== ABOUT COMPANY ===================== -->
    <section class="section pt-0">
      <div class="container">
        <div class="row gy-5 align-items-center">
          <div class="col-lg-5" data-aos="fade-right">
            <div class="frame-tall" id="introPhotoWrap">
              <div class="frame-inner"><i class="bi bi-image"></i><span>Company photo</span></div>
            </div>
          </div>
          <div class="col-lg-7" data-aos="fade-left">
            <h2 class="mb-3" id="introTitle"></h2>
            <div id="introText"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== OUR VISION ===================== -->
    <section class="section bg-forest" data-aos="fade-up">
      <div class="container">
        <div class="row align-items-center gy-5">
          <div class="col-lg-6">
            <span class="pill-tag on-forest"><i class="bi bi-binoculars"></i>Our Vision</span>
            <h2 class="mb-3" style="color: var(--cream);" id="visionHeading"></h2>
            <p class="text-on-forest mb-0" id="visionText"></p>
          </div>
          <div class="col-lg-6">
            <div class="frame-wide" id="visionPhotoWrap">
              <div class="frame-inner"><i class="bi bi-image"></i><span>Vision photo</span></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== OUR MISSION ===================== -->
    <section class="section">
      <div class="container">
        <div class="row gy-5 align-items-start">
          <div class="col-lg-5" data-aos="fade-right">
            <div class="frame-square" id="missionPhotoWrap">
              <div class="frame-inner"><i class="bi bi-image"></i><span>Product photo</span></div>
            </div>
          </div>
          <div class="col-lg-7" data-aos="fade-left">
            <span class="pill-tag"><i class="bi bi-flag"></i>Our Mission</span>
            <h2 class="mb-4" id="missionHeading"></h2>
            <ul class="reach-list" id="missionList"></ul>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== OUR VALUE ===================== -->
    <section class="section bg-cream-dim">
      <div class="container">
        <div class="row align-items-center gy-4 mb-5" data-aos="fade-up">
          <div class="col-lg-7">
            <span class="pill-tag"><i class="bi bi-gem"></i>Our Value</span>
            <h2 class="mb-3" id="valueHeading"></h2>
            <p class="mb-0" style="max-width: 520px;" id="valueIntro"></p>
          </div>
          <div class="col-lg-5">
            <div class="frame-wide" id="valuePhotoWrap">
              <div class="frame-inner"><i class="bi bi-image"></i><span>Workshop photo</span></div>
            </div>
          </div>
        </div>
        <div class="row g-4" id="valueGrid"></div>
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
    AOS.init({ once: true, duration: 600, easing: "ease-out-quart" });

    $.ajax({
      url: "/get-data/master/about",
      method: "GET",
      dataType: "json",
      success: function (data) {
        renderAbout(data);
      },
      error: function (xhr) {
        console.error("Gagal ambil data about:", xhr.status, xhr.responseText);
      }
    });

    function renderPhoto(wrapSelector, src, alt) {
      if (!src) return;
      $(wrapSelector).html('<img src="' + src + '" alt="' + (alt || "") + '" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">');
    }

    function renderAbout(data) {
      var master  = data.master || {};
      var about   = data.about || {};
      var contact = data.contact || {};

      // ===== NAVBAR & FOOTER (shared partials, rendered the same way as every other page) =====
      renderNavbarBrand(master);
      renderFooter(master, contact);

      // ===== PAGE TITLE =====
      if (master.website_name) {
        document.title = "About | " + master.website_name;
      }

      // ===== HERO =====
      $("#pageHeading").text(about.heading || "A company built on quality and trust.");
      $("#pageSubheading").text(about.subheading || "Get to know Aisy Bina Exports — who we are, where we're headed, and the values behind every shipment we send out.");

      // ===== ABOUT COMPANY =====
      $("#introTitle").text(about.intro_title || "Unlimited Creativity, Endless Innovation");
      var introParagraphs = about.intro_paragraphs && about.intro_paragraphs.length ? about.intro_paragraphs : [
        "Aisy Bina Exports is an Indonesian export company focused on providing high-quality products across our sourcing categories. We combine traditional values, product knowledge, and a modern, professional approach to serve both local and international buyers.",
        "With a strong commitment to quality, product authenticity, and professional service, we're here to answer the growing needs of local and international markets.",
        "We believe that authentic Indonesian products can compete in the global market by prioritizing quality, practicality, and cultural value."
      ];
      $("#introText").html(introParagraphs.map(function (p) { return "<p>" + p + "</p>"; }).join(""));
      renderPhoto("#introPhotoWrap", about.image_intro, "About " + (master.website_name || "us"));

      // ===== OUR VISION =====
      $("#visionHeading").text(about.vision_heading || "Our Vision");
      $("#visionText").text(about.vision_text || "To become a trusted export company that delivers original Indonesian products with superior quality — providing added value to our business partners, our consumers, and the global community.");
      renderPhoto("#visionPhotoWrap", about.image_vision, "Our vision");

      // ===== OUR MISSION =====
      $("#missionHeading").text(about.mission_heading || "Our Mission");
      var missionItems = about.mission_items && about.mission_items.length ? about.mission_items : [
        "Providing export products that are high quality, hygienic, and meet international standards",
        "Supporting the growth of local Indonesian MSMEs by opening up access to global markets",
        "Establishing sustainable partnerships based on trust, professionalism, and mutual benefit",
        "Presenting product innovations that suit the needs of the modern market",
        "Promoting a positive image of Indonesian products on the international stage"
      ];
      $("#missionList").html(missionItems.map(function (item) {
        return '<li><i class="bi bi-check2-circle"></i><span>' + item + "</span></li>";
      }).join(""));
      renderPhoto("#missionPhotoWrap", about.image_mission, "Our products");

      // ===== OUR VALUE =====
      $("#valueHeading").text(about.value_heading || "Our Value");
      $("#valueIntro").text(about.value_intro || "Aisy Bina Exports holds a set of company values that we always maintain to protect the integrity of the business.");
      renderPhoto("#valuePhotoWrap", about.image_value, "Inside our workshop");

      var values = about.values && about.values.length ? about.values : [
        { title: "Guaranteed Quality", desc: "Each product goes through a strict selection and supervision process according to export standards." },
        { title: "Professional & Trusted", desc: "We stay highly focused on business partner satisfaction and maintaining long-term relationships." },
        { title: "Sustainable Innovation", desc: "We keep adapting to global trends without leaving our local identity behind." },
        { title: "Social Commitment", desc: "Supporting local workforce empowerment and environmental sustainability." }
      ];
      $("#valueGrid").html(values.map(function (v, idx) {
        return '<div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="' + (idx * 75) + '">' +
          '<div class="value-card">' +
          '<div class="timeline-dot mb-3">' + (idx + 1) + "</div>" +
          "<h3>" + v.title + "</h3>" +
          "<p>" + v.desc + "</p>" +
          "</div></div>";
      }).join(""));

      // ===== WHATSAPP FLOAT =====
      if (contact.whatsapp) {
        var waNumber = contact.whatsapp.replace(/[^0-9]/g, "");
        var waText = encodeURIComponent(
          "Hello " + master.website_name + ", I'd like to know more about your company."
        );
        $("#whatsappFloat").attr("href", "https://wa.me/" + waNumber + "?text=" + waText);
      }
    }
  });
  </script>
</body>
</html>