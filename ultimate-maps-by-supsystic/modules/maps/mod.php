<?php
class mapsUms extends moduleUms
{
  private $_stylizations = [];
  private $_markersLists = [];
  private $_mapsInPosts = [];
  public $_mapsInPostsParams = [];

  private $_engines = [];
  private $_elementorWidgetRegistered = false;

  public function __construct($d)
  {
    parent::__construct($d);
    dispatcherUms::addAction('afterOptsLoaded', [$this, 'checkDefEngine']);
  }

  public function checkDefEngine()
  {
    $engineFromReq = reqUms::getVar('ums_engine');
    if (!empty($engineFromReq) && array_key_exists($engineFromReq, $this->getEngines())) {
      frameUms::_()->getModule('options')->getModel()->save('def_engine', $engineFromReq, true);
    }
  }

  public function init()
  {
    dispatcherUms::addFilter('mainAdminTabs', [$this, 'addAdminTab']);
    $this->registerGutenbergBlock();
    add_action('wp_head', [$this, 'addMapStyles']);
    add_action('template_redirect', [$this, 'getMapsInPosts']);
    add_action('wp_footer', [$this, 'addMapDataToJs'], 5);
    if (defined('ELEMENTOR_VERSION') && version_compare(ELEMENTOR_VERSION, '3.5.0', '<')) {
      add_action('elementor/widgets/widgets_registered', [$this, 'registerElementorWidget']);
    } else {
      add_action('elementor/widgets/register', [$this, 'registerElementorWidget']);
    }
    add_shortcode(UMS_SHORTCODE, [$this, 'drawMapFromShortcode']);
    // Add to admin bar new item
    add_action('admin_bar_menu', [$this, 'addAdminBarNewItem'], 300);
  }

  public function registerElementorWidget($widgetsManager = null)
  {
    if ($this->_elementorWidgetRegistered) {
      return;
    }
    if (!did_action('elementor/loaded') || !class_exists('\Elementor\Widget_Base')) {
      return;
    }

    $widgetFile = $this->getModDir() . 'elementor' . DS . 'ultimate-maps-widget.php';
    if (!class_exists('\Elementor\Widget_Ultimate_Maps_Ums') && is_file($widgetFile)) {
      require_once $widgetFile;
    }

    if (!class_exists('\Elementor\Widget_Ultimate_Maps_Ums')) {
      return;
    }

    $widget = new \Elementor\Widget_Ultimate_Maps_Ums();
    $this->_elementorWidgetRegistered = true;
    if ($widgetsManager && method_exists($widgetsManager, 'register')) {
      $widgetsManager->register($widget);
    } elseif ($widgetsManager && method_exists($widgetsManager, 'register_widget_type')) {
      $widgetsManager->register_widget_type($widget);
    } elseif (isset(\Elementor\Plugin::$instance->widgets_manager)) {
      $manager = \Elementor\Plugin::$instance->widgets_manager;
      method_exists($manager, 'register') ? $manager->register($widget) : $manager->register_widget_type($widget);
    }
  }

  public function registerGutenbergBlock()
  {
    if (!function_exists('register_block_type') || !function_exists('wp_register_script')) {
      return;
    }

    $scriptHandle = 'ums-gutenberg-maps-block';
    $scriptFile = $this->getModDir() . 'gutenberg' . DS . 'ultimate-maps-block.js';
    if (!is_file($scriptFile)) {
      return;
    }

    wp_register_script(
      $scriptHandle,
      $this->getModPath() . 'gutenberg/ultimate-maps-block.js',
      ['wp-blocks', 'wp-element', 'wp-components', 'wp-i18n', 'wp-server-side-render'],
      UMS_VERSION_PLUGIN,
      true
    );
    wp_localize_script($scriptHandle, 'umsGutenbergMaps', [
      'maps' => $this->getMapsOptionsForEditor(),
      'defaultMapId' => $this->getDefaultMapId(),
    ]);

    register_block_type('supsystic/ultimate-maps', [
      'editor_script' => $scriptHandle,
      'render_callback' => [$this, 'renderGutenbergBlock'],
      'attributes' => [
        'map_id' => [
          'type' => 'string',
          'default' => '',
        ],
        'width' => [
          'type' => 'string',
          'default' => '',
        ],
        'height' => [
          'type' => 'number',
        ],
        'align' => [
          'type' => 'string',
          'default' => '',
        ],
      ],
    ]);
  }

  public function renderGutenbergBlock($attributes)
  {
    $mapId = !empty($attributes['map_id']) ? (int) $attributes['map_id'] : 0;
    if (!$mapId) {
      return '';
    }

    $params = ['id' => $mapId];
    if (!empty($attributes['width'])) {
      $params['width'] = sanitize_text_field($attributes['width']);
    }
    if (isset($attributes['height']) && $attributes['height'] !== '') {
      $params['height'] = absint($attributes['height']);
    }
    if (!empty($attributes['align']) && in_array($attributes['align'], ['left', 'right', 'none'], true)) {
      $params['align'] = $attributes['align'];
    }

    return $this->drawMapFromShortcode($params);
  }

  public function getMapsOptionsForSelect()
  {
    $options = ['' => __('Select a map', UMS_LANG_CODE)];
    $maps = $this->getModel()->getAllMaps(['simple' => true]);

    if (!empty($maps)) {
      foreach ($maps as $map) {
        if (empty($map['id'])) {
          continue;
        }
        $id = (int) $map['id'];
        $title = !empty($map['title']) ? wp_strip_all_tags($map['title']) : sprintf(__('Map #%d', UMS_LANG_CODE), $id);
        $options[(string) $id] = sprintf('%s (ID: %d)', $title, $id);
      }
    }

    return $options;
  }

  public function getMapsOptionsForEditor()
  {
    $options = [];
    foreach ($this->getMapsOptionsForSelect() as $value => $label) {
      $options[] = [
        'label' => $label,
        'value' => (string) $value,
      ];
    }
    return $options;
  }

  public function getDefaultMapId()
  {
    foreach ($this->getMapsOptionsForSelect() as $id => $label) {
      if ($id !== '') {
        return $id;
      }
    }
    return '';
  }

  public function getEngines()
  {
    if (empty($this->_engines)) {
      $this->_engines = [
        'leaflet' => ['label' => 'Leaflet (OpenStreetMap)'],
        // Don't use it for now - try to use only LeaFlet API Lib - it should support all OpenStreetMap engines
        //'mapbox' => array('label' => 'MapBox (OpenStreetMap)'),
        'l-mapbox' => ['label' => 'MapBox (OpenStreetMap)', 'key_name' => 'mapbox_key'],
        'l-maptiles' => ['label' => 'MapTiles (OpenStreetMap)', 'key_name' => 'rapidapi_key'],
        'l-thunderforest' => ['label' => 'Thunderforest', 'key_name' => 'thunderforest_key'],
        'bing' => ['label' => 'Bing Microsoft', 'key_name' => 'bing_key'],
      ];
    }
    return $this->_engines;
  }

  public function getEnginesForSelect()
  {
    $this->getEngines();
    $enginesForSelect = [];
    foreach ($this->_engines as $k => $e) {
      $enginesForSelect[$k] = $e['label'];
    }
    return $enginesForSelect;
  }

  public function addAdminTab($tabs)
  {
    $tabs[$this->getCode() . '_add_new'] = [
      'label' => __('Add Map', UMS_LANG_CODE),
      'callback' => [$this, 'getAddNewTabContent'],
      'fa_icon' => 'fa-plus-circle',
      'sort_order' => 10,
      'add_bread' => $this->getCode(),
    ];
    $tabs[$this->getCode() . '_edit'] = [
      'label' => __('Edit', UMS_LANG_CODE),
      'callback' => [$this, 'getEditTabContent'],
      'sort_order' => 20,
      'child_of' => $this->getCode(),
      'hidden' => 1,
      'add_bread' => $this->getCode(),
    ];
    $tabs[$this->getCode()] = [
      'label' => __('All Maps', UMS_LANG_CODE),
      'callback' => [$this, 'getTabContent'],
      'fa_icon' => 'fa-list',
      'sort_order' => 20, //'is_main' => true,
    ];
    return $tabs;
  }
  public function getAddNewTabContent()
  {
    return $this->getView()->getEditMap();
  }
  public function getEditTabContent()
  {
    $id = (int) reqUms::getVar('id', 'get');
    if (!$id) {
      return __('No Map Found', UMS_LANG_CODE);
    }
    return $this->getView()->getEditMap($id);
  }
  public function getTabContent()
  {
    return $this->getView()->getTabContent();
  }
  public function getMapsInPosts()
  {
    if (empty($this->_mapsInPosts)) {
      global $wp_query;

      $havePostsListing = $wp_query && is_object($wp_query) && isset($wp_query->posts) && is_array($wp_query->posts) && !empty($wp_query->posts);

      if ($havePostsListing) {
        foreach ($wp_query->posts as $post) {
          if (is_object($post) && isset($post->post_content)) {
            if (preg_match_all('/\[\s*' . UMS_SHORTCODE . '\s+.*id\s*\=\s*"(?P<MAP_ID>\d+)".*\]/iUs', $post->post_content, $matches)) {
              if (!is_array($matches['MAP_ID'])) {
                $matches['MAP_ID'] = [$matches['MAP_ID']];
              }
              $matches['MAP_ID'] = array_map('intval', $matches['MAP_ID']);
              $this->_mapsInPosts = array_merge($this->_mapsInPosts, $matches['MAP_ID']);

              if (!empty($matches[0])) {
                foreach ($matches[0] as $data) {
                  preg_match_all('/(?P<KEYS>\w+)=["|\'](?P<VALUES>.*)["|\']/iU', $data, $params);
                  if (!is_array($params['KEYS'])) {
                    $params['KEYS'] = [$params['KEYS']];
                  }
                  if (!is_array($params['VALUES'])) {
                    $params['VALUES'] = [$params['VALUES']];
                  }
                  $map_params = [];
                  foreach ($params['KEYS'] as $key => $val) {
                    $map_params[$val] = $params['VALUES'][$key];
                  }
                  $this->_mapsInPostsParams = array_merge($this->_mapsInPostsParams, [$map_params]);
                }
              }
            }
          }
        }
      }
    }
    return $this->_mapsInPosts;
  }
  public function addMapStyles()
  {
    if (!empty($this->_mapsInPosts)) {
      $mapsOnPage = $this->getView()->getMapsObj();
      $iter = 0;

      foreach ($mapsOnPage as $map) {
        if (!empty($this->_mapsInPostsParams[$iter])) {
          $this->_mapsInPostsParams[$map['view_id']] = $this->_mapsInPostsParams[$iter];
        }
        $iter++;
        echo $this->getView()->addMapStyles($map['view_id']);
      }
    }
  }
  public function drawMapFromShortcode($params = null)
  {
    frameUms::_()->getModule('templates')->loadCoreJs();

    if (!isset($params['id']) || empty($params['id'])) {
      return __('Empty or Invalid Map ID', UMS_LANG_CODE) . '. ' . __('Please, check your Map Shortcode.', UMS_LANG_CODE);
    }

    return $this->getView()->drawMap($params);
  }
  public function addMapDataToJs()
  {
    $this->getView()->addMapDataToJs();
  }
  public function generateShortcode($map)
  {
    $shortcodeParams = [];
    $shortcodeParams['id'] = $map['id'];
    // For PRO version
    $shortcodeParamsArr = [];
    foreach ($shortcodeParams as $k => $v) {
      $shortcodeParamsArr[] = $k . "='" . $v . "'";
    }
    return '[' . UMS_SHORTCODE . ' ' . implode(' ', $shortcodeParamsArr) . ']';
  }
  public function getControlsPositions()
  {
    return [
      'TOP_CENTER' => __('Top Center', UMS_LANG_CODE),
      'TOP_LEFT' => __('Top Left', UMS_LANG_CODE),
      'TOP_RIGHT' => __('Top Right', UMS_LANG_CODE),
      'LEFT_TOP' => __('Left Top', UMS_LANG_CODE),
      'RIGHT_TOP' => __('Right Top', UMS_LANG_CODE),
      'LEFT_CENTER' => __('Left Center', UMS_LANG_CODE),
      'RIGHT_CENTER' => __('Right Center', UMS_LANG_CODE),
      'LEFT_BOTTOM' => __('Left Bottom', UMS_LANG_CODE),
      'RIGHT_BOTTOM' => __('Right Bottom', UMS_LANG_CODE),
      'BOTTOM_CENTER' => __('Bottom Center', UMS_LANG_CODE),
      'BOTTOM_LEFT' => __('Bottom Left', UMS_LANG_CODE),
      'BOTTOM_RIGHT' => __('Bottom Right', UMS_LANG_CODE),
    ];
  }
  public function getEditMapLink($id)
  {
    return frameUms::_()->getModule('options')->getTabUrl('maps_edit') . '&id=' . $id;
  }
  public function getCountriesList()
  {
    return require_once $this->getModDir() . 'countries.php';
  }
  public function getStylizationsList()
  {
    if (empty($this->_stylizations)) {
      $this->_stylizations = dispatcherUms::applyFilters('stylizationsList', require_once $this->getModDir() . 'stylezations.php');
      foreach ($this->_stylizations as $k => $v) {
        $this->_stylizations[$k] = utilsUms::jsonDecode($this->_stylizations[$k]);
      }
    }
    return $this->_stylizations;
  }
  public function getStylizationByName($name)
  {
    $this->getStylizationsList();
    return isset($this->_stylizations[$name]) ? $this->_stylizations[$name] : false;
  }
  public function getMarkerLists()
  {
    if (empty($this->_markersLists)) {
      // or == orientation (horizontal, vertical), d == display (title, image, description), eng == slider engine (jssor), pos == position (before, after)
      $this->_markersLists = [
        'slider_simple_before' => ['label' => __('Slider before map', UMS_LANG_CODE), 'or' => 'h', 'd' => ['title', 'img', 'desc'], 'eng' => 'jssor', 'pos' => 'before'],
        'slider_simple' => ['label' => __('Slider', UMS_LANG_CODE), 'or' => 'h', 'd' => ['title', 'img', 'desc'], 'eng' => 'jssor'],
        'slider_simple_title_img_before' => ['label' => __('Slider before map - Title and Img', UMS_LANG_CODE), 'or' => 'h', 'd' => ['title', 'img'], 'eng' => 'jssor', 'pos' => 'before'],
        'slider_simple_title_img' => ['label' => __('Slider - Title and Img', UMS_LANG_CODE), 'or' => 'h', 'd' => ['title', 'img'], 'eng' => 'jssor'],
        'slider_simple_vertical_title_img' => ['label' => __('Slider Vertical - Title and Img', UMS_LANG_CODE), 'or' => 'v', 'd' => ['title', 'img'], 'eng' => 'jssor'],
        'slider_simple_vertical_title_desc' => ['label' => __('Slider Vertical - Title and Description', UMS_LANG_CODE), 'or' => 'v', 'd' => ['title', 'desc'], 'eng' => 'jssor'],
        'slider_simple_vertical_img_2cols' => ['label' => __('Slider Vertical - Title and Img', UMS_LANG_CODE), 'or' => 'v', 'd' => ['img'], 'eng' => 'jssor', 'two_cols' => true],
        'slider_simple_table' => ['label' => __('Slider Table', UMS_LANG_CODE), 'or' => 'h', 'd' => ['title', 'img', 'desc'], 'eng' => 'table'],
        'slider_checkbox_table' => ['label' => __('Slider Checkbox Table', UMS_LANG_CODE), 'or' => 'h', 'd' => ['title', 'img', 'desc'], 'eng' => 'table_checkbox'],
      ];
      foreach ($this->_markersLists as $i => $v) {
        $this->_markersLists[$i]['prev_img'] = isset($this->_markersLists[$i]['prev_img']) ? $this->_markersLists[$i]['prev_img'] : $i . '.jpg';
        $this->_markersLists[$i]['slide_height'] = 150;
        $this->_markersLists[$i]['slide_width'] = in_array('img', $this->_markersLists[$i]['d']) && in_array('desc', $this->_markersLists[$i]['d']) ? 400 : 200;
        if (isset($this->_markersLists[$i]['two_cols']) && $this->_markersLists[$i]['two_cols']) {
          $this->_markersLists[$i]['slide_height'] = round($this->_markersLists[$i]['slide_height'] / 2);
        }
      }
    }
    return $this->_markersLists;
  }
  public function getMarkerListByKey($key)
  {
    $this->getMarkerLists();
    return isset($this->_markersLists[$key]) ? $this->_markersLists[$key] : false;
  }
  public function addAdminBarNewItem($wp_admin_bar)
  {
    $mainCap = frameUms::_()->getModule('adminmenu')->getMainCap();
    if (!current_user_can($mainCap) || !$wp_admin_bar || !is_object($wp_admin_bar)) {
      return;
    }
    $wp_admin_bar->add_menu([
      'parent' => 'new-content',
      'id' => UMS_CODE . '-admin-bar-new-item',
      'title' => __('Google Map', UMS_LANG_CODE),
      'href' => frameUms::_()
        ->getModule('options')
        ->getTabUrl($this->getCode() . '_add_new'),
    ]);
  }
}
