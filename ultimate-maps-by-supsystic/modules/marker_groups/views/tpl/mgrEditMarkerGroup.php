<section class="ums-form-page ums-mgr-edit-page">
	<div class="ums-page-head">
		<div class="ums-page-title">
			<span class="ums-page-icon"><i class="fa fa-map-pin" aria-hidden="true"></i></span>
			<div>
				<h2><?php echo $this->editMarkerGroup ? esc_html__('Edit Category', UMS_LANG_CODE) : esc_html__('New Category', UMS_LANG_CODE); ?></h2>
				<p><?php esc_html_e('The name and colors of the category, as visitors see them in the filter of the map.', UMS_LANG_CODE); ?></p>
			</div>
		</div>
		<div class="ums-page-actions">
			<a
				href="<?php echo esc_attr($this->addNewLink); ?>"
				class="button button-table-action ums-plain"
				id="addMarkerGroup"
				style="display: <?php echo $this->editMarkerGroup ? 'inline-flex;' : 'none;'; ?>"
			>
				<i class="fa fa-plus" aria-hidden="true"></i>
				<?php _e('Add Category', UMS_LANG_CODE); ?>
			</a>
			<button class="button" id="umsMgrSaveBtn">
				<i class="fa fa-save"></i>
				<?php _e('Save', UMS_LANG_CODE); ?>
			</button>
		</div>
	</div>
	<div class="supsystic-item supsystic-panel ums-card ums-mgr-card">
		<div id="containerWrapper">
			<div id="umsMgrTab" class="mgrTabContent">
				<form id="umsMgrForm">
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="marker_group_title">
									<?php _e('Category Title', UMS_LANG_CODE); ?>:
								</label>
							</th>
							<td>
								<?php echo htmlUms::text('marker_group[title]', [
          'value' => $this->editMarkerGroup ? esc_attr($this->marker_group['title']) : '',
          'attrs' => 'style="width: 50%;" id="marker_group_title"',
          'required' => true,
        ]); ?>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="marker_group_parent">
									<?php _e('Parent Category', UMS_LANG_CODE); ?>:
								</label>
							</th>
							<td>
								<?php echo htmlUms::selectbox('marker_group[parent]', [
          'options' => $this->parentsList,
          'value' => $this->editMarkerGroup ? esc_attr($this->marker_group['parent']) : 0,
          'attrs' => 'style="width: 50%;" id="marker_group_parent"',
        ]); ?>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="marker_group_bg_color">
									<?php _e('Background Color', UMS_LANG_CODE); ?>:
								</label>
							</th>
							<td>
								<?php echo htmlUms::colorpicker('marker_group[bg_color]', [
          'value' => $this->editMarkerGroup && $this->marker_group['params']['bg_color'] ? esc_attr($this->marker_group['params']['bg_color']) : '#E4E4E4',
        ]); ?>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="marker_group_text_color">
									<?php _e('Text Color', UMS_LANG_CODE); ?>:
								</label>
							</th>
							<td>
								<?php echo htmlUms::colorpicker('marker_group[text_color]', [
          'value' => $this->editMarkerGroup && $this->marker_group['params']['text_color'] ? esc_attr($this->marker_group['params']['text_color']) : '#E4E4E4',
        ]); ?>
							</td>
						</tr>
					</table>
					<?php echo htmlUms::hidden('mod', ['value' => 'marker_groups']); ?>
					<?php echo htmlUms::defaultNonceForAdminPanel(); ?>
					<?php echo htmlUms::hidden('action', ['value' => 'save']); ?>
					<?php echo htmlUms::hidden('marker_group[id]', ['value' => $this->editMarkerGroup ? esc_attr($this->marker_group['id']) : '']); ?>
				</form>
			</div>
		</div>
	</div>
</section>