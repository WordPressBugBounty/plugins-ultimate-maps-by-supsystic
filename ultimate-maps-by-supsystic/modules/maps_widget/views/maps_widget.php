<?php
class maps_widgetViewUms extends viewUms
{
  public function displayWidget($instance)
  {
    if (isset($instance['id']) && $instance['id']) {
      foreach ($instance as $key => $val) {
        if (empty($instance[$key])) {
          unset($instance[$key]);
        }
      }
      echo frameUms::_()->getModule('maps')->drawMapFromShortcode($instance);
    }
  }
  public function displayForm($data, $widget)
  {
    frameUms::_()->addStyle('maps_widget', $this->getModule()->getModPath() . 'css/maps_widget.css');

    $mapsModule = frameUms::_()->getModule('maps');
    $mapsOpts = $mapsModule ? $mapsModule->getMapsOptionsForSelect() : ['' => __('Select a map', UMS_LANG_CODE)];
    $this->assign('mapsOpts', $mapsOpts);
    $this->displayWidgetForm($data, $widget);
  }
}
