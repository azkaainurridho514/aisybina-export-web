<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title id="titleWeb"></title>
  <meta name="description" content="Get in touch with Aisy Bina Exports to discuss sourcing products from Indonesia for your business.">

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

    <section class="section-tight" style="margin-top: 82px;">
      <div class="container" data-aos="fade-up">
        <span class="pill-tag"><i class="bi bi-envelope"></i>Contact</span>
        <h1 class="mb-3" id="pageHeading"></h1>
        <p class="lead mb-0" style="max-width: 660px;" id="pageSubheading"></p>
      </div>
    </section>

    <section class="section pt-0">
      <div class="container">
        <div class="row gy-5">

          <div class="col-lg-5" data-aos="fade-right">
            <h2 class="mb-4">Contact information</h2>
            <div id="contactInfoList"></div>
          </div>

          <div class="col-lg-7" data-aos="fade-left">
            <div class="inquiry-form">
              <h2 class="mb-4">Inquiry form</h2>
              <div id="inquiryAlert"></div>
              <form method="POST" action="" id="inquiryForm">
                @csrf
                <div class="row g-3">
                  <div class="col-md-6"><label for="fullName" class="form-label">Full Name</label><input type="text" class="form-control" id="fullName" name="full_name" required></div>
                  <div class="col-md-6"><label for="companyName" class="form-label">Company Name</label><input type="text" class="form-control" id="companyName" name="company_name"></div>
                  <div class="col-md-6"><label for="email" class="form-label">Email</label><input type="email" class="form-control" id="email" name="email" required></div>
                  <div class="col-md-6"><label for="phone" class="form-label">WhatsApp / Phone</label><input type="tel" class="form-control" id="phone" name="phone"></div>
                  <div class="col-md-6"><label for="country" class="form-label">Country</label><input type="text" class="form-control" id="country" name="country"></div>
                  <div class="col-md-6"><label for="productInterest" class="form-label">Product Interested In</label><input type="text" class="form-control" id="productInterest" name="product_interest"></div>
                  <div class="col-md-6"><label for="quantity" class="form-label">Estimated Quantity</label><input type="text" class="form-control" id="quantity" name="quantity"></div>
                  <div class="col-12"><label for="message" class="form-label">Message</label><textarea class="form-control" id="message" name="message" rows="4" required></textarea></div>
                  <div class="col-12 mt-2"><button type="submit" class="btn btn-forest btn-arrow">Send Inquiry</button></div>
                </div>
              </form>
            </div>
          </div>

        </div>
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
      url: "/get-data/master/contact",
      method: "GET",
      dataType: "json",
      success: function (data) {
        renderContact(data);
      },
      error: function (xhr) {
        console.error("Gagal ambil data contact:", xhr.status, xhr.responseText);
      }
    });

       
    const validDays = [
      "senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu",
      "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"
    ];

    function normalizeDay(rawDay) {
      return (rawDay || "").toLowerCase().replace(/\s+/g, "");
    }

    function isValidDay(rawDay) {
      return validDays.includes(normalizeDay(rawDay));
    }

    const dayOrder = [
      "senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu",
      "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"
    ];

    function renderContact(data) {
      const businessHours = data.bussiness_hours || [];
      const master        = data.master || {};
      const contact       = data.contact || {};

      // ===== NAVBAR & FOOTER =====
      renderNavbarBrand(master);
      renderFooter(master, contact);

      // ===== HERO =====
      $("#pageHeading").text(contact.heading || "Tell us what you're sourcing.");
      $("#pageSubheading").text(contact.subheading || "");

      // ===== PAGE TITLE =====
      if (master.website_name) {
        document.title = "Contact | " + master.website_name;
      }

      // ===== CONTACT INFORMATION (tampil hanya kalau ada isinya) =====
      let infoHtml = "";

      if (contact.email) {
        infoHtml += `
          <div class="contact-row">
            <span class="label">Email</span>
            <span class="value"><a href="mailto:${contact.email}" class="text-decoration-none">${contact.email}</a></span>
          </div>`;
      }

      if (contact.whatsapp) {
        infoHtml += `
          <div class="contact-row">
            <span class="label">WhatsApp</span>
            <span class="value">${contact.whatsapp}</span>
          </div>`;
      }

      if (contact.location) {
        infoHtml += `
          <div class="contact-row">
            <span class="label">Location</span>
            <span class="value">${contact.location}</span>
          </div>`;
      }
      if (businessHours.length > 0) {
        const standardDays = businessHours.filter(bh => isValidDay(bh.day));
        const customDays   = businessHours.filter(bh => !isValidDay(bh.day));

        const sortedStandard = [...standardDays].sort(function (a, b) {
          return dayOrder.indexOf(normalizeDay(a.day)) - dayOrder.indexOf(normalizeDay(b.day));
        });

        const groups = [];
        sortedStandard.forEach(function (bh) {
          const last = groups[groups.length - 1];
          const currentIndex = dayOrder.indexOf(normalizeDay(bh.day));
          const lastIndex = last ? dayOrder.indexOf(normalizeDay(last.dayLabelEnd)) : null;

          const isConsecutive = last && (lastIndex + 1 === currentIndex);
          const isSameTime = last && last.start_time === bh.start_time && last.end_time === bh.end_time;

          if (last && isConsecutive && isSameTime) {
            last.dayLabelEnd = bh.day;
          } else {
            groups.push({
              dayLabelStart: bh.day,
              dayLabelEnd: bh.day,
              start_time: bh.start_time,
              end_time: bh.end_time
            });
          }
        });

        let lines = groups.map(function (g) {
          const label = g.dayLabelStart === g.dayLabelEnd
            ? g.dayLabelStart
            : `${g.dayLabelStart} \u2013 ${g.dayLabelEnd}`;
          return `${label}, ${g.start_time} \u2013 ${g.end_time} WIB`;
        });

        customDays.forEach(function (bh) {
          lines.push(bh.start_time && bh.end_time
            ? `${bh.day}, ${bh.start_time} \u2013 ${bh.end_time} WIB`
            : `${bh.day}: Closed`);
        });

        // Gabungkan ke infoHtml, BUKAN append terpisah
        infoHtml += `
          <div class="contact-row">
            <span class="label">Business Hours</span>
            <span class="value">${lines.join("<br>")}</span>
          </div>`;
      }

      // Panggil .html() SEKALI SAJA di akhir, setelah semua bagian digabung
      $("#contactInfoList").html(infoHtml);

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


    }

    $("#inquiryForm").on("submit", function (e) {
      e.preventDefault();

      const $form = $(this);
      const $submitBtn = $form.find('button[type="submit"]');
      const originalBtnText = $submitBtn.text();

      $submitBtn.prop("disabled", true).text("Sending...");
      $("#inquiryAlert").html("");

      $.ajax({
        url: "/inquiry",
        method: "POST",
        data: $form.serialize(),
        dataType: "json",
        success: function (res) {
          $("#inquiryAlert").html(`
            <div class="alert alert-success" role="alert">
              ${res.message || "Your inquiry has been successfully submitted. We will contact you shortly."}
            </div>`);
          $form[0].reset();
        },
        error: function (xhr) {
          let errorMsg = "Terjadi kesalahan, silakan coba lagi.";

          if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
            const errors = xhr.responseJSON.errors;
            errorMsg = Object.values(errors).flat().join("<br>");
          }

          $("#inquiryAlert").html(`
            <div class="alert alert-danger" role="alert">
              ${errorMsg}
            </div>`);
        },
        complete: function () {
          $submitBtn.prop("disabled", false).text(originalBtnText);
        }
      });
    });
  });
  </script>
</body>
</html>
