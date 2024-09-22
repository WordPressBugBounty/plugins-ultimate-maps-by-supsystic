<section>
	<div class="supsystic-item supsystic-panel">
		<div id="containerWrapper">
			<div id="umsMgrTab" class="mgrTabContent">
				<a
					href="<?php echo esc_attr($this->addNewLink); ?>"
					class="button button-table-action"
					id="addMarkerGroup"
					style="display: <?php echo $this->editMarkerGroup ? 'inline-block;' : 'none;'; ?>"
				>
					<?php _e('Add Category', UMS_LANG_CODE); ?>
				</a>
				<button class="button" id="umsMgrSaveBtn">
					<i class="fa fa-save"></i>
					<?php _e('Save', UMS_LANG_CODE); ?>
				</button>
				<form id="umsMgrForm">
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="marker_group_title">
									<?php _e('Category Title', UMS_LANG_CODE); ?>:
								</label>
							</th>
							<td>
								<?php echo htmlUms::text('marker_group[title]', array(
									'value' => $this->editMarkerGroup ? esc_attr($this->marker_group['title']) : '',
									'attrs' => 'style="width: 50%;" id="marker_group_title"',
									'required' => true)); ?>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="marker_group_parent">
									<?php _e('Parent Category', UMS_LANG_CODE); ?>:
								</label>
							</th>
							<td>
								<?php echo htmlUms::selectbox('marker_group[parent]', array(
									'options' => $this->parentsList,
									'value' => $this->editMarkerGroup ? esc_attr($this->marker_group['parent']) : 0,
									'attrs' => 'style="width: 50%;" id="marker_group_parent"',
								)); ?>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="marker_group_bg_color">
									<?php _e('Background Color', UMS_LANG_CODE); ?>:
								</label>
							</th>
							<td>
								<?php echo htmlUms::colorpicker('marker_group[bg_color]', array(
									'value' => $this->editMarkerGroup && $this->marker_group['params']['bg_color'] ? esc_attr($this->marker_group['params']['bg_color']) : '#E4E4E4')); ?>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="marker_group_text_color">
									<?php _e('Text Color', UMS_LANG_CODE); ?>:
								</label>
							</th>
							<td>
								<?php echo htmlUms::colorpicker('marker_group[text_color]', array(
									'value' => $this->editMarkerGroup && $this->marker_group['params']['text_color'] ? esc_attr($this->marker_group['params']['text_color']) : '#E4E4E4')); ?>
							</td>
						</tr>
					</table>
					<?php echo htmlUms::hidden('mod', array('value' => 'marker_groups')) ?>
					<?php echo htmlUms::defaultNonceForAdminPanel(); ?>
					<?php echo htmlUms::hidden('action', array('value' => 'save')) ?>
					<?php echo htmlUms::hidden('marker_group[id]', array('value' => $this->editMarkerGroup ? esc_attr($this->marker_group['id']) : '')) ?>
				</form>
			</div>
		</div>
	</div>
</section>