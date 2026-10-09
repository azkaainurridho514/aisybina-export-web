@extends('layouts.app')
@section('title', "Contact")
@section('main')
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
            <form method="POST" action="{{ route('inquiry.store') }}" id="inquiryForm">
              @csrf
              <div class="row g-3">
                <div class="col-md-6"><label for="fullName" class="form-label">Full Name</label><input type="text" class="form-control" id="fullName" name="fullname" required></div>
                <div class="col-md-6"><label for="companyName" class="form-label">Company Name</label><input type="text" class="form-control" id="companyName" name="company_name"></div>
                <div class="col-md-6"><label for="email" class="form-label">Email</label><input type="email" class="form-control" id="email" name="email" required></div>
                <div class="col-md-6"><label for="phone" class="form-label">WhatsApp / Phone</label><input type="tel" class="form-control" id="phone" name="whatsapp"></div>
                <div class="col-md-6"><label for="country" class="form-label">Country</label><input type="text" class="form-control" id="country" name="country"></div>
                <div class="col-md-6"><label for="productInterest" class="form-label">Product Interested In</label><input type="text" class="form-control" id="productInterest" name="product_interested"></div>
                <div class="col-md-6"><label for="quantity" class="form-label">Estimated Quantity</label><input type="text" class="form-control" id="quantity" name="estimated_quantity"></div>
                <div class="col-12"><label for="message" class="form-label">Message</label><textarea class="form-control" id="message" name="message" rows="4" required></textarea></div>
                <div class="col-12 mt-2"><button type="submit" class="btn btn-forest btn-arrow">Send Inquiry</button></div>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
@push('vendors')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@push('scripts')
  <script>
    $(function () {
      $("#inquiryForm").on("submit", function (e) {
        e.preventDefault();

        var $form = $(this);
        var $submitBtn = $form.find('button[type="submit"]');
        var originalBtnText = $submitBtn.text();

        $submitBtn.prop("disabled", true).text("Sending...");

        $.ajax({
          url: $form.attr("action"),
          method: "POST",
          data: $form.serialize(),
          dataType: "json",
          success: function (res) {
            Swal.fire({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 2500,
              timerProgressBar: true,
              icon: "success", 
              title: "Your inquiry has been successfully submitted. We will contact you shortly." 
            });
            $form[0].reset();
          },
          error: function (xhr) {
            console.log(xhr);
            var errorMsg = "Terjadi kesalahan, silakan coba lagi.";
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
              errorMsg = Object.values(xhr.responseJSON.errors).flat().join("<br>");
            }
             Swal.fire({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 2500,
              timerProgressBar: true,
              icon: "error", 
              title: errorMsg 
            });
          },
          complete: function () {
            $submitBtn.prop("disabled", false).text(originalBtnText);
          }
        });
      });
    });
  </script>
@endpush
