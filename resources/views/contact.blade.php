<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $master->website_name ? 'Contact | ' . $master->website_name : 'Contact' }}</title>
  <meta name="description" content="Get in touch with Aisy Bina Exports to discuss sourcing products from Indonesia for your business.">
  <link rel="icon" type="image/png" href="{{ $master->logo ?? '' }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

  @include('layouts.navbar', ['master' => $master])

  <main>

    <section class="section-tight" style="margin-top: 82px;">
      <div class="container" data-aos="fade-up">
        <span class="pill-tag"><i class="bi bi-envelope"></i>Contact</span>
        <h1 class="mb-3">{!! quill_inline($contact->heading ?? "Tell us what you're sourcing.") !!}</h1>
        <p class="lead mb-0" style="max-width: 660px;">{!! quill_inline($contact->subheading ?? '') !!}</p>
      </div>
    </section>

    <section class="section pt-0">
      <div class="container">
        <div class="row gy-5">

          <div class="col-lg-5" data-aos="fade-right">
            <h2 class="mb-4">Contact information</h2>
            <div id="contactInfoList">
              @if (!empty($contact->email))
                <div class="contact-row">
                  <span class="label">Email</span>
                  <span class="value"><a href="mailto:{{ $contact->email }}" class="text-decoration-none">{{ $contact->email }}</a></span>
                </div>
              @endif

              @if (!empty($contact->whatsapp))
                <div class="contact-row">
                  <span class="label">WhatsApp</span>
                  <span class="value">{{ $contact->whatsapp }}</span>
                </div>
              @endif

              @if (!empty($contact->location))
                <div class="contact-row">
                  <span class="label">Location</span>
                  <span class="value">{{ $contact->location }}</span>
                </div>
              @endif

              @if (count($businessHoursLines))
                <div class="contact-row">
                  <span class="label">Business Hours</span>
                  <span class="value">{!! implode('<br>', array_map('e', $businessHoursLines)) !!}</span>
                </div>
              @endif
            </div>
          </div>

          <div class="col-lg-7" data-aos="fade-left">
            <div class="inquiry-form">
              <h2 class="mb-4">Inquiry form</h2>
              <div id="inquiryAlert"></div>
              <form method="POST" action="{{ route('inquiry.store') }}" id="inquiryForm">
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

  @include('layouts.footer', ['master' => $master, 'contact' => $contact])

  <a href="{{ !empty($contact->whatsapp) ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $contact->whatsapp) . '?text=' . urlencode('Hello ' . ($master->website_name ?? '') . ", I am interested in sourcing products from Indonesia. I would like to discuss my requirements.") : '#' }}"
     id="whatsappFloat"
     class="whatsapp-float @if (empty($contact->whatsapp)) d-none @endif"
     target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <i class="bi bi-whatsapp"></i>
  </a>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  @stack('scripts')
  <script>
    // Cuma submit form inquiry yang tetap AJAX — ini aksi, bukan konten.
    $(function () {
      $("#inquiryForm").on("submit", function (e) {
        e.preventDefault();

        var $form = $(this);
        var $submitBtn = $form.find('button[type="submit"]');
        var originalBtnText = $submitBtn.text();

        $submitBtn.prop("disabled", true).text("Sending...");
        $("#inquiryAlert").html("");

        $.ajax({
          url: $form.attr("action"),
          method: "POST",
          data: $form.serialize(),
          dataType: "json",
          success: function (res) {
            $("#inquiryAlert").html(
              '<div class="alert alert-success" role="alert">' +
              (res.message || "Your inquiry has been successfully submitted. We will contact you shortly.") +
              "</div>"
            );
            $form[0].reset();
          },
          error: function (xhr) {
            var errorMsg = "Terjadi kesalahan, silakan coba lagi.";
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
              errorMsg = Object.values(xhr.responseJSON.errors).flat().join("<br>");
            }
            $("#inquiryAlert").html('<div class="alert alert-danger" role="alert">' + errorMsg + "</div>");
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