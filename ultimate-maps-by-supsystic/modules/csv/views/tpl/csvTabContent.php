<section>
    <div class="supsystic-item supsystic-panel">
        <div id="containerWrapper">
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label>
                            <?php esc_html_e('Maps', UMS_LANG_CODE); ?>
                        </label>
                    </th>
                    <td>
                        <button id="umsCsvExportMapsBtn" class="button">
                            <?php esc_html_e('Export', UMS_LANG_CODE); ?>
                        </button>
                        <?php echo htmlUms::ajaxfile('csv_import_file_maps', array(
                            'url' => uriUms::_(
                                array(
                                    'baseUrl' => admin_url('admin-ajax.php'),
                                    'page' => 'csv',
                                    'action' => 'import',
                                    '_wpnonce' =>  wp_create_nonce('ums_nonce'),
                                    'type' => 'maps',
                                    'reqType' => 'ajax'
                                )
                            ),
                            'data' => 'umsCsvImportData',
                            'buttonName' => esc_html__('Import', UMS_LANG_CODE),
                            'responseType' => 'json',
                            'onSubmit' => 'umsCsvImportOnSubmit',
                            'onComplete' => 'umsCsvImportOnComplete',
                            'btn_class' => 'button',
                        )) ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="umsCsvExportMarkersBtn">
                            <?php esc_html_e('Markers', UMS_LANG_CODE); ?>
                        </label>
                    </th>
                    <td>
                        <button id="umsCsvExportMarkersBtn" class="button">
                            <?php esc_html_e('Export', UMS_LANG_CODE); ?>
                        </button>
                        <?php echo htmlUms::ajaxfile('csv_import_file_markers', array(
                            'url' => uriUms::_(
                                array(
                                    'baseUrl' => admin_url('admin-ajax.php'),
                                    'page' => 'csv',
                                    'action' => 'import',
                                    '_wpnonce' =>  wp_create_nonce('ums_nonce'),
                                    'type' => 'markers',
                                    'reqType' => 'ajax'
                                )
                            ),
                            'data' => 'umsCsvImportData',
                            'buttonName' => esc_html__('Import', UMS_LANG_CODE),
                            'responseType' => 'json',
                            'onSubmit' => 'umsCsvImportOnSubmit',
                            'onComplete' => 'umsCsvImportOnComplete',
                            'btn_class' => 'button',
                        )) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><div id="umsCsvImportMsg"></div></td>
                </tr>
            </table>
            <h3><?php esc_html_e('CSV Options', UMS_LANG_CODE)?></h3>
            <form id="umsCsvForm">
                <table class="form-table no-border">
                    <tr>
                        <th scope="row">
                            <label for="umsCsvExportDelimiter">
                                <?php esc_html_e('Delimiter', UMS_LANG_CODE); ?>
                            </label>
                        </th>
                        <td>
                            <?php echo htmlUms::selectbox('opt_values[csv_options][delimiter]', array(
                                'options' => $this->delimiters,
                                'value' => !empty($this->options['delimiter']) ? esc_attr($this->options['delimiter']) : ';',
                                'attrs' => 'style="min-width: 150px;" id="umsCsvExportDelimiter"')) ?>
                        </td>
                    </tr>
                </table>
                <?php echo htmlUms::defaultNonceForAdminPanel(); ?>
                <?php echo htmlUms::hidden('page', array('value' => 'csv'))?>
                <?php echo htmlUms::hidden('action', array('value' => 'saveCsvOptions'))?>
            </form>
            <button id="umsCsvSaveBtn" class="button">
                <i class="fa fa-save"></i>
                <?php esc_html_e('Save', UMS_LANG_CODE)?>
            </button>
        </div>
    </div>
</section>