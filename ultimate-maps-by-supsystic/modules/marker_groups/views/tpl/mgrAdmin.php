<section class="ums-form-page ums-mgr-page">
    <div class="ums-page-head">
        <div class="ums-page-title">
            <span class="ums-page-icon"><i class="fa fa-map-pin" aria-hidden="true"></i></span>
            <div>
                <h2><?php esc_html_e('Marker Categories', UMS_LANG_CODE); ?></h2>
                <p><?php esc_html_e('Group your markers, give each group its colors and let visitors filter the map by them.', UMS_LANG_CODE); ?></p>
            </div>
        </div>
        <div class="ums-page-actions">
            <a class="button button-primary button-table-action" id="addMarkerGroup" href="<?php echo esc_url($this->addNewLink); ?>" title="<?php esc_attr_e('Add Category', UMS_LANG_CODE); ?>">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <?php esc_html_e('Add Category', UMS_LANG_CODE); ?>
            </a>
        </div>
    </div>
    <div class="supsystic-item supsystic-panel ums-card ums-mgr-card">
        <div id="containerWrapper">
            <ul class="supsystic-bar-controls">
                <li title="<?php esc_attr_e('Search', UMS_LANG_CODE); ?>" class="ums-mgr-search">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input id="umsMgrTblSearchTxt" type="text" name="tbl_search" placeholder="<?php esc_attr_e('Search', UMS_LANG_CODE); ?>">
                </li>
                <li title="<?php esc_attr_e('Delete selected', UMS_LANG_CODE); ?>">
                    <button class="button" id="umsMgrRemoveGroupBtn" disabled data-toolbar-button>
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        <?php esc_html_e('Delete Selected', UMS_LANG_CODE); ?>
                    </button>
                </li>
                <li title="<?php esc_attr_e('Clear All', UMS_LANG_CODE); ?>">
                    <button class="button" id="umsMgrClearBtn" data-toolbar-button>
                        <i class="fa fa-eraser" aria-hidden="true"></i>
                        <?php esc_html_e('Clear All', UMS_LANG_CODE); ?>
                    </button>
                </li>
            </ul>
            <div id="umsMgrTblNavShell" class="supsystic-tbl-pagination-shell"></div>
            <div style="clear: both;"></div>
            <div id="umsMgrTbl"></div>
            <div id="umsMgrTblNav"></div>
            <div id="umsMgrTblEmptyMsg" class="ums-empty" style="display: none;">
                <span class="ums-empty-icon"><i class="fa fa-map-pin" aria-hidden="true"></i></span>
                <h3><?php esc_html_e('You have no marker categories yet', UMS_LANG_CODE); ?></h3>
                <p><?php printf(__("<a href='%s'>Create</a> your first category, then pick it for your markers in the map editor.", UMS_LANG_CODE), esc_url($this->addNewLink)); ?></p>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
</section>
