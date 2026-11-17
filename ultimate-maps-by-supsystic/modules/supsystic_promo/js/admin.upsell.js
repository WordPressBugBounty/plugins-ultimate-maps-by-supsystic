/**
 * PRO feature windows of the free version (the same windows as in Photo Gallery and Data Tables). Any element with
 * data-ums-upsell="<feature>" opens the window of that feature, if the page has it (templates printed by the
 * supsystic_promo module); otherwise the element keeps its own behaviour, so its link still leads to the PRO page.
 * The listener runs in the capture phase, before the handlers of the tabs and buttons it sits in.
 */
(function () {
  'use strict';

  var dialog = null,
    body = null;

  function setup() {
    if (dialog) {
      return true;
    }
    dialog = document.querySelector('[data-ums-up]');
    body = dialog ? dialog.querySelector('[data-ums-up-body]') : null;
    if (!dialog || !body || typeof dialog.showModal !== 'function') {
      dialog = null;
      return false;
    }
    dialog.addEventListener('click', function (event) {
      // A click on the dimmed backdrop lands on the dialog itself
      if (event.target === dialog || event.target.closest('[data-ums-up-close]')) {
        dialog.close();
      }
    });
    return true;
  }

  /**
   * @param {string} key The feature
   * @return {boolean} Whether the window opened
   */
  function open(key) {
    var template = key ? document.getElementById('ums-up-' + key) : null;
    if (!template || !setup()) {
      return false;
    }
    body.textContent = '';
    body.appendChild(template.content.cloneNode(true));
    if (!dialog.open) {
      dialog.showModal();
    }
    body.scrollTop = 0;
    var cta = body.querySelector('.ums-up-cta');
    if (cta) {
      cta.focus({ preventScroll: true });
    }
    return true;
  }

  document.addEventListener(
    'click',
    function (event) {
      var trigger = event.target.closest ? event.target.closest('[data-ums-upsell]') : null;
      if (trigger && open(trigger.getAttribute('data-ums-upsell'))) {
        event.preventDefault();
        event.stopImmediatePropagation();
      }
    },
    true
  );

  window.UmsUpsell = { open: open };
})();
