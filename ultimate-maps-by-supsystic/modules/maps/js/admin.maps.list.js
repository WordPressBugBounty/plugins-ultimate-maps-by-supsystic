(function ($) {
  'use strict';

  $(function () {
    var $root = $('#ums-maps-list');
    if (!$root.length) return;

    var config = window.umsMapListConfig || {};
    var labels = config.labels || {};
    var state = $.extend({ page: 1, perPage: 20, sort: 'id', dir: 'desc', recordsTotal: 0, search: '' }, config.initial || {});
    var $table = $('#ums-maps-table');
    var $tbody = $('#ums-maps-tbody');
    var $all = $('#ums-select-all');
    var $status = $('#ums-list-status');
    var $delete = $('#umsMapsRemoveGroupBtn');
    var $clone = $('#umsMapsCloneGroupBtn');
    var activeRequest = null;
    var sequence = 0;
    var searchTimer = null;
    var actionBusy = false;

    function pages() { return Math.max(1, Math.ceil(state.recordsTotal / state.perPage)); }
    function status(message, error) {
      $status.text(message || '').toggleClass('is-visible', !!message).toggleClass('is-error', !!error);
    }
    function rowId(element, prefix) { return parseInt(element.id.slice(prefix.length), 10) || 0; }
    function selectedIds() {
      return $tbody.find('.ums-row-checkbox:checked').map(function () { return rowId(this, 'ums-check-'); }).get().filter(function (id) { return id > 0; });
    }
    function updateSelection() {
      var count = selectedIds().length;
      var available = $tbody.find('.ums-row-checkbox').length;
      $all.prop({ checked: available > 0 && count === available, indeterminate: count > 0 && count < available });
      $delete.prop('disabled', actionBusy || count === 0);
      $clone.prop('disabled', actionBusy || count === 0);
    }
    function normalizeChecks() {
      $root.find('.ums-native-check').each(function () {
        var $input = $(this);
        if ($input.parent().hasClass('icheckbox_minimal') && $.fn.iCheck) $input.iCheck('destroy');
      });
    }
    function updateSort() {
      $table.find('.ums-sortable').each(function () {
        var $head = $(this);
        var selected = this.id === 'ums-sort-' + state.sort;
        $head.toggleClass('ums-sort-active', selected).attr('aria-sort', selected ? (state.dir === 'asc' ? 'ascending' : 'descending') : 'none');
        $head.find('.ums-sort-icon').removeClass('fa-sort fa-sort-asc fa-sort-desc').addClass(selected ? (state.dir === 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort');
      });
    }
    function pageItems(total, current) {
      var result = [], i;
      if (total <= 7) { for (i = 1; i <= total; i++) result.push(i); return result; }
      result.push(1);
      if (current > 3) result.push('…');
      for (i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) result.push(i);
      if (current < total - 2) result.push('…');
      result.push(total);
      return result;
    }
    function updatePagination() {
      var total = pages();
      var from = state.recordsTotal ? (state.page - 1) * state.perPage + 1 : 0;
      var to = Math.min(state.page * state.perPage, state.recordsTotal);
      var $numbers = $('#ums-page-numbers').empty();
      $('#ums-pagination-info').text(from + '–' + to + ' ' + (labels.of || 'of') + ' ' + state.recordsTotal + ' ' + (labels.maps || 'maps'));
      $.each(pageItems(total, state.page), function (_, value) {
        if (typeof value === 'string') { $('<span class="ums-page-ellipsis" aria-hidden="true">…</span>').appendTo($numbers); return; }
        $('<button type="button" class="ums-page-number"></button>').text(value).toggleClass('ums-page-active', value === state.page)
          .attr({ 'aria-label': 'Page ' + value, 'aria-current': value === state.page ? 'page' : null })
          .appendTo($numbers);
      });
      $('#ums-prev-page').prop('disabled', actionBusy || state.page <= 1);
      $('#ums-next-page').prop('disabled', actionBusy || state.page >= total);
      $('#ums-per-page').val(String(state.perPage));
    }
    function setLoading(loading) {
      $root.toggleClass('is-loading', loading);
      $table.attr('aria-busy', loading ? 'true' : 'false');
      $('#ums-per-page, #ums-prev-page, #ums-next-page, #ums-page-numbers button').prop('disabled', loading);
      if (!loading) { updatePagination(); updateSelection(); }
    }
    function requestPage(preserveStatus) {
      var current = ++sequence;
      if (activeRequest && activeRequest.readyState !== 4) activeRequest.abort();
      setLoading(true);
      if (!preserveStatus) status('');
      activeRequest = $.ajax({ url: config.listUrl, type: 'POST', dataType: 'json', data: {
        _wpnonce: config.nonce, page: state.page, perPage: state.perPage, sort: state.sort, dir: state.dir, search: state.search
      } }).done(function (response) {
        if (current !== sequence) return;
        if (!response || response.error || !response.data) { status((response && response.errors && response.errors.join(', ')) || labels.requestFailed, true); return; }
        var data = response.data;
        state.page = parseInt(data.page, 10) || 1;
        state.perPage = parseInt(data.perPage, 10) || 20;
        state.recordsTotal = parseInt(data.recordsTotal, 10) || 0;
        state.sort = data.sort || state.sort;
        state.dir = data.dir === 'asc' ? 'asc' : 'desc';
        $tbody.html(data.html || '');
        normalizeChecks();
        $all.prop({ checked: false, indeterminate: false });
        updateSelection(); updateSort(); updatePagination();
        if (!preserveStatus) status('');
      }).fail(function (_, reason) {
        if (reason !== 'abort' && current === sequence) status(labels.requestFailed || 'Could not load maps.', true);
      }).always(function () { if (current === sequence) setLoading(false); });
    }
    function runAction(ids, type) {
      if (!ids.length || actionBusy) return;
      if (!window.confirm((type === 'delete' ? labels.confirmDelete : labels.confirmClone) || 'Continue?')) return;
      actionBusy = true;
      updateSelection();
      status('');
      $.ajax({ url: type === 'delete' ? config.removeUrl : config.cloneUrl, type: 'POST', dataType: 'json', data: {
        _wpnonce: config.nonce, listIds: ids
      } }).done(function (response) {
        if (!response || response.error) {
          status((response && response.errors && response.errors.join(', ')) || labels.requestFailed, true);
          return;
        }
        status(type === 'delete' ? labels.deleted : labels.cloned);
        requestPage(true);
      }).fail(function () { status(labels.requestFailed || 'The request failed.', true); })
        .always(function () { actionBusy = false; updateSelection(); updatePagination(); });
    }

    $table.on('click keydown', '.ums-sortable', function (event) {
      if (event.type === 'keydown' && event.key !== 'Enter' && event.key !== ' ') return;
      if (event.type === 'keydown') event.preventDefault();
      var key = this.id.slice('ums-sort-'.length);
      state.dir = state.sort === key && state.dir === 'asc' ? 'desc' : 'asc';
      state.sort = key; state.page = 1; requestPage();
    });
    $('#ums-prev-page').on('click', function () { if (state.page > 1) { state.page--; requestPage(); } });
    $('#ums-next-page').on('click', function () { if (state.page < pages()) { state.page++; requestPage(); } });
    $('#ums-page-numbers').on('click', '.ums-page-number', function () {
      var page = parseInt($(this).text(), 10);
      if (page > 0 && page !== state.page) { state.page = page; requestPage(); }
    });
    $('#ums-per-page').on('change', function () { state.perPage = parseInt(this.value, 10) || 20; state.page = 1; requestPage(); });
    $('#umsMapsTblSearchTxt').on('input', function () {
      var value = $.trim(this.value);
      clearTimeout(searchTimer);
      searchTimer = setTimeout(function () { state.search = value; state.page = 1; requestPage(); }, 300);
    });
    $all.on('change', function () { $tbody.find('.ums-row-checkbox').prop('checked', this.checked); updateSelection(); });
    $tbody.on('change', '.ums-row-checkbox', updateSelection);
    $delete.on('click', function () { runAction(selectedIds(), 'delete'); });
    $clone.on('click', function () { runAction(selectedIds(), 'clone'); });
    $tbody.on('click', '.ums-delete-map', function () { runAction([rowId(this, 'ums-delete-')], 'delete'); });
    $tbody.on('click', '.ums-clone-map', function () { runAction([rowId(this, 'ums-clone-')], 'clone'); });
    $tbody.on('click focus', '.ums-copy-code', function () { this.select(); });

    normalizeChecks(); updateSort(); updatePagination(); updateSelection();
  });
})(jQuery);
