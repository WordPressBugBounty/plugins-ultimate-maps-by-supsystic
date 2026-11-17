/**
 * Map editor: the settings of the map are split into groups shown as tabs, every part is a card, a search finds any
 * setting, and the checkboxes look like switches. The markers and shapes forms get cards too.
 *
 * Only the presentation changes. No field is moved, renamed or rebuilt: the rows stay in their tables (the forms hold
 * WordPress editors, whose frames reload when moved), a card is a run of rows with a heading row put before it. The
 * page scripts, the saved values and the PRO forms of any version keep working as before.
 */
(function ($) {
  'use strict';

  var STORAGE_KEY = 'umsMapEditorGroup';
  var T = window.umsEditUi || {};

  function t(key, fallback) {
    return T[key] || fallback;
  }

  /* Cards of each form, in the order of their rows. A row belongs to the card that lists one of its field names; a row
     without fields (a label, buttons) joins the card of the next row; an unknown row stays with the card before it. */
  var MAP_CARDS = [
    { key: 'general', group: 'basics', icon: 'fa-sliders', fields: ['map_opts[title]', 'map_opts[width]', 'map_opts[height]'] },
    { key: 'controls', group: 'controls', icon: 'fa-hand-pointer-o', fields: ['map_opts[navigation_bar_mode]', 'map_opts[draggable]', 'map_opts[mouse_wheel_zoom]', 'map_opts[dbl_click_zoom]'] },
    { key: 'view', group: 'view', icon: 'fa-crosshairs', fields: ['map_opts[map_center][address]', 'map_opts[map_center][coord_x]', 'map_opts[zoom]', 'map_opts[zoom_min]'] },
    { key: 'look', group: 'look', icon: 'fa-paint-brush', fields: ['map_opts[map_type]', 'map_opts[map_stylization]'] },
    { key: 'markers', group: 'markers', icon: 'fa-map-marker', fields: ['map_opts[marker_hover]', 'map_opts[marker_clasterer]'] },
    { key: 'list', group: 'markers', icon: 'fa-list-ul', upsell: 'markers_list', fields: ['map_opts[enable_marker_list_type]', 'map_opts[markers_list_type]'] },
    { key: 'kml', group: 'layers', icon: 'fa-clone', upsell: 'kml', fields: ['map_opts[kml_file_url][]', 'map_opts[kml_import_to_marker]'] },
    { key: 'poi', group: 'layers', icon: 'fa-eye-slash', upsell: 'hide_poi', fields: ['map_opts[hide_poi]'] },
    { key: 'visitors', group: 'markers', icon: 'fa-users', upsell: 'frontend_markers', fields: ['map_opts[frontend_add_markers]'] },
    { key: 'infownd', group: 'info', icon: 'fa-commenting-o', fields: ['map_opts[marker_infownd_width_units]', 'map_opts[marker_infownd_height_units]', 'map_opts[marker_title_color]', 'map_opts[marker_infownd_bg_color]', 'map_opts[marker_title_size]', 'map_opts[marker_desc_size]'] },
  ];
  // The same groups, keys and names as the map editor of Easy Google Maps
  var MAP_GROUPS = [
    { key: 'basics', icon: 'fa-sliders' },
    { key: 'view', icon: 'fa-crosshairs' },
    { key: 'controls', icon: 'fa-hand-pointer-o' },
    { key: 'look', icon: 'fa-paint-brush' },
    { key: 'markers', icon: 'fa-map-marker' },
    { key: 'layers', icon: 'fa-clone' },
    { key: 'info', icon: 'fa-commenting-o' },
    { key: 'more', icon: 'fa-ellipsis-h' },
  ];
  var MARKER_CARDS = [
    { key: 'marker', icon: 'fa-map-marker', fields: ['marker_opts[title]', 'markerDescription', 'marker_opts[description]'] },
    { key: 'place', icon: 'fa-location-arrow', fields: ['marker_opts[icon]', 'marker_opts[address]', 'marker_opts[coord_x]', 'marker_opts[coord_y]', 'marker_opts[marker_group_id][]'] },
    { key: 'behaviour', icon: 'fa-mouse-pointer', fields: ['marker_opts[params][marker_link]', 'marker_opts[params][show_description]', 'marker_opts[params][description_mouse_hover]', 'marker_opts[params][description_mouse_leave]', 'marker_opts[params][marker_list_def_img]', 'marker_opts[params][clasterer_exclude]'] },
    { key: 'period', icon: 'fa-calendar', upsell: 'marker_period', fields: ['marker_opts[period_date_from]', 'marker_opts[period_date_to]'] },
  ];
  var SHAPE_CARDS = [
    { key: 'shape', icon: 'fa-cubes', fields: ['shape_opts[title]'] },
    { key: 'shapeLook', icon: 'fa-paint-brush', fields: ['shape_opts[params][strokeColor]', 'shape_opts[params][fillColor]', 'shapeDescription'] },
    { key: 'points', icon: 'fa-map-pin', fields: ['shape_opts[coords][0][lat]', 'shape_opts[coords][0][address]'] },
  ];

  var TEXTS = {
    general: ['Name and size', 'How the map is called and how much room it takes on the page.'],
    controls: ['Navigation and gestures', 'What visitors can do with the map: zoom buttons, dragging, the mouse wheel.'],
    view: ['Center and zoom', 'Where the map opens and how close visitors can zoom.'],
    look: ['Map look', 'The tiles of the map: streets, terrain, satellite and more.'],
    markers: ['Markers on the map', 'Descriptions on hover and groups of close markers.'],
    list: ['Markers list', 'A slider or a table of all markers under or beside the map.'],
    kml: ['KML layers', 'Routes, areas and points from KML files over the map.'],
    poi: ['Points of interest', 'Hide hotels, fuel stations and other places of the base map.'],
    visitors: ['Markers from visitors', 'Visitors add their own markers to the map from the page.'],
    infownd: ['Info window', 'The popup with the marker or shape description.'],
    marker: ['Marker', 'The name and the text of the popup.'],
    place: ['Icon and location', 'The pin, its place on the map and its categories.'],
    behaviour: ['On click and hover', 'What happens when visitors click or point at the marker.'],
    period: ['Show between dates', 'The marker appears on the map only for the dates you set.'],
    shape: ['Shape', 'Pick a type to draw a new shape, or edit the chosen one.'],
    shapeLook: ['Look and description', 'Lines, fill and the text of the popup.'],
    points: ['Points', 'Type an address or coordinates, or click the map to add points.'],
  };
  var GROUP_LABELS = { basics: 'Basics', view: 'Center & Zoom', controls: 'Controls', look: 'Look', markers: 'Markers', layers: 'Layers', info: 'Info window', more: 'More' };
  var PRO_NOTES = {
    markers_list: 'Photo sliders and a searchable table of your locations next to the map are in Ultimate Maps PRO.',
    kml: 'KML layers from a file or a link, with their points imported as markers, are in Ultimate Maps PRO.',
    hide_poi: 'Hiding the points of interest of the base map is in Ultimate Maps PRO.',
    frontend_markers: 'Letting visitors add markers from the page, with limits and categories, is in Ultimate Maps PRO.',
    marker_period: 'Showing a marker only between two dates is in Ultimate Maps PRO.',
  };

  function readStore() {
    try {
      return window.localStorage.getItem(STORAGE_KEY);
    } catch (e) {
      return null;
    }
  }

  function writeStore(value) {
    try {
      window.localStorage.setItem(STORAGE_KEY, value);
    } catch (e) {}
  }

  /** The rows of the tables of a form, in page order; the rows of nested tables stay with their outer row. */
  function rowsOf(form) {
    var rows = [];
    Array.prototype.forEach.call(form.querySelectorAll('table.form-table'), function (table) {
      if (table.parentElement && table.parentElement.closest('table.form-table')) {
        return;
      }
      table.classList.add('ums-ed-table');
      var body = table.tBodies[0] || table;
      Array.prototype.forEach.call(body.children, function (row) {
        if (row.tagName === 'TR') {
          rows.push(row);
        }
      });
    });
    return rows;
  }

  function namesOf(row) {
    var names = [];
    Array.prototype.forEach.call(row.querySelectorAll('[name]'), function (field) {
      names.push(field.getAttribute('name'));
    });
    return names;
  }

  function cardFor(cards, names) {
    for (var i = 0; i < cards.length; i++) {
      for (var j = 0; j < names.length; j++) {
        if (cards[i].fields.indexOf(names[j]) !== -1) {
          return cards[i];
        }
      }
    }
    return null;
  }

  /** The PRO note of a card of the free version; Read more opens the window of the feature (Upsell). */
  function proNote(upsell) {
    var note = document.createElement('div'),
      link = document.createElement('a');
    note.className = 'ums-pro-note';
    note.innerHTML =
      '<span class="ums-pro-note-icon"><i class="fa fa-diamond" aria-hidden="true"></i></span>' +
      '<span class="ums-pro-note-text"><b class="ums-pro-note-tag">PRO</b><span></span></span>';
    note.querySelector('.ums-pro-note-text > span').textContent = t('pro_' + upsell, PRO_NOTES[upsell] || '');
    link.className = 'ums-pro-note-more';
    link.href = (T.proUrl || 'https://supsystic.com/plugins/ultimate-maps/') + '?utm_source=plugin&utm_medium=' + encodeURIComponent(upsell) + '&utm_campaign=ultimatemaps';
    link.target = '_blank';
    link.rel = 'noopener';
    link.setAttribute('data-ums-upsell', upsell);
    link.innerHTML = '<span></span><i class="fa fa-arrow-right" aria-hidden="true"></i>';
    link.firstChild.textContent = t('readMore', 'Read more');
    note.appendChild(link);
    return note;
  }

  /**
   * Turns the rows of a form into cards.
   * @return {Array} The cards found, each {def, head, rows}
   */
  function buildCards(form, defs, isMapForm) {
    var rows = rowsOf(form),
      found = [],
      current = null,
      pending = [];
    if (!rows.length) {
      return found;
    }
    function add(def, row) {
      if (!current || current.def !== def) {
        current = { def: def, rows: [] };
        found.push(current);
      }
      current.rows.push(row);
    }
    rows.forEach(function (row) {
      var names = namesOf(row);
      if (!names.length) {
        // An old section heading of the map form ("Info Window") gives way to the card heading
        if (isMapForm && row.querySelector('label.label-big') && !row.querySelector('input, select, textarea, a.button, button')) {
          row.classList.add('ums-ed-legacy-head');
        }
        pending.push(row);
        return;
      }
      var def = cardFor(defs, names) || (current ? current.def : defs[0]);
      pending.forEach(function (waiting) {
        add(def, waiting);
      });
      pending = [];
      add(def, row);
    });
    pending.forEach(function (waiting) {
      add(current ? current.def : defs[0], waiting);
    });

    // Two runs of the same card (an unknown order) keep one heading each, both named after the card
    found.forEach(function (card) {
      var first = card.rows[0],
        head = document.createElement('tr'),
        cell = document.createElement('td'),
        text = TEXTS[card.def.key] || [card.def.key, ''],
        isPro = false;
      card.rows.forEach(function (row) {
        row.classList.add('ums-ed-row');
        row.setAttribute('data-ums-card', card.def.key);
        if (card.def.group) {
          row.setAttribute('data-ums-group', card.def.group);
        }
        // The free version marks PRO rows with a "PRO option" label
        if (row.querySelector('.umsProOptMiniLabel')) {
          row.classList.add('ums-ed-pro-row');
          isPro = true;
        }
      });
      head.className = 'ums-ed-card-head';
      head.setAttribute('data-ums-card', card.def.key);
      if (card.def.group) {
        head.setAttribute('data-ums-group', card.def.group);
      }
      cell.colSpan = 2;
      cell.innerHTML =
        '<div class="ums-ed-card-title"><span class="ums-ed-card-icon"><i class="fa ' + card.def.icon + '" aria-hidden="true"></i></span>' +
        '<span class="ums-ed-card-text"><strong></strong><span></span></span></div>';
      cell.querySelector('strong').textContent = t('card_' + card.def.key, text[0]);
      cell.querySelector('.ums-ed-card-text > span').textContent = t('cardDesc_' + card.def.key, text[1]);
      head.appendChild(cell);
      first.parentNode.insertBefore(head, first);
      card.head = head;

      // Free version: the PRO card shows its note; its fields stay in the form (hidden), so a Save keeps their values
      if (isPro && card.def.upsell) {
        var tag = document.createElement('em');
        tag.className = 'ums-ed-pro-tag';
        tag.textContent = 'PRO';
        cell.querySelector('strong').appendChild(tag);
        var noteRow = document.createElement('tr'),
          noteCell = document.createElement('td');
        noteRow.className = 'ums-ed-row ums-ed-note-row';
        noteRow.setAttribute('data-ums-card', card.def.key);
        if (card.def.group) {
          noteRow.setAttribute('data-ums-group', card.def.group);
        }
        noteCell.colSpan = 2;
        noteCell.appendChild(proNote(card.def.upsell));
        noteRow.appendChild(noteCell);
        first.parentNode.insertBefore(noteRow, first);
        card.rows.unshift(noteRow);
        card.rows.forEach(function (row) {
          if (row.classList.contains('ums-ed-pro-row')) {
            row.classList.add('ums-ed-pro-hidden');
          }
        });
      }
    });
    return found;
  }

  function isShown(element, stop) {
    for (var node = element; node && node !== stop; node = node.parentElement) {
      if (node.hidden || window.getComputedStyle(node).display === 'none') {
        return false;
      }
    }
    return true;
  }

  /** The frame of every card follows the rows the page shows: the last shown row closes it, a card with none is hidden. */
  function watchCards(form, cards) {
    function mark() {
      cards.forEach(function (card) {
        var last = null;
        card.rows.forEach(function (row) {
          row.classList.remove('ums-ed-last');
          if (!row.classList.contains('ums-ed-legacy-head') && isShown(row, form)) {
            last = row;
          }
        });
        card.head.classList.toggle('ums-ed-card-empty', !last);
        if (last) {
          last.classList.add('ums-ed-last');
        }
      });
    }
    var timer = null;
    function soon() {
      window.clearTimeout(timer);
      timer = window.setTimeout(mark, 40);
    }
    if (window.MutationObserver) {
      new MutationObserver(function (records) {
        // Only changes of the rows themselves, not the classes this script sets
        for (var i = 0; i < records.length; i++) {
          if (records[i].attributeName !== 'class' || !/ums-ed-(last|card-empty)/.test(records[i].target.className)) {
            soon();
            return;
          }
        }
      }).observe(form, { attributes: true, attributeFilter: ['style', 'class', 'hidden'], subtree: true });
    }
    form.addEventListener('change', soon);
    $(document).on('click', '.nav-tab', soon);
    mark();
    return mark;
  }

  function initMapForm() {
    var form = document.getElementById('umsMapForm');
    if (!form || form.classList.contains('ums-ed-form')) {
      return;
    }
    form.classList.add('ums-ed-form');
    var cards = buildCards(form, MAP_CARDS, true);
    if (!cards.length) {
      return;
    }
    var used = {};
    cards.forEach(function (card) {
      used[card.def.group] = true;
    });
    var groups = MAP_GROUPS.filter(function (group) {
      return used[group.key];
    });

    // Group tabs and the search, above the cards
    var nav = document.createElement('div'),
      list = document.createElement('div'),
      search = document.createElement('label'),
      empty = document.createElement('div');
    nav.className = 'ums-ed-nav';
    list.className = 'ums-ed-groups';
    list.setAttribute('role', 'tablist');
    list.setAttribute('aria-label', t('groups', 'Settings groups'));
    groups.forEach(function (group) {
      var button = document.createElement('button');
      button.type = 'button';
      button.className = 'ums-ed-group';
      button.setAttribute('role', 'tab');
      button.setAttribute('data-ums-group', group.key);
      button.innerHTML = '<i class="fa fa-fw ' + group.icon + '" aria-hidden="true"></i><span></span>';
      button.querySelector('span').textContent = t('group_' + group.key, GROUP_LABELS[group.key]);
      list.appendChild(button);
    });
    search.className = 'ums-ed-search';
    search.innerHTML = '<i class="fa fa-search" aria-hidden="true"></i><input type="search" autocomplete="off">';
    var input = search.querySelector('input');
    input.placeholder = t('search', 'Search settings');
    input.setAttribute('aria-label', t('search', 'Search settings'));
    nav.appendChild(list);
    nav.appendChild(search);
    empty.className = 'ums-ed-empty';
    empty.hidden = true;
    empty.textContent = t('noMatch', 'No settings match your search.');
    form.parentNode.insertBefore(nav, form);
    form.parentNode.insertBefore(empty, form);

    var mark = watchCards(form, cards);

    function activate(key, remember) {
      if (!used[key]) {
        key = groups[0].key;
      }
      form.setAttribute('data-ums-active', key);
      Array.prototype.forEach.call(list.children, function (button) {
        var on = button.getAttribute('data-ums-group') === key;
        button.classList.toggle('is-active', on);
        button.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      Array.prototype.forEach.call(form.querySelectorAll('[data-ums-group]'), function (row) {
        row.classList.toggle('ums-ed-off', row.getAttribute('data-ums-group') !== key);
      });
      // On a phone the groups are a scrolling strip: the active group comes into its view (the page does not scroll)
      var current = list.querySelector('.is-active');
      if (current && list.scrollWidth > list.clientWidth) {
        var box = list.getBoundingClientRect();
        var at = current.getBoundingClientRect();
        list.scrollLeft += at.left + at.width / 2 - (box.left + box.width / 2);
      }
      if (remember) {
        writeStore(key);
      }
      mark();
      // The color pickers and selects of a card shown now get their real width
      $(window).trigger('resize');
    }

    function filter(query) {
      query = query.trim().toLowerCase();
      form.classList.toggle('is-searching', query !== '');
      nav.classList.toggle('is-searching', query !== '');
      // A search looks through every group; without one, only the active group shows
      if (query) {
        Array.prototype.forEach.call(form.querySelectorAll('.ums-ed-off'), function (row) {
          row.classList.remove('ums-ed-off');
        });
      } else if (form.hasAttribute('data-ums-active')) {
        activate(form.getAttribute('data-ums-active'), false);
      }
      var found = 0;
      cards.forEach(function (card) {
        var hits = 0,
          title = card.head.textContent.toLowerCase(),
          wholeCard = query !== '' && title.indexOf(query) !== -1;
        card.rows.forEach(function (row) {
          var label = row.querySelector('th') || row;
          var match = !query || wholeCard || label.textContent.toLowerCase().indexOf(query) !== -1;
          row.classList.toggle('ums-ed-miss', !match);
          if (match && query && !row.classList.contains('ums-ed-legacy-head')) {
            hits++;
          }
        });
        card.head.classList.toggle('ums-ed-miss', query !== '' && hits === 0);
        found += hits;
      });
      empty.hidden = !query || found > 0;
      mark();
    }

    list.addEventListener('click', function (event) {
      var button = event.target.closest('.ums-ed-group');
      if (!button) {
        return;
      }
      input.value = '';
      filter('');
      activate(button.getAttribute('data-ums-group'), true);
    });
    var timer = null;
    input.addEventListener('input', function () {
      window.clearTimeout(timer);
      timer = window.setTimeout(function () {
        filter(input.value);
      }, 120);
    });
    input.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        input.value = '';
        filter('');
      }
      // Enter in the search must not submit the map form
      if (event.key === 'Enter') {
        event.preventDefault();
      }
    });
    document.addEventListener('keydown', function (event) {
      var tag = event.target && event.target.tagName;
      if (event.key === '/' && tag !== 'INPUT' && tag !== 'TEXTAREA' && tag !== 'SELECT' && !event.target.isContentEditable && nav.offsetParent) {
        event.preventDefault();
        input.focus();
      }
    });
    activate(readStore() || groups[0].key, false);
  }

  function initCardsOnly(id, defs) {
    var form = document.getElementById(id);
    if (!form || form.classList.contains('ums-ed-form')) {
      return;
    }
    form.classList.add('ums-ed-form', 'ums-ed-form-plain');
    var cards = buildCards(form, defs, false);
    if (cards.length) {
      watchCards(form, cards);
    }
  }

  /** The page head (shortcode and engine), the tabs and the preview column get the look of the other editors. */
  function initFrame() {
    var tabs = document.getElementById('umsMapPropertiesTabs');
    if (!tabs) {
      return;
    }
    var wrapper = document.getElementById('containerWrapper');
    if (wrapper) {
      var head = wrapper.querySelector('#umsCopyTextCodeExamples');
      head = head ? head.closest('#containerWrapper > div') : null;
      if (head) {
        head.classList.add('ums-ed-head');
      }
      wrapper.classList.add('ums-ed-wrap');
    }
    tabs.classList.add('ums-ed-tabs');
    var bar = document.getElementById('umsMapRightStickyBar');
    if (bar) {
      bar.classList.add('ums-ed-side');
    }
    ['umsMapDeleteBtn', 'umsMarkerDeleteBtn', 'umsShapeDeleteBtn', 'umsHeatmapDeleteBtn'].forEach(function (id) {
      var button = document.getElementById(id);
      if (button) {
        button.classList.add('ums-btn-danger');
      }
    });
    // Free version: "New" of the Shapes tab opens the PRO window of shapes
    var newShape = document.getElementById('umsAddNewShapeBtn');
    if (newShape && newShape.classList.contains('umsProOpt') && !(window.UMS_DATA && UMS_DATA.isPro)) {
      newShape.setAttribute('data-ums-upsell', 'shapes');
    }
  }

  /**
   * The lists of markers and shapes (jqGrid) keep the pixel widths they were built with; they follow the width of the
   * preview column instead, so their head never sticks out of the frame.
   */
  function fitGrids() {
    ['umsMarkersListGrid', 'umsShapesListGrid'].forEach(function (id) {
      var $grid = $('#' + id);
      if (!$grid.length || typeof $grid.jqGrid !== 'function' || !$grid[0].grid) {
        return;
      }
      var $box = $grid.closest('#umsMarkerList, #umsShapeList');
      var width = Math.floor($box.width());
      if (width > 0 && $box.is(':visible')) {
        // On a phone the id, the icon, the coordinates and the type give way, so the title and the buttons keep their room
        var narrow = width < 380,
          model = $grid.jqGrid('getGridParam', 'colModel') || [],
          optional = model
            .map(function (col) {
              return col.name;
            })
            .filter(function (name) {
              return name === 'id' || name === 'icon_img' || name === 'coords' || name === 'type';
            });
        if (optional.length && $grid.data('umsNarrow') !== narrow) {
          $grid.jqGrid(narrow ? 'hideCol' : 'showCol', optional);
          $grid.data('umsNarrow', narrow);
        }
        $grid.jqGrid('setGridWidth', width, true);
      }
    });
  }
  var fitTimer = null;
  function fitGridsSoon() {
    window.clearTimeout(fitTimer);
    fitTimer = window.setTimeout(fitGrids, 80);
  }

  $(function () {
    $(window).on('resize', fitGridsSoon);
    // The lists are built or shown later (the Shapes tab of PRO): follow the size of their boxes
    if (window.ResizeObserver) {
      var observer = new ResizeObserver(fitGridsSoon);
      ['umsMarkerList', 'umsShapeList'].forEach(function (id) {
        var box = document.getElementById(id);
        if (box) {
          observer.observe(box);
        }
      });
    }
    $(document).on('click', '.nav-tab', fitGridsSoon);
    $(document).ajaxComplete(fitGridsSoon);
    // After the page's own ready handlers: the tabs, the editors and the color pickers are set up by then
    window.setTimeout(function () {
      initFrame();
      initMapForm();
      initCardsOnly('umsMarkerForm', MARKER_CARDS);
      initCardsOnly('umsShapeForm', SHAPE_CARDS);
      document.documentElement.classList.add('ums-ed-ready');
      fitGridsSoon();
    }, 0);
  });
})(jQuery);
