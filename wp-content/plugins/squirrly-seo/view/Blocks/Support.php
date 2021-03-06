<div id="sq_options" class="card col-sm-12 p-0 m-0 py-2 my-2 border-0">
    <ul class="p-0 m-0 mx-3">
        <li id="sq_options_dasboard">
            <?php
            if (SQ_Classes_Helpers_Tools::getMenuVisible('show_panel') && current_user_can('manage_options')) { ?>
                <span class="sq_push" style="display:none;">1</span>
                <span class="sq_text"><a href="<?php echo SQ_Classes_RemoteController::getMySquirrlyLink('dashboard') ?>" title="<?php _e('Go to Profile', _SQ_PLUGIN_NAME_) ?>" target="_blank"><span><?php _e('Profile', _SQ_PLUGIN_NAME_) ?></span></a></span>
                <a href="<?php echo SQ_Classes_RemoteController::getMySquirrlyLink('dashboard') ?>" title="<?php _e('Profile', _SQ_PLUGIN_NAME_) ?>" target="_blank"><span class="sq_icon"></span></a>
                <?php
            } else {
                echo '&nbsp;';
            }
            ?>
        </li>

        <li id="sq_options_support">

            <span class="sq_text"><?php _e('Support', _SQ_PLUGIN_NAME_) ?></span><span class="sq_icon"></span>
            <ul class="sq_options_support_popup" style="display: none;">
                <div id="sq_options_close">x</div>
                <li><h6 style="font-weight: bold; font-size: 16px; line-height: 35px"><?php echo __('Need Help with Squirrly SEO?', _SQ_PLUGIN_NAME_) ?></h6></li>

                <li> - <?php echo sprintf(__('10 AM to 4 PM (GMT): Mon-Fri %sby contact form%s.', _SQ_PLUGIN_NAME_), '<a href="' . _SQ_SUPPORT_URL_ . '">', '</a>') ?> </li>
                <li> - <?php echo sprintf(__('How To Squirrly %swebsite%s.', _SQ_PLUGIN_NAME_), '<a href="' . _SQ_HOWTO_URL_ . '" target="_blank">', '</a>') ?> </li>
                <li> - <?php echo sprintf(__('Facebook %sSupport Community%s.', _SQ_PLUGIN_NAME_), '<a href="https://www.facebook.com/groups/SquirrlySEOCustomerService/" target="_blank">', '</a>') ?> </li>
                <li> - <?php echo sprintf(__('Facebook %sMessenger%s.', _SQ_PLUGIN_NAME_), '<a href="https://www.facebook.com/Squirrly.co/" target="_blank">', '</a>') ?> </li>
                <li> - <?php echo sprintf(__('Twitter %sSupport%s.', _SQ_PLUGIN_NAME_), '<a href="https://twitter.com/squirrlyhq" target="_blank">', '</a>') ?> </li>

            </ul>
        </li>
        <li id="sq_options_feedback">

            <span class="sq_icon <?php
            if (isset($_COOKIE['sq_feedback_face']) && (int)$_COOKIE['sq_feedback_face'] > 0) {
                echo 'sq_label_feedback_' . ((int)$_COOKIE['sq_feedback_face'] - 1);
            }
            ?>" <?php
            if (!isset($_COOKIE['sq_feedback_face'])) {
                echo 'title="' . __('How was your Squirrly experience today?', _SQ_PLUGIN_NAME_) . '"';
            }
            ?>></span>
            <?php if (!isset($_COOKIE['sq_feedback_face']) || (isset($_COOKIE['sq_feedback_face']) && (int)$_COOKIE['sq_feedback_face'] < 3)) { ?>
                <?php if (SQ_Classes_Helpers_Tools::getOption('sq_feedback')) { ?>
                    <span class="sq_push">1</span>
                <?php } ?>
                <ul class="sq_options_feedback_popup" style="display: none;">
                    <div id="sq_options_feedback_close">x</div>
                    <li><?php echo __('How was Squirrly today?', _SQ_PLUGIN_NAME_) ?></li>
                    <li>
                        <table width="100%" cellpadding="2" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <label class="sq_label_feedback_smiley sq_label_feedback_0" for="sq_label_feedback_0"></label><input class="sq_feedback_smiley" type="radio" name="sq_feedback_face" id="sq_label_feedback_0" value="1" title="<?php _e('Angry', _SQ_PLUGIN_NAME_) ?>"/><?php _e("Annoying", _SQ_PLUGIN_NAME_) ?>
                                </td>
                                <td>
                                    <label class="sq_label_feedback_smiley sq_label_feedback_1" for="sq_label_feedback_1"></label><input class="sq_feedback_smiley" type="radio" name="sq_feedback_face" id="sq_label_feedback_1" value="2" title="<?php _e('Sad', _SQ_PLUGIN_NAME_) ?>"/><?php _e("Bad", _SQ_PLUGIN_NAME_) ?>
                                </td>
                                <td>
                                    <label class="sq_label_feedback_smiley sq_label_feedback_2" for="sq_label_feedback_2"></label><input class="sq_feedback_smiley" type="radio" name="sq_feedback_face" id="sq_label_feedback_2" value="3" title="<?php _e('Happy', _SQ_PLUGIN_NAME_) ?>"/><?php _e("Nice", _SQ_PLUGIN_NAME_) ?>
                                </td>
                                <td>
                                    <label class="sq_label_feedback_smiley sq_label_feedback_3" for="sq_label_feedback_3"></label><input class="sq_feedback_smiley" type="radio" name="sq_feedback_face" id="sq_label_feedback_3" value="4" title="<?php _e('Excited', _SQ_PLUGIN_NAME_) ?>"/><?php _e("Great", _SQ_PLUGIN_NAME_) ?>
                                </td>
                                <td>
                                    <label class="sq_label_feedback_smiley sq_label_feedback_4" for="sq_label_feedback_4"></label><input class="sq_feedback_smiley" type="radio" name="sq_feedback_face" id="sq_label_feedback_4" value="5" title="<?php _e('Love it', _SQ_PLUGIN_NAME_) ?>"/><?php _e("Love it", _SQ_PLUGIN_NAME_) ?>
                                </td>
                            </tr>
                        </table>
                        <div id="sq_options_feedback_error"></div>
                        <p id="sq_feedback_msg" style="display: none;">
                            <input id="sq_feedback_submit" type="button" value="<?php _e('Send feedback', _SQ_PLUGIN_NAME_) ?>">
                        </p>

                    </li>
                    <li style="margin-top: 10px;"><?php _e('For more support:', _SQ_PLUGIN_NAME_) ?> </li>
                    <li> - <?php echo sprintf(__('10 AM to 4 PM (GMT): Mon-Fri %sby contact form%s.', _SQ_PLUGIN_NAME_), '<a href="' . _SQ_SUPPORT_URL_ . '" target="_blank">', '</a>') ?> </li>
                    <li> - <?php echo sprintf(__('How To Squirrly %swebsite%s.', _SQ_PLUGIN_NAME_), '<a href="' . _SQ_HOWTO_URL_ . '" target="_blank">', '</a>') ?> </li>
                    <li> - <?php echo sprintf(__('Facebook %sSupport Community%s.', _SQ_PLUGIN_NAME_), '<a href="https://www.facebook.com/groups/SquirrlySEOCustomerService/" target="_blank">', '</a>') ?> </li>
                    <li> - <?php echo sprintf(__('Facebook %sMessenger%s.', _SQ_PLUGIN_NAME_), '<a href="https://www.facebook.com/Squirrly.co/" target="_blank">', '</a>') ?> </li>
                    <li> - <?php echo sprintf(__('New Lessons Mon. and Tue. on %sTwitter%s.', _SQ_PLUGIN_NAME_), '<a href="https://twitter.com/squirrlyhq" target="_blank">', '</a>') ?> </li>
                </ul>
            <?php } else { ?>
                <ul class="sq_options_feedback_popup" style="display: none;">
                    <div id="sq_options_feedback_close">x</div>
                    <li><?php echo __('Thank you! You can send us a happy face tomorrow too.', _SQ_PLUGIN_NAME_) ?></li>
                </ul>
            <?php } ?>
        </li>

    </ul>
</div>