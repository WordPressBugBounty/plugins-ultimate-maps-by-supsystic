<?php
class supsystic_promoViewUms extends viewUms
{
  public function showWelcomePage()
  {
    $this->assign('askOptions', [
      1 => ['label' => 'Google'],
      2 => ['label' => 'Worumsess.org'],
      3 => ['label' => 'Refer a friend'],
      4 => ['label' => 'Find on the web'],
      5 => ['label' => 'Other way...'],
    ]);
    $this->assign('originalPage', uriUms::getFullUrl());
    parent::display('welcomePage');
  }
  public function getOverviewTabContent()
  {
    frameUms::_()->getModule('templates')->loadJqueryUi();

    frameUms::_()->getModule('templates')->loadSlimscroll();
    frameUms::_()->addScript('admin.overview', $this->getModule()->getModPath() . 'js/admin.overview.js');
    frameUms::_()->addStyle('admin.overview', $this->getModule()->getModPath() . 'css/admin.overview.css');
    $this->assign('mainLink', $this->getModule()->getMainLink());
    $this->assign('faqList', $this->getFaqList());
    $this->assign('serverSettings', $this->getServerSettings());
    return parent::getContent('overviewTabContent');
  }
  public function getFaqList()
  {
    return [];
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
