<form id="umsMapForm">
	<table class="form-table">
    <tr>
        <th scope="row">
            <label class="label-big" for="map_opts_title">
                <?php esc_html_e('Map Name', UMS_LANG_CODE); ?>:
            </label>
            <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Your map name', UMS_LANG_CODE); ?>"></i>
        </th>
        <td>
            <?php echo htmlUms::text('map_opts[title]', array(
                'value' => $this->editMap ? esc_attr($this->map['title']) : '',
                'attrs' => 'style="width: 100%;" id="map_opts_title"',
                'required' => true)) ?>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="map_opts_width">
                <?php esc_html_e('Map Width', UMS_LANG_CODE); ?>:
            </label>
            <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Your map width', UMS_LANG_CODE); ?>"></i>
        </th>
        <td>
            <div class="sup-col sup-w-25">
                <?php echo htmlUms::text('map_opts[width]', array(
                    'value' => $this->editMap ? esc_attr($this->map['html_options']['width']) : '100',
                    'attrs' => 'style="width: 100%;" id="map_opts_width"')) ?>
            </div>
            <div class="sup-col sup-w-75">
                <label class="supsystic-tooltip" title="<?php esc_attr_e('Pixels', UMS_LANG_CODE)?>" style="margin-right: 15px; position: relative; top: 7px;"><?php echo htmlUms::radiobutton('map_opts[width_units]', array(
                    'value' => 'px',
                    'checked' => $this->editMap ? htmlUms::checkedOpt($this->map['params'], 'width_units', 'px') : false,
                ))?>&nbsp;<?php esc_html_e('Px', UMS_LANG_CODE)?></label>
                <label style="margin-right: 15px; position: relative; top: 7px;"><?php echo htmlUms::radiobutton('map_opts[width_units]', array(
                    'value' => '%',
                    'checked' => $this->editMap ? htmlUms::checkedOpt($this->map['params'], 'width_units', '%') : true,
                ))?>&nbsp;<?php esc_html_e('Percents', UMS_LANG_CODE)?></label>
            </div>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="map_opts_height">
                <?php esc_html_e('Map Height', UMS_LANG_CODE); ?>:
            </label>
            <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Your map height. If Adapt map to screen height option is checked - map height will be recalculated on frontend and can be equals to: 1) your device screen height - height from top of page to top of map (if screen height > height from top of page to top of map) 2) your device screen height (in other cases) Recalculation will be done for maps in page content and widgets except of maps which displaying in Ultimate Maps by Supsystic widget popup (Display as image mode).', UMS_LANG_CODE); ?>"></i>
        </th>
        <td>
            <div class="sup-col no-p">
                <div class="sup-col sup-w-50 umsMainHeightOpts" style="padding-right: 15px;">
                    <?php echo htmlUms::text('map_opts[height]', array(
                        'value' => $this->editMap ? esc_attr($this->map['html_options']['height']) : '250',
                        'attrs' => 'style="width: 100%;" id="map_opts_height"')) ?>
                </div>
                <div class="sup-col sup-w-25 no-p umsMainHeightOpts">
                    <label class="supsystic-tooltip" title="<?php esc_attr_e('Pixels', UMS_LANG_CODE)?>" style="margin-right: 15px; position: relative; top: 7px;"><?php echo htmlUms::radiobutton('map_opts_height_units_is_constant', array(
                        'value' => 'px',
                        'checked' => true,
                    ))?>&nbsp;<?php esc_html_e('Px', UMS_LANG_CODE)?></label>
                </div>
                <div class="sup-col sup-w-25 no-p">
                    <label>
                        <?php echo htmlUms::checkboxHiddenVal('map_opts[adapt_map_to_screen_height]', array(
                            'value' => $this->editMap && isset($this->map['params']['adapt_map_to_screen_height']) ? $this->map['params']['adapt_map_to_screen_height'] : false,
                        )) ?>
                        <span style="vertical-align: middle;">
                            <?php esc_html_e('Adapt map to screen height', UMS_LANG_CODE)?>
                        </span>
                    </label>
                </div>
            </div>
        </td>
    </tr>
    </table>
	<div id="umsExtendOptsShell" class="supRow">
		<table class="form-table">
			<tr>
    <th scope="row">
        <label for="map_opts_navigation_bar_mode">
            <?php esc_html_e('Navigation bar Mode', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Control view for map type - you can see it in the right upper corner by default', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <div class="sup-col sup-w-100">
            <?php echo htmlUms::selectbox('map_opts[navigation_bar_mode]', array(
                'options' => $this->engineOpts['navigation_bar_mode'],
                'value' => $this->editMap && isset($this->map['params']['navigation_bar_mode']) ? esc_attr($this->map['params']['navigation_bar_mode']) : 'HORIZONTAL_BAR',
                'attrs' => 'style="width: 100%;" id="map_opts_navigation_bar_mode"')) ?>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2" style="padding: 0;">
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="map_optsdraggable_check">
                        <?php esc_html_e('Draggable', UMS_LANG_CODE); ?>:
                    </label>
                    <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Enable or disable the possibility to drag your map using the mouse', UMS_LANG_CODE); ?>"></i>
                </th>
                <td>
                    <?php echo htmlUms::selectbox('map_opts[draggable]', array(
                        'options' => array(
                            'enable' => esc_html__('Desktop & Mobile', UMS_LANG_CODE),
                            'desktop' => esc_html__('Only Desktop', UMS_LANG_CODE),
                            'mobile' => esc_html__('Only Mobile', UMS_LANG_CODE),
                            'disable' => esc_html__('Disabled for Everyone', UMS_LANG_CODE),
                        ),
                        'value' => $this->editMap && isset($this->map['params']['draggable']) ? esc_attr($this->map['params']['draggable']) : 'enable',
                        'attrs' => 'style="width: 100%;" id="draggable"')) ?>
                </td>
                <th scope="row">
                    <label for="map_optsmouse_wheel_zoom_check">
                        <?php esc_html_e('Mouse wheel to zoom', UMS_LANG_CODE); ?>:
                    </label>
                    <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Sometimes you need to disable the possibility to zoom your map using the mouse wheel. This can be required, for example, if you need to use your wheel for some other action, such as scrolling your site even if the mouse is over your map.', UMS_LANG_CODE); ?>"></i>
                </th>
                <td>
                    <?php echo htmlUms::checkboxHiddenVal('map_opts[mouse_wheel_zoom]', array(
                        'value' => $this->editMap && isset($this->map['params']['mouse_wheel_zoom']) ? $this->map['params']['mouse_wheel_zoom'] : true,
                    )) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="map_optsdbl_click_zoom_check">
                        <?php esc_html_e('Double click to zoom', UMS_LANG_CODE); ?>:
                    </label>
                    <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('By default double left click on the map will zoom it in. But you can change this here.', UMS_LANG_CODE); ?>"></i>
                </th>
                <td>
                    <?php echo htmlUms::checkboxHiddenVal('map_opts[dbl_click_zoom]', array(
                        'value' => $this->editMap && isset($this->map['params']['dbl_click_zoom']) ? $this->map['params']['dbl_click_zoom'] : true,
                    )) ?>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <th scope="row">
        <label for="map_opts_map_center_address" class="sup-medium-label">
            <?php esc_html_e('Map Center', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Sets map center. You can set the map center in the next ways: type an address to use its coordinates, type the coordinates\' values in appropriate fields, or just drag the map on the preview.', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <div>
            <label for="map_opts_map_center_address">
                <?php esc_html_e('Address', UMS_LANG_CODE); ?>
            </label>
            <?php echo htmlUms::text('map_opts[map_center][address]', array(
                'value' => $this->editMap && isset($this->map['params']['map_center']['address']) ? esc_attr($this->map['params']['map_center']['address']) : '',
                'placeholder' => '603 Park Avenue, Brooklyn, NY 11206, USA',
                'attrs' => 'style="width: 100%;" id="map_opts_map_center_address"')) ?>
        </div>
        <div class="sup-col sup-w-50" style="margin-top: 10px;">
            <label for="map_opts_map_center_coord_x">
                <?php esc_html_e('Latitude', UMS_LANG_CODE); ?>
            </label>
            <?php echo htmlUms::text('map_opts[map_center][coord_x]', array(
                'value' => $this->editMap ? $this->map['params']['map_center']['coord_x'] : '',
                'attrs' => 'style="width: 100%;" id="map_opts_map_center_coord_x"')) ?>
        </div>
        <div class="sup-col sup-w-50" style="margin-top: 10px;">
            <label for="map_opts_map_center_coord_y">
                <?php esc_html_e('Longitude', UMS_LANG_CODE); ?>
            </label>
            <?php echo htmlUms::text('map_opts[map_center][coord_y]', array(
                'value' => $this->editMap ? $this->map['params']['map_center']['coord_y'] : '',
                'attrs' => 'style="width: 100%;" id="map_opts_map_center_coord_y"')) ?>
        </div>
    </td>
</tr>
<tr>
    <th scope="row">
        <label for ="map_opts_zoom_type" class="sup-medium-label">
            <?php esc_html_e('Map Zoom', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Sets map zoom.<br /><br /><b>Min Zoom Level</b> - sets the minimum zoom level (maximum estrangement), which can be applied for the map.<br /><br /><b>Max Zoom Level</b> - sets the maximum zoom level (maximum approximation), which can be applied for the map.', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <?php
        $zoomMin = 1;
        $zoomMax = 21;
        $zoomRange = array_combine(range($zoomMin, $zoomMax), range($zoomMin, $zoomMax));
        ?>
        <div id="zoom_type_options">
            <div style="clear: both;">
                <div class="zoom_level sup-col" style="width: 100%;">
                    <label for="map_opts_zoom">
                        <?php esc_html_e('Zoom Level', UMS_LANG_CODE); ?>
                    </label>
                    <?php echo htmlUms::selectbox('map_opts[zoom]', array(
                        'options' => $zoomRange,
                        'value' => $this->editMap && isset($this->map['params']['zoom']) ? esc_attr($this->map['params']['zoom']) : 8,
                        'attrs' => 'style="width: 100%;"')) ?>
                </div>
                <div class="zoom_min_level sup-col sup-w-50">
                    <label for="map_opts_zoom_min">
                        <?php esc_html_e('Min Zoom Level', UMS_LANG_CODE); ?>
                    </label>
                    <?php echo htmlUms::selectbox('map_opts[zoom_min]', array(
                        'options' => $zoomRange,
                        'value' => $this->editMap && isset($this->map['params']['zoom_min']) ? esc_attr($this->map['params']['zoom_min']) : $zoomMin,
                        'attrs' => 'style="width: 100%;"')) ?>
                </div>
                <div class="zoom_max_level sup-col sup-w-50">
                    <label for="map_opts_zoom_max">
                        <?php esc_html_e('Max Zoom Level', UMS_LANG_CODE); ?>
                    </label>
                    <?php echo htmlUms::selectbox('map_opts[zoom_max]', array(
                        'options' => $zoomRange,
                        'value' => $this->editMap && isset($this->map['params']['zoom_max']) ? esc_attr($this->map['params']['zoom_max']) : $zoomMax,
                        'attrs' => 'style="width: 100%;"')) ?>
                </div>
            </div>
            <div id="umsZoomLelvelsError" class="umsErrorMsg" style="clear: both; display: none; width: 100%;">
                <?php esc_html_e('Min Zoom Level should be less than Max Zoom Level', UMS_LANG_CODE); ?>
            </div>
        </div>
    </td>
</tr>
<tr>
    <th scope="row">
        <label for="map_opts_map_type">
            <?php esc_html_e('Map Type', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('You can select your Map Theme here.', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <?php $mapTypeKeys = array_keys($this->engineOpts['map_type']); ?>
        <?php $defMapType = array_shift($mapTypeKeys); ?>
        <?php echo htmlUms::selectbox('map_opts[map_type]', array(
            'options' => $this->engineOpts['map_type'],
            'value' => $this->editMap && isset($this->map['params']['map_type'])
                ? esc_attr($this->map['params']['map_type'])
                : $defMapType,
            'attrs' => 'style="width: 100%;" id="map_opts_map_type"')) ?>
    </td>
</tr>
<?php if ($this->engineOpts['map_stylization']) { ?>
<tr>
    <th scope="row">
        <label for="map_opts_map_stylization">
            <?php esc_html_e('Map Stylization', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Make your map unique with our Map Themes, just try to change it here - and you will see results on your Map Preview.', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <?php echo htmlUms::selectbox('map_opts[map_stylization]', array(
            'options' => $this->stylizationsForSelect,
            'value' => $this->editMap && isset($this->map['params']['map_stylization']) ? esc_attr($this->map['params']['map_stylization']) : 'none',
            'attrs' => 'style="width: ' . ($this->isPro ? '100%' : 'calc(100% - 200px)') . ';" id="map_opts_map_stylization"')) ?>
        <?php if (!$this->isPro) { ?>
            <a target="_blank" href="<?php echo esc_url($this->mainLink); ?>" class="sup-standard-link">
                <i class="fa fa-plus"></i>
                <?php esc_html_e('Get 300+ Themes with PRO', UMS_LANG_CODE); ?>
            </a>
        <?php } ?>
    </td>
</tr>
<?php } ?>
<tr>
    <th scope="row">
        <label for="map_optsdbl_click_zoom_check">
            <?php esc_html_e('Show marker description by hover', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Show marker description by hover. (Desktop)', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <?php echo htmlUms::checkboxHiddenVal('map_opts[marker_hover]', array(
            'value' => $this->editMap && isset($this->map['params']['marker_hover']) ? esc_attr($this->map['params']['marker_hover']) : true,
        )) ?>
    </td>
</tr>
<tr>
    <th scope="row">
        <label for="map_opts_marker_clasterer" class="sup-medium-label">
            <?php esc_html_e('Markers Clusterization', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('If you have many markers, they may overlap when zoomed out. Marker clusterization groups markers when they are too close to each other.', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <?php echo htmlUms::selectbox('map_opts[marker_clasterer]', array(
            'options' => array('none' => esc_html__('None', UMS_LANG_CODE), 'MarkerClusterer' => esc_html__('Base Clusterization', UMS_LANG_CODE)),
            'value' => $this->editMap && isset($this->map['params']['marker_clasterer']) ? esc_attr($this->map['params']['marker_clasterer']) : 'none',
            'attrs' => 'style="width: 100%;" id="map_opts_marker_clasterer"'));
            
        $oldDefClasterIcon = '';
        $curClusterIcon = uriUms::_(
            $this->editMap && isset($this->map['params']['marker_clasterer_icon']) && $this->map['params']['marker_clasterer_icon'] && $this->map['params']['marker_clasterer_icon'] != $oldDefClasterIcon
                ? $this->map['params']['marker_clasterer_icon']
                : UMS_MODULES_PATH . '/maps/img/m1.png');
        $curClusterIconWidth = $this->editMap && isset($this->map['params']['marker_clasterer_icon_width']) ? $this->map['params']['marker_clasterer_icon_width'] : 53;
        $curClusterIconHeight = $this->editMap && isset($this->map['params']['marker_clasterer_icon_height']) ? $this->map['params']['marker_clasterer_icon_height'] : 52;
        ?>
        <div id="umsMarkerClastererSubOpts" style="display: none;">
            <div class="umsClastererSubOpts">
                <label for="map_opts_marker_clasterer_grid_size">
                    <?php esc_html_e('Cluster Area Size', UMS_LANG_CODE); ?>
                </label>
                <i class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Sets the grid size of the cluster. The higher the size, the more area captures the markers in the cluster.', UMS_LANG_CODE); ?>"></i>
                <br />
                <div class="sup-col sup-w-75">
                    <?php echo htmlUms::text('map_opts[marker_clasterer_grid_size]', array(
                        'value' => $this->editMap && isset($this->map['params']['marker_clasterer_grid_size']) ? esc_attr($this->map['params']['marker_clasterer_grid_size']) : '60',
                        'attrs' => 'style="width: 100%;" id="umsMarkerClastererGridSize" ')); ?>
                </div>
                <div class="sup-col" style="max-width: 50%; min-width: 20%; float: right; padding: 0; text-align: center;">
                    <a id="umsDefaultClastererGridSizeBtn" href="#" class="button" style="width: 100%; margin-bottom: 5px;"><?php esc_html_e('Default', UMS_LANG_CODE); ?></a>
                </div>
                <div style="margin-top: 10px;">
                    <label for="map_opts_marker_clasterer_background_color">
                        <?php esc_html_e('Marker Clasterer Background Color', UMS_LANG_CODE); ?>
                    </label><i class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Works with Leaflet, MapBox, Thunderforest, Bing.', UMS_LANG_CODE); ?>"></i></br>
                    <?php echo htmlUms::colorpicker('map_opts[marker_clasterer_background_color]', array(
                        'value' => $this->editMap && isset($this->map['params']['marker_clasterer_background_color']) ? esc_attr($this->map['params']['marker_clasterer_background_color']) : '#2196f3')); ?>
                </div>
                <div style="margin-top: 10px;">
                    <label for="map_opts_marker_clasterer_border_color">
                        <?php esc_html_e('Marker Clasterer Border Color', UMS_LANG_CODE); ?>
                    </label><i class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Works with Leaflet, MapBox, Thunderforest.', UMS_LANG_CODE); ?>"></i></br>
                    <?php echo htmlUms::colorpicker('map_opts[marker_clasterer_border_color]', array(
                        'value' => $this->editMap && isset($this->map['params']['marker_clasterer_border_color']) ? esc_attr($this->map['params']['marker_clasterer_border_color']) : '#1c7ba7')); ?>
                </div>
                <div style="margin-top: 10px;">
                    <label for="map_opts_marker_clasterer_text_color">
                        <?php esc_html_e('Marker Clasterer Text Color', UMS_LANG_CODE); ?>
                    </label><i class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Works with Leaflet, MapBox, Thunderforest.', UMS_LANG_CODE); ?>"></i></br>
                    <?php echo htmlUms::colorpicker('map_opts[marker_clasterer_text_color]', array(
                        'value' => $this->editMap && isset($this->map['params']['marker_clasterer_text_color']) ? esc_attr($this->map['params']['marker_clasterer_text_color']) : 'white')); ?>
                </div>
            </div>
        </div>
    </td>
</tr>
<tr>
    <th scope="row">
        <label for="map_opts_markers_list_type">
            <?php esc_html_e('Markers List', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Display all map markers as a list below your map. This helps users get more info about your markers and find a specific marker more quickly.', UMS_LANG_CODE); ?>"></i>
        <?php if (!$this->isPro) { ?>
            <br /><span class="umsProOptMiniLabel"><a target="_blank" href="<?php echo esc_url($this->mainLink); ?>"><?php esc_html_e('PRO option', UMS_LANG_CODE); ?></a></span>
        <?php } ?>
    </th>
    <td>
        <?php echo htmlUms::checkboxHiddenVal('map_opts[enable_marker_list_type]', array(
            'value' => $this->editMap && isset($this->map['params']['enable_marker_list_type']) ? $this

->map['params']['enable_marker_list_type'] : false,
        )); ?>
        <?php esc_html_e('Enable markers list', UMS_LANG_CODE); ?>

        <div id="umsMapMarkersListSettings" style="display: none;">
            <?php if ($this->isPro) { ?>
                <div style="margin-top:15px;">
                    <a id="umsMapMarkersListBtn" href="#" class="button"><?php esc_html_e('Select Markers List type', UMS_LANG_CODE); ?></a>
                    <?php echo htmlUms::hidden('map_opts[markers_list_type]', array(
                        'value' => $this->editMap && isset($this->map['params']['markers_list_type']) ? esc_attr($this->map['params']['markers_list_type']) : '',
                    )); ?>
                </div>

                <div style="margin-top:15px;" class="slider_simple_table_show">
                    <label for="map_opts_slider_simple_table_width_address">
                        <?php esc_html_e('Width dimension', UMS_LANG_CODE); ?>
                    </label>
                    </br>
                    <?php echo htmlUms::selectbox('map_opts[slider_simple_table_width_dimension]', array(
                        'options' => array('px' => esc_html__('px', UMS_LANG_CODE), '%' => esc_html__('%', UMS_LANG_CODE)),
                        'value' => $this->editMap && isset($this->map['params']['slider_simple_table_width_dimension']) ? esc_attr($this->map['params']['slider_simple_table_width_dimension']) : 'px',
                        'attrs' => 'style="width: 100%;" id="map_opts_slider_simple_table_width_dimension"')); ?>
                    </br>
                    <label for="map_opts_slider_simple_table_width_address">
                        <?php esc_html_e('Title Column Width', UMS_LANG_CODE); ?>
                    </label>
                    </br>
                    <?php echo htmlUms::text('map_opts[slider_simple_table_width_title]', array(
                        'value' => $this->editMap && isset($this->map['params']['slider_simple_table_width_title']) ? esc_attr($this->map['params']['slider_simple_table_width_title']) : '',
                        'attrs' => 'style="width: 100%;" '
                    )); ?>
                    <label for="map_opts_slider_simple_table_width_address">
                        <?php esc_html_e('Address Column Width', UMS_LANG_CODE); ?>
                    </label>
                    </br>
                    <?php echo htmlUms::text('map_opts[slider_simple_table_width_address]', array(
                        'value' => $this->editMap && isset($this->map['params']['slider_simple_table_width_address']) ? esc_attr($this->map['params']['slider_simple_table_width_address']) : '',
                        'attrs' => 'style="width: 100%;" '
                    )); ?>
                    <label for="map_opts_slider_simple_table_width_address">
                        <?php esc_html_e('Description Column Width', UMS_LANG_CODE); ?>
                    </label>
                    </br>
                    <?php echo htmlUms::text('map_opts[slider_simple_table_width_description]', array(
                        'value' => $this->editMap && isset($this->map['params']['slider_simple_table_width_description']) ? esc_attr($this->map['params']['slider_simple_table_width_description']) : '',
                        'attrs' => 'style="width: 100%;" '
                    )); ?>
                    <label for="map_opts_slider_simple_table_width_address">
                        <?php esc_html_e('Get Direction Column Width', UMS_LANG_CODE); ?>
                    </label>
                    </br>
                    <?php echo htmlUms::text('map_opts[slider_simple_table_width_getdirection]', array(
                        'value' => $this->editMap && isset($this->map['params']['slider_simple_table_width_getdirection']) ? esc_attr($this->map['params']['slider_simple_table_width_getdirection']) : '',
                        'attrs' => 'style="width: 100%;" '
                    )); ?>
                </div>
                <div style="margin-top:15px;">
                    <?php echo htmlUms::checkboxHiddenVal('map_opts[hide_empty_block]', array(
                        'value' => $this->editMap && isset($this->map['params']['hide_empty_block']) ? $this->map['params']['hide_empty_block'] : false,
                    )); ?>
                    <?php esc_html_e('Hide blocks without image', UMS_LANG_CODE); ?>
                </div>
                <div style="margin-top:15px;">
                    <?php echo htmlUms::checkboxHiddenVal('map_opts[autoplay_slider]', array(
                        'value' => $this->editMap && isset($this->map['params']['autoplay_slider']) ? $this->map['params']['autoplay_slider'] : false,
                    )); ?>
                    <?php esc_html_e('Enable autoplay slider and set', UMS_LANG_CODE); ?>
                    <?php echo htmlUms::text('map_opts[slide_duration]', array(
                        'value' => $this->editMap && isset($this->map['params']['slide_duration']) ? esc_attr($this->map['params']['slide_duration']) : false,
                        'placeholder' => '500',
                        'attrs' => 'style="width:50px"',
                    )); ?>
                    <?php esc_html_e('slide duration in (ms)', UMS_LANG_CODE); ?>
                </div>
            <?php } ?>
            <div style="margin-top: 10px;">
                <label for="map_opts_markers_list_color">
                    <?php esc_html_e('Markers List Color', UMS_LANG_CODE); ?>
                </label></br>
                <?php echo htmlUms::colorpicker('map_opts[markers_list_color]', array(
                    'value' => $this->editMap && isset($this->map['params']['markers_list_color']) ? esc_attr($this->map['params']['markers_list_color']) : '#55BA68')); ?>
            </div>
        </div>
    </td>
</tr>
<tr>
    <th scope="row">
        <?php if(!$this->isPro) { ?>
            <?php $proLink = esc_url(frameUms::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=add_kml_layers&utm_campaign=ultimatemaps')); ?>
        <?php }?>
        <label for="map_opts_add_kml_layers">
            <?php esc_html_e('Add KML layers', UMS_LANG_CODE); ?>:
        </label>
        <i class="fa fa-question supsystic-tooltip" style="float: right;" title="<?php esc_attr_e('Add KML files to display custom layers on the map.', UMS_LANG_CODE);
            if(!$this->isPro){
                echo esc_html('<a href="'. $proLink. '" target="_blank"><img src="'. $this->promoModPath. 'img/kml/kml.png" /></a>');
            }?>"
        ></i>
        <?php if(!$this->isPro) { ?>
            <br /><span class="umsProOptMiniLabel"><a target="_blank" href="<?php echo $proLink; ?>"><?php esc_html_e('PRO option', UMS_LANG_CODE); ?></a></span>
        <?php }?>
    </th>
    <td>
        <div id="umsKmlFileRowExample" class="umsKmlFileRow" style="display: none;">
            <div style="clear: both;"></div>
            <label><?php esc_html_e('Enter KML file URL', UMS_LANG_CODE); ?></label>
            <div style="clear: both;"></div>
            <a href="#" title="<?php esc_attr_e('Remove KML field', UMS_LANG_CODE); ?>" class="button umsProOpt" onclick="umsKmlRemoveFileRowBtnClick(this); return false;">
                <i class="fa fa-trash-o"></i>
            </a>
            <?php echo htmlUms::text('map_opts[kml_file_url][]', array('value' => '', 'attrs' => 'class="umsProOpt" style="width: 86%; float: right;" disabled="disabled"')); ?>
            <span class="umsKmlUploadMsg" style="float: right; width: 100%; text-align: right;" ></span>
            <a 	href="#"
                class="umsKmlUploadFileBtn button umsProOpt"
                data-nonce="<?php echo esc_attr(wp_create_nonce('upload-kml-file')); ?>"
                data-url="<?php echo esc_url(uriUms::_(array(
                    'baseUrl' => admin_url('admin-ajax.php'),
                    'page' => 'kml',
                    'action' => 'addFromFile',
                    'reqType' => 'ajax',
                    'pl' => UMS_CODE))); ?>"
                id="umsKmlUploadFileBtn"
                style="margin: 5px 0px; float: right;">
                <?php esc_html_e('or Upload KML file', UMS_LANG_CODE); ?>
            </a><br />
        </div>
        <?php
            if(!empty($this->map['params']['kml_import_to_marker'])
                && count($this->map['params']['kml_import_to_marker'])
            ) {
                foreach($this->map['params']['kml_import_to_marker'] as $omKey => $oneMarker) {
                    $isKmlImpToMarkerVal = 0;
                    if($oneMarker == 'on') {
                        $isKmlImpToMarkerVal = 1;
                    }
                    echo htmlUms::hidden('map_opts[kml_import_to_marker][]', array(
                        'value' => $isKmlImpToMarkerVal,
                        'attrs' => ' class="umsProOpt umsKmlImportToMarkerHid" data-order="' . esc_attr($omKey) . '" ',
                    ));
                }
            }
        ?>
        <div id="umsKmlFileRowsShell"></div>
        <a href="#" class="button umsProOpt" id="umsKmlAddFileRowBtn" style="margin: 5px 5px 5px 0px; float: left;">
            <?php esc_html_e('Add more files', UMS_LANG_CODE); ?>
        </a>
    </td>
</tr>
<?php if(isset($this->engineOpts['hide_poi']) && $this->engineOpts['hide_poi']) { ?>
<tr>
    <th scope="row">
        <label for="map_opts_hide_poi">
            <?php esc_html_e('Hide POI', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('Hide the Points Of Interest - landmark or other object, the marked points on the map (only for Aerial and Birdseye types), for example: hotels, campsites, fuel stations etc.', UMS_LANG_CODE); ?>"></i>
        <?php if(!$this->isPro) { ?>
            <?php $proLink = esc_url(frameUms::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=hide_poi&utm_campaign=ultimatemaps')); ?>
            <br /><span class="umsProOptMiniLabel"><a target="_blank" href="<?php echo $proLink; ?>"><?php esc_html_e('PRO option', UMS_LANG_CODE); ?></a></span>
        <?php }?>
    </th>
    <td>
        <?php echo htmlUms::checkboxHiddenVal('map_opts[hide_poi]', array(
            'value' => $this->editMap && isset($this->map['params']['hide_poi']) ? $this->map['params']['hide_poi'] : false,
            'attrs' => 'class="umsProOpt"')); ?>
    </td>
</tr>
<?php } ?>
<tr>
    <th scope="row">
        <label for="map_opts_frontend_add_markers">
            <?php esc_html_e('Add markers on frontend', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e("You can add markers at the current map with the frontend using the form, which can be displayed using the shortcode (it placed below preview map). Additional options that affect the operation of the form:" .
            "<br /><br /><b>Logged In Users Only</b> - form will be displayed only for logged in users." .
            "<br /><br /><b>Disable WP Editor</b> - disable / enable WP Editor for the Marker Description field of the form." .
            "<br /><br /><b>Delete markers</b> - disable / enable interface for deleting markers on frontend. Each user can delete only his own markers." .
            "<br /><br /><b>Use markers categories</b> - disable / enable interface for choose the marker category on frontend." .
            "<br /><br /><b>Use limits for marker's adding</b> - allows you to limit the number of markers, which user can add from one IP address at the current map for a certain amount of time." .
            "<br /><br /><b>Max marker's count</b> - the maximum number of markers, which can be added over certain amount of time." .
            "<br /><br /><b>For allotted time (minutes)</b> - the number of minutes, during which you can add the maximum number of markers." .
            "<br /><br />For example, during three minutes you can add only two markers at the map. If you try to add a third marker - the form will not be saved and you will see the notice with amount of time you must wait. After the right amount of time will pass - you can add next two markers, etc." .
            "<br /><br />Important! If map and form for add markers at this map are placed on one page - this page will be overload after marker adding.", UMS_LANG_CODE); ?>"></i>
        <?php if(!$this->isPro) { ?>
            <?php $proLink = esc_url(frameUms::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=frontend_add_markers&utm_campaign=ultimatemaps')); ?>
            <br /><span class="umsProOptMiniLabel"><a target="_blank" href="<?php echo esc_url($proLink); ?>"><?php esc_html_e('PRO option', UMS_LANG_CODE); ?></a></span>
        <?php }?>
    </th>
    <td>
        <?php echo htmlUms::checkboxHiddenVal('map_opts[frontend_add_markers]', array(
            'value' => $this->editMap && isset($this->map['params']['frontend_add_markers']) ? $this->map['params']['frontend_add_markers'] : false,
            'attrs' => 'class="umsProOpt" id="map_opts_frontend_add_markers"'
        ))?>
        <div id="umsAddMarkersOnFrontendOptions" style="display: none;">
            <div style="margin-top: 10px;">
                <?php echo htmlUms::text('umsCopyTextCode', array(
                    'value' => '',	// Will be inserted from JS
                    'attrs' => 'class="umsCopyTextCode umsMapMarkerFormCodeShell umsStaticWidth" style="width: 100%; text-align: center;"'));?>
            </div>
            <div style="margin-top: 10px;">
                <?php echo htmlUms::checkboxHiddenVal('map_opts[frontend_add_markers_logged_in_only]', array(
                    'value' => $this->editMap && isset($this->map['params']['frontend_add_markers_logged_in_only']) ? $this->map['params']['frontend_add_markers_logged_in_only'] : false,
                    'attrs' => 'class="umsProOpt" id="map_opts_frontend_add_markers_logged_in_only"'
                ))?>
                <label for="map_opts_frontend_add_markers_logged_in_only"><?php esc_html_e('Logged In Users Only', UMS_LANG_CODE); ?></label>
            </div>
            <div style="margin-top: 10px;">
                <?php echo htmlUms::checkboxHiddenVal('map_opts[frontend_add_markers_disable_wp_editor]', array(
                    'value' => $this->editMap && isset($this->map['params']['frontend_add_markers_disable_wp_editor']) ? $this->map['params']['frontend_add_markers_disable_wp_editor'] : false,
                    'attrs' => 'class="umsProOpt" id="map_opts_frontend_add_markers_disable_wp_editor"'
                ))?>
                <label for="map_opts_frontend_add_markers_disable_wp_editor"><?php esc_html_e('Disable WP Editor', UMS_LANG_CODE); ?></label>
            </div>
            <div style="margin-top: 10px;">
                <?php echo htmlUms::checkboxHiddenVal('map_opts[frontend_add_markers_delete_markers]', array(
					'value' => $this->editMap && isset($this->map['params']['frontend_add_markers_delete_markers']) ? $this->map['params']['frontend_add_markers_delete_markers'] : false,
                    'attrs' => 'class="umsProOpt" id="map_opts_frontend_add_markers_delete_markers"'
                ))?>
                <label for="map_opts_frontend_add_markers_delete_markers"><?php esc_html_e('Delete markers', UMS_LANG_CODE); ?></label>
            </div>
            <div style="margin-top: 10px;">
                <?php echo htmlUms::checkboxHiddenVal('map_opts[frontend_add_markers_use_markers_categories]', array(
                    'value' => $this->editMap && isset($this->map['params']['frontend_add_markers_use_markers_categories']) ? $this->map['params']['frontend_add_markers_use_markers_categories'] : false,
                    'attrs' => 'class="umsProOpt" id="map_opts_frontend_add_markers_use_markers_categories"'
                ))?>
                <label for="map_opts_frontend_add_markers_use_markers_categories"><?php esc_html_e('Use markers categories', UMS_LANG_CODE); ?></label>
            </div>
            <div style="margin-top: 10px;">
                <?php echo htmlUms::checkboxHiddenVal('map_opts[frontend_add_markers_use_limits]', array(
                    'value' => $this->editMap && isset($this->map['params']['frontend_add_markers_use_limits']) ? $this->map['params']['frontend_add_markers_use_limits'] : false,
                    'attrs' => 'class="umsProOpt" id="map_opts_frontend_add_markers_use_limits"'
                ))?>
                <label for="map_opts_frontend_add_markers_use_limits"><?php esc_html_e('Use limits for marker\'s adding', UMS_LANG_CODE); ?></label>
            </div>
            <div id="umsUseLimitsForMarkerAddingOptions" style="display: none; margin-top: 10px;">
                <div class="sup-col sup-w-50">
                    <label for="map_opts_frontend_add_markers_use_count_limits">
                        <?php esc_html_e('Max marker\'s count', UMS_LANG_CODE); ?>
                    </label>
                    <?php echo htmlUms::text('map_opts[frontend_add_markers_use_count_limits]', array(
                        'value' => $this->editMap && isset($this->map['params']['frontend_add_markers_use_count_limits']) ? $this->map['params']['frontend_add_markers_use_count_limits'] : '10',
                        'attrs' => 'style="width: 100%;" id="map_opts_frontend_add_markers_use_count_limits"'))?>
                </div>
                <div class="sup-col sup-w-50">
                    <label for="map_opts_frontend_add_markers_use_time_limits">
                        <?php esc_html_e('For allotted time (minutes)', UMS_LANG_CODE); ?>
                    </label>
                    <?php echo htmlUms::text('map_opts[frontend_add_markers_use_time_limits]', array(
                        'value' => $this->editMap && isset($this->map['params']['frontend_add_markers_use_time_limits']) ? $this->map['params']['frontend_add_markers_use_time_limits'] : '10',
                        'attrs' => 'style="width: 100%;" id="map_opts_frontend_add_markers_use_time_limits"'))?>
                </div>
            </div>
        </div>
    </td>
</tr>
<tr>
    <th scope="row">
        <label class="label-big">
            <?php echo esc_html__('Info Window', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php echo esc_attr__('Parameters of markers / shapes info-window PopUp', UMS_LANG_CODE); ?>"></i>
    </th>
    <td></td>
</tr>
<tr>
    <th scope="row">
        <label for="map_opts_marker_infownd_width">
            <?php echo esc_html__('Width', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php echo esc_attr__('Width of info window', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
    <?php
        $markersInfoWndWidthUnits = isset($this->map['params']['marker_infownd_width_units']) && $this->map['params']['marker_infownd_width_units'];
        $markersInfoWndWidthInput = isset($this->map['params']['marker_infownd_width']) && $this->map['params']['marker_infownd_width'];
        $markersInfoWndWidthInputViewStyle = $this->editMap && $markersInfoWndWidthUnits && htmlUms::checkedOpt($this->map['params'], 'marker_infownd_width_units', 'px') ? 'block' : 'none';
        $markersInfoWndWidthUnitsLabelStyle = $this->editMap && $markersInfoWndWidthUnits && htmlUms::checkedOpt($this->map['params'], 'marker_infownd_width_units', 'px') ? '7px' : '0px';
    ?>
        <div class="sup-col" style="padding-right: 0px;">
            <label for="map_opts_marker_infownd_width_units" style="margin-right: 15px; position: relative; top: <?php echo esc_attr($markersInfoWndWidthUnitsLabelStyle); ?>;">
                <?php echo htmlUms::radiobutton('map_opts[marker_infownd_width_units]', array(
                    'value' => 'auto',
                    'checked' => $this->editMap && $markersInfoWndWidthUnits ? htmlUms::checkedOpt($this->map['params'], 'marker_infownd_width_units', 'auto') : true,
                )); ?>&nbsp;<?php echo esc_html__('Auto', UMS_LANG_CODE); ?>
            </label>
            <label
                for="map_opts_marker_infownd_width_units"
                class="supsystic-tooltip"
                title="<?php echo esc_attr__('The value defines maximum width of the description. Window will be drawn according to content size but not wider than the value.', UMS_LANG_CODE); ?>"
                style="margin-right: 15px; position: relative; top: <?php echo esc_attr($markersInfoWndWidthUnitsLabelStyle); ?>"
            >
                <?php echo htmlUms::radiobutton('map_opts[marker_infownd_width_units]', array(
                    'value' => 'px',
                    'checked' => $this->editMap && $markersInfoWndWidthUnits ? htmlUms::checkedOpt($this->map['params'], 'marker_infownd_width_units', 'px') : false,
                )); ?>&nbsp;<?php echo esc_html__('Px', UMS_LANG_CODE); ?>
            </label>
        </div>
        <div class="sup-col sup-w-25">
            <?php echo htmlUms::text('map_opts[marker_infownd_width]', array(
                'value' => $this->editMap && $markersInfoWndWidthInput ? esc_attr($this->map['params']['marker_infownd_width']) : '200',
                'attrs' => 'style="width: 100%; display: '. esc_attr($markersInfoWndWidthInputViewStyle) .';"'
            )); ?>
        </div>
    </td>
</tr>
<tr>
    <th scope="row">
        <label for="map_opts_marker_infownd_height">
            <?php echo esc_html__('Height', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php echo esc_attr__('Height of info window', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <?php
        $markersInfoWndHeightUnits = isset($this->map['params']['marker_infownd_height_units']) && $this->map['params']['marker_infownd_height_units'];
        $markersInfoWndHeightInput = isset($this->map['params']['marker_infownd_height']) && $this->map['params']['marker_infownd_height'];
        $markersInfoWndHeightInputViewStyle = $this->editMap && $markersInfoWndHeightUnits && htmlUms::checkedOpt($this->map['params'], 'marker_infownd_height_units', 'px') ? 'block' : 'none';
        $markersInfoWndHeightUnitsLabelStyle = $this->editMap && $markersInfoWndHeightUnits && htmlUms::checkedOpt($this->map['params'], 'marker_infownd_height_units', 'px') ? '7px' : '0px';
        ?>
        <div class="sup-col" style="padding-right: 0px;">
            <label for="map_opts_marker_infownd_height_units" style="margin-right: 15px; position: relative; top: <?php echo esc_attr($markersInfoWndHeightUnitsLabelStyle); ?>;">
                <?php echo htmlUms::radiobutton('map_opts[marker_infownd_height_units]', array(
                    'value' => 'auto',
                    'checked' => $this->editMap && $markersInfoWndHeightUnits ? htmlUms::checkedOpt($this->map['params'], 'marker_infownd_height_units', 'auto') : true,
                )); ?>&nbsp;<?php echo esc_html__('Auto', UMS_LANG_CODE); ?>
            </label>
            <label
                for="map_opts_marker_infownd_height_units"
                class="supsystic-tooltip"
                title="<?php echo esc_attr__('Pixels', UMS_LANG_CODE); ?>"
                style="margin-right: 15px; position: relative; top: <?php echo esc_attr($markersInfoWndHeightUnitsLabelStyle); ?>"
                >
                <?php echo htmlUms::radiobutton('map_opts[marker_infownd_height_units]', array(
                    'value' => 'px',
                    'checked' => $this->editMap && $markersInfoWndHeightUnits ? htmlUms::checkedOpt($this->map['params'], 'marker_infownd_height_units', 'px') : false,
                )); ?>&nbsp;<?php echo esc_html__('Px', UMS_LANG_CODE); ?>
            </label>
        </div>
        <div class="sup-col sup-w-25">
            <?php echo htmlUms::text('map_opts[marker_infownd_height]', array(
                'value' => $this->editMap && $markersInfoWndHeightInput ? esc_attr($this->map['params']['marker_infownd_height']) : '100',
                'attrs' => 'style="width: 100%; display: '. esc_attr($markersInfoWndHeightInputViewStyle) .';"'
            )); ?>
        </div>
    </td>
</tr>
<tr>
    <th scope="row">
        <label for="map_opts_marker_title_color">
            <?php echo esc_html__('Title Color', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php echo esc_attr__('You can set your info window title color here', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <?php echo htmlUms::colorpicker('map_opts[marker_title_color]', array(
            'value' => $this->editMap && isset($this->map['params']['marker_title_color']) ? esc_attr($this->map['params']['marker_title_color']) : '#000000'
        )); ?>
    </td>
</tr>
<tr>
    <th scope="row">
        <label for="map_opts_marker_infownd_bg_color">
            <?php echo esc_html__('Background Color', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php echo esc_attr__('You can set your info window background color here', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <?php echo htmlUms::colorpicker('map_opts[marker_infownd_bg_color]', array(
            'value' => $this->editMap && isset($this->map['params']['marker_infownd_bg_color']) ? esc_attr($this->map['params']['marker_infownd_bg_color']) : '#FFFFFF'
        )); ?>
    </td>
</tr>
<tr>
    <th scope="row">
        <label for="map_opts_marker_title_size">
            <?php echo esc_html__('Title Font Size', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php echo esc_attr__('You can set your info window title font size here', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <div class="sup-col sup-w-25">
            <?php echo htmlUms::text('map_opts[marker_title_size]', array(
                'value' => $this->editMap && isset($this->map['params']['marker_title_size']) ? esc_attr($this->map['params']['marker_title_size']) : '19',
                'attrs' => 'style="width: 100%;" id="map_opts_marker_title_size"'
            )); ?>
        </div>
        <div class="sup-col sup-w-75">
            <label class="supsystic-tooltip" title="<?php echo esc_attr__('Pixels', UMS_LANG_CODE); ?>" style="margin-right: 15px; position: relative; top: 7px;">
                <?php echo htmlUms::radiobutton('map_opts[marker_title_size_units]', array(
                    'value' => 'px',
                    'checked' => true,
                )); ?>&nbsp;<?php echo esc_html__('Px', UMS_LANG_CODE); ?></label>
        </div>
    </td>
</tr>
<tr>
    <th scope="row">
        <label for="map_opts_marker_desc_size">
            <?php esc_html_e('Description Font Size', UMS_LANG_CODE); ?>:
        </label>
        <i style="float: right;" class="fa fa-question supsystic-tooltip" title="<?php esc_attr_e('You can set your info window description font size here', UMS_LANG_CODE); ?>"></i>
    </th>
    <td>
        <div class="sup-col sup-w-25">
            <?php echo htmlUms::text('map_opts[marker_desc_size]', array(
                'value' => $this->editMap && isset($this->map['params']['marker_desc_size']) ? esc_attr($this->map['params']['marker_desc_size']) : '13',
                'attrs' => 'style="width: 100%;" id="map_opts_marker_desc_size"'
            )); ?>
        </div>
        <div class="sup-col sup-w-75">
            <label class="supsystic-tooltip" title="<?php esc_attr_e('Pixels', UMS_LANG_CODE); ?>" style="margin-right: 15px; position: relative; top: 7px;">
                <?php echo htmlUms::radiobutton('map_opts[marker_desc_size_units]', array(
                    'value' => 'px',
                    'checked' => true,
                )); ?>&nbsp;<?php esc_html_e('Px', UMS_LANG_CODE); ?></label>
        </div>
    </td>
</tr>
</table>
</div>
<?php if(isset($this->engineFromReq) && !empty($this->engineFromReq)) {
    echo htmlUms::hidden('map_opts[engine_from_req]', array('value' => $this->engineFromReq));
} ?>
<?php echo htmlUms::hidden('mod', array('value' => 'maps'))?>
<?php echo htmlUms::hidden('action', array('value' => 'save'))?>
<?php echo htmlUms::defaultNonceForAdminPanel(); ?>
<?php echo htmlUms::hidden('map_opts[id]', array('value' => $this->editMap ? esc_attr($this->map['id']) : ''))?>
<?php echo htmlUms::hidden('map_opts[membershipEnable]', array('value' => isset($this->map['params']['membershipEnable']) ? esc_attr($this->map['params']['membershipEnable']) : 0, 'attrs' => 'id="membershipHiddenEnable"'))?>
</form>
<!--Map Markers List Wnd-->
<div id="umsMarkersListWnd" style="display: none;" title="<?php esc_attr_e('Show markers list with your map on frontend', UMS_LANG_CODE)?>">
<!--Mml == Map Markers List-->
<ul id="umsMml">
    <?php foreach($this->markerLists as $lKey => $lData) { ?>
    <li class="umsMmlElement umsMmlElement-<?php echo esc_attr($lKey); ?>" data-key="<?php echo esc_attr($lKey); ?>">
        <img src="<?php echo esc_url($this->promoModPath); ?>img/markers_list/<?php echo esc_attr($lData['prev_img']); ?>" /><br />
        <div class="umsMmlElementBtnShell">
            <a href="<?php echo esc_url(frameUms::_()->getModule('supsystic_promo')->generateMainLink('utm_source=plugin&utm_medium=marker_list_' . $lKey . '&utm_campaign=ultimatemaps')); ?>" target="_blank" class="button button-primary umsMmlApplyBtn" data-apply-label="<?php esc_html_e('Apply', UMS_LANG_CODE); ?>" data-active-label="<?php esc_html_e('Selected', UMS_LANG_CODE); ?>">
                <?php echo $this->isPro ? esc_html__('Apply', UMS_LANG_CODE) : esc_html__('Available in PRO', UMS_LANG_CODE); ?>
            </a>
        </div>
    </li>
    <?php }?>
</ul>
</div>
<!--Icons Wnd-->
<div id="umsIconsWnd" style="display: none;">
<ul class="iconsList">
    <?php foreach($this->icons as $icon) { ?>
        <li class="previewIcon"
            data-id="<?php echo esc_attr($icon['id']); ?>"
            data-width="<?php echo esc_attr($icon['width']); ?>"
            data-height="<?php echo esc_attr($icon['height']); ?>"
            title="<?php echo esc_attr($icon['title']); ?>">
            <img src="<?php echo esc_url($icon['path']); ?>" >
            <?php if(!(int)$icon['is_def']) { ?>
                <i class="fa fa-times" aria-hidden="true"></i>
            <?php } ?>
        </li>
    <?php }?>
</ul>
</div>
