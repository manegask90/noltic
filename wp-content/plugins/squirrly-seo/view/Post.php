<?php if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') { ?>
    <div style="font-size: 16px; line-height: 24px; font-weight: 600; margin: 0 auto 10px auto; text-align: center; ">
        <div style="text-align: center;  margin: 6px auto;">
            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" style="text-decoration: none">
                <img src="<?php echo _SQ_ASSETS_URL_ . __('img/editor/sla.png', _SQ_PLUGIN_NAME_); ?>" style="width: 277px"/>
            </a>
        </div>
        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" style="text-decoration: none"><?php _e('To load Squirrly Live Assistant and optimize this page, click to connect to Squirrly Data Cloud.', _SQ_PLUGIN_NAME_); ?></a>
    </div>
<?php } else {

    ?>
    <?php SQ_Classes_RemoteController::loadJsVars(); ?>
    <?php
    SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('slaseo', array('trigger' => true, 'media' => 'all'));
    SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('slasearch', array('trigger' => true, 'media' => 'all'));
    SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('slaresearch', array('trigger' => true, 'media' => 'all'));
    ?>
    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
    <?php echo $view->getView('Blocks/SLASearch'); ?>
    <?php echo $view->getView('Blocks/SLASeo'); ?>
<?php } ?>