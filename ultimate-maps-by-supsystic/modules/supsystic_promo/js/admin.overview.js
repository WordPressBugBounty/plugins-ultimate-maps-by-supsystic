(function ($) {
  'use strict';

  $(function () {
    $('.ums-overview a[href^="#"]').on('click', function (event) {
      var target = document.querySelector(this.getAttribute('href'));
      if (!target) {
        return;
      }

      event.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    $('.ums-overview-faq-question').on('click', function () {
      var $item = $(this).closest('.ums-overview-faq-item');
      var willOpen = !$item.hasClass('is-open');

      $item.siblings('.is-open').removeClass('is-open').find('.ums-overview-faq-question').attr('aria-expanded', 'false');
      $item.toggleClass('is-open', willOpen);
      $(this).attr('aria-expanded', willOpen ? 'true' : 'false');
    });
  });
})(jQuery);
