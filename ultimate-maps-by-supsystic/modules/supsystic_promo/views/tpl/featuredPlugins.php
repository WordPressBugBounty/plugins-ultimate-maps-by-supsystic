<section id="supsystic-featured-plugins" class="supsystic-item supsystic-panel">
    <div class="supsysticPageBundleContainer container-fluid">
        <div class="bundle-text supMd7 supXs12"><?php esc_html_e('Get plugins bundle today and save over 80%', UMS_LANG_CODE)?></div>
        <div class="bundle-btn supMd5 supXs12">
            <a href="<?php echo esc_url($this->bundleUrl);?>" class="btn btn-full btn-revert hvr-shutter-out-horizontal" target="_blank">
                <?php esc_html_e('Check It out', UMS_LANG_CODE)?>
            </a>
        </div>
    </div>
    <hr />
    <?php foreach($this->pluginsList as $p) { ?>
        <div class="catitem supMd4 col-sm-6 supXs12">
            <div class="download-product-item">
                <div class="dp-thumb text-center">
                    <a href="<?php echo esc_url($p['url']);?>" target="_blank">
                        <img src="<?php echo esc_url($p['img']);?>" class="img-responsive wp-post-image" alt="<?php echo esc_html($p['label']);?>" />					
                    </a>
                </div>
                <div class="dp-title">
                    <a href="<?php echo esc_url($p['url']);?>" target="_blank">
                        <?php echo esc_html($p['label']);?>
                    </a>
                </div>
                <div class="dp-excerpt">
                    <div class="dp-excerpt-wrapper">
                        <?php echo !empty($p['desc']) ? esc_html($p['desc']) : '';?>
                    </div>
                </div>
                <div class="dp-buttons">
                    <a href="<?php echo esc_url($p['url']);?>" target="_blank" class="btn btn-full hvr-shutter-out-horizontal <?php echo empty($p['download']) ? 'btn-center' : ''?>">
                        <?php esc_html_e('More info', UMS_LANG_CODE)?>
                    </a>
                    <?php if(!empty($p['download'])) {?>
                        <a href="<?php echo esc_url($p['download']);?>" target="_blank" class="btn btn-full btn-info hvr-shutter-out-horizontal">
                            <?php esc_html_e('Download', UMS_LANG_CODE)?>
                        </a>
                    <?php }?>
                </div>
            </div>
        </div>
    <?php }?>
    <div style="clear: both;"></div>
</section>