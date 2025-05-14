<div class="supsystic-actions-wrap">
    <a class="button button-table-action" id="editMap<?php echo esc_attr($this->map['id']); ?>" href="<?php echo esc_url($this->editLink); ?>">
        <i class="fa fa-fw fa-pencil"></i>
    </a>
    <a class="button button-table-action" id="deleteMap<?php echo esc_attr($this->map['id']); ?>" href="#" onclick="umsRemoveMapFromTblClick(<?php echo esc_attr($this->map['id']); ?>);">
        <i class="fa fa-fw fa-trash-o"></i>
    </a>
    <div id="umsRemoveElemLoader__<?php echo esc_attr($this->map['id']); ?>" style="display: inline-block;"></div>
</div>
