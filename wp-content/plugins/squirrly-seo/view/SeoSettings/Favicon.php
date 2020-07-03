<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_settings')) {
            echo '<div class="col-sm-12 alert alert-success text-center m-0 p-3">'. __("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_).'</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_seosettings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">
                <?php do_action('sq_form_notices'); ?>
                <form method="POST" enctype="multipart/form-data">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_favicon', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_favicon"/>

                    <div class="card col-sm-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-sm-8 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_favicon_icon m-2"></div>
                                </div>
                                <h3 class="card-title"><?php _e('Website Icon', _SQ_PLUGIN_NAME_); ?>:</h3>
                                <div class="col-sm-12 text-left m-0 p-0">
                                    <div class="card-title-description m-2"><?php _e("Add your website icon in the browser tabs and on other devices like iPhone, iPad and Android phones.", _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <div class="checker col-sm-12 row my-2 py-1 mx-0 px-0 ">
                                    <div class="col-sm-12 p-0 sq-switch redgreen sq-switch-sm ">
                                        <label for="sq_auto_favicon" class="mr-2"><?php _e('Activate Favicon', _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_favicon" value="0"/>
                                        <input type="checkbox" id="sq_auto_favicon" name="sq_auto_favicon" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_favicon') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_favicon"></label>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div id="sq_seosettings" class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_favicon') ? '' : 'sq_deactivated') ?>">
                            <div class="card-body p-0">
                                <div class="col-sm-12 m-0 p-0">
                                    <div class="card col-sm-12 p-0 border-0 ">

                                        <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">

                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php _e('Upload file', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo __('Upload a jpg, jpeg, png or ico file.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-1 p-2 text-center input-group">
                                                    <?php
                                                    if (SQ_Classes_Helpers_Tools::getOption('sq_auto_favicon') && SQ_Classes_Helpers_Tools::getOption('favicon') <> '' && file_exists(_SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption('favicon'))) {
                                                        if (!get_option('permalink_structure')) {
                                                            $favicon = get_bloginfo('wpurl') . '/index.php?sq_get=favicon';
                                                        } else {
                                                            $favicon = get_bloginfo('wpurl') . '/favicon.icon' . '?' . time();
                                                        }
                                                        ?>
                                                        <img src="<?php echo $favicon ?>" style="float: left; margin-top: 1px;width: 32px;height: 32px;"/>

                                                    <?php } ?>


                                                </div>
                                                <div class="col-sm-7 p-0 input-group">
                                                    <div class="form-group my-2">
                                                        <input type="file" class="form-control-file" name="favicon">
                                                    </div>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-2" style="min-width: 140px"><?php _e('Upload', _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_favicon_apple" value="0"/>
                                                        <input type="checkbox" id="sq_favicon_apple" name="sq_favicon_apple" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_favicon_apple') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_favicon_apple" class="ml-2"><?php _e('Add Apple Touch Icons', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Also load the favicon for Apple devices.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <span class="col-sm-12 px-0 small text-black-50 font-italic"><?php _e("If you don't see the new icon in your browser, empty the browser cache and refresh the page.", _SQ_PLUGIN_NAME_); ?></span>
                                                <span class="col-sm-12 px-0 small text-black-50 font-italic"><?php echo __('Accepted file types: JPG, JPEG, GIF and PNG.', _SQ_PLUGIN_NAME_); ?></span>
                                                <span class="col-sm-12 px-0 small text-black-50 font-italic"><?php _e("Does not physically create the favicon.ico file. The best option for Multisites.", _SQ_PLUGIN_NAME_); ?></span>
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
