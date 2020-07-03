<style>
    body ul.sq_notification {
        top: 4px !important;
    }
    #postsquirrly {
        display: none;
    }

    .components-squirrly-icon{
        display: none;
        position: fixed;
        right: 20px;
        bottom: 10px;
        z-index: 10;
        border: 1px solid #999;
        margin: 0 !important;
        padding: 3px;
        cursor: pointer;
    }
    #sq_blocksearch #sq_types,
    #sq_blocksearch #sq_search_img_filter,
    #sq_blocksearch .sq_search{
        display: none !important;
    }
</style>
<div id="postsquirrly" class="sq_sticky sq_frontend">
    <?php if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') { ?>
        <div style="font-size: 16px; line-height: 24px; font-weight: 600; margin: 0 auto 10px auto; text-align: center; ">
            <div style="text-align: center;  margin: 6px auto;">
                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" style="text-decoration: none">
                    <img src="<?php echo _SQ_ASSETS_URL_ . __('img/editor/sla.png', _SQ_PLUGIN_NAME_); ?>" style="width: 277px"/>
                </a>
            </div>
            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" style="text-decoration: none"><?php _e('To load Squirrly Live Assistant and optimize this page, click to connect to Squirrly Data Cloud.', _SQ_PLUGIN_NAME_); ?></a>
        </div>
    <?php } else { ?>
        <?php SQ_Classes_RemoteController::loadJsVars(); ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
        <?php echo $view->getView('Blocks/SLASearch'); ?>
        <?php echo $view->getView('Blocks/SLASeo'); ?>
    <?php } ?>
</div>
<?php SQ_Classes_RemoteController::loadJsVars(); ?>
