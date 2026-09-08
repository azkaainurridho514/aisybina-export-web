/* ==========================================================================
   Aisy Bina Exports — script.js
   jQuery is used only for small, simple behaviors:
   - Navbar background/shadow state on scroll
   - Smooth scroll for in-page anchor links
   AOS handles all scroll animation.
   ========================================================================== */

$(function () {

  // Initialize AOS with light, subtle settings.
  AOS.init({
    duration: 700,
    once: true,
    offset: 80
  });

  // Add a class to the navbar once the page has scrolled a little.
  var $navbar = $("#mainNavbar");

  function updateNavbarState() {
    if ($(window).scrollTop() > 10) {
      $navbar.addClass("is-scrolled");
    } else {
      $navbar.removeClass("is-scrolled");
    }
  }

  updateNavbarState();
  $(window).on("scroll", updateNavbarState);

  // Smooth scroll for same-page anchor links (e.g. "#products").
  $('a.nav-link[href^="#"], a[href^="#"].smooth-scroll').on("click", function (e) {
    var target = $(this.hash);
    if (target.length) {
      e.preventDefault();
      $("html, body").animate(
        { scrollTop: target.offset().top - 90 },
        500
      );

      // Collapse mobile navbar after clicking a link.
      var $collapse = $(".navbar-collapse");
      if ($collapse.hasClass("show")) {
        $collapse.collapse("hide");
      }
    }
  });

});

/* ==========================================================================
   ADDITION — Product photo preview modal sync
   When a photo inside a product card carousel is clicked, the preview
   modal opens showing that same photo instead of always starting at
   the first slide. Nothing above this line was changed for this update.
   ========================================================================== */

$(function () {

  var lastClickedSlideIndex = 0;

  $(document).on('click keypress', '.photo-trigger', function (e) {
    if (e.type === 'keypress' && e.which !== 13 && e.which !== 32) {
      return;
    }
    lastClickedSlideIndex = parseInt($(this).attr('data-slide-index'), 10) || 0;
  });

  $('.photo-modal').on('shown.bs.modal', function () {
    var carouselEl = this.querySelector('.carousel');
    if (carouselEl && window.bootstrap && window.bootstrap.Carousel) {
      var instance = bootstrap.Carousel.getOrCreateInstance(carouselEl, { ride: false });
      instance.to(lastClickedSlideIndex);
    }
  });

});
