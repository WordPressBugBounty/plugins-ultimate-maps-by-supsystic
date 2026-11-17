<?php
/**
 * Settings of the plugin, in the look of the Data Tables and Photo Gallery settings: a page head and cards. The fields
 * are made exactly as before (the same names, values and data attributes); only the frame around them changed.
 */
$umsCardOf = [
  'def_engine' => 'engine',
  'access_roles' => 'access',
  'bing_key' => 'keys',
  'rapidapi_key' => 'keys',
  'mapbox_key' => 'keys',
  'thunderforest_key' => 'keys',
];
$umsCards = [
  'engine' => [
    'icon' => 'fa-globe',
    'title' => __('Map engine', UMS_LANG_CODE),
    'desc' => __('The engine every new map starts with. Each map can still pick its own in the editor.', UMS_LANG_CODE),
    'class' => '',
  ],
  'access' => [
    'icon' => 'fa-users',
    'title' => __('Access', UMS_LANG_CODE),
    'desc' => __('Who can work with the plugin.', UMS_LANG_CODE),
    'class' => '',
  ],
  'keys' => [
    'icon' => 'fa-key',
    'title' => __('Provider keys', UMS_LANG_CODE),
    'desc' => __('Keys of the map providers you use. OpenStreetMap with Leaflet needs no key.', UMS_LANG_CODE),
    'class' => 'ums-card-wide',
  ],
];
$umsRows = [];
$umsHidden = '';
foreach ($this->options as $optCatKey => $optCatData) {
  $catClass = 'umsOptCat_' . $optCatKey;
  if (isset($optCatData['opts']) && !empty($optCatData['opts'])) {
    foreach ($optCatData['opts'] as $optKey => $opt) {
      $htmlType = isset($opt['html']) ? $opt['html'] : false;
      $attrs = isset($opt['attrs']) ? $opt['attrs'] : '';
      if (empty($htmlType)) {
        continue;
      }
      if (in_array($optKey, ['cs_mode'])) {
        continue;
      } // Custom options
      $htmlOums = ['value' => $opt['value'], 'attrs' => 'data-optkey="' . $optKey . '" ' . $attrs];
      if (in_array($htmlType, ['selectbox', 'selectlist']) && isset($opt['options'])) {
        if (is_callable($opt['options'])) {
          $htmlOums['options'] = call_user_func($opt['options']);
        } elseif (is_array($opt['options'])) {
          $htmlOums['options'] = $opt['options'];
        }
      }
      $isProOpt = isset($opt['pro']) && !empty($opt['pro']);
      $classes = [];
      if ($isProOpt) {
        $classes[] = 'umsProOpt';
      }
      if ($htmlType === 'selectlist') {
        // A tag picker (Chosen, as the marker categories) instead of the tall list box; the select stays the field
        $classes[] = 'chosen';
      }
      if ($classes) {
        $htmlOums['attrs'] .= ' class="' . implode(' ', $classes) . '"';
      }
      $htmlInput = htmlUms::$htmlType('opt_values[' . $optKey . ']', $htmlOums);
      if (in_array($htmlType, ['hidden'])) {
        $umsHidden .= $htmlInput; // Just show hidden field, without any row at all
        continue;
      }
      $card = isset($umsCardOf[$optKey]) ? $umsCardOf[$optKey] : 'cat_' . $optCatKey;
      if (!isset($umsCards[$card])) {
        $umsCards[$card] = ['icon' => 'fa-sliders', 'title' => __($optCatData['label'], UMS_LANG_CODE), 'desc' => '', 'class' => 'ums-card-wide'];
      }
      if ($isProOpt && empty($umsCards[$card]['pro'])) {
        $umsCards[$card]['pro'] = $optKey;
      }
      ob_start();
      ?>
      <tr<?php if (isset($opt['connect']) && $opt['connect']) { ?> data-connect="<?php echo esc_attr($opt['connect']); ?>" style="display: none;"<?php } ?> class="<?php echo esc_attr($catClass . ($isProOpt ? ' ums-pro-hidden' : '')); ?>">
          <th scope="row">
              <?php _e($opt['label'], UMS_LANG_CODE); ?>
              <i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html($opt['desc']); ?>"></i>
              <?php if (!empty($opt['changed_on'])) { ?>
                  <span class="description">
                      <?php $opt['value'] ? printf(__('Turned On %s', UMS_LANG_CODE), dateUms::_($opt['changed_on'])) : printf(__('Turned Off %s', UMS_LANG_CODE), dateUms::_($opt['changed_on'])); ?>
                  </span>
              <?php } ?>
              <?php if ($isProOpt) { ?>
                  <span class="umsProOptMiniLabel"><a href="<?php echo esc_url($opt['pro']); ?>" target="_blank"><?php _e('PRO option', UMS_LANG_CODE); ?></a></span>
              <?php } ?>
          </th>
          <td><?php echo $htmlInput; ?></td>
      </tr>
      <?php
      $umsRows[$card][] = ob_get_clean();
    }
  }
  if (isset($optCatData['opts_html'])) {
    $card = 'cat_' . $optCatKey;
    if (!isset($umsCards[$card])) {
      $umsCards[$card] = ['icon' => 'fa-sliders', 'title' => __($optCatData['label'], UMS_LANG_CODE), 'desc' => '', 'class' => 'ums-card-wide'];
    }
    $optsHtml = is_callable($optCatData['opts_html']) ? call_user_func($optCatData['opts_html']) : (is_string($optCatData['opts_html']) ? $optCatData['opts_html'] : '');
    $umsRows[$card][] = '<tr class="' . esc_attr($catClass) . '"><td colspan="2">' . $optsHtml . '</td></tr>';
  }
}
$umsProUrl = frameUms::_()->getModule('supsystic_promo')->getMainLink();
?>
<div class="ums-form-page ums-settings-page">
    <div class="ums-page-head">
        <div class="ums-page-title">
            <span class="ums-page-icon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
            <div>
                <h2><?php esc_html_e('Settings', UMS_LANG_CODE); ?></h2>
                <p><?php esc_html_e('These options apply to all your maps.', UMS_LANG_CODE); ?></p>
            </div>
        </div>
        <div class="ums-page-actions">
            <button class="button button-primary" id="umsSettingsSaveBtn" data-toolbar-button title="<?php echo esc_attr__('Save all options', UMS_LANG_CODE); ?>">
                <i class="fa fa-fw fa-save"></i>
                <?php _e('Save', UMS_LANG_CODE); ?>
            </button>
        </div>
    </div>
    <form id="umsSettingsForm" class="umsInputsWithDescrForm">
        <div class="ums-cards">
            <?php foreach ($umsCards as $cardKey => $card) { ?>
                <?php if (empty($umsRows[$cardKey])) {
                  continue;
                } ?>
                <section class="ums-card <?php echo esc_attr($card['class']); ?>" data-ums-card="<?php echo esc_attr($cardKey); ?>">
                    <div class="ums-card-head">
                        <span class="ums-card-icon"><i class="fa <?php echo esc_attr($card['icon']); ?>" aria-hidden="true"></i></span>
                        <div>
                            <h3><?php echo esc_html($card['title']); ?></h3>
                            <?php if ($card['desc'] !== '') { ?><p><?php echo esc_html($card['desc']); ?></p><?php } ?>
                        </div>
                    </div>
                    <?php if (!empty($card['pro'])) { ?>
                        <div class="ums-pro-note ums-pro-note-card">
                            <span class="ums-pro-note-icon"><i class="fa fa-diamond" aria-hidden="true"></i></span>
                            <span class="ums-pro-note-text"><b class="ums-pro-note-tag">PRO</b><?php esc_html_e('Letting editors, authors and other roles work with the maps is in Ultimate Maps PRO.', UMS_LANG_CODE); ?></span>
                            <a class="ums-pro-note-more" href="<?php echo esc_url($umsProUrl . '?utm_source=plugin&utm_medium=' . $card['pro'] . '&utm_campaign=ultimatemaps'); ?>" target="_blank" rel="noopener" data-ums-upsell="access_roles"><?php esc_html_e('Read more', UMS_LANG_CODE); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    <?php } ?>
                    <table class="form-table">
                        <?php echo implode('', $umsRows[$cardKey]); ?>
                    </table>
                </section>
            <?php } ?>
        </div>
        <?php echo $umsHidden; ?>
        <?php echo htmlUms::hidden('mod', ['value' => 'options']); ?>
        <?php echo htmlUms::defaultNonceForAdminPanel(); ?>
        <?php echo htmlUms::hidden('action', ['value' => 'saveGroup']); ?>
    </form>
</div>
