<section>
	<div class="supsystic-item supsystic-panel">
		<div id="containerWrapper">
			<div style="position: relative;">
				<div class="sup-col sup-w-50">
					<?php echo htmlUms::selectbox('shortcode_example', array(
						'attrs' => 'id="umsCopyTextCodeExamples" class="umsBigSelect"',
						'options' => array(
							'shortcode' => esc_html__('Map shortcode', UMS_LANG_CODE),
							'php_code' => esc_html__('PHP code', UMS_LANG_CODE),
						),
					))?>
					<?php echo htmlUms::text('umsCopyTextCode', array(
						'value' => esc_html__('Shortcode will appear after you save map.', UMS_LANG_CODE),
						'attrs' => 'class="umsMapShortCodeShell umsStaticWidth" style="width: 64%; height: 31px; float: right; margin: 0; text-align: center;"',
						'readonly' => true,
					))?>
				</div>
				<div class="sup-col sup-w-50">
					<p>
						<label style="font-size: 15px;">
							<?php esc_html_e('Engine', UMS_LANG_CODE)?>
							<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_attr(sprintf(__('Map engine to render. It set on <a href="%s" target="_blank">Settings page</a> for all maps, but you can select separate engines for your maps here. Just make sure that you entered all required credentials (like API Key) for your engine on Settings page, and after you will select new engine - just re-save and re-load map edit page - to make sure all changes applied.', UMS_LANG_CODE), esc_url(frameUms::_()->getModule('options')->getTabUrl('settings'))))?>"></i>
							<?php echo htmlUms::selectbox('engine', array(
								'options' => $this->enginesForSelect,
								'attrs' => 'id="umsEngineSel" class="umsBigSelect"',
								'value' => $this->editMap && !empty($this->map['engine']) 
									? esc_attr($this->map['engine'])
									: esc_attr($this->defEngine),
							))?>
						</label>
					</p>
				</div>
			</div>
			<div style="clear: both;"></div>
			<?php do_action('ums_lang_tabs'); ?>
			<div style="clear: both;"></div>
			<div id="umsMapPropertiesTabs" style="display: none;">
				<h3 class="nav-tab-wrapper" style="margin-bottom: 12px;">
					<?php foreach($this->tabs as $tId => $t) { ?>
						<a class="nav-tab <?php echo $tId == 'umsMapTab' ? 'nav-tab-active' : ''; ?>" href="#<?php echo $tId; ?>">
							<p>
								<i class="fa <?php echo esc_attr($t['icon'])?>" aria-hidden="true"></i>
								<?php echo esc_html($t['label']); ?>
								<?php if(isset($t['btns'])) { ?>
									<?php foreach($t['btns'] as $btn) { ?>
										<button class="button <?php echo (isset($btn['classes']) ? esc_attr($btn['classes']) : '')?>" id="<?php echo esc_attr($btn['id']);?>">
											<?php echo esc_html($btn['label']); ?>
										</button>
									<?php } ?>
								<?php } ?>
							</p>
						</a>
					<?php } ?>
				</h3>
				<div style="clear: both;"></div>
				<div class="supsistic-half-side-box">
					<?php foreach($this->tabs as $tId => $t) { ?>
						<div id="<?php echo esc_attr($tId); ?>" class="umsTabContent"><?php echo $t['content']; ?></div>
					<?php } ?>
				</div>
				<div class="supsistic-half-side-box" style="position: relative;">
				<div id="umsMapRightStickyBar" class="supsystic-sticky">
					<div id="umsMapPreview" style="width: 100%; height: 350px;"></div>
					<div class="umsMapProControlsCon" id="umsMapProControlsCon_<?php echo esc_attr($this->viewId);?>">
						<?php dispatcherUms::doAction('addAdminMapBottomControls', $this->editMap ? $this->map : array()); ?>
					</div>
					<?php echo htmlUms::hidden('rand_view_id', array('value' => esc_attr($this->viewId), 'attrs' => 'id="umsViewId"'))?>
					<div id="umsMapMainBtns" class="umsControlBtns row" style="display: none;">
						<div class="sup-col sup-w-50">
							<button id="umsMapSaveBtn" class="button button-primary" style="width: 100%;">
								<i class="fa dashicons-before dashicons-admin-site"></i>
								<?php esc_html_e('Save Map', UMS_LANG_CODE)?>
							</button>
						</div>
						<div class="sup-col sup-w-50" style="padding-right: 0;">
							<button id="umsMapDeleteBtn" class="button button-primary" style="width: 100%;">
								<i class="fa dashicons-before dashicons-trash"></i>
								<?php esc_html_e('Delete Map', UMS_LANG_CODE)?>
							</button>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div id="umsMarkerMainBtns" class="umsControlBtns row" style="display: none;">
						<div class="sup-col sup-w-50">
							<button id="umsSaveMarkerBtn" class="button button-primary" style="width: 100%;">
								<i class="fa fa-map-marker"></i>
								<?php esc_html_e('Save Marker', UMS_LANG_CODE)?>
							</button>
						</div>
						<div class="sup-col sup-w-50" style="padding-right: 0;">
							<button id="umsMarkerDeleteBtn" class="button button-primary" style="width: 100%;">
								<i class="fa dashicons-before dashicons-trash"></i>
								<?php esc_html_e('Delete Marker', UMS_LANG_CODE)?>
							</button>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div id="umsShapeMainBtns" class="umsControlBtns row" style="display: none;">
						<div class="sup-col sup-w-50">
							<button id="umsSaveShapeBtn" class="button button-primary" style="width: 100%;">
								<i class="fa fa-cubes"></i>
								<?php esc_html_e('Save Shape', UMS_LANG_CODE)?>
							</button>
						</div>
						<div class="sup-col sup-w-50" style="padding-right: 0;">
							<button id="umsShapeDeleteBtn" class="button button-primary" style="width: 100%;">
								<i class="fa dashicons-before dashicons-trash"></i>
								<?php esc_html_e('Delete Shape', UMS_LANG_CODE)?>
							</button>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div id="umsHeatmapMainBtns" class="umsControlBtns row" style="display: none;">
						<div class="sup-col sup-w-50">
							<button id="umsSaveHeatmapBtn" class="button button-primary" style="width: 100%;">
								<i class="fa fa-map"></i>
								<?php esc_html_e('Save Heatmap Layer', UMS_LANG_CODE)?>
							</button>
						</div>
						<div class="sup-col sup-w-50" style="padding-right: 0;">
							<button id="umsHeatmapDeleteBtn" class="button button-primary" style="width: 100%;">
								<i class="fa dashicons-before dashicons-trash"></i>
								<?php esc_html_e('Delete Heatmap Layer', UMS_LANG_CODE)?>
							</button>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div id="umsMarkerList">
						<input id="umsMarkersSearchInput" type="text" placeholder="<?php esc_attr_e('Search by name', UMS_LANG_CODE)?>" style="display: none; width: 100%; margin: 0;" >
						<table id="umsMarkersListGrid" class="supsystic-tbl-pagination-shell"></table>
					</div>
					<div id="umsShapeList">
						<table id="umsShapesListGrid" class="supsystic-tbl-pagination-shell"></table>
					</div>
				</div>
			</div>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</section>
<div id="umsEngineChangeWnd" style="display: none;" title="<?php esc_attr_e('Change Engine', UMS_LANG_CODE)?>">
	<p><?php esc_html_e('You will now change engine for your Map. Be adviced that this action will make your map look different: each map engine have it\'s own renderer and it\'s own features.', UMS_LANG_CODE)?></p>
	<div id="umsEngineChangeMsg"></div>
</div>