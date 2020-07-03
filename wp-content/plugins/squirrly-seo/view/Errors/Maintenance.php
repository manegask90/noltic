<?php
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-reboot');
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap');
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('navbar');
?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">

                <div class="col-sm-12 p-0">
                    <div class="col-sm-12 px-2 py-3 text-center" >
                        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/maintenance.jpg' ?>" style="width: 500px">
                    </div>
                    <div id="sq_error" class="card col-sm-12 p-0 tab-panel border-0">
                        <div class="col-sm-12 alert alert-success text-center m-0 p-3"><i class="fa fa-exclamation-triangle" style="font-size: 18px !important;"></i> <?php echo sprintf(__("Unfortunately Squirrly Cloud is down for a bit of maintenance right now. But we'll be back in a minute. %srefresh the page%s.", _SQ_PLUGIN_NAME_),'<a href="javascript:location.reload();" >','</a>')?></div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
