<?php
class supsystic_promoViewUms extends viewUms
{
  public function getOverviewTabContent()
  {
    frameUms::_()->addScript('admin.overview', $this->getModule()->getModPath() . 'js/admin.overview.js');
    frameUms::_()->addStyle('admin.overview', $this->getModule()->getModPath() . 'css/admin.overview.css');
    // Free vs PRO comparison and the prices of the plugin page, only while PRO is not active
    $proOffer = '';
    if (!$this->getModule()->isPro()) {
      frameUms::_()->addStyle('admin.pro-offer', $this->getModule()->getModPath() . 'css/admin.pro-offer.css', [], UMS_VERSION_PLUGIN . '-offer-1');
      frameUms::_()->addScript('admin.pro-offer', $this->getModule()->getModPath() . 'js/admin.pro-offer.js', [], UMS_VERSION_PLUGIN . '-offer-1');
      $proOffer = parent::getContent('overviewProOffer');
    }
    $this->assign('proOffer', $proOffer);
    $this->assign('mainLink', $this->getModule()->getMainLink());
    $this->assign('faqList', $this->getFaqList());
    $this->assign('serverSettings', $this->getServerSettings());
    return parent::getContent('overviewTabContent');
  }
  public function getFaqList()
  {
    return [
      __('Do I need a Google Maps API key?', UMS_LANG_CODE) => __('No. OpenStreetMap with Leaflet works without a Google Maps key. Mapbox, Thunderforest and Bing require their own provider keys.', UMS_LANG_CODE),
      __('How do I add a map to a page?', UMS_LANG_CODE) => __('Create a map, add its markers, then paste its shortcode into a page. A Gutenberg block and Elementor widget are also available.', UMS_LANG_CODE),
      __('Can I move my maps and markers?', UMS_LANG_CODE) => __('Use the CSV import and export tools to transfer map and marker data.', UMS_LANG_CODE),
      __('What does PRO add?', UMS_LANG_CODE) => __('PRO adds KML layers, shapes, heatmaps, marker lists and sliders, plus frontend marker submissions with access and usage controls.', UMS_LANG_CODE),
    ];
  }
  public function getServerSettings()
  {
    global $wpdb;
    return [
      'Operating System' => ['value' => PHP_OS],
      'PHP Version' => ['value' => PHP_VERSION],
      'Server Software' => ['value' => $_SERVER['SERVER_SOFTWARE']],
      'MySQL' => ['value' => $wpdb->db_version()],
      'PHP Allow URL Fopen' => ['value' => ini_get('allow_url_fopen') ? __('Yes', UMS_LANG_CODE) : __('No', UMS_LANG_CODE)],
      'PHP Memory Limit' => ['value' => ini_get('memory_limit')],
      'PHP Max Post Size' => ['value' => ini_get('post_max_size')],
      'PHP Max Upload Filesize' => ['value' => ini_get('upload_max_filesize')],
      'PHP Max Script Execute Time' => ['value' => ini_get('max_execution_time')],
      'PHP EXIF Support' => ['value' => extension_loaded('exif') ? __('Yes', UMS_LANG_CODE) : __('No', UMS_LANG_CODE)],
      'PHP EXIF Version' => ['value' => phpversion('exif')],
      'PHP XML Support' => ['value' => extension_loaded('libxml') ? __('Yes', UMS_LANG_CODE) : __('No', UMS_LANG_CODE), 'error' => !extension_loaded('libxml')],
      'PHP CURL Support' => ['value' => extension_loaded('curl') ? __('Yes', UMS_LANG_CODE) : __('No', UMS_LANG_CODE), 'error' => !extension_loaded('curl')],
    ];
  }
  /**
   * PRO features of the free version, each with its window (views/tpl/upsellWindows.php). The key is what
   * data-ums-upsell asks for.
   */
  public function getUpsellFeatures()
  {
    return [
      'markers_list' => [
        'icon' => 'fa-list-ul',
        'chip' => __('Markers list', UMS_LANG_CODE),
        'title' => __('Show your places as a list or a slider', UMS_LANG_CODE),
        'text' => __('Every marker of the map gets a card with its photo and text, in a slider or a table right under or beside the map.', UMS_LANG_CODE),
        'points' => [__('Horizontal and vertical photo sliders', UMS_LANG_CODE), __('An exposition slider for galleries of places', UMS_LANG_CODE), __('A table of locations visitors can search and sort', UMS_LANG_CODE), __('A click on a card opens its marker on the map', UMS_LANG_CODE), __('Autoplay, colors and column widths of your choice', UMS_LANG_CODE)],
        'uses' => [__('Store locators', UMS_LANG_CODE), __('Real estate', UMS_LANG_CODE), __('Tours and trips', UMS_LANG_CODE)],
      ],
      'kml' => [
        'icon' => 'fa-clone',
        'chip' => __('KML layers', UMS_LANG_CODE),
        'title' => __('Put your KML files on the map', UMS_LANG_CODE),
        'text' => __('Layers from KML files or links — points, zones and routes. A linked file is read again on every visit, so the map stays in sync with it.', UMS_LANG_CODE),
        'points' => [__('Several KML files or links on one map', UMS_LANG_CODE), __('The points of a layer show as markers with their name and description', UMS_LANG_CODE), __('Zones and routes of the file are drawn as they are', UMS_LANG_CODE), __('A linked file stays in sync: what changes in it shows on the map, no new import needed', UMS_LANG_CODE)],
        'uses' => [__('City guides', UMS_LANG_CODE), __('Delivery zones', UMS_LANG_CODE), __('Trails', UMS_LANG_CODE)],
      ],
      'shapes' => [
        'icon' => 'fa-cubes',
        'chip' => __('Shapes', UMS_LANG_CODE),
        'title' => __('Mark areas and routes with shapes', UMS_LANG_CODE),
        'text' => __('Draw polygons, lines and circles right on the map, in your colors, each with its own popup text.', UMS_LANG_CODE),
        'points' => [__('Polygons, polylines and circles', UMS_LANG_CODE), __('Draw by clicking the map or by typing addresses', UMS_LANG_CODE), __('Line and fill color, width and transparency', UMS_LANG_CODE), __('A popup with text, photos and links on click', UMS_LANG_CODE)],
        'uses' => [__('Delivery zones', UMS_LANG_CODE), __('Districts and plots', UMS_LANG_CODE), __('Event areas', UMS_LANG_CODE)],
      ],
      'hide_poi' => [
        'icon' => 'fa-eye-slash',
        'chip' => __('Hide POI', UMS_LANG_CODE),
        'title' => __('Keep the map about your places', UMS_LANG_CODE),
        'text' => __('Hide the hotels, fuel stations and shops of the base map, so visitors see only your markers.', UMS_LANG_CODE),
        'points' => [__('A clean base map in one switch', UMS_LANG_CODE), __('Your markers stand out', UMS_LANG_CODE), __('For the aerial and bird\'s eye views of Bing Maps', UMS_LANG_CODE)],
        'uses' => [__('Brand maps', UMS_LANG_CODE), __('Events', UMS_LANG_CODE), __('Venues', UMS_LANG_CODE)],
      ],
      'frontend_markers' => [
        'icon' => 'fa-users',
        'chip' => __('Visitors\' markers', UMS_LANG_CODE),
        'title' => __('Let visitors add their own markers', UMS_LANG_CODE),
        'text' => __('A form on your page lets visitors put their places on the map, with the rules you set.', UMS_LANG_CODE),
        'points' => [__('A form for the page by shortcode', UMS_LANG_CODE), __('Only for signed-in users, if you like', UMS_LANG_CODE), __('A limit of markers per time', UMS_LANG_CODE), __('Marker categories in the form', UMS_LANG_CODE), __('Visitors can remove their own markers', UMS_LANG_CODE)],
        'uses' => [__('Community maps', UMS_LANG_CODE), __('Reports and requests', UMS_LANG_CODE), __('Member directories', UMS_LANG_CODE)],
      ],
      'access_roles' => [
        'icon' => 'fa-user-plus',
        'chip' => __('Access by role', UMS_LANG_CODE),
        'title' => __('Let your team work with the maps', UMS_LANG_CODE),
        'text' => __('Choose which user roles open the plugin, so editors and authors keep the maps up to date without admin rights.', UMS_LANG_CODE),
        'points' => [__('Any role of the site: editor, author, contributor and more', UMS_LANG_CODE), __('One setting for the whole plugin', UMS_LANG_CODE), __('Administrators always keep access', UMS_LANG_CODE)],
        'uses' => [__('Agencies', UMS_LANG_CODE), __('Editorial teams', UMS_LANG_CODE), __('Franchise sites', UMS_LANG_CODE)],
      ],
    ];
  }
  public function getReviewCard($card)
  {
    $this->assign('card', $card);
    return parent::getContent('reviewCard');
  }
  public function getEditorProCard()
  {
    $this->assign('features', $this->getUpsellFeatures());
    $this->assign('proUrl', $this->getModule()->getMainLink());
    return parent::getContent('editorProCard');
  }
  public function getUpsellWindows()
  {
    $this->assign('features', $this->getUpsellFeatures());
    $this->assign('proUrl', $this->getModule()->getMainLink());
    return parent::getContent('upsellWindows');
  }
  public function getPromoTabContent($tabCode)
  {
    $this->assign('promoLink', $this->getModule()->getMainLink());
    $this->assign('tabCode', $tabCode);
    return parent::getContent('adminPromoTabContent');
  }
}
