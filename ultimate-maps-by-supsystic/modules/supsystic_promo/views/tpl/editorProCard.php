<?php
/* PRO features of the map editor while PRO is not active: each button opens the window of its feature. */
?>
<section class="ums-up-card" aria-label="<?php echo esc_attr__('Ultimate Maps PRO', UMS_LANG_CODE); ?>">
    <div class="ums-up-card-head">
        <span class="ums-up-card-eyebrow"><i class="fa fa-diamond" aria-hidden="true"></i> Ultimate Maps PRO</span>
        <h3><?php esc_html_e('Do more with this map', UMS_LANG_CODE); ?></h3>
        <p><?php esc_html_e('Your settings stay as they are, and the PRO options open right in these cards.', UMS_LANG_CODE); ?></p>
    </div>
    <div class="ums-up-card-grid">
        <?php foreach ($this->features as $key => $f) { ?>
            <button type="button" data-ums-upsell="<?php echo esc_attr($key); ?>"><i class="fa <?php echo esc_attr($f['icon']); ?>" aria-hidden="true"></i><?php echo esc_html($f['chip']); ?></button>
        <?php } ?>
    </div>
    <div class="ums-up-card-foot">
        <a class="ums-up-card-cta" href="<?php echo esc_url($this->proUrl . '?utm_source=plugin&utm_medium=editor_pro_card&utm_campaign=ultimatemaps'); ?>" target="_blank" rel="noopener"><?php esc_html_e('Get PRO', UMS_LANG_CODE); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
    </div>
</section>
