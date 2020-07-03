<div id="sq_wrap">
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'step4'), 'sq_onboarding'); ?>
        <div class="sq_row d-flex flex-row bg-white px-3">
            <div class="sq_col flex-grow-1 mr-3">

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top  row">
                        <div class="card-body p-2 bg-title rounded-top">
                            <div class="sq_icons sq_squirrly_icon m-1 mx-3"></div>
                            <h3 class="card-title"><?php _e('Final Step', _SQ_PLUGIN_NAME_); ?></h3>
                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0">
                        <div class="card-body p-5" style="min-width: 800px;min-height: 430px">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="col-sm-12 mx-auto p-0 tab-panel" style="max-width: 900px">
                                    <div class="sq_loading_steps text-center p-3" style="min-height: 60px">
                                        <div class="sq_loading_step1 sq_loading_step" style="font-size: 18px;"><?php echo __("Your private SEO consultant is now accessing our cloud services to start analyzing your site.", _SQ_PLUGIN_NAME_) ?></div>
                                        <div class="sq_loading_step2 sq_loading_step" style="font-size: 18px; display: none"><?php echo __("Our machine learning is now trying to match some of the data with what we have in our system.", _SQ_PLUGIN_NAME_) ?></div>
                                        <div class="sq_loading_step3 sq_loading_step" style="font-size: 18px; display: none"><?php echo __("Getting your SEO Protection to 100%.", _SQ_PLUGIN_NAME_) ?></div>
                                        <div class="sq_loading_step4 sq_loading_step" style="font-size: 18px; display: none"><?php echo __("Covering all the post types from your WP with Excellent on-page SEO.", _SQ_PLUGIN_NAME_) ?></div>
                                        <div class="sq_loading_step5 sq_loading_step" style="font-size: 18px; display: none"><?php echo __("Analysis by consultant reaching 100%.", _SQ_PLUGIN_NAME_) ?></div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                    <div class="sq_loading_steps text-center p-3">
                                        <div class="sq_loading_step6 sq_loading_step mt-3 pt-2 border-top" style="display: none; color: green; font-size: 19px;">
                                            <div class="m-2">
                                                <?php _e("You can now check today's SEO Goals to see what your new Consultant says you should focus on.", _SQ_PLUGIN_NAME_); ?>
                                            </div>

                                            <div class="col-sm-12 m-0 p-0">
                                                <a class="btn btn-warning  m-2 py-2 px-5 center-block" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>#tasks"><?php echo __("Check Today's SEO Goals", _SQ_PLUGIN_NAME_) ?></a>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        (function ($) {
                                            $('#sq_wrap').sq_onboardingFinalStep();
                                        })(jQuery);
                                    </script>

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
