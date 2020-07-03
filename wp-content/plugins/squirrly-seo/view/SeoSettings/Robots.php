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
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_robots', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_robots"/>

                    <div class="card col-sm-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-sm-8 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_robots_icon m-2"></div>
                                </div>
                                <h3 class="card-title"><?php _e('Robots File', _SQ_PLUGIN_NAME_); ?>:</h3>
                                <div class="col-sm-12 text-left m-0 p-0">
                                    <div class="card-title-description m-2"><?php _e("A robots.txt file tells search engine crawlers which pages or files the crawler can or can't request from your site.", _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <div class="checker col-sm-12 row my-2 py-1 mx-0 px-0 ">
                                    <div class="col-sm-12 p-0 sq-switch redgreen sq-switch-sm ">
                                        <label for="sq_auto_robots" class="mr-2"><?php _e('Activate Robots', _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_robots" value="0"/>
                                        <input type="checkbox" id="sq_auto_robots" name="sq_auto_robots" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_robots') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_robots"></label>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div id="sq_seosettings" class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_robots') ? '' : 'sq_deactivated') ?>">
                            <div class="card-body p-0">
                                <div class="col-sm-12 m-0 p-0">
                                    <div class="card col-sm-12 p-0 border-0 ">


                                        <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">

                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Edit the Robots.txt data', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(__('Does not physically create the robots.txt file. The best option for Multisites.', _SQ_PLUGIN_NAME_), '<a href="https://developers.facebook.com/apps/" target="_blank"><strong>', '</strong></a>'); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 form-group">
                                                    <textarea class="form-control" name="robots_permission" rows="10"><?php
                                                        $robots = '';
                                                        $robots_permission = SQ_Classes_Helpers_Tools::getOption('sq_robots_permission');
                                                        if (!empty($robots_permission)) {
                                                            echo implode(PHP_EOL, (array)SQ_Classes_Helpers_Tools::getOption('sq_robots_permission'));
                                                        }

                                                        ?></textarea>
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
