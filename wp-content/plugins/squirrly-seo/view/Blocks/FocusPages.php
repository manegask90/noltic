<div id="sq_focuspages" class="mt-5">
    <div class="col-sm-12 my-4">
        <div class="col-sm-12 row my-4">
            <div class="row text-left m-0 p-0">
                <div class="sq_icons sq_krfound_icon m-2"></div>
                <h3 class="card-title"><?php _e('Focus Pages', _SQ_PLUGIN_NAME_); ?>:</h3>
                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages') ?>" class="btn btn-primary m-2" style="max-height: 35px;"><?php _e('See Focus Pages', _SQ_PLUGIN_NAME_) ?></a>
            </div>
        </div>
    </div>
    <?php if (isset($view->focuspages) && !empty($view->focuspages)) { ?>
        <div class="card my-0 py-4 px-2 bg-light col-sm-12">
            <table class="sq_krfound_list table table-striped table-hover my-2" cellpadding="0" cellspacing="0" border="0">
                <thead>
                <tr>
                    <th><?php echo __('Permalink', _SQ_PLUGIN_NAME_) ?></th>
                    <th><?php echo __('Last audited', _SQ_PLUGIN_NAME_) ?></th>
                    <th style="width: 10px"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($view->focuspages)) {
                    foreach ($view->focuspages as $index => $focuspage) {
                        $view->post = $focuspage->getWppost();

                        if(!isset($view->post->url)) continue;

                        if (strtotime($focuspage->audit_datetime)) {
                            $audit_timestamp = strtotime($focuspage->audit_datetime) + ((int)get_option('gmt_offset') * 3600);
                            $audit_timestamp = date(get_option('date_format') . ' ' . get_option('time_format'), $audit_timestamp);
                        } else {
                            $audit_timestamp = $focuspage->audit_datetime;
                        }

                        ?>
                        <tr id="sq_row_<?php echo $focuspage->id ?>" class="<?php echo($index % 2 ? 'even' : 'odd') ?>">
                            <td style="min-width: 380px;">
                                <?php if ($view->post) { ?>
                                    <div class="col-sm-12 px-0 mx-0 font-weight-bold">
                                        <?php echo $view->post->sq->title ?><?php echo(($view->post->post_status <> 'publish' && $view->post->post_status <> 'inherit' && $view->post->post_status <> '') ? ' <spam style="font-weight: normal">(' . $view->post->post_status . ')</spam>' : '') ?>
                                    </div>
                                <?php } ?>

                                <div class="small" style="font-size: 11px"><?php echo '<a href="' . $view->post->url . '"  class="text-link" rel="permalink" target="_blank">' . $view->post->url . '</a>' ?></div>

                            </td>
                            <td>
                                <div class="small my-1">
                                    <span class="text-danger"><?php echo $audit_timestamp ?></span>
                                </div>
                            </td>
                            <td>
                                <a class="btn btn-info btn-sm" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages') ?>"><?php echo __('Check Focus Page', _SQ_PLUGIN_NAME_) ?></a>
                            </td>
                        </tr>
                        <?php
                    }
                } ?>

                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="card mr-2 bg-light col-sm-12">
            <h5 class="text-center"><?php echo __('To get started with managing the focus pages'); ?>:</h5>
            <div class="row col-sm-12 my-4">
                <div class="col-sm text-right">
                    <h6 onclick="location.href ='<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'addpage') ?>'" class="text-black-50 text-right">
                        <div style="float: right; cursor: pointer"><?php echo __('Add new page'); ?></div>
                        <i class="sq_icons_small sq_addpage_icon" style="float: right; width: 20px; cursor: pointer"></i>
                    </h6>
                </div>
                <div class="col-sm text-left">
                    <h6 class="text-black-50">
                        <i class="fa fa-ellipsis-v mx-2"></i><?php echo __('Then set a page as focus'); ?>
                    </h6>
                </div>
            </div>
        </div>
    <?php } ?>
</div>