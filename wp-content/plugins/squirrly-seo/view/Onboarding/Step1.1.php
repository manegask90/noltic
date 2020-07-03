<div id="sq_wrap">
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'step1.1'), 'sq_onboarding'); ?>
        <div class="sq_row d-flex flex-row bg-white px-3">
            <div class="sq_col flex-grow-1 mr-3">

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top row">
                        <div class="col-sm-8 m-0 p-0 py-2 bg-title rounded-top">
                            <div class="sq_icons sq_squirrly_icon m-1 mx-3"></div>
                            <h3 class="card-title"><?php _e('Welcome to Squirrly SEO 2019 (Strategy)', _SQ_PLUGIN_NAME_); ?></h3>
                        </div>
                        <div class="col-sm-4 m-0 p-0 py-2 text-right">
                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step1.2') ?>" class="btn rounded-0 btn-success btn-lg px-3 mx-4 float-sm-right"><?php _e('Continue >', _SQ_PLUGIN_NAME_); ?></a>
                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 m-0 border-0  border-0">
                        <div class="card-body p-0">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="card col-sm-12 p-0 border-0 ">

                                    <div class="col-sm-12 pt-0 pb-4 ">

                                        <div class="col-sm-12 card-title py-3 pt-3 text-success text-center" style="font-size: 24px; line-height: 30px"><?php _e("We're getting your site ready for Excellent SEO", _SQ_PLUGIN_NAME_); ?>:</div>

                                        <div class="col-sm-12 my-3 px-5 clear">
                                            <div id="checkbox1" class="checkbox my-3">
                                                <label>
                                                    <input type="checkbox" value=""  disabled>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    <?php _e("Getting SEO Automation ready on your WP", _SQ_PLUGIN_NAME_); ?>
                                                </label>
                                            </div>

                                            <div  id="checkbox2" class="checkbox my-3">
                                                <label>
                                                    <input type="checkbox" value=""  disabled>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    <?php _e("Activating METAs", _SQ_PLUGIN_NAME_); ?>
                                                </label>
                                            </div>

                                            <div  id="checkbox3" class="checkbox my-3">
                                                <label>
                                                    <input type="checkbox" value=""  disabled>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    <?php _e("Activating JSON-LD schema.org implementations", _SQ_PLUGIN_NAME_); ?>
                                                </label>
                                            </div>

                                            <div  id="checkbox4" class="checkbox my-3">
                                                <label>
                                                    <input type="checkbox" value=""  disabled>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    <?php _e("Activating Open Graph", _SQ_PLUGIN_NAME_); ?>
                                                </label>
                                            </div>

                                            <div  id="checkbox5" class="checkbox my-3">
                                                <label>
                                                    <input type="checkbox" value=""  disabled>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    <?php _e("Activating Twitter Cards", _SQ_PLUGIN_NAME_); ?>
                                                </label>
                                            </div>

                                            <div  id="checkbox6" class="checkbox my-3">
                                                <label>
                                                    <input type="checkbox" value=""  disabled>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    <?php _e("Creating your Sitemap", _SQ_PLUGIN_NAME_); ?>
                                                </label>
                                            </div>

                                            <div  id="checkbox7" class="checkbox my-3">
                                                <label>
                                                    <input type="checkbox" value=""  disabled>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    <?php _e("Creating robots.txt", _SQ_PLUGIN_NAME_); ?>
                                                </label>
                                            </div>

                                            <div id="field8" class="fields my-3" style="display: none; color: green; font-size: 27px;">
                                                <?php _e("Success! You are all setup.", _SQ_PLUGIN_NAME_); ?>
                                            </div>

                                            <div id="field8" class="fields" style="display: none;">
                                                <?php echo __('Now',_SQ_PLUGIN_NAME_); ?>: <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step2.1') ?>" ><?php _e("Do you want to be placed within the first 10 results, out of Millions of competing pages?", _SQ_PLUGIN_NAME_); ?></a>
                                            </div>

                                            <div class="col-sm-12 m-0 mt-3 p-0 py-2 text-right border-top">
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step1.2') ?>" class="btn rounded-0 btn-success btn-lg px-3 mx-4 float-sm-right"><?php _e('Continue >', _SQ_PLUGIN_NAME_); ?></a>
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
</div>
