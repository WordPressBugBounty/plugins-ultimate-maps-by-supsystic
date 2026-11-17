<?php
/**
 * Asks for a review on WordPress.org once the plugin has done something useful for the site (the same system as in
 * Photo Gallery and Data Tables): a map with markers went live on a published page, PRO reported its own moment (the
 * first shape, the first marker added by a visitor), several maps or many markers were made or, as a fallback, two
 * weeks of use. The card is shown on the plugin's own pages only, to the users allowed to use the plugin, and not
 * again once it is answered.
 *
 * The site state is the option "ums_review", the answer of each user the user meta "ums_review". Ultimate Maps never
 * had a review notice before, so there is no old answer to respect.
 *
 * PRO (or any add-on) reports its moments with do_action('ums_review_moment', $type, ['map' => $id]).
 */
class reviewModelUms extends modelUms
{
  const KEY = 'ums_review';
  const REVIEW_URL = 'https://wordpress.org/support/plugin/ultimate-maps-by-supsystic/reviews/#new-post';
  const SUPPORT_URL = 'https://supsystic.com/contact-us/';

  // No card in the first days after install, whatever happens
  const MIN_DAYS = 3;
  // Without any moment the card comes after two weeks of use
  const FALLBACK_DAYS = 14;
  const MAPS_MILESTONE = 3;
  const MARKERS_MILESTONE = 25;
  const SNOOZE_DAYS = 30;
  const MAX_SNOOZES = 3;

  /**
   * Moments in the order the card picks them: the first one recorded wins.
   * @var string[]
   */
  private static $momentTypes = ['live', 'shape', 'visitor'];
  /** @var array|null */
  private static $state = null;

  /**
   * A map with markers is rendered on a published page that a visitor (or the site owner) opens: the map is live.
   * Covers the shortcode, and the block and the widget once the page is saved (onPostSaved).
   * @param string|false $output
   * @param string $tag
   * @param array|string $attr
   * @return string|false
   */
  public function onShortcodeOutput($output, $tag, $attr)
  {
    if ($tag !== UMS_SHORTCODE || !is_string($output) || !is_array($attr) || empty($attr['id']) || $this->hasMoment('live')) {
      return $output;
    }
    if (is_admin() || wp_doing_ajax() || (defined('REST_REQUEST') && REST_REQUEST) || is_preview() || is_feed() || is_customize_preview() || isset($_GET['elementor-preview'])) {
      return $output;
    }
    if (!is_singular()) {
      return $output;
    }
    $post = get_queried_object();
    $mapId = (int) $attr['id'];
    if ($post instanceof WP_Post && $post->post_status === 'publish' && !post_password_required($post) && $this->countMarkers($mapId) > 0) {
      $this->addMoment('live', ['map' => $mapId, 'post' => (int) $post->ID]);
    }
    return $output;
  }

  /**
   * A post with a map block or shortcode is published: the map is live even before anyone opens the page.
   * @param int $postId
   * @param WP_Post $post
   */
  public function onPostSaved($postId, $post)
  {
    if (!$post instanceof WP_Post || $post->post_status !== 'publish' || $this->hasMoment('live')) {
      return;
    }
    if (wp_is_post_revision($postId) || wp_is_post_autosave($postId) || !is_post_type_viewable($post->post_type)) {
      return;
    }
    $mapId = $this->findMapIn((string) $post->post_content);
    if ($mapId && $this->countMarkers($mapId) > 0) {
      $this->addMoment('live', ['map' => $mapId, 'post' => (int) $postId]);
    }
  }

  /**
   * Handler of the "ums_review_moment" action.
   * @param string $type One of the moment types (shape, visitor)
   * @param array $data ['map' => id]
   */
  public function recordMoment($type, $data = [])
  {
    if (!is_string($type) || $type === 'live' || !in_array($type, self::$momentTypes, true) || $this->hasMoment($type)) {
      return;
    }
    $this->addMoment($type, ['map' => is_array($data) && isset($data['map']) ? (int) $data['map'] : 0]);
  }

  /**
   * The card for the current user, or null when there is nothing to show.
   * @param string $tab The tab of the plugin page
   * @return array|null
   */
  public function getCard($tab)
  {
    if (!in_array($tab, ['overview', 'maps', 'settings', 'marker_groups', 'csv'], true) || !apply_filters('ums_review_request', true)) {
      return null;
    }
    $userId = get_current_user_id();
    if (!$userId || !current_user_can(frameUms::_()->getModule('adminmenu')->getMainCap())) {
      return null;
    }
    $answer = $this->getAnswer($userId);
    if ($answer['status'] === 'rated' || $answer['status'] === 'dismissed') {
      return null;
    }
    if ($answer['status'] === 'snoozed' && $answer['until'] > time()) {
      return null;
    }
    $state = $this->getState();
    if (time() - $state['since'] < self::MIN_DAYS * DAY_IN_SECONDS) {
      return null;
    }
    $moment = $this->pickMoment($state);
    if (!$moment) {
      return null;
    }
    return array_merge($moment, [
      'tab' => $tab,
      'reviewUrl' => self::REVIEW_URL,
      'supportUrl' => self::SUPPORT_URL,
      'ajaxUrl' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('ums_nonce'),
    ]);
  }

  /**
   * Saves the answer of a user. "rate" and "done" end the requests; "later", "support" and "close" put them off for a
   * month, and the third time for good.
   * @param int $userId
   * @param string $answer
   * @return bool
   */
  public function saveAnswer($userId, $answer)
  {
    $userId = (int) $userId;
    if (!$userId || !is_string($answer)) {
      return false;
    }
    $now = time();
    if ($answer === 'rate' || $answer === 'done') {
      update_user_meta($userId, self::KEY, ['status' => 'rated', 'answer' => $answer, 'time' => $now]);
      return true;
    }
    if ($answer === 'later' || $answer === 'support' || $answer === 'close') {
      $snoozes = $this->getAnswer($userId)['snoozes'] + 1;
      update_user_meta($userId, self::KEY, [
        'status' => $snoozes >= self::MAX_SNOOZES ? 'dismissed' : 'snoozed',
        'answer' => $answer,
        'until' => $now + self::SNOOZE_DAYS * DAY_IN_SECONDS,
        'snoozes' => $snoozes,
        'time' => $now,
      ]);
      return true;
    }
    return false;
  }

  /**
   * Site state: when the plugin started to be used and the recorded moments.
   * @return array
   */
  public function getState()
  {
    if (self::$state !== null) {
      return self::$state;
    }
    $state = get_option(self::KEY);
    if (!is_array($state) || !isset($state['since']) || !is_int($state['since'])) {
      $state = $this->createState();
      update_option(self::KEY, $state, true);
    }
    $state['moments'] = isset($state['moments']) && is_array($state['moments']) ? $state['moments'] : [];
    self::$state = $state;
    return self::$state;
  }

  /**
   * @param int $userId
   * @return array ['status' => ''|'snoozed'|'rated'|'dismissed', 'until' => int, 'snoozes' => int]
   */
  public function getAnswer($userId)
  {
    $answer = get_user_meta((int) $userId, self::KEY, true);
    $answer = is_array($answer) ? $answer : [];
    return [
      'status' => isset($answer['status']) && is_string($answer['status']) ? $answer['status'] : '',
      'until' => isset($answer['until']) ? (int) $answer['until'] : 0,
      'snoozes' => isset($answer['snoozes']) ? max(0, (int) $answer['snoozes']) : 0,
    ];
  }

  /**
   * The first state of a site. Existing sites keep their history: the start is their first map.
   * @return array
   */
  private function createState()
  {
    global $wpdb;
    $since = time();
    $suppress = $wpdb->suppress_errors(true);
    $firstMap = $wpdb->get_var("SELECT MIN(create_date) FROM {$wpdb->prefix}ums_maps");
    $wpdb->suppress_errors($suppress);
    if ($firstMap && ($firstTime = strtotime($firstMap)) && $firstTime > 0) {
      $since = min($since, $firstTime);
    }
    return ['since' => (int) $since, 'moments' => []];
  }

  /**
   * @param array $state
   * @return array|null
   */
  private function pickMoment(array $state)
  {
    foreach (self::$momentTypes as $type) {
      if (empty($state['moments'][$type]) || !is_array($state['moments'][$type])) {
        continue;
      }
      $moment = $state['moments'][$type];
      $mapId = isset($moment['map']) ? (int) $moment['map'] : 0;
      $map = $this->getMapTitle($mapId);
      if ($map === null) {
        // The map was deleted since then
        continue;
      }
      $map = trim($map) !== '' ? trim($map) : '#' . $mapId;
      if ($type === 'live') {
        $post = isset($moment['post']) ? get_post((int) $moment['post']) : null;
        if (!$post instanceof WP_Post || $post->post_status !== 'publish') {
          continue;
        }
        $postTitle = get_the_title($post);
        return [
          'type' => 'live',
          'eyebrow' => __('Map published', UMS_LANG_CODE),
          'title' => $postTitle !== '' ? sprintf(__('“%1$s” is live on “%2$s”', UMS_LANG_CODE), $map, $postTitle) : sprintf(__('“%s” is live on your site', UMS_LANG_CODE), $map),
          'text' => __('Visitors can now find your places and open their details right on the map.', UMS_LANG_CODE),
          'link' => get_permalink($post),
          'linkText' => __('View page', UMS_LANG_CODE),
        ];
      }
      if ($type === 'shape') {
        return [
          'type' => 'shape',
          'eyebrow' => __('Shapes on the map', UMS_LANG_CODE),
          'title' => sprintf(__('“%s” now shows your areas', UMS_LANG_CODE), $map),
          'text' => __('Zones, routes and circles make the map easy to read at a glance.', UMS_LANG_CODE),
        ];
      }
      return [
        'type' => 'visitor',
        'eyebrow' => __('Markers from visitors', UMS_LANG_CODE),
        'title' => sprintf(__('Visitors add their places to “%s”', UMS_LANG_CODE), $map),
        'text' => __('Your map grows with your community.', UMS_LANG_CODE),
      ];
    }

    $maps = $this->countRows('ums_maps');
    if ($maps >= self::MAPS_MILESTONE) {
      return [
        'type' => 'maps',
        'eyebrow' => __('Milestone', UMS_LANG_CODE),
        'title' => sprintf(__('You have built %d maps with Ultimate Maps', UMS_LANG_CODE), $maps),
        'text' => __('Nice work. Your places are easy to find.', UMS_LANG_CODE),
      ];
    }
    $markers = $this->countRows('ums_markers');
    if ($markers >= self::MARKERS_MILESTONE) {
      return [
        'type' => 'markers',
        'eyebrow' => __('Milestone', UMS_LANG_CODE),
        'title' => sprintf(__('You have put %d markers on your maps', UMS_LANG_CODE), $markers),
        'text' => __('Nice work. Your maps tell visitors where to go.', UMS_LANG_CODE),
      ];
    }
    $days = (int) floor((time() - $state['since']) / DAY_IN_SECONDS);
    if ($maps >= 1 && $days >= self::FALLBACK_DAYS) {
      $weeks = (int) floor($days / 7);
      return [
        'type' => 'time',
        'eyebrow' => __('Thank you for using Ultimate Maps', UMS_LANG_CODE),
        'title' => $weeks < 9 ? sprintf(__('Ultimate Maps has been working on your site for %d weeks', UMS_LANG_CODE), $weeks) : __('Ultimate Maps has been working on your site for a while now', UMS_LANG_CODE),
        'text' => __('We hope it makes showing your places a pleasure.', UMS_LANG_CODE),
      ];
    }
    return null;
  }

  /**
   * @param string $type
   * @return bool
   */
  private function hasMoment($type)
  {
    $state = $this->getState();
    return !empty($state['moments'][$type]);
  }

  /**
   * @param string $type
   * @param array $data
   */
  private function addMoment($type, array $data)
  {
    $state = $this->getState();
    $state['moments'][$type] = array_merge($data, ['time' => time()]);
    self::$state = $state;
    update_option(self::KEY, $state, true);
  }

  /**
   * The first map in a map block or a map shortcode of the content.
   * @param string $content
   * @return int
   */
  private function findMapIn($content)
  {
    if ($content === '' || (strpos($content, UMS_SHORTCODE) === false && strpos($content, 'supsystic/ultimate-maps') === false)) {
      return 0;
    }
    if (preg_match('#<!--\s+wp:supsystic/ultimate-maps\s+(\{.*?\})\s+/?-->#', $content, $match)) {
      $attributes = json_decode($match[1], true);
      if (is_array($attributes) && !empty($attributes['map_id']) && (int) $attributes['map_id'] > 0) {
        return (int) $attributes['map_id'];
      }
    }
    if (preg_match_all('/' . get_shortcode_regex([UMS_SHORTCODE]) . '/', $content, $matches, PREG_SET_ORDER)) {
      foreach ($matches as $shortcode) {
        $attributes = shortcode_parse_atts($shortcode[3]);
        if (is_array($attributes) && !empty($attributes['id']) && (int) $attributes['id'] > 0) {
          return (int) $attributes['id'];
        }
      }
    }
    return 0;
  }

  /**
   * @param int $id
   * @return string|null Null when there is no such map
   */
  private function getMapTitle($id)
  {
    global $wpdb;
    if ($id < 1) {
      return null;
    }
    $title = $wpdb->get_var($wpdb->prepare("SELECT title FROM {$wpdb->prefix}ums_maps WHERE id = %d", $id));
    return $title === null ? null : (string) $title;
  }

  /**
   * @param int $mapId
   * @return int
   */
  private function countMarkers($mapId)
  {
    global $wpdb;
    if ($mapId < 1) {
      return 0;
    }
    $suppress = $wpdb->suppress_errors(true);
    $count = (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}ums_markers WHERE map_id = %d", $mapId));
    $wpdb->suppress_errors($suppress);
    return $count;
  }

  /**
   * @param string $table ums_maps or ums_markers
   * @return int
   */
  private function countRows($table)
  {
    global $wpdb;
    $suppress = $wpdb->suppress_errors(true);
    $count = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}{$table}");
    $wpdb->suppress_errors($suppress);
    return $count;
  }
}
