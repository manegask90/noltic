<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php echo $view->getScripts(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row flex-nowrap my-0 bg-nav" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_focuspages')) {
            echo '<div class="col-sm-12 alert alert-success text-center m-0 p-3">' . __("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAuditTabs(); ?>

        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-sm-12 p-0">

                    <div class="card-body p-2 bg-title rounded-top row">
                        <div class="col-sm-10 text-left m-0 p-0">
                            <div class="sq_icons_content p-3 py-4">
                                <div class="sq_icons sq_audit_icon m-2"></div>
                            </div>
                            <h3 class="card-title"><?php _e('Audit Details', _SQ_PLUGIN_NAME_); ?>:</h3>
                            <div class="card-title-description m-2"><?php _e('Verifies the online presence of your website by knowing how your website is performing in terms of Blogging, SEO, Social, Authority, Links, and Traffic', _SQ_PLUGIN_NAME_); ?></div>
                        </div>

                    </div>

                    <?php if ($view->audit) { ?>

                        <div id="sq_audit" class="card col-sm-12 p-0 tab-panel border-0">
                            <div class="card-content" style="min-height: 150px">
                                <?php if (SQ_Classes_Helpers_Tools::getValue('sid', false)) { ?>
                                    <div class="form-group text-right col-sm-12 p-0 m-0 mb-3">
                                        <div class="sq_serp_settings_button mx-2 my-0 p-0" style="margin-top:-70px !important">
                                            <button type="button" class="btn btn-info p-v-xs" onclick="location.href = '<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'audits') ?>';" style="cursor: pointer"><?php echo __('Show All') ?></button>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php echo $view->getView('Audits/AuditStats'); ?>


                                <ul class="sq_audit_tasks">
                                    <?php
                                    if(!empty($view->audit->groups)) {
                                        foreach ($view->audit->groups as $name => $group) {
                                            ?>
                                            <li onclick="var headertop = jQuery('#sq_audit_tasks_header_<?php echo $name ?>').offset().top;
                                                    jQuery('html,body').animate({scrollTop: headertop - 50}, 1000);">
                                                <span class="sq_audit_task_completed <?php echo $group->color ?>"><?php echo $group->colorname ?></span>
                                                <span class="sq_audit_task_title"><?php echo ucfirst($name) ?></a></span>
                                            </li>
                                        <?php }
                                    }?>
                                </ul>

                                <div class="sq_separator"></div>


                                <table class="table">
                                    <tr class="sq_audit_tasks_row">
                                        <td class="sq_audit_tasks_title text-right" style="vertical-align: middle; min-width: 170px;"><?php echo __('Audit Pages', _SQ_PLUGIN_NAME_) ?></td>
                                        <td class="sq_audit_tasks_description text-left">
                                            <ul class="p-1 m-0 sq_audit_pages" style="max-height: 200px; overflow-y: auto;">
                                                <?php foreach ($view->audit->urls as $url) { ?>
                                                    <li>
                                                        <a href="<?php echo $url ?>" target="_blank"><?php echo $url ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>


                                <div class="sq_separator"></div>


                                <div class="card col-sm-12 p-0 m-0 border-0 shadow-none">
                                    <div class="col-sm-12 text-center row p-0 m-0">
                                        <div class="col-sm-6 m-0 p-2 text-right">
                                            <button class="sq_audit_completed_tasks btn btn-sm btn-success px-3">
                                                <i class="fa fa-check-circle-o mr-2 py-2"></i><?php echo __('Show Only Completed Tasks', _SQ_PLUGIN_NAME_) ?>
                                            </button>
                                        </div>
                                        <div class="col-sm-6 m-0 p-2 text-left">
                                            <button class="sq_audit_incompleted_tasks btn btn-sm btn-danger px-3">
                                                <i class="fa fa-circle-o mr-2 py-2"></i><?php echo __('Show Only Incompleted Tasks', _SQ_PLUGIN_NAME_) ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="sq_separator"></div>


                                <?php foreach ($view->audit->audit as $group => $audit) {
                                    if(!isset($view->audit->groups->$group)){
                                        continue;
                                    }
                                    $current_group = $view->audit->groups->$group; ?>
                                    <?php if ($current_group->total > 0) { ?>
                                        <div class="persist-area">
                                            <ul class="sq_audit_list p-3 m-0">
                                                <li>
                                                    <table class="p-0 m-0 mb-3">
                                                        <tr>
                                                            <td id="sq_audit_tasks_header_<?php echo $group ?>" class="sq_audit_tasks_header" colspan="4">
                                                                <span class="persist-header sq_audit_tasks_header_title <?php echo $current_group->color . '_text' ?>" data-id="<?php echo $group ?>"><?php echo ucfirst($group) ?></span>
                                                                <span class="sq_audit_task_completed <?php echo $current_group->color ?>"><?php echo $current_group->complete ?>/<?php echo $current_group->total ?></span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div class="sq_separator"></div>
                                                    <ul>
                                                        <?php if (!empty($audit)) {
                                                            foreach ($audit as $key => $task) {
                                                                ?>
                                                                <li class="sq_audit_tasks_row m-0 p-0 py-4 sq_audit_task_complete_<?php echo (int)$task->complete ?>">
                                                                    <table>
                                                                        <tr>
                                                                            <td rowspan="2" class="sq_first_header_column text-center">
                                                                                <span class="<?php echo ((int)$task->complete == 1) ? 'sq_audit_tasks_pass' : 'sq_audit_tasks_fail' ?>"></span>
                                                                            </td>
                                                                            <td style="vertical-align: middle" class="sq_second_header_column text-left">
                                                                                <span class="sq_audit_tasks_title"><?php echo $task->title ?></span>
                                                                                <span class="sq_audit_tasks_value sq_audit_tasks_value<?php echo ((int)$task->complete == 1) ? '_pass' : '_fail' ?>">
                                                                                <?php echo ($task->complete) ? $task->success : $task->fail ?>
                                                                            </span>
                                                                            </td>
                                                                        </tr>

                                                                        <?php if ($task->description) { ?>
                                                                            <tr>
                                                                                <td class="sq_audit_tasks_description sq_second_column">
                                                                                    <?php echo $task->description; ?>
                                                                                    <?php if ($task->protip <> '') { ?>
                                                                                        <div class="my-3 p-0">
                                                                                            <strong class="text-info"><?php echo __('PRO TIP', _SQ_PLUGIN_NAME_) ?>:</strong> <?php echo $task->protip ?>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>

                                                                    </table>
                                                                </li>
                                                            <?php }
                                                        } ?>
                                                    </ul>
                                                </li>
                                            </ul>

                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

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
