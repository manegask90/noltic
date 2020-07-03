<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_settings')) {
            echo '<div class="col-sm-12 alert alert-success text-center m-0 p-3">' . __("You do not have permission to access this page. You need Squirrly SEO Admin role", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_seosettings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">
                <?php do_action('sq_form_notices'); ?>


                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top  row">
                        <div class="col-sm-12 text-left m-0 p-0">
                            <div class="sq_icons_content p-3 py-4" style="min-height: 150px">
                                <div class="sq_icons sq_settings_icon m-2"></div>
                            </div>
                            <h3 class="card-title"><?php _e('Import Settings & SEO', _SQ_PLUGIN_NAME_); ?>:</h3>
                            <div class="col-sm-12 text-left m-0 p-0">
                                <div class="card-title-description m-2"><?php _e("Import the settings and SEO from other plugins so you can use only Squirrly SEO for on-page SEO.", _SQ_PLUGIN_NAME_); ?></div>
                                <div class="card-title-description m-2"><?php _e("Note! If you import the SEO settings from other plugins or themes, you will lose all the settings that you had in Squirrly SEO. Make sure you backup your settings from the panel below before you do this.", _SQ_PLUGIN_NAME_); ?></div>
                            </div>
                        </div>


                    </div>

                    <?php $platforms = apply_filters('sq_importList', false); ?>
                    <div id="sq_seosettings" class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0">
                        <div class="card-body p-0">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="card col-sm-12 p-0 border-0 ">

                                    <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">
                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php _e('Import Settings From', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo __('Select the plugin or theme you want to import the Settings from.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group">
                                                    <?php
                                                    if ($platforms && count((array)$platforms) > 0) {
                                                        ?>
                                                        <select name="sq_import_platform" class="form-control bg-input mb-1">
                                                            <?php
                                                            foreach ($platforms as $path => $settings) {
                                                                ?>
                                                                <option value="<?php echo $path ?>"><?php echo ucfirst(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($path)); ?></option>
                                                            <?php } ?>
                                                        </select>

                                                        <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_importsettings', 'sq_nonce'); ?>
                                                        <input type="hidden" name="action" value="sq_seosettings_importsettings"/>
                                                        <button type="submit" class="btn rounded-0 btn-success px-2 mx-2" style="min-width: 140px"><?php _e('Import Settings', _SQ_PLUGIN_NAME_); ?></button>
                                                    <?php } else { ?>
                                                        <div class="col-sm-12 my-2"><?php _e("We couldn't find any SEO plugin or theme to import from."); ?></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php _e('Import SEO From', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo __('Select the plugin or theme you want to import the SEO settings from.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group">
                                                    <?php
                                                    if ($platforms && count((array)$platforms) > 0) {
                                                        ?>
                                                        <select name="sq_import_platform" class="form-control bg-input mb-1">
                                                            <?php
                                                            foreach ($platforms as $path => $settings) {
                                                                ?>
                                                                <option value="<?php echo $path ?>"><?php echo ucfirst(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($path)); ?></option>
                                                            <?php } ?>
                                                        </select>

                                                        <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_importseo', 'sq_nonce'); ?>
                                                        <input type="hidden" name="action" value="sq_seosettings_importseo"/>
                                                        <button type="submit" class="btn rounded-0 btn-success px-2 mx-2" style="min-width: 140px"><?php _e('Import SEO', _SQ_PLUGIN_NAME_); ?></button>
                                                    <?php } else { ?>
                                                        <div class="col-sm-12 my-2"><?php _e("We couldn't find any SEO plugin or theme to import from."); ?></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                    <div class="bg-title p-2">
                                        <h3 class="card-title"><?php _e('Backup Settings & SEO', _SQ_PLUGIN_NAME_); ?>:</h3>
                                        <div class="col-sm-12 text-left m-0 p-0">
                                            <div class="card-title-description mb-0"><?php _e("You can now download your Squirrly settings in an sql file before you go ahead and import the SEO settings from another plugin. That way, you can always go back to your Squirrly settings.", _SQ_PLUGIN_NAME_); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">
                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php _e('Backup Settings', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo __('Download all the settings from Squirrly SEO.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group">
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_backupsettings', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_backupsettings"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-2 noloading"><?php _e('Download  Backup', _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php _e('Backup SEO', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo __('Download all the Squirrly SEO Snippet optimizations.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8  p-0 input-group">
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_backupseo', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_backupseo"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-2 noloading"><?php _e('Download Backup', _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                    <div class="bg-title p-2">
                                        <h3 class="card-title"><?php _e('Restore Settings & SEO', _SQ_PLUGIN_NAME_); ?>:</h3>
                                        <div class="col-sm-12 text-left m-0 p-0">
                                            <div class="card-title-description mb-0"><?php _e("Restore the settings and all the pages optimized with Squirrly SEO.", _SQ_PLUGIN_NAME_); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">
                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php _e('Restore Settings', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo __('Upload the file with the saved Squirrly Settings.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group">
                                                    <div class="form-group my-2">
                                                        <input type="file" class="form-control-file" name="sq_options">
                                                    </div>
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_restoresettings', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_restoresettings"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-2" style="min-width: 140px"><?php _e('Restore Settings', _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 ">
                                                    <div class="font-weight-bold"><?php _e('Restore SEO', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo __('Upload the file with the saved Squirrly SEO SQL file.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group">
                                                    <div class="form-group my-2">
                                                        <input type="file" class="form-control-file" name="sq_sql">
                                                    </div>
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_restoreseo', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_restoreseo"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-2" style="min-width: 140px"><?php _e('Restore SEO', _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="bg-title p-2">
                                        <h3 class="card-title"><?php _e('Rollback Plugin', _SQ_PLUGIN_NAME_); ?>:</h3>
                                        <div class="col-sm-12 text-left m-0 p-0">
                                            <div class="card-title-description mb-0"><?php _e("You can rollback Squirrly SEO plugin to the last stable version.", _SQ_PLUGIN_NAME_); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">
                                        <form id="sq_rollback_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php echo __('Rollback to', _SQ_PLUGIN_NAME_) . ' ' . SQ_STABLE_VERSION; ?>:</div>
                                                    <div class="small text-black-50"><?php _e("Install the last stable version of the plugin.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group">
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_rollback', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_rollback"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-2"><?php echo __('Install Squirrly SEO', _SQ_PLUGIN_NAME_) . ' ' . SQ_STABLE_VERSION; ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-sm-12 my-3 p-0">
                        <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php _e('Save Settings', _SQ_PLUGIN_NAME_); ?></button>
                    </div>

                </div>
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
