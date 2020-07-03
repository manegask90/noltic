<?php
$whole = $decimal = 0;
if (isset($view->checkin->subscription_devkit) && $view->checkin->subscription_devkit) {
    ?>
    <div class="card-text col-sm-12 p-0 m-0 border-0">
        <div class="author">
            <i class="avatar sq_icons sq_icon_package"></i>
        </div>
        <div class="title mt-4 mb-0 text-center">
            <h6><?php echo __('Account Info Unavailable', _SQ_PLUGIN_NAME_) ?></h6>
        </div>
    </div>
    <?php
    return;
}
if (isset($view->checkin->product_price) && (int)$view->checkin->product_price > 0) {
    list($whole, $decimal) = explode('.', number_format($view->checkin->product_price, 2, '.', ''));
}
if (isset($view->checkin->subscription_status) && isset($view->checkin->product_name)) {
    if ($view->checkin->subscription_status == 'active' && $view->checkin->product_name == 'Free') {
        $view->checkin->product_name = 'Free + Bonus';
    }
}
?>
<?php if (SQ_Classes_Helpers_Tools::getMenuVisible('show_panel') && current_user_can('manage_options')) { ?>
    <div class="card-text col-sm-12 p-0 m-0 border-0">
        <div class="author">
            <i class="avatar sq_icons sq_icon_package"></i>
        </div>
        <div class="block block-pricing text-center">
            <h1 class="block-caption mt-2">
                <small class="power">$</small>
                <?php echo $whole ?>
                <small class="power"><?php echo($decimal > 0 ? $decimal : '00') ?></small>
                <small><?php echo((int)$view->checkin->subscription_months == 1 ? '/mo' : ((int)$view->checkin->subscription_months == 12 ? '/year' : '')) ?></small>

            </h1>
        </div>
        <div class="title mt-4 mb-0 text-center">
            <ul class="p-0 m-0">
                <?php if (isset($view->checkin->product_name)) { ?>
                    <li>
                        <?php echo __('Your Plan: ', _SQ_PLUGIN_NAME_) ?>
                        <a href="<?php echo SQ_Classes_RemoteController::getMySquirrlyLink('account') ?>" title="<?php _e('Check Account Info', _SQ_PLUGIN_NAME_) ?>" target="_blank"><strong style="font-size: 17px; color: #f7681b;"><?php echo $view->checkin->product_name ?></strong></a>
                    </li>
                <?php } ?>
                <?php if (isset($view->checkin->subscription_email)) { ?>
                    <li>
                        <?php echo __('Email: ', _SQ_PLUGIN_NAME_) ?>
                        <strong><?php echo $view->checkin->subscription_email ?></strong>
                    </li>
                <?php } ?>
                <?php if (isset($view->checkin->subscription_paid) && isset($view->checkin->subscription_expires) && $view->checkin->subscription_paid && $view->checkin->subscription_expires) { ?>
                    <li>
                        <?php echo sprintf(__('Due Date: %s'), '<strong ' . ((time() - strtotime($view->checkin->subscription_expires) > 0) ? 'style="color:red"' : '') . '>' . date('d M Y', strtotime($view->checkin->subscription_expires)) . ' </strong>'); ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php }