<?php
$promoLink = esc_url($this->promoLink . '?utm_source=plugin&utm_campaign=ultimatemaps&utm_medium=' . $this->tabCode);
?>
<a target="_blank" class="button button-primary" href="<?php echo $promoLink; ?>">
    <?php esc_html_e('Get it now!'); ?>
</a>
<a target="_blank" href="<?php echo $promoLink; ?>">
    <img src="<?php echo esc_url($this->getModule()->getModPath() . 'img/' . $this->tabCode . '.jpg'); ?>" />
</a>
