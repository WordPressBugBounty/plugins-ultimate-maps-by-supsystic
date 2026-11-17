/**
 * One look for the admin pages of Ultimate Maps (with css/admin.design.css). The old jQuery UI dialogs give every
 * button the same look: when a dialog of the plugin opens, the buttons that only close it (Cancel, Close, No) are
 * marked plain, so the action button is the only dark one, and the dialog is centered under the admin bar. It runs a
 * tick later, after the plugin's own handlers of the same event.
 */
(function ($) {
  'use strict';

  var plain = /^(cancel|close|no|back|отмена|закрыть|нет|назад)$/i;

  $(document).on('dialogopen', function (event) {
    var $dialog = $(event.target).closest('.ui-dialog');
    if (!$dialog.length) {
      return;
    }
    setTimeout(function () {
      var $buttons = $dialog.find('.ui-dialog-buttonset button');
      $buttons.each(function () {
        var $button = $(this);
        // A dialog with one button (OK, Close) keeps it as its action
        $button.toggleClass('ums-dlg-plain', $buttons.length > 1 && plain.test($.trim($button.text())));
      });
      $dialog.addClass('ums-dlg-center');
    }, 0);
  });

  // The frame of the page reaches at least the bottom of the side menu (both start under the breadcrumbs), and on a
  // short page it goes down to the bottom of the WordPress menu or the window: the footer closes the page with no
  // empty strip under it (only the usual room of the WordPress footer)
  function fitFrame() {
    var $nav = $('.supsystic-plugin .supsystic-content > .supsystic-navigation');
    var $frame = $('.supsystic-plugin .supsystic-content > .supsystic-container');
    var $foot = $('.supsystic-plugin .supsystic-footer-wrapper');
    if (!$nav.length || !$frame.length) {
      return;
    }
    $frame.css('min-height', '');
    var min = Math.ceil($nav.outerHeight());
    if ($foot.length) {
      var $menu = $('#adminmenuwrap');
      var bottom = $(window).height() - 65;
      if ($menu.length && $menu.is(':visible')) {
        bottom = Math.max(bottom, $menu.offset().top + $menu.outerHeight());
      }
      var gap = bottom - ($foot.offset().top + $foot.outerHeight());
      if (gap > 0) {
        min = Math.max(min, Math.ceil($frame.outerHeight() + gap));
      }
    }
    $frame.css('min-height', min + 'px');
  }
  $(fitFrame);
  $(window).on('load resize', fitFrame);
  $(document).on('wp-collapse-menu', fitFrame);
})(jQuery);
