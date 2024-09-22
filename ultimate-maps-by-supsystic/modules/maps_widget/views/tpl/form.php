<?php
if (empty($this->data['width'])) $this->data['width'] = '100%';
if (empty($this->data['img_width'])) $this->data['img_width'] = 175;
if (empty($this->data['img_height'])) $this->data['img_height'] = 175;
?>
<div class="umsWidgetRow umsMapRow">
    <div class="umsWidgetRowCell umsFirstCell">
        <label for="<?php echo esc_attr($this->widget->get_field_id('id')) ?>"><?php esc_html_e('Select map', UMS_LANG_CODE) ?>:</label>
    </div>
    <div class="umsWidgetRowCell umsLastCell">
        <?php echo htmlUms::selectbox($this->widget->get_field_name('id'), array(
            'attrs' => 'id="' . esc_attr($this->widget->get_field_id('id')) . '"',
            'value' => isset($this->data['id']) ? esc_attr($this->data['id']) : 0,
            'options' => $this->mapsOpts,
        )); ?>
    </div>
</div>
<div class="umsWidgetRow">
    <div class="umsWidgetRowCell umsFirstCell">
        <label for="<?php echo esc_attr($this->widget->get_field_id('width')) ?>"><?php esc_html_e('Widget Map width', UMS_LANG_CODE) ?>:</label>
    </div>
    <div class="umsWidgetRowCell umsLastCell">
        <?php echo htmlUms::text($this->widget->get_field_name('width'), array(
            'attrs' => 'id="' . esc_attr($this->widget->get_field_id('width')) . '"',
            'value' => isset($this->data['width']) ? esc_attr($this->data['width']) : '100%',
        )); ?>
        <i class="supsystic-info"><?php esc_html_e('in % or px, for example, 100% or 200px', UMS_LANG_CODE) ?></i>
    </div>
</div>
<div class="umsWidgetRow">
    <div class="umsWidgetRowCell umsFirstCell">
        <label for="<?php echo esc_attr($this->widget->get_field_id('height')) ?>"><?php esc_html_e('Widget Map height', UMS_LANG_CODE) ?>:</label>
    </div>
    <div class="umsWidgetRowCell umsLastCell">
        <?php echo htmlUms::text($this->widget->get_field_name('height'), array(
            'attrs' => 'id="' . esc_attr($this->widget->get_field_id('height')) . '"',
            'value' => isset($this->data['height']) ? esc_attr($this->data['height']) : '',
        )); ?>
        <i class="supsystic-info"><?php esc_html_e('in px, for example, 200 or 400', UMS_LANG_CODE) ?></i>
    </div>
</div>
<div class="umsWidgetRow">
    <div class="umsWidgetRowCell umsFirstCell">
        <label for="<?php echo esc_attr($this->widget->get_field_id('map_center')) ?>"><?php esc_html_e('Map Center', UMS_LANG_CODE) ?>:</label>
    </div>
    <div class="umsWidgetRowCell umsLastCell">
        <?php echo htmlUms::text($this->widget->get_field_name('map_center'), array(
            'attrs' => 'id="' . esc_attr($this->widget->get_field_id('map_center')) . '"',
            'value' => isset($this->data['map_center']) ? esc_attr($this->data['map_center']) : '',
        )); ?>
        <i class="supsystic-info"><?php esc_html_e('Set coords, separated by semicolons or marker id', UMS_LANG_CODE) ?></i>
    </div>
</div>
<div class="umsWidgetRow">
    <div class="umsWidgetRowCell umsFirstCell">
        <label for="<?php echo esc_attr($this->widget->get_field_id('zoom')) ?>"><?php esc_html_e('Map Zoom', UMS_LANG_CODE) ?>:</label>
    </div>
    <div class="umsWidgetRowCell umsLastCell">
        <?php echo htmlUms::text($this->widget->get_field_name('zoom'), array(
            'attrs' => 'id="' . esc_attr($this->widget->get_field_id('zoom')) . '"',
            'value' => isset($this->data['zoom']) ? esc_attr($this->data['zoom']) : '',
        )); ?>
        <i class="supsystic-info"><?php esc_html_e('Set zoom level from 1 to 21', UMS_LANG_CODE) ?></i>
    </div>
</div>
<div class="umsWidgetRow">
    <div class="umsWidgetRowCell umsFirstCell">
        <label for="<?php echo esc_attr($this->widget->get_field_id('display_as_img')) ?>"><?php esc_html_e('Display as image', UMS_LANG_CODE) ?></label>
    </div>
    <div class="umsWidgetRowCell umsLastCell">
        <?php echo htmlUms::checkbox($this->widget->get_field_name('display_as_img'), array(
            'attrs' => 'id="' . esc_attr($this->widget->get_field_id('display_as_img')) . '"',
            'checked' => isset($this->data['display_as_img']),
        )); ?>
        <br />
        <i class="supsystic-info"><?php esc_html_e('Map will be displayed as an image at the sidebar, on click - will be opened in a popup', UMS_LANG_CODE) ?></i>
        <div class="umsWidgetSuboptions" id="<?php echo esc_attr($this->widget->get_field_id('img_params_shell')) ?>" style="display: none;">
            <div class="umsWidgetSuboptionsCell">
                <label for="<?php echo esc_attr($this->widget->get_field_id('img_width')) ?>"><?php esc_html_e('Image width (in px)', UMS_LANG_CODE) ?>:</label>
                <?php echo htmlUms::text($this->widget->get_field_name('img_width'), array(
                    'attrs' => 'id="' . esc_attr($this->widget->get_field_id('img_width')) . '"',
                    'value' => $this->data['img_width'],
                )); ?>
            </div>
            <div class="umsWidgetSuboptionsCell">
                <label for="<?php echo esc_attr($this->widget->get_field_id('img_height')) ?>"><?php esc_html_e('Image height (in px)', UMS_LANG_CODE) ?>:</label>
                <?php echo htmlUms::text($this->widget->get_field_name('img_height'), array(
                    'attrs' => 'id="' . esc_attr($this->widget->get_field_id('img_height')) . '"',
                    'value' => $this->data['img_height'],
                )); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // <!--
    jQuery(function () {
        function checkOpenImgParams() {
            if (jQuery('#<?php echo esc_js($this->widget->get_field_id('display_as_img')) ?>').prop('checked')) {
                jQuery('#<?php echo esc_js($this->widget->get_field_id('img_params_shell')) ?>').show();
            } else {
                jQuery('#<?php echo esc_js($this->widget->get_field_id('img_params_shell')) ?>').hide();
            }
        }
        checkOpenImgParams();
        jQuery('#<?php echo esc_js($this->widget->get_field_id('display_as_img')) ?>').change(function () {
            checkOpenImgParams();
        });
    });
    // -->
</script>