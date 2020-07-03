<?php
$refresh = false;
$report_time = SQ_Classes_Helpers_Tools::getOption('seoreport_time');
if (empty($report_time) || (time() - (int)$report_time) > (3600 * 12)) {
    $refresh = true;
}

$category_name = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', 'sq_dashboard'));

$ignored_count = $countdone = 0;
foreach ($view->report as $function => $row) {
    if (in_array($view->report[$function]['status'], array('completed', 'done', 'ignore'))) {
        $countdone++;

        if ($row['status'] == 'ignore') {
            $ignored_count++;
        }
    }
}

//Show all done image if all tasks are done
if ($countdone == count($view->report)) {
    $view->report = array();
}
?>
<div class="row text-left m-0 p-0">
    <div class="px-2" style="max-width: 350px;width: 38%;">
        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/calendar.png' ?>" style="width: 100%">
    </div>
    <div class="col-sm px-2 ">
        <div class="text-left m-0 p-0 py-1">
            <div class="col-sm m-0 p-0">
                <div class="sq_icons sq_audit_icon m-2"></div>
                <h3 class="card-title m-0 p-0"><?php _e('Daily SEO Goals', _SQ_PLUGIN_NAME_); ?>:
                    <?php if (isset($view->report) && !empty($view->report)) { ?>
                        <a href="#tasks" style="display: inline-block"><?php echo sprintf(__('%s goals for today', _SQ_PLUGIN_NAME_), (count((array)$view->report)) - $countdone) ?></a>
                    <?php } ?>
                </h3>
            </div>
            <div class="col-sm m-0 p-0 text-center">
                <?php if (current_user_can('sq_manage_snippets')) { ?>
                    <button type="button" class="btn btn-warning  m-2 py-2 px-5 center-block sq_seocheck_submit" <?php echo($refresh ? 'data-action="trigger"' : '') ?> >
                        <?php echo __('Run SEO Test', _SQ_PLUGIN_NAME_) ?>
                    </button>
                <?php } ?>
            </div>
        </div>
        <div class="sq_separator"></div>
        <div class="row text-left m-0 p-0 pt-3">
            <div class="col-sm-8 m-0 p-0">
                <h3 class="card-title m-0 p-0"><?php _e('Reach New Goals', _SQ_PLUGIN_NAME_); ?>:</h3>
                <div class="card-title-description m-2 text-black-50"><?php _e("Squirrly Smart Strategy sets new goals.", _SQ_PLUGIN_NAME_); ?></div>
                <div class="card-title-description m-2">
                    <a href="https://howto.squirrly.co/faq/how-unique-are-the-daily-seo-goals/" target="_blank">(<?php _e("How unique are these goals?", _SQ_PLUGIN_NAME_); ?>)</a>
                </div>
            </div>
            <div class="col-sm-3 m-0 p-0 py-1 text-center" style="min-width: 100px">
                <?php
                $color = false;
                if ((int)$view->score > 0) {
                    $color = '#dd3333';
                    if (((int)$view->score >= 50)) $color = 'orange';
                    if (((int)$view->score >= 90)) $color = '#20bc49';
                }
                ?>
                <input id="knob_checkseo" type="text" value="<?php echo $view->score ?>" class="dial" style="box-shadow: none; border: none; background: none; width: 1px; color: white" title="<?php echo __('Daily Progress', _SQ_PLUGIN_NAME_) ?>">
                <script>jQuery("#knob_checkseo").knob({
                        'min': 0,
                        'max': 100,
                        'readOnly': true,
                        'width': 80,
                        'height': 80,
                        'skin': "tron",
                        'fgColor': '<?php echo $color  ?>'
                    });</script>
                <div class="m-2 text-black-50 font-weight-bold"><?php _e("Today's Progress", _SQ_PLUGIN_NAME_); ?></div>

            </div>
        </div>
    </div>
</div>

<a name="tasks"></a>
<div class="sq_separator mt-4"></div>

<?php if (isset($view->report) && !empty($view->report)) { ?>
    <div class="small text-info text-center p-3"><?php echo sprintf(__('Hint: remember to click: %sShow me how - Mark as Done%s, when you complete a goal.', _SQ_PLUGIN_NAME_), '<strong>', '</strong>') ?></div>
    <div class="sq_separator"></div>
    <div class="col-sm-12 text-center mt-2">
        <a href="#tasks"><i class="fa fa-arrow-circle-down" style="font-size: 45px !important; color: red; cursor: pointer"></i></a>
    </div>

    <div id="sq_seocheck_tasks" class="card my-0 py-4 px-0 col-sm-12 border-0 shadow-none">
        <table class="table table-striped my-0">
            <tbody>
            <?php foreach ($view->report as $function => $row) {
                if (in_array($row['status'], array('done', 'ignore'))) {
                    continue;
                }
                ?>
                <tr>
                    <td class="p-3" <?php echo($row['completed'] ? 'colspan="3" style="position:relative;"' : '') ?>>
                        <?php echo($row['completed'] ? '<div class="completed">' . __('Goal completed. Good Job!', _SQ_PLUGIN_NAME_) . '</div>' : '') ?>
                        <h4 class="sq_seocheck_tasks_title text-left <?php echo($row['color'] ? $row['color'] : 'text-danger') ?>" style="<?php echo($row['color'] ? 'color:' . $row['color'] : '') ?>">
                            <i class="fa fa-arrow-circle-right m-0 p-0" style="font-size: 18px !important; vertical-align: middle;"></i> <?php echo(isset($row['warning']) ? $row['warning'] : '') ?>
                        </h4>
                        <?php if (isset($row['goal'])) { ?>
                            <div class="text-black-50 my-2 px-4  text-left">
                                <?php echo $row['goal'] ?>
                            </div>
                        <?php } ?>
                        <div class="row p-0 m-0 flex-nowrap">
                            <?php if (isset($row['tools']) && !empty($row['tools'])) { ?>
                                <div class="small text-black-50 my-2 pl-4 ">
                                    <i><img src="<?php echo _SQ_ASSETS_URL_ . 'img/logo.png' ?>" style="width: 14px;vertical-align: middle;"></i> <?php echo __('use', _SQ_PLUGIN_NAME_); ?>:
                                    <?php echo join(', ', $row['tools']) ?>
                                </div>
                            <?php } ?>

                            <?php if (isset($row['time']) && $row['time']) { ?>
                                <div class="small text-black-50 my-2 pl-4" style="min-width: 150px">
                                    <i class="fa fa-clock-o" style=" font-size: 16px !important; vertical-align: middle;" title="<?php echo __('Time to complete this goal.', _SQ_PLUGIN_NAME_); ?>"></i> <?php echo __('up to', _SQ_PLUGIN_NAME_); ?>:
                                    <strong class="text-info"><?php echo(($row['time'] < 60) ? $row['time'] . ' seconds' : (($row['time'] < 3600) ? ceil($row['time'] / 60) . ' minutes' : ($row['time'] / 3600) . ' hours')) ?></strong>
                                </div>
                            <?php } ?>
                        </div>
                    </td>
                    <?php if (!$row['completed']) { ?>
                        <td class="p-1 pr-0" style="width: 150px; vertical-align: middle;">
                            <div class="text-right mx-1">
                                <?php if (current_user_can('sq_manage_snippets')) {
                                    $dbtasks = json_decode(get_option(SQ_TASKS), true);
                                    ?>
                                    <div class="col-sm p-0 m-1 mx-1">
                                        <div class="col-sm-12 sq_task" data-category="<?php echo $category_name ?>" data-active="1" data-name="<?php echo $function ?>" data-completed="<?php echo (int)$row['completed'] ?>">
                                            <button type="button" class="btn btn-sm btn-success text-white p-1 px-2 m-0" style="width: 130px" data-dismiss="modal">
                                                <?php echo __("Show me how", _SQ_PLUGIN_NAME_) ?>
                                            </button>
                                            <?php if (isset($row['reopened']) && $row['reopened']) { ?>
                                                <div class="m-1">
                                                    <i class="fa fa-warning text-danger"></i> <?php echo __("Goal is not done!", _SQ_PLUGIN_NAME_) ?>
                                                </div>
                                            <?php } ?>
                                            <div class="description" style="display: none">
                                                <div class="row">
                                                    <div class="col-sm py-1">
                                                        <div class="sq_seocheck_tasks_title m-1 text-left" style="<?php echo($row['color'] ? 'color:' . $row['color'] : '') ?>">
                                                            <?php echo(isset($row['warning']) ? $row['warning'] : '') ?>
                                                        </div>
                                                        <div class="sq_seocheck_tasks_description p-1 py-3 m-0">
                                                            <?php echo(isset($row['message']) ? $row['message'] : '') ?>

                                                            <?php if (isset($row['solution']) && $row['solution'] <> '') { ?>
                                                                <div class="sq_seocheck_tasks_solution my-3">
                                                                    <?php echo '<strong class="text-info">' . __('SOLUTION', _SQ_PLUGIN_NAME_) . '</strong>' . ': ' . $row['solution'] ?>
                                                                </div>
                                                            <?php } ?>


                                                        </div>
                                                    </div>

                                                    <div class="py-2 px-3 m-0">
                                                        <?php if (isset($row['link']) && isset($row['link'])) { ?>
                                                            <div class="col-sm p-0 m-1 mx-1">
                                                                <a href="<?php echo $row['link'] ?>" target="_blank" class="btn btn-sm bg-success text-white p-1 px-2 m-0" style="width: 130px">
                                                                    <?php echo __("Let's do this", _SQ_PLUGIN_NAME_) ?>
                                                                </a>
                                                            </div>
                                                        <?php } ?>

                                                        <div class="col-sm p-0 m-1 mx-1">

                                                            <div class="sq_save_ajax">
                                                                <input type="hidden" id="sq_done_<?php echo $function ?>" value="1">
                                                                <button type="button" class="btn btn-sm btn-success text-white p-1 px-2 m-0" style="width: 130px" id="sq_done" data-input="sq_done_<?php echo $function ?>" data-name="<?php echo $category_name ?>|<?php echo $function ?>|done" data-action="sq_ajax_assistant" data-javascript="javascript:void(0);">
                                                                    <?php echo __('Mark As Done', _SQ_PLUGIN_NAME_) ?>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="message" style="display: none"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </td>
                        <td class="sq_save_ajax" style="width: 10px; vertical-align: middle;  padding-left: 0; padding-right: 0; margin: 0">
                            <?php if (current_user_can('sq_manage_snippets')) { ?>
                                <input type="hidden" id="sq_ignore_<?php echo $function ?>" value="0">
                                <button type="button" class="float-right btn btn-sm btn-link text-black-50 p-2 px-3 m-0" id="sq_ignore" data-input="sq_ignore_<?php echo $function ?>" data-name="<?php echo $category_name ?>|<?php echo $function ?>" data-action="sq_ajax_assistant" data-javascript="javascript:void(0);" data-confirm="<?php echo __('Do you want to ignore this goal?', _SQ_PLUGIN_NAME_) ?>">
                                    <i class="fa fa-close"></i>
                                </button>
                            <?php } ?>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td colspan="3" class="p-2 m-0 border-0"></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
<?php } else { ?>
    <div class="row text-left m-0 p-0 py-3">
        <div class="col-sm-6 m-0 p-0 py-4">
            <h4 class="text-center bd-highlight" style="line-height: 35px">
                <i class="fa fa-check align-middle text-success mx-2" style="font-size: 18px;"></i><?php echo sprintf(__("No other goals for today. %sGood job!"), '<br />'); ?>
            </h4>
            <div class="row col-sm-12 my-4 text-center">
                <div class="col-sm-12 my-3 text-center"><?php echo __("Want to keep boosting your SEO?"); ?></div>
                <div class="col-sm-12 m-2 text-center">
                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant', 'assistant') ?>" class="btn btn-sm btn-success" style="width: 300px"><?php echo __('Optimize your Posts and Pages'); ?></a>
                </div>
                <div class="col-sm-12 m-2 text-center">
                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo') ?>" class="btn btn-sm btn-success" style="width: 300px"><?php echo __('Boost your SEO with Bulk SEO'); ?></a>
                </div>
                <div class="col-sm-12 m-2 text-center">
                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'pagelist') ?>" class="btn btn-sm btn-success" style="width: 300px"><?php echo __('Rank your best pages with Focus Pages'); ?></a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 m-0 p-0 text-right">
            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/success_background.jpg' ?>" style="width: 100%">
        </div>
    </div>
<?php } ?>

<div class="sq_separator"></div>

<div class="row">
    <div class="col-sm p-0 m-2 mx-0 text-left">
        <?php if ($ignored_count > 0) { ?>
            <form method="post" class="p-0 m-0">
                <?php SQ_Classes_Helpers_Tools::setNonce('sq_resetignored', 'sq_nonce'); ?>
                <input type="hidden" name="action" value="sq_resetignored"/>
                <button type="submit" class="btn btn-link text-black-50 small p-2 px-3 m-0">
                    <?php echo __('Show hidden goals', _SQ_PLUGIN_NAME_) ?>
                    <span class="rounded-circle p-1 px-2 text-white bg-danger"><?php echo $ignored_count ?></span>
                </button>
            </form>
        <?php } ?>

    </div>

    <?php if (empty($view->report)) { ?>
        <div class="col-sm p-0 m-3 mx-0 text-right" style="font-size: 16px">
            <?php echo __('Next goals on') ?>:
            <strong class="text-info"><?php echo date(get_option('date_format'), strtotime('+1 day')) ?></strong>
        </div>
        <div class="col-sm p-0 m-2 mx-0 text-right">
            <div class="col-sm">
                <form method="post" class="p-0 m-0">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_moretasks', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_moretasks"/>
                    <button type="submit" class="btn btn-warning m-0 py-2 px-5 font-bold p-2 px-3 m-0">
                        <?php echo __('Load more goals if exist', _SQ_PLUGIN_NAME_) ?>
                    </button>
                </form>
            </div>
        </div>
    <?php } ?>

</div>

