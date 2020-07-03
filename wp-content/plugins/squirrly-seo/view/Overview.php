<div id="sq_wrap" class="sq_overview">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_form_notices'); ?>
    <?php if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') { ?>
        <div class="d-flex flex-row my-0 bg-white col-sm-12 p-2 m-0">
            <div class="sq_flex flex-grow-1 mx-0 my-2 px-3">
                <div class="mx-auto">
                    <div class="bg-title col-sm-8 mx-auto card-body my-3 p-2 offset-2 rounded-top" style="min-width: 600px;">
                        <div class="col-sm-12 text-center m-2 p-0 e-connect">
                            <div class="mt-3 mb-4 mx-auto e-connect-link">
                                <div class="p-0 mx-2" style="width:48px; float: left;">
                                    <div class="sq_wordpress_icon m-0 p-0" style="width: 48px; height: 48px;"></div>
                                </div>
                                <div class="p-0 mx-2" style="width:48px; float: right;">
                                    <div class="sq_squirrly_icon m-0 p-0" style="width: 40px; height: 48px;"></div>
                                </div>
                            </div>
                            <h4 class="card-title"><?php _e('Connect Your Site to Squirrly Cloud', _SQ_PLUGIN_NAME_); ?></h4>
                            <div class="small"><?php echo sprintf(__('Get Access to the Non-Human SEO Consultant, Focus Pages, SEO Audits and all our features %s by creating a free account'), '<br/>') ?></div>
                        </div>

                        <?php SQ_Classes_ObjController::getClass('SQ_Core_Blocklogin')->init(); ?>
                    </div>
                </div>
            </div>


            <div class="sq_col sq_col_side ">
                <div class="card col-sm-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockKnowledgeBase')->init(); ?>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="d-flex flex-row my-0 bg-white col-sm-12 p-2 m-0">

            <div class="sq_flex flex-grow-1 mx-0 px-3">
                <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockStats')->init(); ?>
                <?php if (current_user_can('sq_manage_snippets')) { ?>
                    <?php SQ_Classes_ObjController::getClass('SQ_Controllers_CheckSeo')->init(); ?>
                    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockJorney')->init(); ?>
                <?php } else {
                    echo '<div class="col-sm-12 alert alert-success text-center mx-0 my-3 p-3">' . __("You do not have permission to access Daily Goals. You need Squirrly SEO Editor role.", _SQ_PLUGIN_NAME_) . '</div>';
                } ?>
                <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockFeatures')->init(); ?>
            </div>


            <div class="sq_col sq_col_side ">
                <div class="card col-sm-12 p-0 my-1">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php if (SQ_Classes_Helpers_Tools::getMenuVisible('show_panel') && current_user_can('manage_options')) { ?>
                        <div class="sq_account_info" style="min-height: 20px;"></div>
                    <?php } ?>


                </div>

                <div class="card col-sm-12 p-0 my-1">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockConnect')->init(); ?>
                </div>

                <div class="card col-sm-12 p-0 my-1">
                    <div class="card col-sm-12 px-1 py-3 m-0 my-2 border-0 shadow-none">
                        <h5 class="card-title text-center"><?php _e('Squirrly SEO Feature Categories', _SQ_PLUGIN_NAME_); ?></h5>
                        <div class="card-body pt-4">
                            <a href="#features"><img src="<?php echo _SQ_ASSETS_URL_ . 'img/squirrly_features.png' ?>" style="width: 100%"></a>
                        </div>
                    </div>
                </div>


                <?php if (current_user_can('sq_manage_snippets')) { ?>
                    <div class="card col-sm-12 p-0 my-1">
                        <div class="my-4 py-4">
                            <div class="col-sm-12 row m-0">
                                <div class="checker col-sm-12 row m-0 p-0">
                                    <div class="col-sm-12 p-0  m-0 sq-switch sq-switch-sm sq_save_ajax">
                                        <input type="checkbox" id="sq_seoexpert" name="sq_seoexpert" class="sq-switch" data-action="sq_ajax_seosettings_save" data-input="sq_seoexpert" data-name="sq_seoexpert" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_seoexpert') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_seoexpert" class="ml-1"><?php _e('Show Advanced SEO', _SQ_PLUGIN_NAME_); ?></label>
                                        <div class="text-black-50 m-0 mt-2 p-1" style="font-size: 13px;"><?php _e('Switch off to have the simplified version of the settings, intended for Non-SEO Experts.', _SQ_PLUGIN_NAME_); ?></div>
                                        <div class="text-black-50 m-0 mt-2 p-1" style="font-size: 13px;"><?php _e('It will offer the same level of SEO performance, but it will be less customizable.', _SQ_PLUGIN_NAME_); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="card col-sm-12 p-0 my-1">
                    <div class="my-3 py-3">
                        <div class="col-sm-12 row m-0">
                            <div class="checker col-sm-12 row m-0 p-0 text-center">
                                <div class="col-sm-12 my-2 mx-auto p-0 font-weight-bold" style="font-size: 18px;"><?php echo __('We Need Your Support', _SQ_PLUGIN_NAME_) ?></div>

                                <div class="col-sm-12 my-2 p-0">
                                    <a href="https://wordpress.org/support/view/plugin-reviews/squirrly-seo#postform" target="_blank">
                                        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/5stars.png' ?>">
                                    </a>
                                </div>
                                <div class="col-sm-12 my-2 p-0">
                                    <a href="https://wordpress.org/support/view/plugin-reviews/squirrly-seo#postform" target="_blank" class="font-weight-bold" style="font-size: 16px;">
                                        <?php echo __('Rate us if you like Squirrly SEO', _SQ_PLUGIN_NAME_) ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card col-sm-12 p-0 my-1">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockKnowledgeBase')->init(); ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
