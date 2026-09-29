<?php
$list = $this->list;
?>
<section id="ums-maps-list">
  <div class="supsystic-item supsystic-panel ums-list-panel">
    <div class="ums-table-toolbar">
      <div class="ums-table-toolbar-left">
        <a class="button button-primary ums-toolbar-button" href="<?php echo esc_url($this->addNewLink); ?>">
          <i class="fa fa-plus" aria-hidden="true"></i> <?php esc_html_e('Add New Map', UMS_LANG_CODE); ?>
        </a>
        <button type="button" class="button ums-toolbar-button" id="umsMapsCloneGroupBtn" disabled>
          <i class="fa fa-clone" aria-hidden="true"></i> <?php esc_html_e('Clone selected', UMS_LANG_CODE); ?>
        </button>
        <button type="button" class="button ums-toolbar-button" id="umsMapsRemoveGroupBtn" disabled>
          <i class="fa fa-trash-o" aria-hidden="true"></i> <?php esc_html_e('Delete selected', UMS_LANG_CODE); ?>
        </button>
        <label class="ums-tables-search">
          <span class="screen-reader-text"><?php esc_html_e('Search maps', UMS_LANG_CODE); ?></span>
          <input id="umsMapsTblSearchTxt" type="search" placeholder="<?php esc_attr_e('Search maps by title or ID...', UMS_LANG_CODE); ?>" autocomplete="off">
        </label>
      </div>
      <div class="ums-pagination">
        <span id="ums-pagination-info" class="ums-pagination-info" role="status" aria-live="polite"></span>
        <div class="ums-pagination-controls">
          <button type="button" class="ums-page-btn" id="ums-prev-page" aria-label="<?php esc_attr_e('Previous page', UMS_LANG_CODE); ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
          <span id="ums-page-numbers" class="ums-page-numbers"></span>
          <button type="button" class="ums-page-btn" id="ums-next-page" aria-label="<?php esc_attr_e('Next page', UMS_LANG_CODE); ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
        </div>
        <label class="ums-per-page-label" for="ums-per-page"><?php esc_html_e('Rows', UMS_LANG_CODE); ?>
          <select id="ums-per-page"><option value="10">10</option><option value="20" selected>20</option><option value="50">50</option><option value="100">100</option></select>
        </label>
      </div>
    </div>
    <div class="ums-table-scroll">
      <table id="ums-maps-table" class="ums-maps-table">
        <thead><tr>
          <th scope="col" class="ums-col-check"><input id="ums-select-all" type="checkbox" class="ums-native-check" aria-label="<?php esc_attr_e('Select all maps on this page', UMS_LANG_CODE); ?>"></th>
          <th scope="col" class="ums-col-id ums-sortable" id="ums-sort-id" tabindex="0"><?php esc_html_e('ID', UMS_LANG_CODE); ?><i class="fa fa-sort ums-sort-icon" aria-hidden="true"></i></th>
          <th scope="col" class="ums-col-title ums-sortable" id="ums-sort-title" tabindex="0"><?php esc_html_e('Title', UMS_LANG_CODE); ?><i class="fa fa-sort ums-sort-icon" aria-hidden="true"></i></th>
          <th scope="col" class="ums-col-markers ums-sortable" id="ums-sort-markers" tabindex="0"><?php esc_html_e('Markers', UMS_LANG_CODE); ?><i class="fa fa-sort ums-sort-icon" aria-hidden="true"></i></th>
          <th scope="col" class="ums-col-created ums-sortable" id="ums-sort-create_date" tabindex="0"><?php esc_html_e('Created', UMS_LANG_CODE); ?><i class="fa fa-sort ums-sort-icon" aria-hidden="true"></i></th>
          <th scope="col" class="ums-col-code"><?php esc_html_e('Shortcode', UMS_LANG_CODE); ?></th>
          <th scope="col" class="ums-col-code"><?php esc_html_e('PHP code', UMS_LANG_CODE); ?></th>
          <th scope="col" class="ums-col-actions"><?php esc_html_e('Actions', UMS_LANG_CODE); ?></th>
        </tr></thead>
        <tbody id="ums-maps-tbody"><?php echo $this->getAdminListRows($list['rows']); ?></tbody>
      </table>
    </div>
    <div id="ums-list-status" class="ums-list-status" role="status" aria-live="polite"></div>
  </div>
</section>
