<?php
add_filter('sq_themes', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'getAvailableThemes'));
add_filter('sq_plugins', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'getAvailablePlugins'));
$platforms = apply_filters('sq_importList', false);

$next_step = 'step4';
if ($platforms && count((array)$platforms) > 0) {
    $next_step = 'step3';
}
?>
<div id="sq_wrap">
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'step1'), 'sq_onboarding'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top row">
                        <div class="col-sm-8 m-0 p-0 py-2 bg-title rounded-top">
                            <div class="sq_icons sq_squirrly_icon m-1 mx-3"></div>
                            <h3 class="card-title"><?php _e('Welcome to Squirrly SEO 2020 (Smart Strategy)', _SQ_PLUGIN_NAME_); ?></h3>
                        </div>
                        <div class="col-sm-4 m-0 p-0 py-2 text-right">
                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', $next_step) ?>" class="btn rounded-0 btn-success btn-lg px-3 mx-4 float-sm-right"><?php _e('Continue >', _SQ_PLUGIN_NAME_); ?></a>
                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 m-0 border-0  border-0">
                        <div class="card-body" style="min-width: 800px; min-height: 430px;">

                            <div class="row col-sm-12 pt-0 pb-4 ">
                                <div class="col-sm-5 m-0 p-2 py-5">
                                    <div class="col-sm-12 card-title py-5 text-success text-center" style="font-size: 24px; line-height: 35px; margin-top: 20px;"><?php _e("Your Private SEO Consultant Sets Up the SEO for Your WordPress", _SQ_PLUGIN_NAME_); ?>:</div>
                                </div>
                                <div class="col-sm-7 m-0 p-0">
                                    <div class="col-sm-12 my-2 px-2">
                                        <div id="checkbox1" class="checkbox my-2">
                                            <label>
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php _e("Getting SEO Automation ready on your WP", _SQ_PLUGIN_NAME_); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox2" class="checkbox my-2">
                                            <label>
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php _e("Activating METAs", _SQ_PLUGIN_NAME_); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox3" class="checkbox my-2">
                                            <label>
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php _e("Activating JSON-LD schema.org", _SQ_PLUGIN_NAME_); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox4" class="checkbox my-2">
                                            <label>
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php _e("Activating Open Graph", _SQ_PLUGIN_NAME_); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox5" class="checkbox my-2">
                                            <label>
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php _e("Activating Twitter Cards", _SQ_PLUGIN_NAME_); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox6" class="checkbox my-2">
                                            <label>
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php _e("Creating your Sitemap", _SQ_PLUGIN_NAME_); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox7" class="checkbox my-2">
                                            <label>
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php _e("Creating robots.txt", _SQ_PLUGIN_NAME_); ?>
                                            </label>
                                        </div>

                                        <div id="field8" class="fields mt-1 pt-2 border-top" style="display: none; color: green; font-size: 27px;">
                                            <?php _e("Success! You are all setup", _SQ_PLUGIN_NAME_); ?> <i class="fa fa-thumbs-up" style="font-size: 34px !important;"></i>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
</div>
