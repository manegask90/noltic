<div id="sq_wrap">
    <style>.modal-footer .sq_save_ajax {
            display: none !important;
        }</style>
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

                    <div id="sq_audit" class="card col-sm-12 p-0 tab-panel border-0">
                        <div class="card-content" style="min-height: 150px">
                            <?php if (!empty($view->audits)) {
                                //set the first audit as referrence
                                $view->audit = current($view->audits);

                                //get the modal window for the assistant popup
                                echo SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->getModal();
                                ?>
                                <div class="form-group text-right col-sm-12 p-0 m-0 mb-3">
                                    <div class="sq_serp_settings_button mx-2 my-0 p-0" style="margin-top:-70px !important">
                                        <button type="button" class="btn btn-info p-v-xs" onclick="location.href = '<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'audits') ?>';" style="cursor: pointer"><?php echo __('Show All') ?></button>
                                    </div>
                                </div>

                                <ul class="px-3 m-0">
                                    <li class="sq_audit_tasks_row border-0">
                                        <table>
                                            <tr>

                                                <td style="vertical-align: middle" class="sq_second_header_column px-3 text-left">
                                                    <span class="sq_audit_tasks_title"><?php echo __('Scores') ?></span>
                                                </td>

                                                <?php

                                                if (isset($view->audits)) {
                                                    foreach ($view->audits as $all) {
                                                        $color = false;
                                                        if ((int)$all->score > 0) {
                                                            $color = '#dd3333';
                                                            if (((int)$all->score >= 50)) $color = 'orange';
                                                            if (((int)$all->score >= 90)) $color = '#20bc49';
                                                        }

                                                        ?>
                                                        <td rowspan="2" class="sq_first_header_column text-center px-3">


                                                            <div class="col-sm-12">
                                                                <input id="knob_<?php echo $all->id ?>" type="text" value="<?php echo $all->score ?>" class="dial" style="box-shadow: none; border: none; background: none; width: 1px; color: white" title="<?php echo __('Audit Score', _SQ_PLUGIN_NAME_) ?>">
                                                                <script>jQuery("#knob_<?php echo $all->id ?>").knob({
                                                                        'min': 0,
                                                                        'max': 100,
                                                                        'readOnly': true,
                                                                        'width': 100,
                                                                        'height': 100,
                                                                        'skin': "tron",
                                                                        'fgColor': '<?php echo $color  ?>'
                                                                    });</script>
                                                            </div>

                                                            <div class="col-sm-12 mt-2">
                                                                <?php echo date('d M Y', strtotime($all->audit_datetime)) ?>
                                                            </div>
                                                        </td>
                                                    <?php }
                                                } ?>
                                            </tr>


                                        </table>
                                    </li>
                                </ul>
                                <?php foreach ($view->audit->audit as $group => $audit) {
                                    if(!isset($view->audit->groups->$group)){
                                        continue;
                                    }
                                    $current_group = $view->audit->groups->$group;
                                    ?>
                                    <div class="persist-area">
                                        <ul class="sq_audit_list px-3 m-0">
                                            <li>
                                                <table class="p-0 m-0 mb-3">
                                                    <tr>
                                                        <td id="sq_audit_tasks_header_<?php echo $group ?>" class="sq_audit_tasks_header" colspan="4">
                                                            <span class="persist-header sq_audit_tasks_header_title <?php echo $current_group->color . '_text' ?>" data-id="<?php echo $group ?>"><?php echo ucfirst($group) ?></span>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="sq_separator"></div>
                                                <ul>
                                                    <?php if (!empty($audit)) {
                                                        $category_name = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', 'sq_audits'));
                                                        $dbtasks = json_decode(get_option(SQ_TASKS), true);

                                                        foreach ($audit as $task) {
                                                            ?>
                                                            <li class="sq_audit_tasks_row m-0 p-0 py-4">
                                                                <table>
                                                                    <tr>

                                                                        <td style="vertical-align: middle" class="sq_second_header_column px-3 text-left">
                                                                            <span class="sq_audit_tasks_title"><?php echo $task->title ?></span>
                                                                        </td>

                                                                        <?php
                                                                        if (isset($view->audits)) {
                                                                            foreach ($view->audits as $all) {
                                                                                $audit_group = (array)$all->audit->$group;

                                                                                foreach ($audit_group as $audit_task) {
                                                                                    if ($task->audit_task == $audit_task->audit_task) {

                                                                                        if (isset($dbtasks[$category_name][ucfirst($task->audit_task)])) {
                                                                                            $dbtask = $dbtasks[$category_name][ucfirst($task->audit_task)];
                                                                                            //get the dbtask status
                                                                                            $dbtask['status'] = $dbtask['active'] ? (((int)$audit_task->complete == 1) ? 'completed' : '') : 'ignore';
                                                                                        } else {
                                                                                            $dbtask['status'] =  ((int)$audit_task->complete == 1) ? 'completed' : '';
                                                                                        }
                                                                                        ?>
                                                                                        <td class="sq_first_header_column text-center px-3">

                                                                                            <div class="col-sm-12 sq_task <?php echo $dbtask['status'] ?>">
                                                                                                <i class="fa fa-check" style="font-size: 30px !important;" data-category="<?php echo $category_name ?>" data-name="<?php echo ucfirst($group) ?>" data-completed="<?php echo (int)$audit_task->complete ?>" data-dismiss="modal"></i>
                                                                                                <h4 style="display: none"><?php echo $audit_task->title ?></h4>
                                                                                                <div class="description" style="display: none">
                                                                                                    <div class="sq_audit_tasks_row">
                                                                                                        <div class="sq_audit_tasks_title text-left"><?php echo $audit_task->title ?>
                                                                                                            <span class="sq_audit_tasks_value sq_audit_tasks_value<?php echo ((int)$audit_task->complete == 1) ? '_pass' : '_fail' ?>">
                                                                                                                <?php echo ($audit_task->complete) ? $audit_task->success : $audit_task->fail ?>
                                                                                                            </span>
                                                                                                        </div>
                                                                                                        <div class="sq_separator"></div>
                                                                                                        <div class="sq_audit_tasks_description">
                                                                                                            <?php echo $audit_task->description ?>
                                                                                                            <?php if ($audit_task->protip <> '') { ?>
                                                                                                                <div class="my-3 p-0">
                                                                                                                    <strong class="text-info"><?php echo __('PRO TIP', _SQ_PLUGIN_NAME_) ?>:</strong> <?php echo $audit_task->protip ?>
                                                                                                                </div>
                                                                                                            <?php } ?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="message" style="display: none"></div>
                                                                                            </div>
                                                                                            <div class="col-sm-12 mt-2">
                                                                                                <?php echo date('d M Y', strtotime($all->audit_datetime)) ?>
                                                                                            </div>
                                                                                        </td>
                                                                                    <?php }
                                                                                }
                                                                            }
                                                                        } ?>
                                                                    </tr>


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

                </div>
            </div>

        </div>
    </div>
</div>