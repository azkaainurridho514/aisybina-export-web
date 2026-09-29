$(function () {
  AOS.init({
    duration: 700,
    once: true,
    offset: 80
  });

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
  $('a.nav-link[href^="#"], a[href^="#"].smooth-scroll').on("click", function (e) {
    var target = $(this.hash);
    if (target.length) {
      e.preventDefault();
      $("html, body").animate(
        { scrollTop: target.offset().top - 90 },
        500
      );
      var $collapse = $(".navbar-collapse");
      if ($collapse.hasClass("show")) {
        $collapse.collapse("hide");
      }
    }
  });

});

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
