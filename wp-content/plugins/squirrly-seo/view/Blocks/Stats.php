<div id="sq_stats">
    <?php
    $dbtasks = json_decode(get_option(SQ_TASKS), true);

    /////////////////// Check the SEO Protection in real time
    $settings = array();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsMetas();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsJsonld();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsSocialOG();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsSocialTWC();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsSitemap();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsPatterns();

    $valid = 0;
    foreach ($settings as $setting) {
        if ($setting) {
            $valid += 1;
        }
    }

    $view->stats['seo_percent'] = 0;
    if ($valid > 0) {
        $view->stats['seo_percent'] = number_format((($valid * 100) / count($settings)), 0);
    }
    ////////////////////////////////////////////////////////////

    if (!isset($dbtasks['sq_onboarding']['OnboardingBanner']) || $dbtasks['sq_onboarding']['OnboardingBanner']['active']) {
        ?>
        <div id="OnboardingBanner" class="banner col-sm-12 m-0 mt-4 p-0" style="box-shadow: 0 0 10px -3px #994525;">
            <div class="sq_save_ajax" style="position: absolute; right: 0; width: 10px; vertical-align: middle;  padding-left: 0; padding-right: 0; margin: 0">
                <input type="hidden" id="sq_ignore_OnboardingBanner" value="0">
                <button type="button" class="float-right btn btn-sm btn-link text-black-50 p-2 px-3 m-0" id="sq_onboarding_banner" data-input="sq_ignore_OnboardingBanner" data-name="sq_onboarding|OnboardingBanner" data-action="sq_ajax_assistant" data-javascript="$('#OnboardingBanner').hide();">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/banner.png' ?>" style="width: 100%">
        </div>
    <?php } ?>
    <div class="card col-sm-12 m-0 mt-4 p-0" style="box-shadow: 0 0 10px -3px #994525;">
        <div class="card-body m-0 p-0 bg-title">
            <div class="row text-left m-0 p-0">
                <div class="col-sm p-4">
                    <div class="text-left m-0 p-0 py-1">
                        <div class="col-sm m-0 p-0">
                            <h2 class="m-0 p-0" style="font-size: 40px;font-weight: bold;"><?php _e('Hello', _SQ_PLUGIN_NAME_); ?>,</h2>
                        </div>
                    </div>
                    <div class="sq_separator"></div>
                    <div class="row text-left m-0 p-0 py-3">
                        <div class="col-sm-8 m-0 p-0">
                            <h3 class="card-title m-0 p-0"><?php echo sprintf(__('%s SEO Protection', _SQ_PLUGIN_NAME_), '<strong class="text-info" style="font-size: 40px; text-shadow: 1px 1px white;">' . (int)$view->stats['seo_percent'] . '%' . '</strong>'); ?></h3>
                            <div class="card-title-description m-0 p-0 text-black-50">
                                <?php if ((int)$view->stats['seo_percent'] == 100) { ?>
                                    <?php echo __("All protection layers are activated.", _SQ_PLUGIN_NAME_); ?>
                                <?php } else { ?>
                                    <?php echo sprintf(__("Power up the SEO from %sSquirrly > SEO Settings%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>'); ?>
                                <?php } ?>
                            </div>
                            <div class="card-title-description m-0 p-0">
                                <a href="https://howto.squirrly.co/faq/how-does-seo-protection-work/" target="_blank">(<?php _e("How does this work?", _SQ_PLUGIN_NAME_); ?>)</a>
                            </div>

                            <div class="row text-left m-0 p-0 pt-4">
                                <div class="col-sm-5 m-0 p-0">
                                    <h5 class="m-0 p-0 text-info" style="text-shadow: 1px 1px white;"><?php echo (int)$view->stats['post_count'] ?>
                                        <span class="small"><?php echo(isset($view->stats['all_post_count']) ? " (" . (int)$view->stats['all_post_count'] . " total)" : '') ?></span>
                                    </h5>
                                    <div class="card-title-description m-0 p-0 text-black-50"><?php _e("Pages SEO'ed", _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                                <div class="col-sm-7 m-0 p-0" style="min-width: 100px">
                                    <h5 class="m-0 p-0 text-info" style="text-shadow: 1px 1px white;"><?php echo (int)$view->stats['post_types_count'] ?>
                                        <span class="small"><?php echo(isset($view->stats['all_post_types_count']) ? " (" . (int)$view->stats['all_post_types_count'] . " total)" : '') ?></span>
                                    </h5>
                                    <div class="card-title-description m-0 p-0 text-black-50"><?php _e("Post Types Covered", _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 m-0 p-0" style="min-width: 100px">
                            <h3 class="card-title m-0 p-0"><?php echo sprintf(__('%s Aspects', _SQ_PLUGIN_NAME_), '<strong class="text-info" style="font-size: 40px; text-shadow: 1px 1px white;">' . '70' . '</strong>'); ?></h3>
                            <div class="card-title-description m-0 p-0 text-black-50"><?php _e("Handled by Squirrly Genius.", _SQ_PLUGIN_NAME_); ?></div>
                            <div class="card-title-description m-0 p-0 ">
                                <a href="https://howto.squirrly.co/faq/70-aspects-handled-by-squirrly-genius/" target="_blank">(<?php _e("Can I see them?", _SQ_PLUGIN_NAME_); ?>)</a>
                            </div>
                            <?php if (current_user_can('sq_manage_snippets')) { ?>
                                <button type="button" class="btn btn-warning m-0 mt-4 py-1 px-5 center-block sq_seocheck_submit">
                                    <?php echo __('Run SEO Test', _SQ_PLUGIN_NAME_) ?>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="pl-2 pr-0">
                    <div style="width: 220px; height: 300px; overflow: hidden; ">
                        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/squirrly_coffee.png' ?>" style="width: 300px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>