<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'labels'), 'sq_research'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_help_question float-right"><a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#labels" target="_blank"><i class="fa fa-question-circle"></i></a></div>
                        <div class="sq_icons_content p-3 py-4">
                            <div class="sq_icons sq_labels_icon m-2"></div>
                        </div>
                        <h3 class="card-title"><?php _e('Briefcase Labels', _SQ_PLUGIN_NAME_); ?>:</h3>
                        <div class="card-title-description m-2"><?php _e("Briefcase Labels will help you sort your keywords based on your SEO strategy. Labels are like categories and you can quickly filter your keywords by one or more labels.", _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_briefcaselabels" class="card col-sm-12 p-0 tab-panel border-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <button class="btn btn-lg btn-warning text-white col-sm-3 ml-3" onclick="jQuery('.sq_add_labels_dialog').modal('show')" data-dismiss="modal"><i class="fa fa-plus-square-o"></i> <?php _e('Add new Label', _SQ_PLUGIN_NAME_); ?></button>
                        <div class="sq_add_labels_dialog modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content bg-light">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><?php _e('Add New Label', _SQ_PLUGIN_NAME_); ?></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="sq_labelname"><?php _e('Label Name', _SQ_PLUGIN_NAME_); ?></label>
                                            <input type="text" class="form-control" id="sq_labelname" maxlength="35"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="sq_labelcolor" style="display: block"><?php _e('Label Color', _SQ_PLUGIN_NAME_); ?></label>
                                            <input type="text" id="sq_labelcolor" value="<?php echo sprintf('#%06X', mt_rand(0, 0xFFFFFF)); ?>"/>
                                        </div>


                                    </div>
                                    <div class="modal-footer" style="border-bottom: 1px solid #ddd;">
                                        <button type="button" id="sq_save_label" class="btn btn-success"><?php _e('Add Label', _SQ_PLUGIN_NAME_); ?></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="sq_edit_label_dialog modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content bg-light">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><?php _e('Edit Label', _SQ_PLUGIN_NAME_); ?></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="sq_labelname"><?php _e('Label Name', _SQ_PLUGIN_NAME_); ?></label>
                                            <input type="text" class="form-control" id="sq_labelname" maxlength="35"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="sq_labelcolor"><?php _e('Label Color', _SQ_PLUGIN_NAME_); ?></label>
                                            <input type="text" id="sq_labelcolor"/>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" id="sq_labelid"/>
                                        <button type="button" id="sq_save_label" class="btn btn-success"><?php _e('Save Label', _SQ_PLUGIN_NAME_); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="card col-sm-12 my-4 p-0 border-0">
                                    <?php if (is_array($view->labels) && !empty($view->labels)) { ?>
                                        <div class="col-3">
                                            <select name="sq_bulk_action" class="sq_bulk_action">
                                                <option value=""><?php echo __('Bulk Actions') ?></option>
                                                <option value="sq_ajax_labels_bulk_delete" data-confirm="<?php echo __('Ar you sure you want to delete the labels?', _SQ_PLUGIN_NAME_) ?>"><?php echo __('Delete', _SQ_PLUGIN_NAME_) ?></option>
                                            </select>
                                            <button class="sq_bulk_submit btn btn-sm btn-success"><?php _e('Apply'); ?></button>
                                        </div>

                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th style="width: 10px;"></th>
                                                <th style="width: 70%;"><?php echo __('Name', _SQ_PLUGIN_NAME_) ?></th>
                                                <th scope="col" title="<?php _e('Color', _SQ_PLUGIN_NAME_) ?>"><?php _e('Color', _SQ_PLUGIN_NAME_) ?></th>
                                                <th style="width: 20px;"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($view->labels as $key => $row) {
                                                ?>
                                                <tr id="sq_row_<?php echo $row->id ?>">
                                                    <td style="width: 10px;">
                                                        <?php if (current_user_can('sq_manage_settings')) { ?>
                                                            <input type="checkbox" name="sq_edit[]" class="sq_bulk_input" value="<?php echo $row->id ?>"/>
                                                        <?php } ?>
                                                    </td>
                                                    <td style="width: 50%;" class="text-left">
                                                        <?php echo $row->name ?>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <span style="display: block; float: left; background-color:<?php echo $row->color ?>; width: 20px;height: 20px; margin-right: 5px;"></span><?php echo $row->color ?>
                                                    </td>

                                                    <td class="px-0 py-2" style="width: 20px">
                                                        <div class="sq_sm_menu">
                                                            <div class="sm_icon_button sm_icon_options">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </div>
                                                            <div class="sq_sm_dropdown">
                                                                <ul class="text-left p-2 m-0">
                                                                    <li class="sq_edit_label border-bottom m-0 p-1 py-2" data-id="<?php echo $row->id ?>" data-name="<?php echo $row->name ?>" data-color="<?php echo $row->color ?>">
                                                                        <i class="sq_icons_small sq_labels_icon"></i>
                                                                        <?php echo __('Edit Label', _SQ_PLUGIN_NAME_) ?>
                                                                    </li>
                                                                    <?php if (current_user_can('sq_manage_settings')) { ?>
                                                                        <li class="sq_delete_label m-0 p-1 py-2" data-id="<?php echo $row->id ?>">
                                                                            <i class="sq_icons_small fa fa-trash-o"></i>
                                                                            <?php echo __('Delete Label', _SQ_PLUGIN_NAME_) ?>
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
                                            <h4 class="text-center"><?php echo __('Welcome to Briefcase Labels'); ?></h4>
                                            <div class="col-sm-12 mt-5 mx-2">
                                                <h5 class="text-left my-3 text-info"><?php echo __('TIPS: How Should I Create My Labels?'); ?></h5>
                                                <ul>
                                                    <li onclick="jQuery('.sq_add_labels_dialog').modal('show')"  style="font-size: 15px;"><?php echo sprintf(__("Click on %sAdd New Label%s button, add a label name and choose a color for it."),'<strong style="cursor: pointer">','</strong>'); ?></li>
                                                    <li style="font-size: 15px;"><a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#labels" target="_blank"><?php echo __("Read more details about Briefcase Labels"); ?></a></li>
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