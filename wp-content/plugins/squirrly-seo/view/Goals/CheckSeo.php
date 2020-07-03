<?php
$refresh = false;
$report_time = SQ_Classes_Helpers_Tools::getOption('seoreport_time');
if (empty($report_time) || (time() - (int)$report_time) > (3600 * 12)) {
    $refresh = true;
}
$category_name = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', 'sq_dashboard'));
?>
    <div id="sq_blockseoissues">
        <?php if (isset($view->congratulations) && !empty($view->congratulations)) { ?>
            <div class="col-sm-12 my-4 py-3" style="box-shadow: 0 0 10px -3px #994525; background-color: white;">

                <div class="row text-left m-0 p-0">
                    <div class="px-2 text-center" style="width: 38%;">
                        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/trompette.png' ?>" style="width: 100%; max-width: 200px;">
                    </div>
                    <div class="col-sm px-2 py-5">
                        <div class="col-sm-12 m-0 p-0">
                            <div class="sq_icons sq_audit_icon m-2"></div>
                            <h3 class="card-title" style="color: green;"><?php _e('Progress & Achievements', _SQ_PLUGIN_NAME_); ?>:</h3>
                        </div>

                        <div class="sq_separator"></div>
                        <div class="col-sm-12 m-2 p-0">
                            <div class="card-title-description m-2 text-black-50"><?php _e("See all the improvements from all Squirrly SEO features in a single panel.", _SQ_PLUGIN_NAME_); ?></div>
                        </div>
                    </div>
                </div>


                <div class="sq_separator"></div>
                <div class="card my-0 p-0 col-sm-12 border-0 shadow-none">

                    <table class="table table-striped my-0">
                        <tbody>
                        <?php foreach ($view->congratulations as $function => $row) { ?>
                            <tr>
                                <td class="p-3 text-success text-left" style="width: 150px; vertical-align: middle;  font-size: 16px !important; <?php echo($row['color'] ? 'color:' . $row['color'] : '') ?>">
                                    <?php if (isset($row['image']) && $row['image']) { ?>
                                        <div class="col-sm-12 text-center p-0 m-0">
                                            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/' . $row['image'] ?>" style="max-width: 100px;"/>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td class="p-3 text-success text-left" style="vertical-align: middle; font-size: 18px !important; <?php echo($row['color'] ? 'color:' . $row['color'] : '') ?>">
                                    <?php echo(isset($row['message']) ? $row['message'] : '') ?>
                                </td>
                                <?php if (isset($row['link']) && isset($row['link'])) { ?>
                                    <td style="width: 100px; vertical-align: middle;  padding-left: 0; padding-right: 0; margin: 0">
                                        <div class="col-sm p-0 m-0 mx-1">
                                            <a href="<?php echo $row['link'] ?>" class="btn btn-sm btn-success text-white p-2 px-3 m-0" target="_blank">
                                                <?php echo __('See results', _SQ_PLUGIN_NAME_) ?>
                                            </a>
                                        </div>
                                    </td>
                                <?php } ?>
                                <td class="sq_save_ajax" style="width: 10px; vertical-align: middle;  padding-left: 0; padding-right: 0; margin: 0">
                                    <?php if (isset($row['ignorable']) && $row['ignorable']) { ?>
                                        <button type="button" class="float-right btn btn-sm btn-link text-black-50 p-2 px-3 m-0" id="sq_ignore" data-input="sq_ignore_<?php echo $function ?>" data-name="<?php echo $category_name ?>|<?php echo $function ?>" data-action="sq_ajax_assistant" value="1">
                                            <i class="fa fa-close"></i>
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="<?php if (isset($row['link']) && isset($row['link'])) {
                                    echo 4;
                                } else {
                                    echo 3;
                                } ?>" class="p-2 m-0"></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        <?php } ?>

        <a name="tasks"></a>

        <!-- Show the Goals from Goals.php through ajax -->
        <div id="sq_seocheck_content"  class="col-sm-12 my-4 py-3" style="box-shadow: 0 0 10px -3px #994525; background-color: white; min-height: 100px;">
            <?php
            $view->report = $view->getNotifications();
            $content = $view->getView('Goals/Goals');
            if (function_exists('iconv')) {
                $content = iconv('UTF-8', 'UTF-8//IGNORE', $content);
            }
            echo $content;
            ?>
        </div>

    </div>
    <div id="sq_loading_modal" tabindex="-1" class="sq_loading_modal modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo __('Website SEO Check', _SQ_PLUGIN_NAME_); ?>
                        <span style="font-weight: bold; font-size: 110%"></span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="min-height: 90px;">
                    <div class="row text-left m-0 p-0">
                        <div class="px-2 my-3 mx-auto" style="width: 200px;">
                            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/calendar.png' ?>" style="width: 100%">
                        </div>
                        <div class="col-sm px-2 ">
                            <div class="text-left mx-3 p-0 py-1">
                                <h3 class="card-title m-0 p-0"><?php echo sprintf(__('%s Aspects', _SQ_PLUGIN_NAME_), '<strong class="text-info">' . '70' . '</strong>'); ?></h3>
                                <div class="card-title-description m-0 p-0 text-black-50"><?php _e("Handled by Squirrly Genius.", _SQ_PLUGIN_NAME_); ?></div>
                                <div class="card-title-description m-0 mt-3 p-0 text-black-50"><?php _e("Remember that it may take up to 1 minute for a complete SEO check. There is a lot of processing involved.", _SQ_PLUGIN_NAME_); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="m-0 my-2 p-0">
                        <div style="font-size: 18px; text-align: center; font-weight: bold; margin: 20px auto 10px auto;"><?php echo __('Checking the website ...', _SQ_PLUGIN_NAME_) ?></div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php if (!empty($view->congratulations) && !$refresh) { //if there are congratulations and is checked today
    $seosuccess_time = SQ_Classes_ObjController::getClass('SQ_Models_CheckSeo')->getDbTask('seosuccess_time');

    foreach ($view->congratulations as $index => $row) {
        if (!empty($seosuccess_time) && (time() - (int)$seosuccess_time) < (3600 * 12)) {
            break;
        }
        if ($row['completed']) { ?>
            <div id="sq_success_modal" tabindex="-1" class="sq_success_modal modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-light">
                        <div class="modal-header">
                            <h4 class="modal-title"><?php echo __('Congratulations!', _SQ_PLUGIN_NAME_); ?>
                                <span style="font-weight: bold; font-size: 110%"></span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="min-height: 90px;">
                            <?php if (isset($row['image']) && $row['image']) { ?>
                                <div class="col-sm-12 text-center">
                                    <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/' . $row['image'] ?>" style="max-width: 250px;"/>
                                </div>
                            <?php } ?>
                            <div class="col-sm-12 p-3 text-center text-success" style="font-size: 16px">
                                <?php echo(isset($row['message']) ? $row['message'] : '') ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
            SQ_Classes_ObjController::getClass('SQ_Models_CheckSeo')->saveDbTasks('seosuccess_time', current_time('timestamp', 1));
            break;
        }
    } ?>
    <script>
        (function ($) {
            $(document).ready(function () {
                if ($('#sq_success_modal').length > 0) {
                    $('#sq_success_modal').modal('show');
                }
            });
        })(jQuery);

    </script>

<?php } ?>