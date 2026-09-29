<?php
class supsystic_promoViewUms extends viewUms
{
  public function getOverviewTabContent()
  {
    frameUms::_()->addScript('admin.overview', $this->getModule()->getModPath() . 'js/admin.overview.js');
    frameUms::_()->addStyle('admin.overview', $this->getModule()->getModPath() . 'css/admin.overview.css');
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
  public function getPromoTabContent($tabCode)
  {
    $this->assign('promoLink', $this->getModule()->getMainLink());
    $this->assign('tabCode', $tabCode);
    return parent::getContent('adminPromoTabContent');
  }
}
