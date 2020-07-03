<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'briefcase'), 'sq_research'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_help_question float-right">
                            <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase" target="_blank"><i class="fa fa-question-circle"></i></a>
                        </div>
                        <div class="sq_icons_content p-3 py-4">
                            <div class="sq_icons sq_briefcase_icon m-2"></div>
                        </div>
                        <h3 class="card-title"><?php _e('Briefcase', _SQ_PLUGIN_NAME_); ?>:</h3>
                        <div class="card-title-description m-2"><?php _e("Briefcase is essential to managing your SEO Strategy. With Briefcase you'll find the best opportunities for keywords you're using in the Awareness Stage, Decision Stage and other stages you may plan for your Customer's Journey.", _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_briefcase" class="card col-sm-12 p-0 tab-panel border-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <?php if (isset($view->keywords) && !empty($view->keywords)) { ?>
                            <div class="row px-3">
                                <form method="get" class="form-inline col-sm-12">
                                    <input type="hidden" name="page" value="<?php echo SQ_Classes_Helpers_Tools::getValue('page') ?>">
                                    <input type="hidden" name="tab" value="<?php echo SQ_Classes_Helpers_Tools::getValue('tab') ?>">
                                    <div class="col-sm-3 p-0">
                                        <h3 class="card-title text-dark p-2"><?php _e('Labels', _SQ_PLUGIN_NAME_); ?>:</h3>
                                    </div>
                                    <div class="col-sm-9 p-0 py-2">
                                        <div class="d-flex flex-row justify-content-end p-0 m-0">
                                            <input type="search" class="d-inline-block align-middle col-sm-7 p-2 mr-2" id="post-search-input" autofocus name="skeyword" value="<?php echo htmlspecialchars(SQ_Classes_Helpers_Tools::getValue('skeyword')) ?>"/>
                                            <input type="submit" class="btn btn-primary" value="<?php echo __('Search Keyword', _SQ_PLUGIN_NAME_) ?>"/>
                                            <?php if (SQ_Classes_Helpers_Tools::getIsset('skeyword') || SQ_Classes_Helpers_Tools::getIsset('slabel')) { ?>
                                                <button type="button" class="btn btn-info ml-1 p-v-xs" onclick="location.href = '<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') ?>';" style="cursor: pointer"><?php echo __('Show All') ?></button>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="sq_filter_label p-2">
                                        <?php if (isset($view->labels) && !empty($view->labels)) {
                                            $keyword_labels = SQ_Classes_Helpers_Tools::getValue('slabel', array());
                                            foreach ($view->labels as $label) {
                                                ?>
                                                <input type="checkbox" name="slabel[]" onclick="form.submit();" id="search_checkbox_<?php echo $label->id ?>" style="display: none;" value="<?php echo $label->id ?>" <?php echo(in_array($label->id, (array)$keyword_labels) ? 'checked' : '') ?> />
                                                <label for="search_checkbox_<?php echo $label->id ?>" class="sq_circle_label fa <?php echo(in_array($label->id, (array)$keyword_labels) ? 'sq_active' : '') ?>" data-id="<?php echo $label->id ?>" style="background-color: <?php echo $label->color ?>" title="<?php echo $label->name ?>"><?php echo $label->name ?></label>
                                                <?php

                                            }
                                        } ?>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                        <div class="card-body p-0">
                            <div class="col-sm-12 m-0 p-0">

                                <div class="card col-sm-12 my-4 mx-0 p-0 border-0">
                                    <?php if (isset($view->keywords) && !empty($view->keywords)) { ?>
                                        <div class="col-5">
                                            <select name="sq_bulk_action" class="sq_bulk_action">
                                                <option value=""><?php echo __('Bulk Actions') ?></option>
                                                <option value="sq_ajax_briefcase_bulk_doserp"><?php echo __('Send to Rank Checker', _SQ_PLUGIN_NAME_); ?></option>
                                                <option value="sq_ajax_briefcase_bulk_label"><?php echo __('Assign Label', _SQ_PLUGIN_NAME_); ?></option>
                                                <option value="sq_ajax_briefcase_bulk_delete" data-confirm="<?php echo __('Ar you sure you want to delete the keywords?', _SQ_PLUGIN_NAME_) ?>"><?php echo __('Delete', _SQ_PLUGIN_NAME_) ?></option>
                                            </select>
                                            <button class="sq_bulk_submit btn btn-sm btn-success"><?php _e('Apply'); ?></button>

                                            <div id="sq_label_manage_popup_bulk" tabindex="-1" class="sq_label_manage_popup modal fade" role="dialog">
                                                <div class="modal-dialog" style="width: 600px;">
                                                    <div class="modal-content bg-light">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><?php echo sprintf(__('Select Labels for: %s', _SQ_PLUGIN_NAME_), __('selected keywords', _SQ_PLUGIN_NAME_)); ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body" style="min-height: 50px; display: table; margin: 10px 20px 10px 20px;">
                                                            <div class="pb-2 mx-2 small text-black-50"><?php echo __('By assigning these labels, you will reset the other labels you assigned for each keyword individually.', _SQ_PLUGIN_NAME_); ?></div>
                                                            <?php if (isset($view->labels) && !empty($view->labels)) {
                                                                foreach ($view->labels as $label) {
                                                                    ?>
                                                                    <input type="checkbox" name="sq_labels[]" class="sq_bulk_labels" id="popup_checkbox_bulk_<?php echo $label->id ?>" style="display: none;" value="<?php echo $label->id ?>"/>
                                                                    <label for="popup_checkbox_bulk_<?php echo $label->id ?>" class="sq_checkbox_label fa" style="background-color: <?php echo $label->color ?>" title="<?php echo $label->name ?>"><?php echo $label->name ?></label>
                                                                    <?php
                                                                }
                                                            } else { ?>
                                                                <a class="btn btn-warning" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'labels') ?>"><?php _e('Add new Label', _SQ_PLUGIN_NAME_); ?></a>
                                                            <?php } ?>
                                                        </div>
                                                        <?php if (isset($view->labels) && !empty($view->labels)) { ?>
                                                            <div class="modal-footer">
                                                                <button class="sq_bulk_submit btn-modal btn btn-success"><?php _e('Save Labels', _SQ_PLUGIN_NAME_); ?></button>
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <table class="table table-striped table-hover mx-0 p-0 ">
                                            <thead>
                                            <tr>
                                                <th style="width: 10px;"></th>
                                                <th style="width: 500px;"><?php echo __('Keyword', _SQ_PLUGIN_NAME_) ?></th>
                                                <th style="width: 120px;"><?php echo __('Usage', _SQ_PLUGIN_NAME_) ?></th>
                                                <th style="width: 130px;">
                                                    <?php
                                                    if ($view->checkin->subscription_serpcheck) {
                                                        echo __('Rank', _SQ_PLUGIN_NAME_);
                                                    } else {
                                                        echo __('Avg Rank', _SQ_PLUGIN_NAME_);
                                                    }
                                                    ?>
                                                </th>
                                                <th style="width: 120px;"><?php echo __('Research', _SQ_PLUGIN_NAME_) ?></th>
                                                <th style="width: 20px;"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($view->keywords as $key => $row) {
                                                $row->rank = false;
                                                if (!empty($view->rankkeywords)) {
                                                    foreach ($view->rankkeywords as $rankkeyword) {
                                                        if (strtolower($rankkeyword->keyword) == strtolower($row->keyword)) {
                                                            if ($view->checkin->subscription_serpcheck) {
                                                                if ((int)$rankkeyword->rank > 0) {
                                                                    $row->rank = $rankkeyword->rank;
                                                                }
                                                            } elseif ((int)$rankkeyword->average_position > 0) {
                                                                $row->rank = $rankkeyword->average_position;
                                                            }
                                                        }
                                                    }
                                                }

                                                ?>
                                                <tr id="sq_row_<?php echo $row->id ?>">
                                                    <td style="width: 10px;">
                                                        <?php if (current_user_can('sq_manage_settings')) { ?>
                                                            <input type="checkbox" name="sq_edit[]" class="sq_bulk_input" value="<?php echo htmlspecialchars(addslashes($row->keyword)) ?>"/>
                                                        <?php } ?>
                                                    </td>
                                                    <td style="width: 500px;">
                                                        <?php if (!empty($row->labels)) {
                                                            foreach ($row->labels as $label) {
                                                                ?>
                                                                <span class="sq_circle_label fa" style="background-color: <?php echo $label->color ?>" data-id="<?php echo $label->lid ?>" title="<?php echo $label->name ?>"></span>
                                                                <?php
                                                            }
                                                        } ?>

                                                        <span style="display: block; clear: left; float: left;"><?php echo $row->keyword ?></span>
                                                    </td>
                                                    <td style="width: 120px;"><?php echo __('in', _SQ_PLUGIN_NAME_) . ' ' . $row->count . ' ' . ($row->count == 1 ? __('post', _SQ_PLUGIN_NAME_) : __('posts', _SQ_PLUGIN_NAME_)) ?></td>
                                                    <td style="width: 130px;">
                                                        <?php if (!$row->rank) { ?>
                                                            <?php echo __('N/A', _SQ_PLUGIN_NAME_) ?>
                                                        <?php } else { ?>
                                                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'rankings', array('strict=1', 'skeyword=' . htmlspecialchars($row->keyword))) ?>" target="_blank" style="font-weight: bold;font-size: 15px;"><?php echo $row->rank ?></a>
                                                        <?php } ?>
                                                    </td>
                                                    <td style="width: 100px;">
                                                        <?php if (isset($row->research->rank->value)) { ?>
                                                            <button data-value="<?php echo $row->research->rank->value ?>" onclick="jQuery('#sq_kr_research<?php echo $key ?>').modal('show');" class="small btn btn-success btn-sm" style="cursor: pointer; width: 120px"><?php echo __('keyword info', _SQ_PLUGIN_NAME_) ?></button>
                                                            <div class="progress" style="max-width: 120px; max-height: 3px">
                                                                <?php
                                                                $progress_color = 'danger';
                                                                switch ($row->research->rank->value) {
                                                                    case ($row->research->rank->value < 4):
                                                                        $progress_color = 'danger';
                                                                        break;
                                                                    case ($row->research->rank->value < 6):
                                                                        $progress_color = 'warning';
                                                                        break;
                                                                    case ($row->research->rank->value < 8):
                                                                        $progress_color = 'info';
                                                                        break;
                                                                    case ($row->research->rank->value <= 10):
                                                                        $progress_color = 'success';
                                                                        break;
                                                                }
                                                                ?>
                                                                <div class="progress-bar bg-<?php echo $progress_color; ?>" role="progressbar" style="width: <?php echo($row->research->rank->value * 10) ?>%" aria-valuenow="<?php echo $row->research->rank->value ?>" aria-valuemin="0" aria-valuemax="10"></div>
                                                            </div>
                                                        <?php } else { ?>
                                                            <button style="cursor: pointer;" class="btn btn-sm btn-default bg-transparent"><?php echo __('No research data', _SQ_PLUGIN_NAME_) ?></button>
                                                        <?php } ?>
                                                    </td>

                                                    <td class="px-0 py-2" style="width: 20px">
                                                        <div class="sq_sm_menu">
                                                            <div class="sm_icon_button sm_icon_options">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </div>
                                                            <div class="sq_sm_dropdown">
                                                                <ul class="p-2 m-0 text-left">
                                                                    <li class="sq_research_selectit border-bottom m-0 p-1 py-2" data-post="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('/post-new.php') ?>" data-keyword="<?php echo htmlspecialchars(addslashes($row->keyword)) ?>">
                                                                        <i class="sq_icons_small sq_sla_icon"></i>
                                                                        <?php echo __('Optimize for this', _SQ_PLUGIN_NAME_) ?>
                                                                    </li>
                                                                    <?php if (current_user_can('sq_manage_settings')) { ?>
                                                                        <?php if (isset($row->do_serp) && !$row->do_serp) { ?>
                                                                            <li class="sq_research_doserp border-bottom m-0 p-1 py-2" data-keyword="<?php echo htmlspecialchars(str_replace('"', '\"', $row->keyword)) ?>">
                                                                                <i class="sq_icons_small sq_ranks_icon"></i>
                                                                                <span><?php echo __('Send to Rank Checker', _SQ_PLUGIN_NAME_) ?></span>
                                                                            </li>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                    <li class="border-bottom m-0 p-1 py-2">
                                                                        <i class="sq_icons_small sq_kr_icon"></i>
                                                                        <?php if ($row->research == '') { ?>
                                                                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research', array('keyword=' . htmlspecialchars($row->keyword))) ?>"><?php echo __('Do a research', _SQ_PLUGIN_NAME_) ?></a>
                                                                        <?php } else { ?>
                                                                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research', array('keyword=' . htmlspecialchars($row->keyword))) ?>"><?php echo __('Refresh Research', _SQ_PLUGIN_NAME_) ?></a>
                                                                        <?php } ?>
                                                                    </li>
                                                                    <li class="border-bottom m-0 p-1 py-2">
                                                                        <i class="sq_icons_small sq_labels_icon"></i>
                                                                        <span onclick="jQuery('#sq_label_manage_popup<?php echo $key ?>').modal('show')"><?php _e('Assign Label', _SQ_PLUGIN_NAME_); ?></span>
                                                                    </li>
                                                                    <?php if (current_user_can('sq_manage_settings')) { ?>
                                                                        <li class="sq_delete m-0 p-1 py-2" data-id="<?php echo $row->id ?>" data-keyword="<?php echo htmlspecialchars(str_replace('"', '\"', $row->keyword)) ?>">
                                                                            <i class="sq_icons_small fa fa-trash-o"></i>
                                                                            <?php echo __('Delete Keyword', _SQ_PLUGIN_NAME_) ?>
                                                                        </li>
                                                                    <?php } ?>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                            </tbody>
                                        </table>

                                        <?php foreach ($view->keywords as $key => $row) { ?>
                                            <div id="sq_kr_research<?php echo $key; ?>" tabindex="-1" class="sq_kr_research modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content bg-light">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><?php echo __('Keyword', _SQ_PLUGIN_NAME_); ?>: <?php echo $row->keyword ?>
                                                                <span style="font-weight: bold; font-size: 110%"></span>
                                                            </h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body" style="min-height: 90px;">
                                                            <ul class="col-sm-12">
                                                                <?php if (!isset($row->country)) $row->country = ''; ?>
                                                                <li class="row py-3 border-bottom">
                                                                    <div class="col-sm-4"><?php echo __('Country', _SQ_PLUGIN_NAME_) ?>:</div>
                                                                    <div class="col-sm-6"><?php echo $row->country ?></div>
                                                                </li>
                                                                <?php if (isset($row->research->sc)) { ?>
                                                                    <li class="row py-3 border-bottom">
                                                                        <div class="col-sm-4"><?php echo __('Competition', _SQ_PLUGIN_NAME_) ?>:</div>
                                                                        <div class="col-sm-6" style="color: <?php echo $row->research->sc->color ?>"><?php echo($row->research->sc->text <> '' ? $row->research->sc->text : __('-', _SQ_PLUGIN_NAME_)) ?></div>
                                                                    </li>
                                                                <?php } ?>
                                                                <?php if (isset($row->research->sv)) {
                                                                    if (isset($row->research->sv->absolute) && is_numeric($row->research->sv->absolute)) {
                                                                        $row->research->sv->absolute = number_format((int)$row->research->sv->absolute, 0, '', '.');
                                                                    }
                                                                    ?>
                                                                    <li class="row py-3 border-bottom">
                                                                        <div class="col-sm-4"><?php echo __('Search Volume', _SQ_PLUGIN_NAME_) ?>:</div>
                                                                        <div class="col-sm-6" style="color: <?php echo $row->research->sv->color ?>"><?php echo($row->research->sv->absolute <> '' ? $row->research->sv->absolute : __('-', _SQ_PLUGIN_NAME_)) ?></div>
                                                                    </li>
                                                                <?php } ?>
                                                                <?php if (isset($row->research->tw)) { ?>
                                                                    <li class="row py-3 border-bottom">
                                                                        <div class="col-sm-4"><?php echo __('Recent discussions', _SQ_PLUGIN_NAME_) ?>:</div>
                                                                        <div class="col-sm-6" style="color: <?php echo $row->research->tw->color ?>"><?php echo($row->research->tw->text <> '' ? $row->research->tw->text : __('-', _SQ_PLUGIN_NAME_)) ?></div>
                                                                    </li>
                                                                <?php } ?>
                                                                <?php if (isset($row->research->td)) { ?>
                                                                    <li class="row py-3">
                                                                        <div class="col-sm-4"><?php echo __('Trending', _SQ_PLUGIN_NAME_) ?>:</div>
                                                                        <div class="col-sm-6" style="color: <?php echo $row->research->td->color ?>">
                                                                            <?php if (isset($row->research->td->absolute) && is_array($row->research->td->absolute) && !empty($row->research->td->absolute)) {
                                                                                $last = 0.1;
                                                                                $datachar = [];
                                                                                foreach ($row->research->td->absolute as $td) {
                                                                                    if ((float)$td > 0) {
                                                                                        $datachar[] = $td;
                                                                                        $last = $td;
                                                                                    } else {
                                                                                        $datachar[] = $last;
                                                                                    }
                                                                                }
                                                                                if (!empty($datachar)) {
                                                                                    $row->research->td->absolute = array_splice($datachar, -7);
                                                                                }
                                                                            } else {
                                                                                $row->research->td->absolute = [0.1, 0.1, 0.1, 0.1, 0.1, 0.1, 0.1];
                                                                            }
                                                                            ?>
                                                                            <div style="width: 60px;height: 30px;">
                                                                                <canvas id="sq_trend<?php echo $key; ?>" class="sq_trend" data-values="<?php echo join(',', $row->research->td->absolute) ?>"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="sq_label_manage_popup<?php echo $key ?>" tabindex="-1" class="sq_label_manage_popup modal fade" role="dialog">
                                                <div class="modal-dialog" style="width: 600px;">
                                                    <div class="modal-content bg-light">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><?php echo sprintf(__('Select Labels for: %s', _SQ_PLUGIN_NAME_), '<strong style="font-size: 115%">' . $row->keyword . '</strong>'); ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body" style="min-height: 50px; display: table; margin: 10px 20px 10px 20px;">
                                                            <?php if (isset($view->labels) && !empty($view->labels)) {

                                                                $keyword_labels = array();
                                                                if (!empty($row->labels)) {
                                                                    foreach ($row->labels as $label) {
                                                                        $keyword_labels[] = $label->lid;
                                                                    }
                                                                }

                                                                foreach ($view->labels as $label) {
                                                                    ?>
                                                                    <input type="checkbox" name="sq_labels" id="popup_checkbox_<?php echo $key ?>_<?php echo $label->id ?>" style="display: none;" value="<?php echo $label->id ?>" <?php echo(in_array($label->id, $keyword_labels) ? 'checked' : '') ?> />
                                                                    <label for="popup_checkbox_<?php echo $key ?>_<?php echo $label->id ?>" class="sq_checkbox_label fa <?php echo(in_array($label->id, $keyword_labels) ? 'sq_active' : '') ?>" style="background-color: <?php echo $label->color ?>" title="<?php echo $label->name ?>"><?php echo $label->name ?></label>
                                                                    <?php
                                                                }

                                                            } else { ?>

                                                                <a class="btn btn-warning" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'labels') ?>"><?php _e('Add new Label', _SQ_PLUGIN_NAME_); ?></a>

                                                            <?php } ?>
                                                        </div>
                                                        <?php if (isset($view->labels) && !empty($view->labels)) { ?>
                                                            <div class="modal-footer">
                                                                <button data-keyword="<?php echo htmlspecialchars(str_replace('"', '\"', $row->keyword)) ?>" class="sq_save_keyword_labels btn btn-success"><?php _e('Save Labels', _SQ_PLUGIN_NAME_); ?></button>
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div>

                                            </div>
                                        <?php } ?>
                                    <?php } elseif (SQ_Classes_Helpers_Tools::getIsset('skeyword') || SQ_Classes_Helpers_Tools::getIsset('slabel')) { ?>
                                        <div class="card-body">
                                            <h3 class="text-center"><?php echo $view->error; ?></h3>
                                        </div>
                                    <?php } else { ?>

                                        <div class="card-body">
                                            <h4 class="text-center"><?php echo __('Welcome to Squirrly Briefcase'); ?></h4>
                                            <div class="col-sm-12 m-2 text-center">
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') ?>" class="btn btn-lg btn-primary">
                                                    <i class="fa fa-plus-square-o"></i> <?php echo __('Go Find New Keywords'); ?>
                                                </a>

                                                <div class="col-sm-12 mt-5 mx-2">
                                                    <h5 class="text-left my-3 text-info"><?php echo __('Tips: How to add Keywords in Briefcase?'); ?></h5>
                                                    <ul>
                                                        <li class="text-left" style="font-size: 15px;"><?php echo sprintf(__("From %sKeyword Research%s send keywords to Briefcase."), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '" >', '</a>'); ?></li>
                                                        <li class="text-left" style="font-size: 15px;"><?php echo sprintf(__("From Briefcase you can use the keywords in %sSquirrly Live Assistant%s to optimize your pages."), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant', 'assistant') . '" >', '</a>'); ?></li>
                                                        <li class="text-left" style="font-size: 15px;"><?php echo __("If you already have a list of keywords, Import the keywords usign the below button."); ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if (current_user_can('sq_manage_settings')) { ?>
                                        <div class="col-sm-12 row py-2 mx-0 my-3 mt-4 pt-4 border-bottom-0 border-top">
                                            <div class="col-sm-8 p-0 pr-3">
                                                <div class="font-weight-bold"><?php _e('Backup/Restore Briefcase Keywords', _SQ_PLUGIN_NAME_); ?>:</div>
                                                <div class="small text-black-50"><?php echo __('Keep your briefcase keywords safe in case you change your domain or reinstall the plugin', _SQ_PLUGIN_NAME_); ?></div>
                                                <div class="small text-black-50"><?php echo sprintf(__('%sLearn how to import keywords into briefcase%s', _SQ_PLUGIN_NAME_), '<a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_backup_keywords" target="_blank">', '</a>'); ?></div>
                                            </div>
                                            <div class="col-sm-4 p-0 text-center">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_briefcase_backup', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_briefcase_backup"/>
                                                    <button type="submit" class="btn rounded-0 btn-success my-1 px-2 mx-2 noloading" style="min-width: 175px"><?php _e('Download Keywords', _SQ_PLUGIN_NAME_); ?></button>
                                                </form>
                                                <div>
                                                    <button type="button" class="btn rounded-0 btn-success my-1 px-2 mx-2" style="min-width: 175px" onclick="jQuery('.sq_briefcase_restore_dialog').modal('show')" data-dismiss="modal"><?php _e('Import Keywords', _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                                <div class="sq_briefcase_restore_dialog modal fade" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content bg-light">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title"><?php _e('Restore Briefcase Keywords', _SQ_PLUGIN_NAME_); ?></h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form name="import" action="" method="post" enctype="multipart/form-data">
                                                                    <div class="col-sm-12 row py-2 mx-0 my-3">
                                                                        <div class="col-sm-4 p-0 pr-3">
                                                                            <div class="font-weight-bold"><?php _e('Restore Keywords', _SQ_PLUGIN_NAME_); ?>:</div>
                                                                            <div class="small text-black-50"><?php echo __('Upload the file with the saved Squirrly Briefcase Keywords.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                        <div class="col-sm-8 p-0 input-group">
                                                                            <div class="col-sm-8 form-group m-0 p-0 my-2">
                                                                                <input type="file" class="form-control-file" name="sq_upload_file">
                                                                            </div>
                                                                            <div class="col-sm-4 form-group m-0 p-0 my-2">
                                                                                <?php SQ_Classes_Helpers_Tools::setNonce('sq_briefcase_restore', 'sq_nonce'); ?>
                                                                                <input type="hidden" name="action" value="sq_briefcase_restore"/>
                                                                                <button type="submit" class="btn rounded-0 btn-success btn-sm px-3 mx-2"><?php _e('Upload', _SQ_PLUGIN_NAME_); ?></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                    <div class="card-body f-gray-dark p-0">
                        <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                        <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>