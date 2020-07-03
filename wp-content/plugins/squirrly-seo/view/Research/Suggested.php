<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'suggested'), 'sq_research'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons_content p-3 py-4">
                            <div class="sq_icons sq_suggested_icon m-2"></div>
                        </div>
                        <h3 class="card-title"><?php _e('Suggested', _SQ_PLUGIN_NAME_); ?>:</h3>
                        <div class="card-title-description m-2"><?php _e("See the trending keywords suitable for your website's future topics. We check for new keywords weekly based on your latest researches.", _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_suggested" class="card col-sm-12 p-0 tab-panel border-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-0">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="card col-sm-12 my-4 p-0 px-3 border-0 ">
                                    <?php if (is_array($view->suggested) && !empty($view->suggested)) { ?>
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th style="width: 30%;"><?php echo __('Keyword', _SQ_PLUGIN_NAME_) ?></th>
                                                <th scope="col" title="<?php _e('Country', _SQ_PLUGIN_NAME_) ?>"><?php _e('Co', _SQ_PLUGIN_NAME_) ?></th>
                                                <th style="width: 150px;">
                                                    <i class="fa fa-users" title="<?php echo __('Competition', _SQ_PLUGIN_NAME_) ?>"></i>
                                                    <?php echo __('Competition', _SQ_PLUGIN_NAME_) ?>
                                                </th>
                                                <th style="width: 80px;">
                                                    <i class="fa fa-search" title="<?php echo __('SEO Search Volume', _SQ_PLUGIN_NAME_) ?>"></i>
                                                    <?php echo __('SV', _SQ_PLUGIN_NAME_) ?>
                                                </th>
                                                <th style="width: 135px;">
                                                    <i class="fa fa-comments-o" title="<?php echo __('Recent discussions', _SQ_PLUGIN_NAME_) ?>"></i>
                                                    <?php echo __('Discussion', _SQ_PLUGIN_NAME_) ?>
                                                </th>
                                                <th style="width: 100px;">
                                                    <i class="fa fa-bar-chart" title="<?php echo __('Trending', _SQ_PLUGIN_NAME_) ?>"></i>
                                                    <?php echo __('Trend', _SQ_PLUGIN_NAME_) ?>
                                                </th>
                                                <th style="width: 20px;"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($view->suggested as $key => $row) {
                                                $research = '';
                                                $keyword_labels = array();

                                                if ($row->data <> '') {
                                                    $research = json_decode($row->data);

                                                    if (isset($research->sv->absolute) && is_numeric($research->sv->absolute)) {
                                                        $research->sv->absolute = number_format((int)$research->sv->absolute, 0, '', '.');
                                                    }
                                                }

                                                $in_briefcase = false;
                                                if (!empty($view->keywords))
                                                    foreach ($view->keywords as $krow) {
                                                        if (trim(strtolower($krow->keyword)) == trim(strtolower($row->keyword))) {
                                                            $in_briefcase = true;
                                                            break;
                                                        }
                                                    }
                                                ?>
                                                <tr id="sq_row_<?php echo $row->id ?>" class="<?php echo($in_briefcase ? 'bg-briefcase' : '') ?>">
                                                    <td style="width: 280px;">
                                                        <span style="display: block; clear: left; float: left;"><?php echo $row->keyword ?></span>
                                                    </td>
                                                    <td>
                                                        <span style="display: block; clear: left; float: left;"><?php echo $row->country ?></span>
                                                    </td>
                                                    <td style="width: 150px;">
                                                        <?php if (isset($research->sc)) { ?>
                                                            <span style="color: <?php echo $research->sc->color ?>" title="<?php echo __('Competition', _SQ_PLUGIN_NAME_) ?>"><?php echo($research->sc->text <> '' ? $research->sc->text : __('-', _SQ_PLUGIN_NAME_)) ?></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td style="width: 80px;">
                                                        <?php if (isset($research->sv)) { ?>
                                                            <span style="color: <?php echo $research->sv->color ?>" title="<?php echo __('SEO Search Volume', _SQ_PLUGIN_NAME_) ?>"><?php echo($research->sv->absolute <> '' ? $research->sv->absolute : __('-', _SQ_PLUGIN_NAME_)) ?></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td style="width: 130px;">
                                                        <?php if (isset($research->tw)) { ?>
                                                            <span style="color: <?php echo $research->tw->color ?>" title="<?php echo __('Recent discussions', _SQ_PLUGIN_NAME_) ?>"><?php echo($research->tw->text <> '' ? $research->tw->text : __('-', _SQ_PLUGIN_NAME_)) ?></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td style="width: 100px;">
                                                        <?php if (isset($research->td)) { ?>
                                                            <?php
                                                            if (isset($research->td->absolute) && is_array($research->td->absolute) && !empty($research->td->absolute)) {
                                                                $last = 0.1;
                                                                $datachar = [];
                                                                foreach ($research->td->absolute as $td) {
                                                                    if ((float)$td > 0) {
                                                                        $datachar[] = $td;
                                                                        $last = $td;
                                                                    } else {
                                                                        $datachar[] = $last;
                                                                    }
                                                                }
                                                                if (!empty($datachar)) {
                                                                    $research->td->absolute = array_splice($datachar, -7);
                                                                }
                                                            } else {
                                                                $research->td->absolute = [0.1, 0.1, 0.1, 0.1, 0.1, 0.1, 0.1];
                                                            }
                                                            ?>
                                                            <div style="width: 60px;height: 30px;">
                                                                <canvas class="sq_trend" data-values="<?php echo join(',', $research->td->absolute) ?>"></canvas>
                                                            </div>

                                                        <?php } ?>
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
                                                                        <li class="sq_research_add_briefcase m-0 p-1 py-2" data-keyword="<?php echo htmlspecialchars(str_replace('"', '\"', $row->keyword)) ?>">
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
                                            <h4 class="text-center"><?php echo __('Welcome to Suggested Keywords'); ?></h4>
                                            <h5 class="text-center"><?php echo __('Once a week, Squirrly checks all the keywords from your briefcase.'); ?></h5>
                                            <h5 class="text-center"><?php echo __('If it finds better keywords, they will be listed here'); ?></h5>
                                            <h6 class="text-center text-black-50 mt-3"><?php echo __('Until then, add keywords in Briefcase'); ?>:</h6>
                                            <div class="col-sm-12 my-4 text-center">
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') ?>" class="btn btn-lg btn-primary">
                                                    <i class="fa fa-plus-square-o"></i> <?php echo __('Go Find New Keywords'); ?>
                                                </a>
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
