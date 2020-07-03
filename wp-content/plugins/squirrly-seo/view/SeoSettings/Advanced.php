<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_settings')) {
            echo '<div class="col-sm-12 alert alert-success text-center m-0 p-3">' . __("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_seosettings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">
                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_advanced', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_advanced"/>

                    <div class="card col-sm-12 p-0">
                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-sm-12 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_settings_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php _e('Advanced Settings', _SQ_PLUGIN_NAME_); ?>:</h3>
                            </div>

                        </div>

                        <div id="sq_seosettings" class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0">
                            <div class="card-body p-0 ">
                                <div class="col-sm-12 m-0 p-0">
                                    <div class="card col-sm-12 p-0 border-0 ">
                                        <div class="col-sm-12 row mb-1 ml-1">
                                            <div class="checker col-sm-12 row my-2 py-1">
                                                <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_load_css" value="0"/>
                                                    <input type="checkbox" id="sq_load_css" name="sq_load_css" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_load_css') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_load_css" class="ml-2"><?php _e('Load Squirrly Frontend CSS', _SQ_PLUGIN_NAME_); ?></label>
                                                    <div class="offset-1 small text-black-50"><?php echo __('Load Squirrly SEO CSS for Twitter and Article inserted from Squirrly Blogging Assistant.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 row mb-1 ml-1">
                                            <div class="checker col-sm-12 row my-2 py-1">
                                                <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_minify" value="0"/>
                                                    <input type="checkbox" id="sq_minify" name="sq_minify" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_minify') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_minify" class="ml-2"><?php _e('Minify Squirrly SEO Metas', _SQ_PLUGIN_NAME_); ?></label>
                                                    <div class="offset-1 small text-black-50"><?php _e('Minify the metas in source code to optimize the page loading.', _SQ_PLUGIN_NAME_); ?></div>
                                                    <div class="offset-1 small text-black-50"><?php _e('Remove comments and newlines from Squirrly SEO Metas.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 row mb-1 ml-1">
                                            <div class="checker col-sm-12 row my-2 py-1">
                                                <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_laterload" value="0"/>
                                                    <input type="checkbox" id="sq_laterload" name="sq_laterload" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_laterload') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_laterload" class="ml-2"><?php _e('Squirrly SEO Late Buffer', _SQ_PLUGIN_NAME_); ?></label>
                                                    <div class="offset-1 small text-black-50"><?php echo __('Wait all plugins to load before loading Squirrly SEO frontend buffer.', _SQ_PLUGIN_NAME_); ?></div>
                                                    <div class="offset-1 small text-black-50"><?php echo __('For compatibility with some Cache and CDN plugins.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sq_separator my-3"></div>

                                        <div class="col-sm-12 row mb-1 ml-1">
                                            <div class="checker col-sm-12 row my-2 py-1">
                                                <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_complete_uninstall" value="0"/>
                                                    <input type="checkbox" id="sq_complete_uninstall" name="sq_complete_uninstall" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_complete_uninstall') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_complete_uninstall" class="ml-2"><?php _e('Delete Squirrly Table on Uninstall', _SQ_PLUGIN_NAME_); ?></label>
                                                    <div class="offset-1 small text-black-50"><?php echo __('Delete Squirrly SEO table and options on uninstall.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12 my-3 p-0">
                            <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php _e('Save Settings', _SQ_PLUGIN_NAME_); ?></button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="sq_col_side sticky">
                <div class="card col-sm-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
