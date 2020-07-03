<script type="text/javascript" src="//www.gstatic.com/charts/loader.js"></script>
<div id="sq_ranks" class="mt-5">
    <div class="col-sm-12 my-4">
        <div class="row text-left m-0 p-0">
            <div class="sq_icons sq_ranks_icon m-2"></div>
            <h3 class="card-title"><?php _e('Google Rankings', _SQ_PLUGIN_NAME_); ?>:</h3>
            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings') ?>" class="btn btn-primary m-2" style="max-height: 35px;"><?php _e('See Rankings', _SQ_PLUGIN_NAME_) ?></a>
        </div>
    </div>
    <?php if (isset($view->ranks) && !empty($view->ranks)) {
        echo $view->getScripts();
        ?>
        <div class="card-group mb-5">
            <?php if (isset($view->info) && !empty($view->info)) {
                $info = $view->info;
                ?>
                <div class="card mr-0 bg-light col-sm-12">
                    <div class="card-body">
                        <h4 class="card-title"><?php _e('Google Ranks', _SQ_PLUGIN_NAME_) ?></h4>
                        <p class="card-subtitle my-1 text-warning"><?php _e('last 7 days', _SQ_PLUGIN_NAME_) ?></p>
                        <div class="card-text mt-2">
                            <?php
                            foreach ($info->average as $key => $average) {
                                if ($key > 0 && !empty($info->average[$key])) {
                                    $info->average[$key][0] = date('d/m/Y', strtotime($info->average[$key][0]));
                                    $info->average[$key][1] = (float)$info->average[$key][1];
                                    if ($info->average[$key][1] == 0) {
                                        $info->average[$key][1] = 100;
                                    }
                                }
                                $average[1] = (int)$average[1];
                            }
                            if (count($info->average) > 1) {
                                echo '
                                <div class="text-center" style="padding: 2px 0; border-left: 1px solid #eee; border-bottom: 1px solid #eee;">
                                    <div id="sq_chart" class="sq_chart no-p" style="width: 600px; height: 260px; margin: auto;"></div><script>var sq_chart_val = drawChart("sq_chart", ' . json_encode($info->average) . ' ,true); </script>
                                </div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="card-footer row">
                        <div class="col-sm-8">
                            <small class="text-muted"><?php _e('Today Average', _SQ_PLUGIN_NAME_) ?>:
                                <?php
                                $today = isset($info->average[sizeof($info->average) - 1][1]) ? $info->average[sizeof($info->average) - 1][1] : 0;

                                if ($today > 0) {
                                    echo '<span style="font-weight: bold;">' . $today . '</span>';

                                    $diff = null;

                                    if (!empty($info->average)) {
                                        foreach ($info->average as $scores) {
                                            //SQD_Classes_Tools::dump($scores);
                                            list($time, $score) = $scores;
                                            SQ_Debug::dump($time, $score);

                                            if (time() - strtotime($time) > (3600 * 24) && $score > 0) {
                                                $diff = ($today - $score);
                                                $difftime = $time;
                                            }
                                        }
                                    }
                                    if (isset($diff)) {
                                        if ($diff > 0) {
                                            echo '<span class="sq_progression goingdown" title="' . sprintf(__('The average rank went down with %s since %s', _SQ_PLUGIN_NAME_), $diff, date(get_option('date_format'), strtotime($difftime))) . '"></span>';
                                        } elseif ($diff < 0) {
                                            echo '<span class="sq_progression goingup" title="' . sprintf(__('The average rank went up with %s since %s', _SQ_PLUGIN_NAME_), abs($diff), date(get_option('date_format'), strtotime($difftime))) . '"></span>';
                                        }
                                    }
                                }
                                ?>
                            </small>
                        </div>
                        <div class="col-sm-3 text-right pl-4 pr-0">
                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings') ?>" class="btn btn-primary" style="font-size: 11px; margin-left: 10px; color: white"><?php _e('See Rankings', _SQ_PLUGIN_NAME_) ?></a>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="card mr-0 bg-light col-sm-6">
                    <div class="card-body">
                        <h4 class="card-title"><?php _e('Google Ranks', _SQ_PLUGIN_NAME_) ?></h4>
                        <p class="card-subtitle my-1 text-warning"><?php _e('last 7 days', _SQ_PLUGIN_NAME_) ?></p>
                        <div class="card-text mt-2">
                            <div class="col-sm-7" style="padding: 2px 0; border-left: 1px solid #eee; border-bottom: 1px solid #eee;">
                                <div id="sq_chart" class="sq_chart no-p" style="width: 450px; height: 260px;"></div>
                                <script>
                                    if (typeof google !== 'undefined') {
                                        google.setOnLoadCallback(function () {
                                            var sq_chart_val = drawChart("sq_chart", [["date", "average"], ["", 0], ["", 0], ["", 0], ["", 0], ["", 0], ["", 0]], true);
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    <?php } else { ?>
        <div class="card mr-2 bg-light col-sm-12">
            <div class="card-body">
                <h5 class="text-center"><?php echo __('To see how your website is ranking on Google'); ?>:</h5>
                <div class="row col-sm-12 my-4">
                    <div class="col-sm text-right">
                        <h6 onclick="location.href ='<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') ?>'" class="text-black-50 text-right">
                            <div style="float: right; cursor: pointer"><?php echo __('Add keywords in Briefcase'); ?></div>
                            <i class="sq_icons_small sq_briefcase_icon" style="float: right; width: 20px; cursor: pointer"></i>
                        </h6>
                    </div>
                    <div class="col-sm text-left">
                        <h6 class="text-black-50">
                            <i class="fa fa-ellipsis-v mx-2"></i><?php echo __('Then send keywords to Rank Checker'); ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
