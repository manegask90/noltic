<?php if (current_user_can('sq_manage_snippets') && SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) { ?>
    <div class="card col-sm-12 p-0 m-0 border-0">
        <div class="card-body py-1">
            <div id="sq_assistant_sq_seosettings" class="sq_assistant">
                <form method="post" action="">
                    <ul id="sq_assistant_tasks_sq_seosettings" class="p-0 m-0">
                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_cloud_connect')) { ?>

                            <li class="sq_task row border-0" style="cursor: default">
                                <?php SQ_Classes_Helpers_Tools::setNonce('sq_cloud_connect', 'sq_nonce'); ?>
                                <input type="hidden" name="action" value="sq_cloud_connect"/>
                                <i class="fa fa-check" title="ssss" data-original-title=""></i>
                                <div class="message" style="display: none"></div>
                                <div class="description" style="display: none"><?php _e('This option is used to track innerlinks and insights for your Focus Pages and give detailed informations about them.', _SQ_PLUGIN_NAME_); ?></div>
                                <h4>
                                    <?php _e('Let Squirrly API get data for Focus Pages', _SQ_PLUGIN_NAME_); ?>
                                    <button type="submit" class="btn btn-primary btn-sm inline p-0 px-3 m-0"><?php _e('Connect', _SQ_PLUGIN_NAME_); ?></button>
                                </h4>
                            </li>

                        <?php } else { ?>

                            <li class="sq_task row completed border-0" style="cursor: default">
                                <?php SQ_Classes_Helpers_Tools::setNonce('sq_cloud_disconnect', 'sq_nonce'); ?>
                                <input type="hidden" name="action" value="sq_cloud_disconnect"/>
                                <i class="fa fa-check" title="" data-original-title=""></i>
                                <div class="message" style="display: none"></div>
                                <div class="description" style="display: none"><?php _e('This option is used to track innerlinks and insights for your Focus Pages and give detailed informations about them.', _SQ_PLUGIN_NAME_); ?></div>
                                <h4>
                                    <?php _e('Let Squirrly API get data for Focus Pages', _SQ_PLUGIN_NAME_); ?>
                                    <button type="submit" class="btn btn-link btn-sm inline p-0 m-0">(<?php _e('disconnect', _SQ_PLUGIN_NAME_); ?>)</button>
                                </h4>
                            </li>

                        <?php } ?>
                    </ul>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
