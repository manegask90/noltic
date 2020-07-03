<?php
$tasks_completed = SQ_Classes_ObjController::getClass('SQ_Controllers_CheckSeo')->getCongratulations();
$tasks_incompleted = SQ_Classes_ObjController::getClass('SQ_Controllers_CheckSeo')->getNotifications();
?>
<style>
    .sq_offer{
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        padding: 7px;
        margin-bottom: 15px;
    }
    #sq_dashboard_content {
        min-height: 150px;
    }

    #sq_dashboard_content .sq_loading {
        height: 60px;
        background: transparent url('<?php echo _SQ_THEME_URL_ ?>assets/img/loading.gif') no-repeat center !important;
    }

    #sq_dashboard_content .wp_button {
        display: block;
        width: 50%;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: 1px solid #589ee4;
        border-radius: 0;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        padding: .5rem 1rem;
        font-size: 1.25rem;
        line-height: 1;
        color: #fff !important;
        background-color: #589ee4;
        margin: 7px auto;
        cursor: pointer;
    }


    #sq_dashboard_content .sq_strength {
        position: relative;
        height: 190px;
    }

    #sq_dashboard_content .sq_strength .sq_strength-meter {
        float: left;
        width: 120px;
        margin: 25px 31px;
        position: relative;
    }

    #sq_dashboard_content .sq_strength .sq_strength-meter .sq_mask {
        position: absolute;
        height: 138px;
        width: 120px;
        top: 0;
        left: 0;
        display: block;
        z-index: 2
    }

    #sq_dashboard_content .sq_strength .sq_strength-meter .sq_fill .sq_mask {
        position: absolute;
        z-index: 1
    }

    #sq_dashboard_content .sq_strength .sq_strength-meter .sq_strength-data {
        position: relative
    }

    #sq_dashboard_content .sq_strength .sq_strength-meter .sq_level-indicator {
        position: relative;
        overflow: hidden;
        height: 138px;
        width: 120px;
        left: -1px;
        top: -1px;
    }

    #sq_dashboard_content .sq_strength .sq_strength-meter .sq_fill {
        width: 1290px;
        height: 0;
        display: block;
    }

    #sq_dashboard_content .sq_strength .sq_strength-meter .sq_level-separator {
        background: white;
        display: block;
        position: absolute;
        width: 120px;
        left: 0;
        top: 0;
        z-index: 1
    }

    #sq_dashboard_content .sq_strength .sq_subtitle {
        text-align: center;
        font-weight: normal;
        font-style: italic;
        color: #7f0101;
        padding: 0;
        font-size: 14px;
        vertical-align: middle;
    }

    #sq_dashboard_content ul {
        margin: 10px 0 10px 20px;
        list-style: initial;
    }

    #sq_dashboard_content ul li {
        margin: 10px 0;
        line-height: 20px;
    }

    #sq_dashboard_content ul li span {
        font-size: 14px !important;
        line-height: 30px;
    }

    #sq_dashboard_content ul li strong {
        font-size: 105%;
        font-weight: 700;
    }

    #sq_dashboard_content .sq_dashboard_title {
        font-size: 18px;
        text-align: left;
        margin: 30px 0 0 0;
        font-weight: normal;
    }

    #sq_dashboard_content .sq_dashboard_description {
        margin: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #ddd;
        word-break: break-word;
    }

    @media only screen and (max-width: 1030px) {
        #sq_dashboard_content .sq_strength .sq_strength-meter {
            margin-left: 0;
        }
    }

</style>
<div id="sq_dashboard_content" style="position: relative;">
    <?php do_action('sq_form_notices'); ?>

    <div style="margin: 0 0 20px 0;">
        <table class="sq_strength">
            <tr>
                <td class="sq_strength-meter">
                    <div class="sq_strength-data">
                        <div class="sq_level-indicator">
                            <span class="sq_fill"> <img class="sq_mask" alt="" src="<?php echo _SQ_ASSETS_URL_ . 'img/squirrly_filled.png' ?>"></span>
                            <em class="sq_level-separator" style="height:135px;"></em>
                        </div>
                    </div>
                    <img class="sq_mask" alt="" src="<?php echo _SQ_ASSETS_URL_ . 'img/squirrly_blank.png' ?>">
                </td>
                <td class="sq_subtitle">
                    <?php echo __('Upgrade your SEO with Squirrly and improve your rankings on Google', _SQ_PLUGIN_NAME_) ?>
                </td>
            </tr>
        </table>

        <?php if (!empty($tasks_completed)) {
            $tasks_completed = array_values($tasks_completed);

            ?>
            <div class="sq_dashboard_title">
                <strong><?php echo __('Congratulations! you have success messages', _SQ_PLUGIN_NAME_) ?>:
            </div>
            <div class="sq_dashboard_description">
                <ul>
                    <?php
                    foreach ($tasks_completed as $index => $row) { ?>
                        <li>
                            <span style="<?php echo($row['color'] ? 'color:' . $row['color'] . ';' : 'color:darkgreen;') ?>"><img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/' . $row['image'] ?>" style="max-width: 20px; vertical-align: middle; margin: -3px 5px 0 0"/><?php echo(isset($row['message']) ? $row['message'] : '') ?></span>
                        </li>
                        <?php
                        if ($index > 0) break;
                    }
                    ?>
                    <?php if (count($tasks_completed) > 2) { ?>
                        <li>
                            <span style="<?php echo($row['color'] ? 'color:' . $row['color'] . ';' : 'color:orangered;') ?>"><?php echo '+' . (count($tasks_completed) - 2) . ' ' . __('others', _SQ_PLUGIN_NAME_) ?></span>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div style="margin: 20px 0; text-align: center">
                <a class="wp_button" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" style="font-size: 16px;">
                    <?php if (count($tasks_completed) > 2) { ?>
                        <span><?php echo sprintf(__("See %s other achievements", _SQ_PLUGIN_NAME_), '+' . (count($tasks_completed) - 2)) ?></span>
                    <?php } else { ?>
                        <span><?php echo __("See today's achievements", _SQ_PLUGIN_NAME_) ?></span>
                    <?php } ?>
                </a>
            </div>
        <?php } ?>

        <?php if (!empty($tasks_incompleted)) {
            $tasks_incompleted = array_values($tasks_incompleted);
            ?>
            <div class="sq_dashboard_title"><?php echo __('You got new goals for today', _SQ_PLUGIN_NAME_) ?>:</div>
            <div class="sq_dashboard_description">
                <ul>
                    <?php
                    //$tasks_incompleted = array_slice($tasks_incompleted, 0, 2);
                    foreach ($tasks_incompleted as $index => $row) { ?>
                        <li>
                            <span style="<?php echo($row['color'] ? 'color:' . $row['color'] . ';' : 'color:orangered;') ?>"><?php echo(isset($row['warning']) ? $row['warning'] : '') ?></span>
                        </li>
                        <?php
                        if ($index > 0) break;
                    } ?>

                    <?php if (count($tasks_incompleted) > 2) { ?>
                        <li>
                            <span style="<?php echo($row['color'] ? 'color:' . $row['color'] . ';' : 'color:orangered;') ?>"><?php echo '+' . (count($tasks_incompleted) - 2) . ' ' . __('others', _SQ_PLUGIN_NAME_) ?></span>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div style="margin: 20px 0; text-align: center">
                <a class="wp_button" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>#tasks" style="font-size: 16px;">
                    <?php if (count($tasks_incompleted) > 2) { ?>
                        <span><?php echo sprintf(__("See %s other goals", _SQ_PLUGIN_NAME_), '+' . (count($tasks_incompleted) - 2)) ?></span>
                    <?php } else { ?>
                        <span><?php echo __("See today's goals", _SQ_PLUGIN_NAME_) ?></span>
                    <?php } ?>
                </a>
            </div>
        <?php } else { ?>
            <h4 style="margin:20px 0; font-size: 20px; line-height: 30px; text-align: center;">
                <?php echo sprintf(__("No other goals for today. %sGood job!"), '<br />'); ?>
            </h4>
            <div style="margin: 10px 0; text-align: center">
                <a class="wp_button" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'pagelist') ?>" class="btn btn-sm btn-success" style="font-size: 14px"><?php echo __('Rank your best pages with Focus Pages'); ?></a>
            </div>
            <div style="margin: 10px 0; text-align: center">
                <a class="wp_button" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo') ?>" class="btn btn-sm btn-success" style="font-size: 14px"><?php echo __('Boost your SEO with Bulk SEO'); ?></a>
            </div>
        <?php } ?>

    </div>
</div>

<script>
    var sq_profilelevel = function (level) {
        jQuery('.sq_level-separator').animate({height: level}, 500);
        jQuery('.sq_fill-marker').animate({top: level}, 500);
        jQuery('.sq_current-level-description').animate({top: level}, 500);
    };

    setTimeout(function () {
        sq_profilelevel(0);
    }, 1000);

    <?php if (current_user_can('sq_manage_snippets')) {?>
    (function ($) {
        $.fn.sq_widget_recheck = function () {
            var $this = this;
            var $div = $this.find('.inside');

            $div.find('#sq_dashboard_content').html('<div style="font-size: 18px; text-align: center; font-weight: bold; margin: 30px 0;"><?php echo __('Checking the website ...', _SQ_PLUGIN_NAME_) ?></div><div class="sq_loading"></div>');
            $.post(
                sqQuery.ajaxurl,
                {
                    action: 'sq_ajaxcheckseo',
                    sq_nonce: sqQuery.nonce
                }
            ).done(function (response) {
                if (typeof response.data !== 'undefined') {
                    $div.html(response.data);
                }
            }).error(function () {
                $div.html('');
            });
        };

        $(document).ready(function () {
            <?php
            $report_time = SQ_Classes_Helpers_Tools::getOption('seoreport_time');
            if (empty($report_time) || (time() - (int)$report_time) > (3600 * 12)) { ?>
            $('#sq_dashboard_widget').sq_widget_recheck();
            <?php }?>
        });
    })(jQuery);
    <?php }?>

</script>