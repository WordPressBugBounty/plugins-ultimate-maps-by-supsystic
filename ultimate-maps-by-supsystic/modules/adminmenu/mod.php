<?php
class adminmenuUms extends moduleUms
{
  protected $_mainSlug = UMS_ADMIN_AREA_SLUG;
  private $_mainCap = 'manage_options';
  public function init()
  {
    parent::init();
    add_action('admin_menu', [$this, 'initMenu'], 9);
    $plugName = plugin_basename(UMS_DIR . UMS_MAIN_FILE);
  }
  public function initMenu()
  {
    $mainCap = $this->getMainCap();
    $mainSlug = dispatcherUms::applyFilters('adminMenuMainSlug', $this->_mainSlug);
    $mainMenuPageOptions = [
      'page_title' => UMS_WP_PLUGIN_NAME,
      'menu_title' => UMS_WP_PLUGIN_NAME,
      'capability' => $mainCap,
      'menu_slug' => $mainSlug,
      'function' => [frameUms::_()->getModule('options'), 'getAdminPage'],
    ];
    $mainMenuPageOptions = dispatcherUms::applyFilters('adminMenuMainOption', $mainMenuPageOptions);
    add_menu_page($mainMenuPageOptions['page_title'], $mainMenuPageOptions['menu_title'], $mainMenuPageOptions['capability'], $mainMenuPageOptions['menu_slug'], $mainMenuPageOptions['function'], UMS_ADMIN_MENU_ICON);
    // Internal tabs live in the plugin navigation; WordPress needs only the top-level entry.
  }
  public function getMainLink()
  {
    return uriUms::_(['baseUrl' => admin_url('admin.php'), 'page' => $this->getMainSlug()]);
  }
  public function getMainSlug()
  {
    return $this->_mainSlug;
  }
  public function getMainCap()
  {
    return dispatcherUms::applyFilters('adminMenuAccessCap', $this->_mainCap);
  }
}
