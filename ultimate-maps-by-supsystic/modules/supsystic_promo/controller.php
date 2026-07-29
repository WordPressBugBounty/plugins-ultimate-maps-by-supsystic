<?php
class supsystic_promoControllerUms extends controllerUms
{
  public function welcomePageSaveInfo()
  {
    $res = new responseUms();
    installerUms::setUsed();
    if ($this->getModel()->welcomePageSaveInfo(reqUms::get('get'))) {
      $res->addMessage(__('Information was saved. Thank you!', UMS_LANG_CODE));
    } else {
      $res->pushError($this->getModel()->getErrors());
    }
    $originalPage = reqUms::getVar('original_page');
    $http = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
    if (strpos($originalPage, $http . $_SERVER['HTTP_HOST']) !== 0) {
      $originalPage = '';
    }
    redirectUms($originalPage);
  }
  public function addNoticeAction()
  {
    $res = new responseUms();
    $code = reqUms::getVar('code', 'post');
    $choice = reqUms::getVar('choice', 'post');
    if (!empty($code) && !empty($choice)) {
      $optModel = frameUms::_()->getModule('options')->getModel();
      switch ($choice) {
        case 'hide':
          $optModel->save('hide_' . $code, 1);
          break;
        case 'later':
          $optModel->save('later_' . $code, time());
          break;
        case 'done':
          $optModel->save('done_' . $code, 1);
          break;
      }
      $this->getModel()->saveUsageStat($code . '.' . $choice, true);
      $this->getModel()->checkAndSend(true);
    }
    $res->ajaxExec();
  }
  public function sendSubscribeMail()
  {
    $res = new responseUms();
    $data = reqUms::get('post');
    $apiUrl = 'https://supsystic.com/wp-admin/admin-ajax.php';
    $reqUrl = $apiUrl . '?action=ac_get_plugin_installed';
    $mail = $data['data'];
    $isPro = !empty($this->getModule('suspsystic_promo')->isPro()) ? true : false;
    $data = [
      'body' => [
        'key' => 'kJ#f3(FjkF9fasd124t5t589u9d4389r3r3R#2asdas3(#R03r#(r#t-4t5t589u9d4389r3r3R#$%lfdj',
        'user_name' => $mail['username'],
        'user_email' => $mail['email'],
        'customertype' => $mail['expertise'],
        'site_url' => get_bloginfo('wpurl'),
        'site_name' => get_bloginfo('name'),
        'plugin_code' => 'ums',
        'is_pro' => $isPro,
      ],
    ];
    $response = wp_remote_post($reqUrl, $data);
    if (is_wp_error($response)) {
      $res->pushError('Some errors');
    } else {
      update_option('ums_ac_subscribe', true);
    }
    $res->ajaxExec();
  }
  public function sendSubscribeRemind()
  {
    $res = new responseUms();
    update_option('ums_ac_remind', date('Y-m-d h:i:s', time() + 86400));
    $res->ajaxExec();
  }
  public function sendSubscribeDisable()
  {
    $res = new responseUms();
    update_option('ums_ac_disabled', true);
    $res->ajaxExec();
  }
  /**
   * @see controller::getPermissions();
   */
  public function getNoncedMethods()
  {
    return ['welcomePageSaveInfo', 'addNoticeAction', 'sendSubscribeMail', 'sendSubscribeRemind', 'sendSubscribeDisable'];
  }
  public function getPermissions()
  {
    return [
      UMS_USERLEVELS => [
        UMS_ADMIN => ['welcomePageSaveInfo', 'addNoticeAction', 'sendSubscribeMail', 'sendSubscribeRemind', 'sendSubscribeDisable'],
      ],
    ];
  }
}
