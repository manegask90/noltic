<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'sq_rankings'), 'sq_rankings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons_content p-3 py-4">
                            <div class="sq_icons sq_rankings_icon m-2"></div>
                        </div>
                        <h3 class="card-title"><?php _e('Google Search Console Keywords Sync', _SQ_PLUGIN_NAME_); ?>:</h3>
                        <div class="card-title-description m-2"><?php _e("See the trending keywords suitable for your website's future topics. We check for new keywords weekly based on your latest researches.", _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_keywords" class="card col-sm-12 p-0 tab-panel border-0">
                        <div class="alert alert-success text-center">
                            <?php echo __("This is the list of keywords you have in Google Search Console. Information for the last 90 days. You can add keywords that you find relevant to your Briefcase and to the Rankings section.", _SQ_PLUGIN_NAME_);?>
                        </div>


                        <div class="card-body p-0">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="card col-sm-12 my-4 p-0 px-3 border-0 ">
                                    <?php if (is_array($view->suggested) && !empty($view->suggested)) { ?>
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th style="width: 30%;"><?php echo __('Keyword', _SQ_PLUGIN_NAME_) ?></th>
                                                <th scope="col" title="<?php _e('Clicks', _SQ_PLUGIN_NAME_) ?>"><?php _e('Clicks', _SQ_PLUGIN_NAME_) ?></th>
                                                <th scope="col" title="<?php _e('Impressions', _SQ_PLUGIN_NAME_) ?>"><?php _e('Impressions', _SQ_PLUGIN_NAME_) ?></th>
                                                <th scope="col" title="<?php _e('Click-Through Rate', _SQ_PLUGIN_NAME_) ?>"><?php _e('CTR', _SQ_PLUGIN_NAME_) ?></th>
                                                <th scope="col" title="<?php _e('Average Position', _SQ_PLUGIN_NAME_) ?>"><?php _e('AVG Position', _SQ_PLUGIN_NAME_) ?></th>
                                                <th style="width: 20px;"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($view->suggested as $key => $row) {
                                                $in_briefcase = false;
                                                if (!empty($view->keywords))
                                                    foreach ($view->keywords as $krow) {
                                                        if (trim(strtolower($krow->keyword)) == trim(strtolower($row->keywords))) {
                                                            $in_briefcase = true;
                                                            break;
                                                        }
                                                    }

                                                ?>
                                                <tr class="<?php echo($in_briefcase ? 'bg-briefcase' : '') ?>">
                                                    <td style="width: 280px;">
                                                        <span style="display: block; clear: left; float: left;"><?php echo $row->keywords ?></span>
                                                    </td>
                                                    <td>
                                                        <span style="display: block; clear: left; float: left;"><?php echo $row->clicks ?></span>
                                                    </td>
                                                    <td>
                                                        <span style="display: block; clear: left; float: left;"><?php echo $row->impressions ?></span>
                                                    </td>
                                                    <td>
                                                        <span style="display: block; clear: left; float: left;"><?php echo number_format($row->ctr, 2) ?></span>
                                                    </td>
                                                    <td>
                                                        <span style="display: block; clear: left; float: left;"><?php echo $row->position ?></span>
                                                    </td>
                                                    <td class="px-0 py-2" style="width: 20px">
                                                        <div class="sq_sm_menu">
                                                            <div class="sm_icon_button sm_icon_options">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </div>
                                                            <div class="sq_sm_dropdown">
                                                                <ul class="text-left p-2 m-0 ">
                                                                    <?php if ($in_briefcase) { ?>
                                                                        <li class="bg-briefcase m-0 p-1 py-2 text-black-50">
                                                                            <i class="sq_icons_small sq_briefcase_icon"></i>
                                                                            <?php _e('Already in briefcase', _SQ_PLUGIN_NAME_); ?>
                                                                        </li>
                                                                    <?php } else { ?>
                                                                        <li class="sq_research_add_briefcase m-0 p-1 py-2" data-hidden="0" data-doserp="1" data-keyword="<?php echo htmlspecialchars(str_replace('"', '\"', $row->keywords)) ?>">
                                                                            <i class="sq_icons_small sq_briefcase_icon"></i>
                                                                            <?php _e('Add to briefcase', _SQ_PLUGIN_NAME_); ?>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="card-body">
                                            <h4 class="text-center"><?php echo __('Welcome to Google Search Console Keywords Sync'); ?></h4>

                                            <div class="col-sm-12 mt-5 mx-2">
                                                <div><?php echo sprintf(__("If you're new to SEO, you probably don't know yet how slow Google actually is with regard to crawling and gathering data about sites which are not as big as The New York Times, Amazon.com, etc. %s Here are some resources. %s We could not find any keywords from your GSC account, because Google doesn't have enough data about your site yet. %s Give Google more time to learn about your site. Until then, keep working on your Daily SEO Goals from Squirrly SEO."), '<br /><br /><a href="https://www.squirrly.co/seo/kit/" target="_blank">','</a><br /><br />', '<br /><br />'); ?></div>
                                            </div>
                                            <div class="col-sm-12 mt-5 mx-2">
                                                <h5 class="text-left my-3 text-info"><?php echo __('Tips: Which Keyword Should I Choose?'); ?></h5>
                                                <ul>
                                                    <li class="text-left" style="font-size: 15px;"><?php echo sprintf(__("From %sSquirrly Briefcase%s you can send keywords to Rank Checker to track the SERP evolution."), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') . '" >', '</a>');  ?></li>
                                                </ul>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
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
