<div class="mapListMarkers">
    <?php if (isset($this->map['markers']) && !empty($this->map['markers'])) {?>
        <?php $rest = count($this->map['markers']) - 2; ?>
        <?php for ($i = 0; $i <= 1; $i++) { ?>
            <span <?php if (!empty($this->map['markers'][$i]['address'])) { ?>
                class="supsystic-tooltip"
                title="<?php echo esc_attr(htmlspecialchars($this->map['markers'][$i]['address'])); ?>"
                style="cursor: help;"
            <?php } ?>>
                <?php echo esc_html(htmlspecialchars((isset($this->map['markers'][$i]) ? $this->map['markers'][$i]['title'] : ''))); ?>
                <?php if ($i < 1 && count($this->map['markers']) > 1) { ?>,<?php }?>
            </span>
        <?php } ?>
        <?php if ($rest > 0) {?>
            <?php $markers = array();
            array_shift($this->map['markers']);
            array_shift($this->map['markers']);
            foreach ($this->map['markers'] as $marker) {
                $markers[] = esc_html(htmlspecialchars($marker['title']));
            }?>
            <span class="supsystic-tooltip" title="<?php echo esc_attr(implode(', ', $markers)); ?>" style="cursor: help"><?php echo sprintf(__('and %s more', UMS_LANG_CODE), $rest); ?></span>
        <?php } ?>
    <?php } else {?>
        <span>&mdash;</span>
    <?php }?>
</div>