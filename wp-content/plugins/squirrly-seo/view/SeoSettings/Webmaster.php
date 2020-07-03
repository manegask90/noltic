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
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_webmaster', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_webmaster"/>

                    <div class="card col-sm-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-sm-7 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_websites_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php _e('Webmaster Tools', _SQ_PLUGIN_NAME_); ?>:</h3>
                            </div>
                            <div class="col-sm-5 text-right">
                                <div class="checker col-sm-12 row my-2 py-1 mx-0 px-0 ">
                                    <div class="col-sm-12 p-0 sq-switch redgreen sq-switch-sm ">
                                        <label for="sq_auto_webmasters" class="mr-2"><?php _e('Activate Webmasters', _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_webmasters" value="0"/>
                                        <input type="checkbox" id="sq_auto_webmasters" name="sq_auto_webmasters" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_webmasters') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_webmasters"></label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="sq_seosettings" class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_webmasters') ? '' : 'sq_deactivated') ?>">

                            <div class="card-body p-0">
                                <div class="col-sm-12 m-0 p-0">
                                    <div class="card col-sm-12 p-0 border-0 ">
                                        <?php
                                        $codes = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));
                                        $connect = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('connect')));
                                        ?>

                                        <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">

                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Google Verification Code', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(__('Add the Google META verification code to connect to %sGoogle Search Console%s and %sWebmaster Tool%s', _SQ_PLUGIN_NAME_), '<a href="https://search.google.com/search-console" target="_blank">', '</a>', '<a href="https://www.google.com/webmasters" target="_blank">', '</a>'); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                                    <input id="google_wt" type="text" class="form-control bg-input" name="codes[google_wt]" value="<?php echo((isset($codes->google_wt)) ? $codes->google_wt : '') ?>" />
                                                    <?php if (!$connect->google_search_console) { ?>
                                                        <div class="sq_step1 my-0 mx-2">
                                                            <a href="<?php echo SQ_Classes_RemoteController::getApiLink('gscoauth'); ?>" onclick="jQuery('.sq_step1').hide();jQuery('.sq_step2').show();" target="_blank" type="button" class="btn btn-block btn-social btn-google text-info connect-button connect btn-lg">
                                                                <span class="fa fa-google-plus"></span> <?php echo __('Sign in', _SQ_PLUGIN_NAME_); ?>
                                                            </a>
                                                        </div>
                                                        <div class="sq_step2 my-0 mx-2" style="display: none">
                                                            <button id="sq_connection_check_button" type="button" class="btn btn-block btn-social btn-warning btn-lg">
                                                                <span class="fa fa-google-plus"></span> <?php echo __('Check connection', _SQ_PLUGIN_NAME_); ?>
                                                            </button>
                                                        </div>
                                                    <?php }else{?>
                                                        <div class="my-0 mx-2">
                                                            <button id="sq_webmaster_button" type="button" class=" btn btn-block btn-warning btn-lg">
                                                                <?php echo __('Get GSC Code', _SQ_PLUGIN_NAME_); ?>
                                                            </button>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Bing Verification Code', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(__('Add the Bing META verification code to connect to %sWebmaster Tool%s', _SQ_PLUGIN_NAME_), '<a href="http://www.bing.com/toolbox/webmaster/" target="_blank">', '</a>'); ?></div>
                                                </div>
                                                <div class="col-sm-6 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="codes[bing_wt]" value="<?php echo((isset($codes->bing_wt)) ? $codes->bing_wt : '') ?>" />
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Alexa META Code', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(__('Add the Alexa META code to analyze your entire website. Visit the %sAlexa Marketing Tool%s', _SQ_PLUGIN_NAME_), '<a href="http://www.alexa.com/" target="_blank">', '</a>'); ?></div>
                                                </div>
                                                <div class="col-sm-6 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="codes[alexa_verify]" value="<?php echo((isset($codes->alexa_verify)) ? $codes->alexa_verify : '') ?>" />
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Pinterest Website Validator Code', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(__('Add the Pinterest verification code to connect your website to your Pinterest account. Visit the %sRich Pins Validator%s', _SQ_PLUGIN_NAME_), '<a href="https://developers.pinterest.com/tools/url-debugger/" target="_blank">', '</a>'); ?></div>
                                                </div>
                                                <div class="col-sm-6 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="codes[pinterest_verify]" value="<?php echo((isset($codes->pinterest_verify)) ? $codes->pinterest_verify : '') ?>" />
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
