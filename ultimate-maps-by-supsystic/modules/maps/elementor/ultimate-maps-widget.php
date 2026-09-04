<?php
namespace Elementor;

if (!defined('ABSPATH')) {
  exit();
}

class Widget_Ultimate_Maps_Ums extends Widget_Base
{
  public function get_name()
  {
    return 'ultimate_maps_by_supsystic';
  }

  public function get_title()
  {
    return esc_html__('Ultimate Maps by Supsystic', UMS_LANG_CODE);
  }

  public function get_icon()
  {
    return 'eicon-google-maps';
  }

  public function get_categories()
  {
    return ['basic', 'general'];
  }

  public function get_keywords()
  {
    return ['map', 'maps', 'ultimate maps', 'supsystic', 'leaflet', 'bing'];
  }

  public function is_reload_preview_required()
  {
    return true;
  }

  protected function register_controls()
  {
    $this->start_controls_section('section_ultimate_maps', [
      'label' => esc_html__('Map', UMS_LANG_CODE),
    ]);

    $this->add_control('map_id', [
      'label' => esc_html__('Select Map', UMS_LANG_CODE),
      'type' => Controls_Manager::SELECT,
      'options' => $this->getMapsOptions(),
      'default' => $this->getDefaultMapId(),
    ]);

    $this->add_control('width', [
      'label' => esc_html__('Width', UMS_LANG_CODE),
      'type' => Controls_Manager::TEXT,
      'placeholder' => '100%',
    ]);

    $this->add_control('height', [
      'label' => esc_html__('Height', UMS_LANG_CODE),
      'type' => Controls_Manager::NUMBER,
      'min' => 50,
      'step' => 10,
    ]);

    $this->add_control('align', [
      'label' => esc_html__('Alignment', UMS_LANG_CODE),
      'type' => Controls_Manager::SELECT,
      'options' => [
        '' => esc_html__('Default', UMS_LANG_CODE),
        'left' => esc_html__('Left', UMS_LANG_CODE),
        'right' => esc_html__('Right', UMS_LANG_CODE),
        'none' => esc_html__('None', UMS_LANG_CODE),
      ],
      'default' => '',
    ]);

    $this->end_controls_section();
  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $mapId = !empty($settings['map_id']) ? (int) $settings['map_id'] : 0;

    if (!$mapId) {
      if (isset(Plugin::$instance->editor) && Plugin::$instance->editor->is_edit_mode()) {
        echo '<div class="elementor-alert elementor-alert-info">' . esc_html__('Select an Ultimate Maps map to display it here.', UMS_LANG_CODE) . '</div>';
      }
      return;
    }

    $params = ['id' => $mapId];
    foreach (['width', 'height', 'align'] as $key) {
      if (isset($settings[$key]) && $settings[$key] !== '') {
        $params[$key] = sanitize_text_field($settings[$key]);
      }
    }

    echo \frameUms::_()->getModule('maps')->drawMapFromShortcode($params);
  }

  private function getMapsOptions()
  {
    $mapsModule = \frameUms::_()->getModule('maps');
    return $mapsModule ? $mapsModule->getMapsOptionsForSelect() : ['' => esc_html__('Select a map', UMS_LANG_CODE)];
  }

  private function getDefaultMapId()
  {
    $mapsModule = \frameUms::_()->getModule('maps');
    return $mapsModule ? $mapsModule->getDefaultMapId() : '';
  }
}
