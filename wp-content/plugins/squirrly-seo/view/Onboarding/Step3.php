<div id="sq_wrap">
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'step3'), 'sq_onboarding'); ?>
        <div class="sq_row d-flex flex-row bg-white px-3">
            <div class="sq_col flex-grow-1 mr-3">

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top row">
                        <div class="col-sm-8 m-0 p-0 py-2 bg-title rounded-top">
                            <div class="sq_icons sq_squirrly_icon m-1 mx-3"></div>
                            <h3 class="card-title"><?php _e('Import SEO & Settings', _SQ_PLUGIN_NAME_); ?></h3>
                        </div>
                        <div class="col-sm-4 m-0 p-0 py-2 text-right">
                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step4') ?>" class="btn rounded-0 btn-success btn-lg px-3 mx-4 float-sm-right"><?php _e('Continue >', _SQ_PLUGIN_NAME_); ?></a>
                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0">
                        <div class="card-body p-0"  style="min-width: 800px;min-height: 430px">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="col-sm-12 p-0 border-0 ">

                                    <div class="col-sm-12 pt-0 pb-4 tab-panel">
                                        <?php
                                        add_filter('sq_themes', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'getAvailableThemes'));
                                        add_filter('sq_plugins', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'getAvailablePlugins'));
                                        $platforms = apply_filters('sq_importList', false);
                                        if ($platforms && count((array)$platforms) > 0) {
                                            ?>
                                            <div class="col-sm-12 card-title pt-4 text-center" style="font-size: 23px; line-height: 35px"><?php _e("We've detected another SEO Plugin on your site.", _SQ_PLUGIN_NAME_); ?></div>

                                            <div id="sq_onboarding">

                                                <div class="col-sm-12 card-title m-2 mt-5 text-center" style="font-size: 20px; line-height: 35px"><?php echo sprintf(__("%sImport your settings and SEO%s from the following plugin into your new Squirrly SEO", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?>:</div>

                                                <div class="col-sm-12 pt-0 pb-4 ml-3 tab-panel">
                                                    <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                                        <div class="col-sm-12 row py-2 mx-0 my-3">
                                                            <div class="col-sm-10 offset-1 p-0 input-group">
                                                                <?php
                                                                if ($platforms && count((array)$platforms) > 0) {
                                                                    ?>
                                                                    <select name="sq_import_platform" class="form-control bg-input mb-1">
                                                                        <?php
                                                                        foreach ($platforms as $path => $settings) {
                                                                            ?>
                                                                            <option value="<?php echo $path ?>"><?php echo ucfirst(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($path)); ?></option>
                                                                        <?php } ?>
                                                                    </select>

                                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_importall', 'sq_nonce'); ?>
                                                                    <input type="hidden" name="action" value="sq_seosettings_importall"/>
                                                                    <button type="submit" class="btn rounded-0 btn-success px-3 mx-2" style="min-width: 140px; max-height: 50px;"><?php _e('Import', _SQ_PLUGIN_NAME_); ?></button>
                                                                <?php } else { ?>
                                                                    <div class="col-sm-12 my-2"><?php _e("We couldn't find any SEO plugin or theme to import from."); ?></div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </form>


                                                    <div class="card-body m-0 py-0">
                                                        <div class="col-sm-12 mt-5 mx-2">
                                                            <h5 class="text-left my-3 text-info"><?php echo __('What you gain'); ?>:</h5>
                                                            <ul style="list-style: circle; margin-left: 30px;">
                                                                <li style="font-size: 15px;"><?php echo __("Everything will be the same in your site, and Google will keep all your rankings safe."); ?></li>
                                                                <li style="font-size: 15px;"><?php echo __("Squirrly SEO covers everything that Google used to see from the old plugin, and brings new stuff in. That's why Google will do more than keep your rankings safe. It might award you with brand new page 1 positions if you use Squirrly."); ?></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-sm-12 mt-5 mx-2">
                                                            <h5 class="text-left my-3 text-info"><?php echo __('If you decide to switch back'); ?>:</h5>
                                                            <ul style="list-style: circle; margin-left: 30px;">
                                                                <li style="font-size: 15px;"><?php echo __("you can always switch back, without any issues. Your old plugin will remain the same. We don't delete it."); ?></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 my-3 p-0 py-3 border-top">
                                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step4') ?>" class="btn rounded-0 btn-default btn-lg px-3 mx-4 float-sm-right"><?php _e('Skip this step', _SQ_PLUGIN_NAME_); ?></a>
                                                </div>
                                            </div>

                                        <?php }else{ ?>
                                        <div class="col-sm-12 card-title pt-5 text-center" style="font-size: 23px; line-height: 35px"><?php _e("We haven't detected other SEO Plugins on your site.", _SQ_PLUGIN_NAME_); ?></div>

                                        <div class="text-center m-5" >
                                            <?php _e("Click Continue to go to the next step.", _SQ_PLUGIN_NAME_); ?>
                                        </div>

                                        <?php } ?>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
</div>
