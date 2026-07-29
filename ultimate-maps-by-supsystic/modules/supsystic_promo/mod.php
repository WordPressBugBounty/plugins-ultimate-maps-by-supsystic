<?php
class supsystic_promoUms extends moduleUms
{
  private $_mainLink = '';
  private $_specSymbols = [
    'from' => ['?', '&'],
    'to' => ['%', '^'],
  ];
  private $_minDataInStatToSend = 20; // At least 20 points in table shuld be present before send stats
  public function __construct($d)
  {
    parent::__construct($d);
    $this->getMainLink();
  }
  public function init()
  {
    parent::init();
    add_action('admin_footer', [$this, 'displayAdminFooter'], 9);
    if (is_admin()) {
      $this->checkStatisticStatus();
    }
    $this->weLoveYou();
    dispatcherUms::addFilter('mainAdminTabs', [$this, 'addAdminTab']);
    // dispatcherUms::addAction('discountMsg', array($this, 'getDiscountMsg'));
    // add_action('admin_notices', array($this, 'checkAdminPromoNotices'));
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
  public function checkAdminPromoNotices()
  {
    if (!frameUms::_()->isAdminPlugOptsPage()) {
      // Our notices - only for our plugin pages for now
      return;
    }
    $notices = [];
    // Start usage
    $startUsage = (int) frameUms::_()->getModule('options')->get('start_usage');
    $currTime = time();
    $day = 24 * 3600;
    if ($startUsage) {
      // Already saved
      $rateMsg = sprintf(__("<h3>Hey, I noticed you just use %s over a week - that's awesome!</h3><p>Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.</p>", UMS_LANG_CODE), UMS_WP_PLUGIN_NAME);
      $rateMsg .=
        '<p><a href="https://wordpress.org/support/view/plugin-reviews/' .
        UMS_WP_NAME .
        '?rate=5#postform" target="_blank" class="button button-primary" data-statistic-code="done">' .
        __('Ok, you deserve it', UMS_LANG_CODE) .
        '</a>
			<a href="#" class="button" data-statistic-code="later">' .
        __('Nope, maybe later', UMS_LANG_CODE) .
        '</a>
			<a href="#" class="button" data-statistic-code="hide">' .
        __('I already did', UMS_LANG_CODE) .
        '</a></p>';
      // $checkOtherPlugins = '<p>'
      // 	. sprintf(__("Check out <a href='%s' target='_blank' class='button button-primary' data-statistic-code='hide'>our other Plugins</a>! Years of experience in WordPress plugins developers made those list unbreakable!", UMS_LANG_CODE), frameUms::_()->getModule('options')->getTabUrl('featured-plugins'))
      // . '</p>';
      $needGoogleMapsMsg =
        '<p>' .
        sprintf(
          __('Need <b>Google Maps</b>? Find it in our <a target="_blank" href="%s">Easy Google Maps</a> plugin or directly on <a href="%s" target="_blank">WordPress.org</a>!', UMS_LANG_CODE),
          admin_url('plugin-install.php?tab=search&type=term&s=Google+Maps+Easy'),
          'https://wordpress.org/plugins/google-maps-easy/',
        ) .
        '</p>';
      $notices = [
        'rate_msg' => ['html' => $rateMsg, 'show_after' => 7 * $day],
        // 'check_other_plugs_msg' => array('html' => $checkOtherPlugins, 'show_after' => 1 * $day),
        'need_google_maps' => ['html' => $needGoogleMapsMsg, 'show_after' => 0],
      ];
      foreach ($notices as $nKey => $n) {
        if ($currTime - $startUsage <= $n['show_after']) {
          unset($notices[$nKey]);
          continue;
        }
        $done = (int) frameUms::_()
          ->getModule('options')
          ->get('done_' . $nKey);
        if ($done) {
          unset($notices[$nKey]);
          continue;
        }
        $hide = (int) frameUms::_()
          ->getModule('options')
          ->get('hide_' . $nKey);
        if ($hide) {
          unset($notices[$nKey]);
          continue;
        }
        $later = (int) frameUms::_()
          ->getModule('options')
          ->get('later_' . $nKey);
        if ($later && $currTime - $later <= 2 * $day) {
          // remember each 2 days
          unset($notices[$nKey]);
          continue;
        }
      }
    } else {
      frameUms::_()->getModule('options')->getModel()->save('start_usage', $currTime);
    }
    if (!empty($notices)) {
      $html = '';
      foreach ($notices as $nKey => $n) {
        $this->getModel()->saveUsageStat($nKey . '.' . 'show', true);
        $html .= '<div class="updated notice is-dismissible supsystic-admin-notice" data-code="' . $nKey . '">' . $n['html'] . '</div>';
      }
      echo $html;
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
  public function displayAdminFooter()
  {
    if (frameUms::_()->isAdminPlugPage()) {
      $this->getView()->displayAdminFooter();
    }
  }
  private function _preparePromoLink($link, $ref = '')
  {
    if (empty($ref)) {
      $ref = 'user';
    }
    $link .= '?ref=' . $ref;
    return $link;
  }
  public function weLoveYou()
  {
    if (!frameUms::_()->getModule(implode('', ['l', 'ic', 'e', 'ns', 'e']))) {
      //
    }
  }
  /**
   * Public shell for private method
   */
  public function preparePromoLink($link, $ref = '')
  {
    return $this->_preparePromoLink($link, $ref);
  }
  public function checkStatisticStatus()
  {
    $canSend = (int) frameUms::_()->getModule('options')->get('send_stats');
    if ($canSend) {
      $this->getModel()->checkAndSend();
    }
  }
  public function getMinStatSend()
  {
    return $this->_minDataInStatToSend;
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
  // public function showFeaturedPluginsPage() {
  // 	return $this->getView()->showFeaturedPluginsPage();
  // }
  // public function getDiscountMsg() {
  // 	if($this->isPro()
  // 		&& frameUms::_()->getModule('options')->getActiveTab() == 'license'
  // 		&& frameUms::_()->getModule('license')
  // 		&& frameUms::_()->getModule('license')->getModel()->isActive()
  // 	) {
  // 		$proPluginsList = array(
  // 			'ultimate-maps-by-supsystic-pro', 'newsletters-by-supsystic-pro', 'contact-form-by-supsystic-pro', 'live-chat-pro',
  // 			'digital-publications-supsystic-pro', 'coming-soon-supsystic-pro', 'price-table-supsystic-pro', 'tables-generator-pro',
  // 			'social-share-pro', 'popup-by-supsystic-pro', 'supsystic_slider_pro', 'supsystic-gallery-pro', 'google-maps-easy-pro',
  // 			'backup-supsystic-pro',
  // 		);
  // 		$activePluginsList = get_option('active_plugins', array());
  // 		$activeProPluginsCount = 0;
  // 		foreach($activePluginsList as $actPl) {
  // 			foreach($proPluginsList as $proPl) {
  // 				if(strpos($actPl, $proPl) !== false) {
  // 					$activeProPluginsCount++;
  // 				}
  // 			}
  // 		}
  // 		if($activeProPluginsCount === 1) {
  // 			$buyLink = $this->getDiscountBuyUrl();
  // 			$this->getView()->getDiscountMsg($buyLink);
  // 		}
  // 	}
  // }
  public function getDiscountBuyUrl()
  {
    $license = frameUms::_()->getModule('license')->getModel()->getCredentials();
    $license['key'] = md5($license['key']);
    $license = urlencode(base64_encode(implode('|', $license)));
    $plugin_code = 'ultimate_maps_pro';
    return 'http://supsystic.com/?mod=manager&pl=lms&action=applyDiscountBuyUrl&plugin_code=' . $plugin_code . '&lic=' . $license;
  }
}
