<?php
$promoLink = esc_url($this->promoLink . '?utm_source=plugin&utm_campaign=ultimatemaps&utm_medium=' . $this->tabCode);
$upsellKey = $this->tabCode === 'shapes' ? 'shapes' : $this->tabCode;
?>
<div class="ums-promo-card">
    <div class="ums-promo-card-body">
        <?php if ($this->tabCode === 'shapes') { ?>
            <h3><span class="ums-ed-card-icon"><i class="fa fa-cubes" aria-hidden="true"></i></span><?php esc_html_e('Shapes on your map', UMS_LANG_CODE); ?><em class="ums-ed-pro-tag">PRO</em></h3>
            <p><?php esc_html_e('Draw delivery zones, districts and routes right on the map: polygons, lines and circles in your colors, each with its own popup text.', UMS_LANG_CODE); ?></p>
            <ul>
                <li><?php esc_html_e('Polygons, polylines and circles', UMS_LANG_CODE); ?></li>
                <li><?php esc_html_e('Draw by clicking the map', UMS_LANG_CODE); ?></li>
                <li><?php esc_html_e('Line and fill color and transparency', UMS_LANG_CODE); ?></li>
                <li><?php esc_html_e('A popup with text, photos and links', UMS_LANG_CODE); ?></li>
            </ul>
        <?php } else { ?>
            <h3><span class="ums-ed-card-icon"><i class="fa fa-diamond" aria-hidden="true"></i></span><?php esc_html_e('Available in PRO', UMS_LANG_CODE); ?><em class="ums-ed-pro-tag">PRO</em></h3>
        <?php } ?>
        <div class="ums-promo-card-actions">
            <a class="button" href="<?php echo $promoLink; ?>" target="_blank" rel="noopener" data-ums-upsell="<?php echo esc_attr($upsellKey); ?>"><?php esc_html_e('Read more', UMS_LANG_CODE); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            <a class="button button-primary" href="<?php echo $promoLink; ?>" target="_blank" rel="noopener"><?php esc_html_e('Get PRO', UMS_LANG_CODE); ?></a>
        </div>
    </div>
</div>
