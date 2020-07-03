<div id="sq_kr" class="mt-5">
    <div class="col-sm-12 my-4">
        <div class="row text-left m-0 p-0">
            <div class="sq_icons sq_kr_icon m-2"></div>
            <h3 class="card-title"><?php _e('Keyword Research', _SQ_PLUGIN_NAME_); ?>:</h3>
            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'history') ?>" class="btn btn-primary m-2" style="max-height: 35px;"><?php _e('See Research History', _SQ_PLUGIN_NAME_) ?></a>
        </div>
    </div>

    <?php if (isset($view->kr) && !empty($view->kr)) { ?>
        <div class="card my-0 py-4 px-2 bg-light col-sm-12">
            <table class="sq_krhistory_list table table-striped table-hover my-0" cellpadding="0" cellspacing="0" border="0">
                <thead>
                <tr>
                    <th scope="col"><?php _e('Keyword', _SQ_PLUGIN_NAME_) ?></th>
                    <th scope="col" title="<?php _e('Country', _SQ_PLUGIN_NAME_) ?>"><?php _e('Co', _SQ_PLUGIN_NAME_) ?></th>
                    <th style="width: 160px;"><?php _e('Date', _SQ_PLUGIN_NAME_) ?></th>

                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($view->kr))
                    foreach ($view->kr as $key => $kr) {
                        if (!isset($kr->keyword)) {
                            continue;
                        }
                        ?>
                        <tr>
                            <td class="sq_kr_keyword" title="<?php echo $kr->keyword ?>"><?php echo $kr->keyword ?></td>
                            <td><?php echo $kr->country ?></td>
                            <td><?php echo date(get_option('date_format'), strtotime($kr->datetime)) ?></td>
                        </tr>
                        <?php
                        if ($key > 20) break;
                    } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="card mr-2 bg-light col-sm-12">
            <div class="card-body">
                <h5 class="text-center"><?php echo __('See your research results and compare them over time'); ?>:</h5>
                <div class="row col-sm-12 my-4 text-center">
                    <div class="my-0 mx-auto justify-content-center text-center">
                        <h6 onclick="location.href ='<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') ?>'" class="text-black-50 text-right">
                            <div style="float: right; cursor: pointer"><?php echo __('Do Keyword Research'); ?></div>
                            <i class="sq_icons_small sq_kr_icon" style="float: right; width: 20px; cursor: pointer"></i>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>