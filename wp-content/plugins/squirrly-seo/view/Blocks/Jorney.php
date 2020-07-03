<div id="sq_journey">
    <?php if ($view->days) { ?>
        <div class="card col-sm-12 my-3 p-0">
            <div class="card-body m-0 p-0">
                <div class="row text-left m-0 p-0">
                    <div class="row text-left m-0 p-0">
                        <div class="px-2 py-3" style="max-width: 350px;width: 40%;">
                            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/onboarding/racing_car.png' ?>" style="width: 100%">
                        </div>
                        <div class="col-sm px-2 py-3">
                            <div class="col-sm-12 m-0 p-0">
                                <h3 class="card-title" style="color: green;"><?php _e('14 Days Journey Course', _SQ_PLUGIN_NAME_); ?>:</h3>
                            </div>

                            <div class="sq_separator"></div>
                            <div class="col-sm-12 m-2 p-0">
                                <div class="my-2"><?php echo sprintf(__("Follow the %sdaily recipe%s from below.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></div>
                                <div class="my-2"><?php echo sprintf(__("%sJoin%s the rest of the %sJourneyTeam on the Facebook Group%s and if you want you can share with the members that you have started your Journey.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<strong><a href="https://www.facebook.com/groups/SquirrlySEOCustomerService/" target="_blank" >', '</a></strong>'); ?></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="sq_separator"></div>
                <div class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0">
                    <div class="card-body p-0">
                        <div class="col-sm-12 m-0 p-0">
                            <div class="card col-sm-12 m-0 p-0 border-0 ">

                                <div class="col-sm-12 m-0 p-3 text-center">
                                    <?php if ($view->days > 14) { ?>
                                        <h5 class="col-sm-12 card-title py-3 "><?php _e("Congratulations! You've completed the 14 Days Journey To Better Ranking", _SQ_PLUGIN_NAME_); ?></h5>
                                    <?php } else { ?>
                                        <h2 class="col-sm-12 card-title py-3 "><?php _e("Your 14 Days Journey To Better Ranking", _SQ_PLUGIN_NAME_); ?></h2>
                                    <?php } ?>

                                    <ul class="stepper horizontal horizontal-fix focused" id="horizontal-stepper-fix">
                                        <?php for ($i = 1; $i <= 14; $i++) { ?>
                                            <li class="step <?php echo(($view->days >= $i) ? 'completed' : '') ?>">
                                                <div class="step-title waves-effect waves-dark">
                                                    <?php echo(($view->days >= $i) ? '<a href="https://howto.squirrly.co/wordpress-seo/journey-to-better-ranking-day-' . $i . '/" target="_blank"><i class="fa fa-check-circle" style="color: darkcyan;"></i></a>' : '<i class="fa fa-circle-o"  style="color: darkgrey;"></i>') ?>
                                                    <div><?php echo(($view->days >= $i) ? '<a href="https://howto.squirrly.co/wordpress-seo/journey-to-better-ranking-day-' . $i . '/" target="_blank">' . __('Day', _SQ_PLUGIN_NAME_) . ' ' . $i . '</a>' : __('Day', _SQ_PLUGIN_NAME_) . ' ' . $i) ?></div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>

                                    <?php if ($view->days > 14) { ?>
                                        <em class="text-black-50"><?php echo __("If you missed a day, click on it and read the SEO recipe for it.", _SQ_PLUGIN_NAME_); ?></em>
                                        <div class="small text-center my-2">
                                            <form method="post" class="p-0 m-0">
                                                <?php SQ_Classes_Helpers_Tools::setNonce('sq_journey_close', 'sq_nonce'); ?>
                                                <input type="hidden" name="action" value="sq_journey_close"/>
                                                <button type="submit" class="btn btn-sm text-info btn-link bg-transparent p-0 m-0">
                                                    <?php echo __("I'm all done. Hide this block.", _SQ_PLUGIN_NAME_) ?>
                                                </button>
                                            </form>
                                        </div>
                                    <?php } else { ?>
                                        <a href="https://howto.squirrly.co/wordpress-seo/journey-to-better-ranking-day-<?php echo $view->days ?>/" target="_blank" class="btn btn-primary m-2 py-2 px-4" style="font-size: 20px;"><?php echo __('Day', _SQ_PLUGIN_NAME_) . ' ' . $view->days . ': ' . __("Open the SEO recipe for today", _SQ_PLUGIN_NAME_); ?></a>
                                        <?php
                                        switch ($view->days) {
                                            case 1:
                                                ?>
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'addpage') ?>" target="_blank" class="btn btn-success m-2 py-2 px-4" style="font-size: 20px;"><?php echo __("Add a page in Focus Pages", _SQ_PLUGIN_NAME_); ?></a><?php
                                                break;
                                            case 2:
                                                ?>
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') ?>" target="_blank" class="btn btn-success m-2 py-2 px-4" style="font-size: 20px;"><?php echo __("Do Keyword Research", _SQ_PLUGIN_NAME_); ?></a><?php
                                                break;
                                        }
                                        ?>
                                    <?php } ?>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    <?php } else { ?>
        <div class="col-sm-12 my-3 py-3" style="box-shadow: 0 0 10px -3px #994525;">
            <div class="row text-left m-0 p-0">
                <div class="row text-left m-0 p-0">
                    <div class="px-2 py-3" style="max-width: 350px;width: 40%;">
                        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/onboarding/racing_car.png' ?>" style="width: 100%">
                    </div>
                    <div class="col-sm px-2 py-3">
                        <div class="col-sm-12 m-0 p-0">
                            <h3 class="card-title" style="color: green;"><?php _e('14 Days Journey Course', _SQ_PLUGIN_NAME_); ?>:</h3>
                        </div>

                        <div class="sq_separator"></div>
                        <div class="col-sm-12 m-2 p-0">
                            <div class="card-title-description m-2 text-black-50"><?php _e("All you need now is to start driving One of your most valuable pages to Better Rankings.", _SQ_PLUGIN_NAME_); ?></div>
                        </div>
                        <div class="col-sm-12 m-0 p-3 text-center">
                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step2.1') ?>" class="btn btn-sm btn-success m-0 py-2 px-4"><?php echo __("I'm ready to start the Journey To Better Ranking", _SQ_PLUGIN_NAME_); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
