<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact | Aisy Bina Exports</title>
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
        <h1 class="mb-3">Tell us what you're sourcing.</h1>
        <p class="lead mb-0" style="max-width: 660px;">The more detail you share about product, quantity, and timing, the faster we can come back with real supplier options.</p>
      </div>
    </section>

    <section class="section pt-0">
      <div class="container">
        <div class="row gy-5">

          <div class="col-lg-5" data-aos="fade-right">
            <h2 class="mb-4">Contact information</h2>

            <div class="contact-row"><span class="label">Email</span><span class="value"><a href="mailto:[EMAIL]" class="text-decoration-none">[EMAIL]</a></span></div>
            <div class="contact-row"><span class="label">WhatsApp</span><span class="value">[WHATSAPP]</span></div>
            <div class="contact-row"><span class="label">Location</span><span class="value">Indonesia</span></div>
            <div class="contact-row"><span class="label">Business Hours</span><span class="value">Monday &ndash; Friday, 09:00 &ndash; 17:00 WIB</span></div>
          </div>

          <div class="col-lg-7" data-aos="fade-left">
            <div class="inquiry-form">
              <h2 class="mb-4">Inquiry form</h2>
              <form method="POST" action="">
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

  <a href="https://wa.me/[WHATSAPP_NUMBER]?text=Hello%20Aisy%20Bina%20Exports%2C%20I%20am%20interested%20in%20sourcing%20products%20from%20Indonesia.%20I%20would%20like%20to%20discuss%20my%20requirements."
     class="whatsapp-float" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <i class="bi bi-whatsapp"></i>
  </a>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="{{ asset("template/assets/js/script.js") }}"></script>
</body>
</html>
