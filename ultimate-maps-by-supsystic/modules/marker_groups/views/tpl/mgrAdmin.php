<section>
    <div class="supsystic-item supsystic-panel">
        <div id="containerWrapper">
            <ul class="supsystic-bar-controls">
                <li title="<?php esc_attr_e('Add Category', UMS_LANG_CODE) ?>">
                    <a class="button button-table-action" id="addMarkerGroup" href="<?php echo esc_url($this->addNewLink) ?>">
                        <?php esc_html_e('Add Category', UMS_LANG_CODE) ?>
                    </a>
                </li>
                <li title="<?php esc_attr_e('Delete selected', UMS_LANG_CODE) ?>">
                    <button class="button" id="umsMgrRemoveGroupBtn" disabled data-toolbar-button>
                        <?php esc_html_e('Delete Selected', UMS_LANG_CODE) ?>
                    </button>
                </li>
                <li title="<?php esc_attr_e('Clear All', UMS_LANG_CODE) ?>">
                    <button class="button" id="umsMgrClearBtn" data-toolbar-button>
                        <?php esc_html_e('Clear All', UMS_LANG_CODE) ?>
                    </button>
                </li>
                <li title="<?php esc_attr_e('Search', UMS_LANG_CODE) ?>">
                    <input id="umsMgrTblSearchTxt" type="text" name="tbl_search" placeholder="<?php esc_attr_e('Search', UMS_LANG_CODE) ?>">
                </li>
            </ul>
            <div id="umsMgrTblNavShell" class="supsystic-tbl-pagination-shell"></div>
            <div style="clear: both;"></div>
            <hr />
            <div id="umsMgrTbl"></div>
            <div id="umsMgrTblNav"></div>
            <div id="umsMgrTblEmptyMsg" style="display: none;">
                <h3><?php printf(__("You have no Marker Categories for now. <a href='%s' style='font-style: italic;'>Create</a> your first Marker Category!", UMS_LANG_CODE), esc_url($this->addNewLink)) ?></h3>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
</section>