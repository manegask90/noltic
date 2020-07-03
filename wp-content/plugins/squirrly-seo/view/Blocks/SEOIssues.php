<div id="sq_blockseoissues" class="mt-5">
    <div class="col-sm-12 my-4">
        <div class="row text-left m-0 p-0">
            <div class="sq_icons sq_audit_icon m-2"></div>
            <h3 class="card-title"><?php _e('SEO Issues', _SQ_PLUGIN_NAME_); ?>:</h3>
            <form method="post" class="p-0 m-0">
                <?php SQ_Classes_Helpers_Tools::setNonce('sq_checkseo', 'sq_nonce'); ?>
                <input type="hidden" name="action" value="sq_checkseo"/>
                <button type="submit" class="btn btn-warning m-2" style="max-height: 35px;">
                    <?php echo __('Run new test', _SQ_PLUGIN_NAME_) ?>
                </button>
            </form>
        </div>
    </div>


    <?php if (isset($view->report) && !empty($view->report)) { ?>
        <div class="card my-0 py-4 px-2 bg-light col-sm-12">
            <?php if (!empty($view->report)) { ?>
                <table class="table table-striped my-0">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><?php echo __('Problem', _SQ_PLUGIN_NAME_) ?></th>
                        <th scope="col"><?php echo __('Solution', _SQ_PLUGIN_NAME_) ?></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($view->report as $index => $row) {
                        if (!$row['valid']) {
                            ?>
                            <tr>
                                <td class="p-3 <?php echo($row['valid'] ? 'text-success' : 'text-danger') ?>" style="font-size: 16px !important;">
                                    <i class="fa fa-times mx-2"></i><?php echo(isset($row['warning']) ? $row['warning'] : '') ?>
                                </td>
                                <td style="width: 100px; padding-right: 0!important;">
                                    <div class="modal fade" id="sq_reportdetail<?php echo $index ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo __('Task Details', _SQ_PLUGIN_NAME_) ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php echo(isset($row['message']) ? $row['message'] : '') ?>
                                                    <br/><br/>
                                                    <?php echo(isset($row['solution']) ? $row['solution'] : '') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#sq_reportdetail<?php echo $index ?>"><?php echo __('See solution', _SQ_PLUGIN_NAME_) ?></button>

                                </td>
                                <td style="width: 100px">
                                    <?php if (isset($row['name']) && isset($row['value'])) { ?>
                                        <form method="post" class="p-0 m-0">
                                            <?php SQ_Classes_Helpers_Tools::setNonce('sq_fixsettings', 'sq_nonce'); ?>
                                            <input type="hidden" name="action" value="sq_fixsettings"/>
                                            <input type="hidden" name="name" value="<?php echo $row['name'] ?>"/>
                                            <input type="hidden" name="value" value="<?php echo $row['value'] ?>"/>
                                            <button type="submit" class="btn btn-sm bg-success text-white p-2 px-3 m-0">
                                                <?php echo __('Fix It', _SQ_PLUGIN_NAME_) ?>
                                            </button>
                                        </form>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>

            <?php } ?>
        </div>


    <?php } else { ?>
        <div class="card mr-2 bg-light col-sm-12">
            <div class="card-body">
                <h4 class="text-center">
                    <i class="fa fa-check align-middle text-success mx-2" style="font-size: 18px;"></i><?php echo __('No SEO major issues found in your website'); ?>
                </h4>
                <h6 class="text-center text-black-50 mt-3"><?php echo __('Now, check the SEO for each page using Bulk SEO'); ?>:</h6>
                <div class="row col-sm-12 my-4 text-center">
                    <div class="my-0 mx-auto justify-content-center text-center">
                        <h6 onclick="location.href ='<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'bulkseo') ?>'" class="text-black-50 text-right">
                            <div style="float: right; cursor: pointer"><?php echo __('Go to Bulk SEO'); ?></div>
                            <i class="sq_icons_small sq_bulkseo_icon" style="float: right; width: 20px; cursor: pointer"></i>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>