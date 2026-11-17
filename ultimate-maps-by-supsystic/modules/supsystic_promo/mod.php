<?php
class supsystic_promoUms extends moduleUms
{
  private $_mainLink = '';
  public function __construct($d)
  {
    parent::__construct($d);
    $this->getMainLink();
  }
  public function init()
  {
    parent::init();
    $this->registerDeactivationDialog();
    dispatcherUms::addFilter('mainAdminTabs', [$this, 'addAdminTab']);
    add_action('admin_notices', [$this, 'showUserApiKeyAdminNotice']);
    if (is_admin()) {
      add_action('admin_enqueue_scripts', [$this, 'enqueueUpsell']);
      add_action('admin_footer', [$this, 'printUpsellWindows']);
      add_action('admin_enqueue_scripts', [$this, 'enqueueReview']);
      add_filter('plugin_row_meta', [$this, 'addPluginRowLink'], 10, 2);
    }
    // Review request (models/review.php): the moments when the plugin has done something useful
    add_filter('do_shortcode_tag', [$this, 'reviewOnShortcodeOutput'], 10, 3);
    add_action('wp_after_insert_post', [$this, 'reviewOnPostSaved'], 10, 2);
    add_action('ums_review_moment', [$this, 'reviewRecordMoment'], 10, 2);
  }
  public function reviewOnShortcodeOutput($output, $tag, $attr)
  {
    if ($tag !== UMS_SHORTCODE) {
      return $output;
    }
    $model = $this->getModel('review');
    return $model ? $model->onShortcodeOutput($output, $tag, $attr) : $output;
  }
  public function reviewOnPostSaved($postId, $post)
  {
    $model = $this->getModel('review');
    if ($model) {
      $model->onPostSaved($postId, $post);
    }
  }
  public function reviewRecordMoment($type, $data = [])
  {
    $model = $this->getModel('review');
    if ($model) {
      $model->recordMoment($type, $data);
    }
  }
  /**
   * The review card of the current plugin page, or null.
   * @return array|null
   */
  public function getReviewCard()
  {
    static $card = false;
    if ($card === false) {
      $model = frameUms::_()->isAdminPlugOptsPage() ? $this->getModel('review') : null;
      $card = $model ? $model->getCard(frameUms::_()->getModule('options')->getActiveTab()) : null;
    }
    return $card;
  }
  public function enqueueReview()
  {
    if (!$this->getReviewCard()) {
      return;
    }
    $ver = UMS_VERSION_PLUGIN . '-review-1';
    wp_enqueue_style('ums-review', $this->getModPath() . 'css/admin.review.css', [], $ver);
    wp_enqueue_script('ums-review', $this->getModPath() . 'js/admin.review.js', [], $ver, true);
  }
  public function getReviewCardHtml()
  {
    $card = $this->getReviewCard();
    return $card ? $this->getView()->getReviewCard($card) : '';
  }
  /**
   * "Rate us" link in the plugin's row on the Plugins page.
   * @param array $links
   * @param string $file
   * @return array
   */
  public function addPluginRowLink($links, $file)
  {
    if (!is_array($links) || $file !== plugin_basename(UMS_DIR . UMS_MAIN_FILE)) {
      return $links;
    }
    $links[] = sprintf(
      '<a href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s">%s <span style="color:#ffb900;letter-spacing:1px;" aria-hidden="true">&#9733;&#9733;&#9733;&#9733;&#9733;</span></a>',
      esc_url('https://wordpress.org/support/plugin/ultimate-maps-by-supsystic/reviews/#new-post'),
      esc_attr__('Rate Ultimate Maps on WordPress.org', UMS_LANG_CODE),
      esc_html__('Rate us', UMS_LANG_CODE)
    );
    return $links;
  }
  /**
   * PRO feature windows of the free version: any element with data-ums-upsell="<feature>" opens one. Not printed
   * with PRO, so nothing on the pages speaks of PRO while it is active.
   */
  public function enqueueUpsell()
  {
    if (!frameUms::_()->isAdminPlugOptsPage() || $this->isPro()) {
      return;
    }
    $ver = UMS_VERSION_PLUGIN . '-up-1';
    wp_enqueue_style('ums-upsell', $this->getModPath() . 'css/admin.upsell.css', [], $ver);
    wp_enqueue_script('ums-upsell', $this->getModPath() . 'js/admin.upsell.js', [], $ver, true);
  }
  public function printUpsellWindows()
  {
    if (!frameUms::_()->isAdminPlugOptsPage() || $this->isPro()) {
      return;
    }
    echo $this->getView()->getUpsellWindows();
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

  /**
   * Why the plugin is deactivated: the short dialog shared by the Supsystic plugins (deactivation-v1/deactivation.php
   * in this folder says what is sent and when). Nothing is sent unless the user sends the answer.
   */
  public function registerDeactivationDialog()
  {
    if (!is_admin()) {
      return;
    }
    require_once __DIR__ . '/deactivation-v1/deactivation.php';
    Supsystic_Deactivation_V1::register([
      'slug' => 'ultimate-maps-by-supsystic',
      'name' => 'Ultimate Maps',
      'file' => dirname(__DIR__, 2) . '/ums.php',
      'tables' => ['ums_modules', 'ums_options', 'ums_maps'],
      'pro' => [
        'slug' => 'ultimate-maps-by-supsystic-pro',
        'name' => 'Ultimate Maps PRO',
        'email' => function () {
          $license = class_exists('frameUms') ? frameUms::_()->getModule('license') : null;
          return $license ? (string) $license->getModel()->getEmail() : '';
        },
      ],
    ]);
  }
}
