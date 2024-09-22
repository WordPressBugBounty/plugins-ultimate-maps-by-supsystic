<?php
// TODO: Make this as it should be - in a class or a normal way, not like this
$promoData = esc_html(frameUms::_()->getModule('supsystic_promo')->addPromoMapTabs());
?>

<?php if (esc_html($this->isPro)) : ?>
    <form id="<?php echo esc_attr('umsHeatmapForm'); ?>">
        <table class="<?php echo esc_attr('form-table'); ?>">
            <tr>
                <th scope="row">
                    <label class="<?php echo esc_attr('label-big'); ?>">
                        <?php esc_html_e('Points', UMS_LANG_CODE); ?>:
                    </label>
                    <i style="float: right;" class="<?php echo esc_attr('fa fa-question supsystic-tooltip'); ?>" title="<?php esc_attr_e('To add Heatmap Layer points you need to activate Add Points button and draw each point by click on map. To remove points you need to activate Remove Points button and delete necessary point by click on it or just click on Delete Heatmap Layer button to remove all Heatmap Layer points. Important! You must to deactivate Add by Click and Remove by Click buttons after ending of the add / remove points.', UMS_LANG_CODE); ?>"></i>
                </th>
                <td>
                    <div class="<?php echo esc_attr('umsHeatmapPointsBtns'); ?>">
                        <a href="#" class="<?php echo esc_attr('button'); ?>" id="<?php echo esc_attr('umsHeatmapAddPointBtn'); ?>">
                            <?php esc_html_e('Add Point', UMS_LANG_CODE); ?>
                        </a>
                        <a href="#" class="<?php echo esc_attr('button'); ?>" id="<?php echo esc_attr('umsHeatmapRemovePointBtn'); ?>">
                            <?php esc_html_e('Remove Point', UMS_LANG_CODE); ?>
                        </a>
                    </div>
                    <div class="<?php echo esc_attr('umsHeatmapPointsCount'); ?>">
                        <label>
                            <?php esc_html_e('Points Count', UMS_LANG_CODE); ?>:
                        </label>
                        <div id="<?php echo esc_attr('umsHeatmapPointsNumber'); ?>"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label>
                        <?php esc_html_e('Radius', UMS_LANG_CODE); ?>:
                    </label>
                    <i style="float: right;" class="<?php echo esc_attr('fa fa-question supsystic-tooltip'); ?>" title="<?php esc_attr_e('Heatmap Layer points radius in pixels', UMS_LANG_CODE); ?>"></i>
                </th>
                <td>
                    <?php echo esc_html(htmlUms::text('heatmap_opts[params][radius]', array(
                        'value' => '',
                        'attrs' => 'style="width: 100%;"'))); ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label>
                        <?php esc_html_e('Opacity', UMS_LANG_CODE); ?>:
                    </label>
                    <i style="float: right;" class="<?php echo esc_attr('fa fa-question supsystic-tooltip'); ?>" title="<?php esc_attr_e('Heatmap Layer points opacity', UMS_LANG_CODE); ?>"></i>
                </th>
                <td>
                    <?php echo esc_html(htmlUms::selectbox('heatmap_opts[params][opacity]', array(
                        'options' => array(
                            '0' => 0, '0.1' => 0.1, '0.2' => 0.2, '0.3' => 0.3,
                            '0.4' => 0.4, '0.5' => 0.5, '0.6' => 0.6,
                            '0.7' => 0.7, '0.8' => 0.8, '0.9' => 0.9, '1' => 1),
                        'value' => '',
                        'attrs' => 'style="width: 100%;"'))); ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label>
                        <?php esc_html_e('Gradient', UMS_LANG_CODE); ?>:
                    </label>
                    <i style="float: right;" class="<?php echo esc_attr('fa fa-question supsystic-tooltip'); ?>" title="<?php esc_attr_e('Heatmap Layer points color gradient.', UMS_LANG_CODE); ?>"></i>
                </th>
                <td>
                    <a href="#" class="<?php echo esc_attr('button'); ?>" id="<?php echo esc_attr('umsHeatmapAddColorBtn'); ?>">
                        <?php esc_html_e('Add Color', UMS_LANG_CODE); ?>
                    </a>
                    <a href="#" class="<?php echo esc_attr('button'); ?>" id="<?php echo esc_attr('umsHeatmapClearColorsBtn'); ?>" style="float: right;">
                        <?php esc_html_e('Clear', UMS_LANG_CODE); ?>
                    </a>
                    <div class="<?php echo esc_attr('umsHeatmapGradientExample umsHeatmapGradient'); ?>" style="display: none; margin-top: 10px;">
                        <input type="text" name="<?php echo esc_attr('heatmap_opts[params][gradient][]'); ?>" value="<?php echo esc_attr('#5ED836'); ?>" disabled="disabled" />
                        <a href="#" class="<?php echo esc_attr('button umsHeatmapRemoveColorBtn'); ?>" title="<?php esc_attr_e('Remove Color', UMS_LANG_CODE); ?>" onclick="umsHeatmapRemoveColorBtnClick(this); return false;">
                            <i class="<?php echo esc_attr('fa fa-trash-o'); ?>"></i>
                        </a>
                    </div>
                    <div id="<?php echo esc_attr('umsHeatmapGradientFirstColorContainer'); ?>">

                    </div>
                    <?php echo esc_html(htmlUms::hidden('heatmap_opts[params][gradient][]', array('value' => '', 'attrs' => 'class="firstHeatmapColor"'))); ?>
                    <div id="<?php echo esc_attr('umsHeatmapGradientContainer'); ?>"></div>
                </td>
            </tr>
            <!-- Additional form fields ... -->
        </table>
        <?php echo esc_html(htmlUms::hidden('mod', array('value' => 'heatmap'))); ?>
        <?php echo esc_html(htmlUms::hidden('action', array('value' => 'save'))); ?>
        <?php echo htmlUms::defaultNonceForAdminPanel(); ?>
        <?php echo esc_html(htmlUms::hidden('heatmap_opts[id]', array('value' => ''))); ?>
        <?php echo esc_html(htmlUms::hidden('heatmap_opts[map_id]', array('value' => esc_attr($this->editMap ? $this->map['id'] : '')))); ?>
    </form>
<?php else :
    echo esc_html($promoData['umsHeatmapTab']['content']);
endif;
?>