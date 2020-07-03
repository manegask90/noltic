<div id="sq_toolbarblog" class="col-sm-12 m-0 p-0">
    <nav class="navbar navbar-expand-sm" color-on-scroll="500">
        <div class=" container-fluid  ">
            <div class="justify-content-start" id="navigation">
                <ul class="nav navbar-nav mr-auto">
                    <?php
                    $visitedmenu = false;
                    $mainmenu = SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getMainMenu();
                    if (SQ_Classes_Helpers_Tools::getOption('sq_api') <> '' && SQ_Classes_Helpers_Tools::getOption('sq_onboarding') == SQ_VERSION) {
                        $visitedmenu = SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getVisitedMenu();
                    }
                    $errors = apply_filters('sq_seo_errors', 0);

                    if (!empty($mainmenu)) {
                        foreach ($mainmenu as $menuid => $item) {
                            if ($menuid == 'sq_audits' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_audit')) {
                                continue;
                            } elseif ($menuid == 'sq_rankings' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_rankings')) {
                                continue;
                            } elseif ($menuid == 'sq_focuspages' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_focuspages')) {
                                continue;
                            } elseif (!isset($item['parent'])) {
                                continue;
                            }
                            //make sure the user has the capabilities
                            if (current_user_can($item['capability'])) {
                                if ($menuid <> 'sq_dashboard') {
                                    ?>
                                    <li class="nav-item" style="    padding-top: 8px;">
                                        <svg class="separator" height="40" width="20" xmlns="http://www.w3.org/2000/svg">
                                            <?php if(is_rtl()){ ?>
                                                <line stroke="lightgray" stroke-width="1" x1="0" x2="19" y1="40" y2="20"></line>
                                                <line stroke="lightgray" stroke-width="1" x1="0" x2="19" y1="0" y2="20"></line>
                                            <?php }else{ ?>
                                                <line stroke="lightgray" stroke-width="1" x1="0" x2="19" y1="0" y2="20"></line>
                                                <line stroke="lightgray" stroke-width="1" x1="0" x2="19" y1="40" y2="20"></line>
                                            <?php } ?>
                                        </svg>
                                    </li>
                                <?php } ?>
                                <?php $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', false)); ?>
                                <li class="nav-item <?php echo(($page == $menuid) ? 'active' : '') ?>">
                                    <a class="nav-link" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl($menuid) ?>">
                                        <?php echo($menuid == 'sq_dashboard' ? __('Overview', _SQ_PLUGIN_NAME_)  : $item['title']) ?>
                                        <?php echo (($menuid == 'sq_dashboard' && $page <> $menuid && $errors) ? '<span class="sq_errorcount">' . $errors . '</span>' : '') ?>
                                    </a>

                                </li>
                            <?php }
                        }
                    } ?>
                    <li class="sq_help_toolbar">
                        <i class="fa fa-question-circle" onclick="jQuery('.header-search').toggle();"></i></li>
                </ul>
            </div>
        </div>
        <div id="sq_btn_toolbar_close" class="m-0 p-0">
            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" class="btn btn-lg bg-white text-black m-0 mx-2 p-2 px-3 font-weight-bold">X</a>
        </div>
    </nav>
</div>
<?php SQ_Classes_ObjController::getClass('SQ_Core_BlockSearch')->init(); ?>
<?php
//if there is only the dashboard visited
//show the highlight on the main divs
if($visitedmenu && count($visitedmenu) == 1) {
    echo '<div style="position: absolute; width: 100%; height: 100%; background-color: black; z-index: 1; opacity: 0.5"></div>';
}
?>
