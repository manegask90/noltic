<div class="card col-sm-12 px-0 py-2 border-0 m-0">
    <div class="card-body">
        <?php
        if (!empty($view->auditpages)) { ?>

            <h4 class="card-title"><?php _e('Audited pages', _SQ_PLUGIN_NAME_) ?></h4>
            <div class="card-text mx-0 my-2 p-0">
                <div class="card-body p-0 position-relative">
                    <div class=" col-sm-12 m-0 p-0 my-2 py-2 py-0 flexcroll">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th><?php echo __('Permalink', _SQ_PLUGIN_NAME_) ?></th>
                                <th></th>
                                <th style="width: 10px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($view->auditpages)) {

                                foreach ($view->auditpages as $index => $auditpage) {

                                    if ($auditpage->permalink <> '') {
                                        if (!current_user_can('sq_manage_focuspages')) continue;

                                        ?>
                                        <tr id="sq_row_<?php echo $auditpage->id ?>" class="<?php echo($index % 2 ? 'even' : 'odd') ?>">
                                            <?php
                                            $view->auditpage = $auditpage;
                                            echo $view->getView('Audits/AuditPageRow');
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php } elseif (SQ_Classes_Helpers_Tools::getValue('sid', false)) { ?>

            <div class="card-body">
                <h4 class="text-center"><?php echo sprintf(__('No data for this filter. %sShow All%s Audit Pages.', _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'audits') . '" >', '</a>') ?></h4>
            </div>

        <?php } elseif (!SQ_Classes_Error::isError()) { ?>

            <div class="card-body">
                <h4 class="text-center"><?php echo __('Welcome to Squirrly SEO Audits'); ?></h4>
                <div class="col-sm-12 m-2 text-center">
                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'addpage') ?>" class="btn btn-lg btn-success"><i class="fa fa-plus-square-o"></i> <?php echo __('Add a new page for Audit to get started'); ?>
                    </a>
                </div>
            </div>

        <?php } else { ?>

            <div class="card-body">
                <div class="col-sm-12 px-2 py-3 text-center">
                    <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/noconnection.jpg' ?>" style="width: 300px">
                </div>
                <div class="col-sm-12 m-2 text-center">
                    <div class="col-sm-12 alert alert-success text-center m-0 p-3">
                        <i class="fa fa-exclamation-triangle" style="font-size: 18px !important;"></i> <?php echo sprintf(__("There is a connection error with Squirrly Cloud. Please check the connection and %srefresh the page%s.", _SQ_PLUGIN_NAME_), '<a href="javascript:location.reload();" >', '</a>') ?>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>
</div>