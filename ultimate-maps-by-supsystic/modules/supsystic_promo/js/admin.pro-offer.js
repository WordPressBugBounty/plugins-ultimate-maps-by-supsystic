/* Free vs PRO comparison and PRO pricing on the Overview page: the same behaviour as on the supsystic.com plugin page
   (the matrix filter, the rings of the plans and the license tabs of the prices), scoped to .ums-pro-offer. */
(function (init) {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})(function () {
  var offer = document.querySelector('.ums-pro-offer');
  if (!offer) {
    return;
  }
  /* Free / Pro matrix filter: hides a group heading once all of its rows are out */
  (function () {
    var table = offer.querySelector('.umpMtxTable');
    if (!table) { return; }
    var filters = offer.querySelectorAll('.umpMtxFilter');
    var empty = table.querySelector('.umpMtxEmpty');
    var nodes = Array.prototype.slice.call(table.children);
    function apply(want) {
      var group = null, groupVisible = 0, total = 0;
      function closeGroup() { if (group) { group.hidden = groupVisible === 0; } }
      nodes.forEach(function (node) {
        if (node.hasAttribute('data-ump-group')) { closeGroup(); group = node; groupVisible = 0; return; }
        var tier = node.getAttribute('data-ump-tier');
        if (!tier) { return; }
        var show = want === 'all' || tier === want;
        node.hidden = !show;
        if (show) { groupVisible++; total++; }
      });
      closeGroup();
      if (empty) { empty.hidden = total !== 0; }
    }
    Array.prototype.forEach.call(filters, function (btn) {
      btn.addEventListener('click', function () {
        Array.prototype.forEach.call(filters, function (b) { b.classList.toggle('umpMtxFilterActive', b === btn); });
        apply(btn.getAttribute('data-ump-tier-filter'));
      });
    });
  })();
  /* Free / Pro rings: fill the arc and count up the first time the cards come into view. */
  (function () {
    var band = offer.querySelector('.umpMtxTop');
    var plans = offer.querySelectorAll('.umpMtxPlan');
    if (!band || !plans.length) { return; }
    var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    function reveal(plan) {
      plan.classList.add('umpIsIn');
      var num = plan.querySelector('.umpMtxRingNum');
      if (!num) { return; }
      var target = parseInt(num.getAttribute('data-count'), 10);
      if (!target) { return; }
      if (reduced) { num.textContent = target; return; }
      var DURATION = 1400, started = null;
      num.textContent = '0';
      function tick(now) {
        if (started === null) { started = now; }
        var p = (now - started) / DURATION;
        if (p > 1) { p = 1; }
        var eased = 1 - Math.pow(1 - p, 5);
        num.textContent = Math.round(eased * target);
        if (p < 1) { window.requestAnimationFrame(tick); }
      }
      window.requestAnimationFrame(tick);
    }
    band.classList.add('umpMtxAnimReady');
    if (!('IntersectionObserver' in window)) { Array.prototype.forEach.call(plans, reveal); return; }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) { if (entry.isIntersecting) { reveal(entry.target); io.unobserve(entry.target); } });
    }, { threshold: 0.4 });
    Array.prototype.forEach.call(plans, function (plan) { io.observe(plan); });
  })();
  (function () {
    var root = offer.querySelector(".supPricing");
    if (!root) {
      return;
    }
    var tabs = root.querySelectorAll('.sptTab');
    var panels = root.querySelectorAll('.sptPanel');
    for (var i = 0; i < tabs.length; i++) {
      tabs[i].addEventListener('click', function () {
        var licence = this.getAttribute('data-licence');
        for (var t = 0; t < tabs.length; t++) {
          var isActive = tabs[t] === this;
          tabs[t].classList.toggle('is-active', isActive);
          tabs[t].setAttribute('aria-selected', isActive ? 'true' : 'false');
        }
        for (var p = 0; p < panels.length; p++) {
          panels[p].hidden = panels[p].getAttribute('data-licence') !== licence;
        }
      });
    }
  })();
});
