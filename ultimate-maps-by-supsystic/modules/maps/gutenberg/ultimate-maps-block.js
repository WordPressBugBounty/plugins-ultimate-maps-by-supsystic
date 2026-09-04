(function (blocks, element, components, i18n, serverSideRender) {
  var el = element.createElement;
  var __ = i18n.__;
  var ServerSideRender = serverSideRender && serverSideRender.default ? serverSideRender.default : serverSideRender;
  var mapsData = window.umsGutenbergMaps || {};
  var mapsOptions = mapsData.maps || [{ label: __('Select a map', 'ultimate-maps-by-supsystic'), value: '' }];

  blocks.registerBlockType('supsystic/ultimate-maps', {
    title: __('Ultimate Maps by Supsystic', 'ultimate-maps-by-supsystic'),
    icon: 'location-alt',
    category: 'widgets',
    keywords: [
      __('map', 'ultimate-maps-by-supsystic'),
      __('maps', 'ultimate-maps-by-supsystic'),
      __('supsystic', 'ultimate-maps-by-supsystic'),
    ],
    attributes: {
      map_id: {
        type: 'string',
        default: mapsData.defaultMapId || '',
      },
      width: {
        type: 'string',
        default: '',
      },
      height: {
        type: 'number',
      },
      align: {
        type: 'string',
        default: '',
      },
    },
    edit: function (props) {
      var attrs = props.attributes;
      var selectedMapId = attrs.map_id || '';
      var heightValue = typeof attrs.height === 'undefined' ? '' : attrs.height;
      var preview = selectedMapId && ServerSideRender
        ? el(ServerSideRender, {
            block: 'supsystic/ultimate-maps',
            attributes: attrs,
          })
        : selectedMapId
          ? el(
              'p',
              {},
              __('Map preview will be available after saving or refreshing the editor.', 'ultimate-maps-by-supsystic')
            )
        : el(
            'p',
            {},
            __('Select an Ultimate Maps by Supsystic map to display it here.', 'ultimate-maps-by-supsystic')
          );

      return el(
        'div',
        { className: props.className },
        el(
          components.PanelBody,
          { title: __('Map Settings', 'ultimate-maps-by-supsystic'), initialOpen: true },
          el(components.SelectControl, {
            label: __('Select Map', 'ultimate-maps-by-supsystic'),
            value: selectedMapId,
            options: mapsOptions,
            onChange: function (value) {
              props.setAttributes({ map_id: value });
            },
          }),
          el(components.TextControl, {
            label: __('Width', 'ultimate-maps-by-supsystic'),
            value: attrs.width || '',
            placeholder: '100%',
            onChange: function (value) {
              props.setAttributes({ width: value });
            },
          }),
          el(components.TextControl, {
            label: __('Height', 'ultimate-maps-by-supsystic'),
            type: 'number',
            min: 50,
            step: 10,
            value: heightValue,
            onChange: function (value) {
              var parsedValue = parseInt(value, 10);
              props.setAttributes({ height: value === '' || isNaN(parsedValue) ? undefined : parsedValue });
            },
          }),
          el(components.SelectControl, {
            label: __('Alignment', 'ultimate-maps-by-supsystic'),
            value: attrs.align || '',
            options: [
              { label: __('Default', 'ultimate-maps-by-supsystic'), value: '' },
              { label: __('Left', 'ultimate-maps-by-supsystic'), value: 'left' },
              { label: __('Right', 'ultimate-maps-by-supsystic'), value: 'right' },
              { label: __('None', 'ultimate-maps-by-supsystic'), value: 'none' },
            ],
            onChange: function (value) {
              props.setAttributes({ align: value });
            },
          })
        ),
        preview
      );
    },
    save: function () {
      return null;
    },
  });
})(window.wp.blocks, window.wp.element, window.wp.components, window.wp.i18n, window.wp.serverSideRender);
