<div id="sq_wrap">
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <div class="sq_row d-flex flex-row flex-nowrap bg-white px-3">
            <div class="sq_col flex-grow-1 mr-3" >

                <div class="card col-sm-12 p-0" style="min-width: 850px;">
                    <div class="card-body p-2 bg-title rounded-top row">
                        <div class="col-sm-6 m-0 p-0 py-2 bg-title rounded-top">
                            <div class="sq_icons sq_squirrly_icon m-1 mx-3"></div>
                            <h3 class="card-title"><?php _e('Start the 14 Days Journey', _SQ_PLUGIN_NAME_); ?></h3>
                        </div>
                        <div class="col-sm-6 m-0 p-0 py-2 text-right">
                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" class="btn btn-default btn-lg px-3 mx-4 float-sm-right border rounded-circle"><?php _e('X', _SQ_PLUGIN_NAME_); ?></a>
                        </div>
                    </div>

                    <div class="col-sm-12 p-0 m-0 border-0 tab-panel border-0">
                        <div class="p-0">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="col-sm-12 p-0 border-0 ">
                                    <div class="col-sm-12 pt-0 pb-4 tab-panel">
                                        <div class="col-sm-12 m-auto px-5 tab-panel">
                                            <?php if (SQ_Classes_Helpers_Tools::getOption('sq_seojourney')) { ?>
                                                <div class="col-sm-12 py-3 pt-5 text-success text-center" style="font-size: 28px; color: rebeccapurple; line-height: 30px"><?php echo sprintf(__("Awesome! You are on your way to better results.", _SQ_PLUGIN_NAME_), '<br />'); ?></div>
                                                <div class="p-0 m-0 mb-5 text-center">
                                                    <div class="col-sm-12" style="font-size: 18px"><?php echo sprintf(__("You will receive the %sdaily recipe%s in your %sDashboard%s.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<strong>', '</strong>'); ?></div>
                                                </div>
                                                <div class="col-sm-12 m-3 px-4 text-center justify-content-center">
                                                    <img src="<?php echo _SQ_ASSETS_URL_ . 'img/onboarding/racing_car start.png' ?>" style="max-width: 60%;">
                                                </div>
                                                <div class="col-sm-12 m-3 px-4 clear">
                                                    <div class="my-3" style="font-size: 16px; line-height: 30px"><?php echo sprintf(__("%sJoin%s the rest of the %sJourneyTeam on the Facebook Group%s and if you want you can share with the members that you have started your Journey.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<strong><a href="https://www.facebook.com/groups/SquirrlySEOCustomerService/" target="_blank" >', '</a></strong>'); ?></div>
                                                    <div class="my-3" style="font-size: 16px; line-height: 30px"><?php echo sprintf(__("%sIn 14 Days you can tell us how it went%s (via messages on our %sFacebook Page%s) and we'll tell you what you can do to further improve the results you got during the 14 Days.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<strong><a href="https://www.facebook.com/Squirrly.co/" target="_blank" >', '</a></strong>'); ?></div>
                                                </div>
                                                <div class="p-0 m-0 mb-3 text-center">
                                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" class="btn btn-lg bg-success text-white px-5 mt-3">
                                                        <?php echo __("Close", _SQ_PLUGIN_NAME_) ?>
                                                    </a>
                                                </div>
                                            <?php } else { ?>
                                                <h2 class="col-sm-12 py-3 text-center"><?php _e("Choose how to continue", _SQ_PLUGIN_NAME_); ?>:</h2>
                                                <div class="row flex-nowrap py-3">
                                                    <div class="col-sm text-center">

                                                        <form method="post" class="p-0 m-0">
                                                            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/onboarding/racing_car start.png' ?>" class="float-left mr-4" style="max-width: 100%;">

                                                            <?php SQ_Classes_Helpers_Tools::setNonce('sq_onboarding_commitment', 'sq_nonce'); ?>
                                                            <input type="hidden" name="action" value="sq_onboarding_commitment"/>
                                                            <button type="submit" class="btn btn-lg btn-success px-5 mt-3">
                                                                <?php echo __("Let's Start My 14 Days Journey", _SQ_PLUGIN_NAME_) ?>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col-sm text-center">
                                                        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/onboarding/racing_car_finish_rusty.png' ?>" class="float-left mr-4" style="max-width: 100%;">

                                                        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" class="btn btn-lg bg-transparent text-black-50 my-2">
                                                            <?php echo __("Nah, there is little interest in this", _SQ_PLUGIN_NAME_) ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        </div>
                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_seojourney')) { ?>
                                            <div class="col-sm-12 my-3 p-0 py-3 border-top">
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" class="btn rounded-0 btn-default btn-lg px-3 mx-4 float-sm-right"><?php _e('Close Window', _SQ_PLUGIN_NAME_); ?></a>
                                            </div>
                                        <?php } ?>

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
