<?php $tab = SQ_Classes_Helpers_Tools::getValue('tab', 'register'); ?>
<div class="card col-sm-12 p-0 border-0">
    <div class="card-body">
        <div class="col-sm-12 p-0 m-0"><?php echo apply_filters('sq_form_notices', $view->message); ?></div>

        <?php if ($tab == 'login') { ?>
            <form method="post" action="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard', 'login') ?>">
                <?php SQ_Classes_Helpers_Tools::setNonce('sq_login', 'sq_nonce'); ?>
                <input type="hidden" name="action" value="sq_login"/>
                <div class="form-group">
                    <label for="email"><?php _e('Email:', _SQ_PLUGIN_NAME_); ?></label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label for="pwd"><?php _e('Password:', _SQ_PLUGIN_NAME_); ?></label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard', 'register') ?>"><?php _e('Register to Squirrly.co', _SQ_PLUGIN_NAME_); ?></a> |
                    <a href="<?php echo _SQ_DASH_URL_ . '/login?action=lostpassword' ?>" target="_blank" title="<?php _e('Lost password?', _SQ_PLUGIN_NAME_); ?>"><?php _e('Lost password', _SQ_PLUGIN_NAME_); ?></a>
                </div>
                <button type="submit" class="btn btn-lg btn-primary"><?php _e('Login', _SQ_PLUGIN_NAME_); ?></button>
            </form>
        <?php } elseif ($tab == 'register') { ?>
            <form id="sq_register" method="post" action="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard', 'register') ?>">
                <?php SQ_Classes_Helpers_Tools::setNonce('sq_register', 'sq_nonce'); ?>
                <input type="hidden" name="action" value="sq_register"/>
                <div class="form-group">
                    <label for="email"><?php _e('Email:', _SQ_PLUGIN_NAME_); ?></label>
                    <input type="email" class="form-control" name="email" value="<?php
                    $current_user = wp_get_current_user();
                    echo $current_user->user_email;
                    ?>">
                </div>
                <div class="form-group">
                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard', 'login') ?>"><?php _e('I already have an account', _SQ_PLUGIN_NAME_); ?></a>
                </div>
                <div class="form-group">
                    <input type="checkbox" required id="sq_terms" style="height: 18px;width: 18px; margin: 0 10px;"/><?php echo sprintf(__('I Agree with the Squirrly %sTerms of Use%s and %sPrivacy Policy%s', _SQ_PLUGIN_NAME_), '<a href="https://www.squirrly.co/terms-of-use" target="_blank" >', '</a>', '<a href="https://www.squirrly.co/privacy-policy" target="_blank" >', '</a>'); ?>
                </div>
                <button type="submit" class="btn btn-lg btn-primary noloading"><?php _e('Sign Up', _SQ_PLUGIN_NAME_); ?></button>
            </form>
        <?php } ?>

    </div>

</div>