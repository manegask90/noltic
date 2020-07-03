<script type="text/javascript" src="//www.gstatic.com/charts/loader.js"></script>
<div id="sq_blockaudits" class="mt-5">
    <div class="col-sm-12 my-4  ">
        <div class="row text-left m-0 p-0">
            <div class="sq_icons sq_audits_icon m-2"></div>
            <h3 class="card-title"><?php _e('SEO Audit', _SQ_PLUGIN_NAME_); ?>:</h3>
            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits') ?>" class="btn btn-primary m-2" style="max-height: 35px;"><?php _e('See Audits', _SQ_PLUGIN_NAME_) ?></a>
        </div>

    </div>
    <?php if (isset($view->audits) && !empty($view->audits)) { ?>
        <div class="card-group mb-5">
            <div class="card mr-0 pb-0 bg-light col-sm-12">
                <div class="card-body">
                    <h4 class="card-title"><?php _e('Audits Score', _SQ_PLUGIN_NAME_) ?></h4>
                    <p class="card-subtitle my-1 text-warning"><?php _e('last 4 audits', _SQ_PLUGIN_NAME_) ?></p>
                    <div class="card-text mt-2">
                        <?php
                        if (!empty($view->audits)) {
                            echo $view->getScripts();
                            $chart[0][0] = __('Date', _SQ_PLUGIN_NAME_);
                            $chart[0][1] = __('On-Page', _SQ_PLUGIN_NAME_);
                            $chart[0][2] = __('Off-Page', _SQ_PLUGIN_NAME_);
                            $moz = 0;
                            foreach ($view->audits as $key => &$audit) {
                                if ((int)$audit->moz > 0) {
                                    $moz = (int)$audit->moz;
                                } else {
                                    $audit->moz = $moz;
                                }
                            }
                            foreach ($view->audits as $key => $audit) {
                                $chart[$key + 1][0] = date('d/m/Y', strtotime($audit->datetime));
                                $chart[$key + 1][1] = (int)$audit->score;
                                $chart[$key + 1][2] = (int)$audit->moz;
                            }
                            echo '
                                <div class="text-center" style="padding: 2px 0; border-left: 1px solid #eee; border-bottom: 1px solid #eee;">
                                    <div id="sq_chart_audit" class="sq_chart no-p" style="width: 600px; height: 300px; margin: auto;"></div><script>var sq_chart_val = drawChart("sq_chart_audit", ' . json_encode($chart) . ' ,true); </script>
                                </div>';
                        } else {
                            _e('No data yet', _SQ_PLUGIN_NAME_);
                        }
                        ?>
                        <?php foreach ($view->audits as $key => $audits) { ?>

                        <?php } ?>
                    </div>
                </div>
                <div class="card-footer row">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-3 text-right pl-4 pr-0">
                        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits') ?>" class="btn btn-primary" style="font-size: 11px; margin-left: 10px; color: white"><?php _e('See Audits', _SQ_PLUGIN_NAME_) ?></a>
                    </div>
                </div>
            </div>

        </div>
    <?php } else { ?>
        <div class="card mr-2 bg-light col-sm-12">
            <div class="card-body">
                <h5 class="text-center"><?php echo __('The SEO Audit is generated once every week'); ?></h5>
                <h6 class="text-center text-black-50 mt-3"><?php echo __('Until the audit is ready, try the Focus Pages section'); ?>:</h6>
                <div class="row col-sm-12 my-4 text-center">
                    <div class="my-0 mx-auto justify-content-center text-center">
                        <h6 onclick="location.href ='<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'pagelist') ?>'" class="text-black-50 text-right">
                            <div style="float: right; cursor: pointer"><?php echo __('Go to Focus Pages'); ?></div>
                            <i class="sq_icons_small sq_focuspages_icon" style="float: right; width: 20px; cursor: pointer"></i>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>