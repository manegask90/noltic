<?php
$connect = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('connect')));
?>
<div class="ga-connect-place">
    <?php if ($connect->google_analytics) { ?>
        <div class="card col-sm-12 bg-google  px-0 py-0 mx-0">
            <div class="card-heading my-2">
                <h3 class="card-title text-white">
                    <div class="google-icon fa fa-google mx-2"></div><?php echo __('Google Analytics', _SQ_PLUGIN_NAME_); ?>
                </h3>
            </div>
            <div class="card-body bg-light py-3">
                <div class="row">
                    <h6 class="col-sm-7 py-3 m-0  text-black-50"><?php echo __('You are connected to Google Analytics', _SQ_PLUGIN_NAME_) ?></h6>
                    <div class="col-sm-5">
                        <form method="post" class="p-0 m-0" onsubmit="if(!confirm('Are you sure?')){return false;}">
                            <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_ga_revoke', 'sq_nonce'); ?>
                            <input type="hidden" name="action" value="sq_seosettings_ga_revoke"/>
                            <button type="submit" class="btn btn-block btn-social btn-google text-info connect-button connect btn-lg">
                                <?php echo __('Disconnect', _SQ_PLUGIN_NAME_) ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-sm-12 bg-google py-2 mb-2">
            <div class="col-sm-12">
                <h4 class="text-white py-3"><?php echo __('Connect this site to Google Analytics', _SQ_PLUGIN_NAME_); ?></h4>
                <p><?php echo __("Connect Google Analytics and get traffic insights for your website on each Audit", _SQ_PLUGIN_NAME_) ?></p>
            </div>
            <div class="sq_step1 mt-1">
                <a href="<?php echo SQ_Classes_RemoteController::getApiLink('gaoauth'); ?>" onclick="jQuery('.sq_step1').hide();jQuery('.sq_step2').show();" target="_blank" type="button" class="btn btn-block btn-social btn-google text-info connect-button connect btn-lg">
                    <span class="fa fa-google-plus"></span> <?php echo __('Sign in', _SQ_PLUGIN_NAME_); ?>
                </a>
            </div>
            <div class="sq_step2 mt-1" style="display: none">
                <button  type="button" onclick="location.reload();" class="btn btn-block btn-social btn-warning btn-lg">
                    <span class="fa fa-google-plus"></span> <?php echo __('Check connection', _SQ_PLUGIN_NAME_); ?>
                </button>
            </div>
        </div>
    <?php } ?>
</div>