<section class="ums-form-page ums-csv-page">
    <div class="ums-page-head">
        <div class="ums-page-title">
            <span class="ums-page-icon"><i class="fa fa-exchange" aria-hidden="true"></i></span>
            <div>
                <h2><?php esc_html_e('Import / Export', UMS_LANG_CODE); ?></h2>
                <p><?php esc_html_e('Move your maps and markers between sites with CSV files, or keep a copy of them.', UMS_LANG_CODE); ?></p>
            </div>
        </div>
    </div>
    <div class="supsystic-item supsystic-panel ums-cards">
        <div id="containerWrapper" class="ums-card ums-csv-card">
            <div class="ums-card-head">
                <span class="ums-card-icon"><i class="fa fa-database" aria-hidden="true"></i></span>
                <div>
                    <h3><?php esc_html_e('Maps and markers', UMS_LANG_CODE); ?></h3>
                    <p><?php esc_html_e('Export saves a CSV file; Import adds the maps or markers of a CSV file to this site.', UMS_LANG_CODE); ?></p>
                </div>
            </div>
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
                        <?php echo htmlUms::ajaxfile('csv_import_file_maps', [
                          'url' => uriUms::_([
                            'baseUrl' => admin_url('admin-ajax.php'),
                            'page' => 'csv',
                            'action' => 'import',
                            '_wpnonce' => wp_create_nonce('ums_nonce'),
                            'type' => 'maps',
                            'reqType' => 'ajax',
                          ]),
                          'data' => 'umsCsvImportData',
                          'buttonName' => esc_html__('Import', UMS_LANG_CODE),
                          'responseType' => 'json',
                          'onSubmit' => 'umsCsvImportOnSubmit',
                          'onComplete' => 'umsCsvImportOnComplete',
                          'btn_class' => 'button',
                        ]); ?>
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
                        <?php echo htmlUms::ajaxfile('csv_import_file_markers', [
                          'url' => uriUms::_([
                            'baseUrl' => admin_url('admin-ajax.php'),
                            'page' => 'csv',
                            'action' => 'import',
                            '_wpnonce' => wp_create_nonce('ums_nonce'),
                            'type' => 'markers',
                            'reqType' => 'ajax',
                          ]),
                          'data' => 'umsCsvImportData',
                          'buttonName' => esc_html__('Import', UMS_LANG_CODE),
                          'responseType' => 'json',
                          'onSubmit' => 'umsCsvImportOnSubmit',
                          'onComplete' => 'umsCsvImportOnComplete',
                          'btn_class' => 'button',
                        ]); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><div id="umsCsvImportMsg"></div></td>
                </tr>
            </table>
        </div>
        <div class="ums-card ums-csv-card">
            <div class="ums-card-head">
                <span class="ums-card-icon"><i class="fa fa-sliders" aria-hidden="true"></i></span>
                <div>
                    <h3><?php esc_html_e('CSV Options', UMS_LANG_CODE); ?></h3>
                    <p><?php esc_html_e('The character between the columns of the files, for export and import.', UMS_LANG_CODE); ?></p>
                </div>
            </div>
            <form id="umsCsvForm">
                <table class="form-table no-border">
                    <tr>
                        <th scope="row">
                            <label for="umsCsvExportDelimiter">
                                <?php esc_html_e('Delimiter', UMS_LANG_CODE); ?>
                            </label>
                        </th>
                        <td>
                            <?php echo htmlUms::selectbox('opt_values[csv_options][delimiter]', [
                              'options' => $this->delimiters,
                              'value' => !empty($this->options['delimiter']) ? esc_attr($this->options['delimiter']) : ';',
                              'attrs' => 'style="min-width: 150px;" id="umsCsvExportDelimiter"',
                            ]); ?>
                        </td>
                    </tr>
                </table>
                <?php echo htmlUms::defaultNonceForAdminPanel(); ?>
                <?php echo htmlUms::hidden('page', ['value' => 'csv']); ?>
                <?php echo htmlUms::hidden('action', ['value' => 'saveCsvOptions']); ?>
            </form>
            <p class="ums-card-actions">
                <button id="umsCsvSaveBtn" class="button button-primary">
                    <i class="fa fa-save"></i>
                    <?php esc_html_e('Save', UMS_LANG_CODE); ?>
                </button>
            </p>
        </div>
    </div>
</section>