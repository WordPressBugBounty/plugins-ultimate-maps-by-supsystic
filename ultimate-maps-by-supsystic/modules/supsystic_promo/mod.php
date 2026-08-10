<?php
class supsystic_promoUms extends moduleUms
{
  private $_mainLink = '';
  private $_specSymbols = [
    'from' => ['?', '&'],
    'to' => ['%', '^'],
  ];
  public function __construct($d)
  {
    parent::__construct($d);
    $this->getMainLink();
  }
  public function init()
  {
    parent::init();
    dispatcherUms::addFilter('mainAdminTabs', [$this, 'addAdminTab']);
    add_action('admin_notices', [$this, 'showUserApiKeyAdminNotice']);
  }
  function showUserApiKeyAdminNotice()
  {
    // Check each active engine and it's API key
    // TODO: Add on main site - articles about each engine - and setup here links to it's documentation
    $settingsLink = frameUms::_()->getModule('options')->getTabUrl('settings');
    $engines = frameUms::_()->getModule('maps')->getEngines();
    $defEngine = frameUms::_()->getModule('options')->get('def_engine');
    $usedEngines = frameUms::_()->getModule('maps')->getModel()->getUsedEngines();
    $allRequiredEngines = [$defEngine];
    $errorsForEngines = [];
    if (!empty($usedEngines) && is_array($usedEngines)) {
      foreach ($usedEngines as $ed) {
        if (!empty($ed['engine']) && !in_array($ed['engine'], $allRequiredEngines)) {
          $allRequiredEngines[] = $ed['engine'];
        }
      }
    }
    foreach ($allRequiredEngines as $eKey) {
      if (isset($engines[$eKey]['key_name']) && !empty($engines[$eKey]['key_name'])) {
        $savedKey = trim(frameUms::_()->getModule('options')->get($engines[$eKey]['key_name']));
        if (empty($savedKey)) {
          $errorsForEngines[$eKey] = $engines[$eKey];
        }
      }
    }
    if (!empty($errorsForEngines)) {
      foreach ($errorsForEngines as $eKey => $ed) {
        printf('<div class="%1$s" data-code=""><p>%2$s</p></div>', 'updated notice is-dismissible supsystic-admin-notice', sprintf(__('Please, set your API key for %s in Ultimate Maps by Supsystic plugin <a href="%s">Settings</a>!', UMS_LANG_CODE), $ed['label'], $settingsLink));
      }
    }
  }
  public function addAdminTab($tabs)
  {
    $tabs['overview'] = [
      'label' => __('Overview', UMS_LANG_CODE),
      'callback' => [$this, 'getOverviewTabContent'],
      'fa_icon' => 'fa-info',
      'sort_order' => 5,
    ];
    return $tabs;
  }
  public function getOverviewTabContent()
  {
    return $this->getView()->getOverviewTabContent();
  }
  // We used such methods - _encodeSlug() and _decodeSlug() - as in slug wp don't understand urlencode() functions
  private function _encodeSlug($slug)
  {
    return str_replace($this->_specSymbols['from'], $this->_specSymbols['to'], $slug);
  }
  private function _decodeSlug($slug)
  {
    return str_replace($this->_specSymbols['to'], $this->_specSymbols['from'], $slug);
  }
  public function decodeSlug($slug)
  {
    return $this->_decodeSlug($slug);
  }
  public function modifyMainAdminSlug($mainSlug)
  {
    $firstTimeLookedToPlugin = !installerUms::isUsed();
    if ($firstTimeLookedToPlugin) {
      $mainSlug = $this->_getNewAdminMenuSlug($mainSlug);
    }
    return $mainSlug;
  }
  private function _getWelcomMessageMenuData($option, $modifySlug = true)
  {
    return array_merge($option, [
      'page_title' => __('Welcome to Supsystic Secure', UMS_LANG_CODE),
      'menu_slug' => $modifySlug ? $this->_getNewAdminMenuSlug($option['menu_slug']) : $option['menu_slug'],
      'function' => [$this, 'showWelcomePage'],
    ]);
  }
  public function addWelcomePageToMenus($options)
  {
    $firstTimeLookedToPlugin = !installerUms::isUsed();
    if ($firstTimeLookedToPlugin) {
      foreach ($options as $i => $opt) {
        $options[$i] = $this->_getWelcomMessageMenuData($options[$i]);
      }
    }
    return $options;
  }
  private function _getNewAdminMenuSlug($menuSlug)
  {
    // We can't use "&" symbol in slug - so we used "|" symbol
    $newSlug = $this->_encodeSlug(str_replace('admin.php?page=', '', $menuSlug));
    return 'welcome-to-' . frameUms::_()->getModule('adminmenu')->getMainSlug() . '|return=' . $newSlug;
  }
  public function addWelcomePageToMainMenu($option)
  {
    $firstTimeLookedToPlugin = !installerUms::isUsed();
    if ($firstTimeLookedToPlugin) {
      $option = $this->_getWelcomMessageMenuData($option, false);
    }
    return $option;
  }
  public function showWelcomePage()
  {
    $this->getView()->showWelcomePage();
  }
  private function _preparePromoLink($link, $ref = '')
  {
    if (empty($ref)) {
      $ref = 'user';
    }
    $link .= '?ref=' . $ref;
    return $link;
  }
  /**
   * Public shell for private method
   */
  public function preparePromoLink($link, $ref = '')
  {
    return $this->_preparePromoLink($link, $ref);
  }
  public function getMainLink()
  {
    if (empty($this->_mainLink)) {
      $affiliateQueryString = '';
      $this->_mainLink = 'https://supsystic.com/plugins/ultimate-maps/' . $affiliateQueryString;
    }
    return $this->_mainLink;
  }
  public function isPro()
  {
    return frameUms::_()->getModule('add_map_options') ? true : false;
  }
  public function generateMainLink($params = '')
  {
    $mainLink = $this->getMainLink();
    if (!empty($params)) {
      return $mainLink . (strpos($mainLink, '?') ? '&' : '?') . $params;
    }
    return $mainLink;
  }
  public function addPromoMapTabs()
  {
    $tabs = [];
    if (!$this->isPro()) {
      $tabs['umsShapeTab'] = [
        'label' => __('Figures', UMS_LANG_CODE),
        'content' => $this->getView()->getPromoTabContent('shapes'),
        'promo' => true,
      ];
      $tabs['umsHeatmapTab'] = [
        'label' => __('Heatmap', UMS_LANG_CODE),
        'content' => $this->getView()->getPromoTabContent('heatmap'),
        'promo' => true,
      ];
    }
    return $tabs;
  }
}
