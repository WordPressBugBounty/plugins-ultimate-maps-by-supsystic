<?php if (!empty($this->maps)) : foreach ($this->maps as $map) :
  $id = (int) $map['id'];
  $editUrl = $this->getModule()->getEditMapLink($id);
  $shortcode = '[' . UMS_SHORTCODE . ' id="' . $id . '"]';
  $phpCode = '<?php echo do_shortcode(\'' . $shortcode . '\'); ?>';
  $markerCount = (int) $map['marker_count'];
  $markerTitles = !empty($map['marker_preview']) ? implode(', ', $map['marker_preview']) : '';
?>
<tr id="ums-map-<?php echo $id; ?>">
  <td class="ums-col-check"><input type="checkbox" id="ums-check-<?php echo $id; ?>" class="ums-row-checkbox ums-native-check" aria-label="<?php echo esc_attr(sprintf(__('Select map: %s', UMS_LANG_CODE), $map['title'])); ?>"></td>
  <td class="ums-col-id"><?php echo $id; ?></td>
  <td class="ums-col-title"><a href="<?php echo esc_url($editUrl); ?>" title="<?php echo esc_attr(sprintf(__('Edit map: %s', UMS_LANG_CODE), $map['title'])); ?>"><?php echo esc_html($map['title']); ?></a></td>
  <td class="ums-col-markers"><span class="ums-marker-count"><?php echo $markerCount; ?></span><?php if ($markerTitles !== '') : ?><span class="ums-marker-preview" title="<?php echo esc_attr($markerTitles); ?>"><?php echo esc_html($markerTitles); ?></span><?php endif; ?></td>
  <td class="ums-col-created"><?php echo esc_html($map['created_label'] ?: '—'); ?></td>
  <td class="ums-col-code"><input type="text" readonly class="ums-copy-code" value="<?php echo esc_attr($shortcode); ?>" aria-label="<?php esc_attr_e('Shortcode', UMS_LANG_CODE); ?>"></td>
  <td class="ums-col-code"><input type="text" readonly class="ums-copy-code" value="<?php echo esc_attr($phpCode); ?>" aria-label="<?php esc_attr_e('PHP code', UMS_LANG_CODE); ?>"></td>
  <td class="ums-col-actions">
    <a class="button ums-row-action" href="<?php echo esc_url($editUrl); ?>"><i class="fa fa-pencil" aria-hidden="true"></i> <?php esc_html_e('Edit', UMS_LANG_CODE); ?></a>
    <button type="button" class="button ums-row-action ums-clone-map" id="ums-clone-<?php echo $id; ?>" title="<?php esc_attr_e('Clone', UMS_LANG_CODE); ?>" aria-label="<?php echo esc_attr(sprintf(__('Clone map: %s', UMS_LANG_CODE), $map['title'])); ?>"><i class="fa fa-clone" aria-hidden="true"></i></button>
    <button type="button" class="button ums-row-action ums-delete-map" id="ums-delete-<?php echo $id; ?>" title="<?php esc_attr_e('Delete', UMS_LANG_CODE); ?>" aria-label="<?php echo esc_attr(sprintf(__('Delete map: %s', UMS_LANG_CODE), $map['title'])); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
  </td>
</tr>
<?php endforeach; else : ?>
<tr class="ums-empty-row"><td colspan="8"><i class="fa fa-map-marker" aria-hidden="true"></i><strong><?php esc_html_e('No maps found', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Try another search or create a new map.', UMS_LANG_CODE); ?></span></td></tr>
<?php endif; ?>
