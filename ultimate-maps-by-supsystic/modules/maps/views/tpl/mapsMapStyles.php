<?php
if (empty($this->currentMap)) {
    return;
}
$viewId = esc_attr($this->currentMap['view_id']);
$mapHtmlId = esc_attr($this->currentMap['view_html_id']);
$width = trim($this->currentMap['html_options']['width']);
$widthUnits = trim($this->currentMap['params']['width_units']);
if (strpos($width, '%') === false && strpos($width, 'px') === false) {
    $widthUnits = isset($this->currentMap['params']['width_units']) ? esc_attr($this->currentMap['params']['width_units']) : 'px';
    $width = (int)$width . esc_attr($widthUnits);
}
//$width = $width.$widthUnits;
$percentMode = strpos($width, '%') == strlen($width) - 1 ? true : false;
$mapWidth = $this->currentMap['params']['map_display_mode'] == 'popup' ? '100%' : esc_attr($width);
$controlsWidth = $percentMode ? '100%' : esc_attr($width);

$height = esc_attr($this->currentMap['html_options']['height']);

$align = isset($this->currentMap['html_options']['align']) 
         ? trim(esc_attr($this->currentMap['html_options']['align'])) 
         : '';
$border = ((int)@$this->currentMap['html_options']['border_width']) . 'px solid ' . esc_attr(@$this->currentMap['html_options']['border_color']);
$margin = esc_attr(@$this->currentMap['html_options']['margin']);
?>
<style type="text/css" id="umsMapStyles_<?php echo $viewId; ?>">
    #<?php echo $mapHtmlId; ?> {
        width: <?php echo $mapWidth; ?>;
        height: <?php echo $height; ?>px;
        <?php if (!empty($align)) { ?>
            float: <?php echo $align; ?>;
        <?php } ?>
        border: <?php echo $border; ?>;
        margin: <?php echo ((int)$margin) . 'px'; ?>;
    }
    #mapsControlsNum_<?php echo $viewId; ?> {
        width:<?php echo $controlsWidth; ?>
    }
    .umsMapDetailsContainer#umsMapDetailsContainer_<?php echo $viewId; ?> {
        height:<?php echo (int)$height; ?>px;
    }
    .ums_MapPreview#<?php echo $mapHtmlId; ?> {
        /*position:absolute;*/
        width:100%;
    }
    #mapConElem_<?php echo $viewId; ?>{
        width:<?php echo esc_attr($width); ?>
    }
    <?php if (isset($this->currentMap['params']['infownd_title_color'])) { ?>
        #<?php echo $mapHtmlId; ?> .umsInfoWindowtitle {
            color: <?php echo esc_attr($this->currentMap['params']['infownd_title_color']) ?> !important;
            font-size: <?php echo esc_attr($this->currentMap['params']['infownd_title_size']) ?>px !important;
        }
    <?php } ?>
</style>