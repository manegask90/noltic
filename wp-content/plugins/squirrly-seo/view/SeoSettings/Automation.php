<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_settings')) {
            echo '<div class="col-sm-12 alert alert-success text-center m-0 p-3">'. __("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_).'</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs('automation', 'sq_seosettings'); ?>
        <div class="d-flex flex-row bg-white px-3">
            <div class="flex-grow-1 mr-3 sq_flex">

                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_automation', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_automation"/>

                    <div class="card col-sm-12 p-0">
                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-sm-8 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_automation_icon m-2"></div>
                                </div>
                                <h3 class="card-title"><?php _e('Meta Automation', _SQ_PLUGIN_NAME_); ?>:</h3>
                                <div class="col-sm-12 text-left m-0 p-0">
                                    <div class="card-title-description m-1"><?php _e('Control how post types are displayed on your site, within search engine results, and social media feeds.', _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <div class="checker col-sm-12 row my-2 py-1 mx-0 px-0 ">
                                    <div class="col-sm-12 p-0 sq-switch redgreen sq-switch-sm ">
                                        <div class="sq_help_question float-right"><a href="https://howto.squirrly.co/kb/seo-automation/" target="_blank"><i class="fa fa-question-circle" style="margin: 0;"></i></a></div>
                                        <label for="sq_auto_pattern" class="ml-2"><?php _e('Activate Patterns', _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_pattern" value="0"/>
                                        <input type="checkbox" id="sq_auto_pattern" name="sq_auto_pattern" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_pattern" class="mx-2"></label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0">

                            <div class="card-body p-0">
                                <div class="col-sm-12 m-0 p-0">
                                    <div class="card col-sm-12 p-0 my-0 border-0 ">

                                        <?php
                                        $filter = array('public' => true, '_builtin' => false);
                                        $types = get_post_types($filter);

                                        $new_types = array();
                                        foreach ($types as $pattern => $type) {
                                            if (in_array($pattern, array_keys(SQ_Classes_Helpers_Tools::getOption('patterns')))) {
                                                continue;
                                            }
                                            $new_types[$pattern] = $type;
                                        }
                                        if (!empty($new_types)) {
                                            ?>
                                            <div class="col-sm-12 m-0 py-4 bg-light border-bottom tab-panel">
                                                <div class="col-sm-12 text-left mb-4 p-0">
                                                    <H5><?php _e("Add Post Type for SEO Automation", _SQ_PLUGIN_NAME_); ?>:</H5>
                                                </div>

                                                <div class="checker col-sm-12 row m-0 p-0 sq_save_ajax">
                                                    <div class="col-sm-12 row py-2 mx-0 my-3">
                                                        <div class="col-sm-4 p-1">
                                                            <div class="font-weight-bold"><?php _e('Add Post Type', _SQ_PLUGIN_NAME_); ?>:<a href="https://howto.squirrly.co/kb/seo-automation/#add_post_type" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></div>
                                                            <div class="small text-black-50"><?php echo __('Add new post types in the list and customize the automation for it.', _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                        <div class="col-sm-8 p-0 input-group">
                                                            <select id="sq_select_post_types" class="form-control bg-input mb-1">
                                                                <?php
                                                                foreach ($new_types as $pattern => $type) {
                                                                    ?>
                                                                    <option value="<?php echo $pattern ?>"><?php echo ucwords(str_replace(array('-', '_'), ' ', $pattern)); ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <button type="button" data-input="sq_select_post_types" data-action="sq_ajax_automation_addpostype" data-name="post_type" class="btn rounded-0 btn-success px-5 mx-4" style="max-height: 45px;"><?php _e('Add Post Type', _SQ_PLUGIN_NAME_); ?></button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="col-sm-12 pt-0 py-4 border-bottom tab-panel">
                                            <div class="col-sm-12 text-left mb-4 p-0">
                                                <h5><?php _e('Customize the automation for each post type', _SQ_PLUGIN_NAME_); ?>:</h5>
                                            </div>

                                            <div class="d-flex flex-row mt-2">

                                                <ul class="nav nav-tabs nav-tabs--vertical nav-tabs--left" id="nav-tab" role="tablist">
                                                    <?php foreach (SQ_Classes_Helpers_Tools::getOption('patterns') as $pattern => $type) {
                                                        if (strpos($pattern, 'product') !== false || strpos($pattern, 'shop') !== false) {
                                                            if (!SQ_Classes_Helpers_Tools::isEcommerce()) {
                                                                continue;
                                                            }
                                                        }

                                                        ?>
                                                        <input type="hidden" name="patterns[<?php echo $pattern ?>][protected]" value="<?php echo((isset($type['protected']) && $type['protected']) ? 1 : 0) ?>"/>

                                                        <li class="nav-item">
                                                            <a class="nav-item nav-link text-info <?php if ($pattern == 'home') { ?>active<?php } ?>" id="nav-<?php echo $pattern ?>-tab" data-toggle="tab" href="#nav-<?php echo $pattern ?>" role="tab" aria-controls="nav-<?php echo $pattern ?>" <?php if ($pattern == 'home') { ?>aria-selected="true" <?php }else{ ?>aria-selected="false"<?php } ?>><?php echo ucwords(str_replace(array('-', '_'), ' ', $pattern)); ?></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                                <div class="tab-content flex-grow-1 border-top border-right border-bottom">
                                                    <?php foreach (SQ_Classes_Helpers_Tools::getOption('patterns') as $pattern => $type) { ?>

                                                        <div class="tab-pane <?php if ($pattern == 'home') { ?>show active<?php } ?>" id="nav-<?php echo $pattern ?>" role="tabpanel" aria-labelledby="nav-<?php echo $pattern ?>-tab">
                                                            <h4 class="col-sm-12 py-3 text-center text-black"><?php echo ucwords(str_replace(array('-', '_'), ' ', $pattern)); ?></h4>

                                                            <div id="sq_seosettings" class="col-sm-12 pt-0 pb-4 border-bottom tab-panel <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern') ? '' : 'sq_deactivated') ?>">

                                                                <div class="col-sm-12 row py-2 mx-0 my-3">
                                                                    <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                                        <?php _e('Title', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="small text-black-50 my-1"><?php _e('Tips: Length 10-75 chars', _SQ_PLUGIN_NAME_); ?></div>
                                                                    </div>
                                                                    <div class="col-sm-8 p-0 input-group input-group-lg sq_pattern_field">
                                                                        <textarea rows="1" class="form-control bg-input" name="patterns[<?php echo $pattern ?>][title]" ><?php echo $type['title'] ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 row py-2 mx-0 my-3">
                                                                    <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                                        <?php _e('Description', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="small text-black-50 my-1"><?php _e('Tips: Length 70-320 chars', _SQ_PLUGIN_NAME_); ?></div>
                                                                    </div>
                                                                    <div class="col-sm-8 p-0 sq_pattern_field">
                                                                        <textarea class="form-control" name="patterns[<?php echo $pattern ?>][description]" rows="5"><?php echo $type['description'] ?></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 row py-2 mx-0 my-3">
                                                                    <div class="col-sm-4 p-1">
                                                                        <div class="font-weight-bold"><?php _e('Separator', _SQ_PLUGIN_NAME_); ?>:</div>
                                                                        <div class="small text-black-50"><?php echo __('Use separator to help user read the most relevant part of your title and increase Conversion Rate', _SQ_PLUGIN_NAME_); ?></div>
                                                                    </div>
                                                                    <div class="col-sm-4 p-0 input-group">
                                                                        <select name="patterns[<?php echo $pattern ?>][sep]" class="form-control bg-input mb-1">
                                                                            <?php
                                                                            $seps = json_decode(SQ_ALL_SEP, true);

                                                                            foreach ($seps as $sep => $code) { ?>
                                                                                <option value="<?php echo $sep ?>" <?php echo ($type['sep'] == $sep) ? 'selected="selected"' : '' ?>><?php echo $code ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 py-4 border-bottom tab-panel">

                                                                <div class="col-sm-12 row mb-1 ml-1">

                                                                    <div class="checker col-sm-12 row my-2 py-1">

                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_metas" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_metas" data-action="sq_ajax_seosettings_save" data-name="sq_auto_metas"><?php echo __('Activate Metas', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_noindex" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_noindex" data-action="sq_ajax_seosettings_save" data-name="sq_auto_noindex"><?php echo __('Activate Robots Meta', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') || !SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo $pattern ?>][noindex]" value="1"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo $pattern ?>_noindex" name="patterns[<?php echo $pattern ?>][noindex]" class="sq-switch" <?php echo(($type['noindex'] == 0) ? 'checked="checked"' : '') ?> value="0"/>
                                                                            <label for="sq_patterns_<?php echo $pattern ?>_noindex" class="ml-2"><?php _e('Let Google Index it', _SQ_PLUGIN_NAME_); ?></label>
                                                                            <div class="offset-1 small text-black-50"><?php _e('If you switch off this option, Squirrly will add noindex meta for this post type.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="col-sm-12 row mb-1 ml-1">
                                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_metas" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_metas" data-action="sq_ajax_seosettings_save" data-name="sq_auto_metas"><?php echo __('Activate Metas', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_noindex" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_noindex" data-action="sq_ajax_seosettings_save" data-name="sq_auto_noindex"><?php echo __('Activate Robots Meta', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') || !SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo $pattern ?>][nofollow]" value="1"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo $pattern ?>_nofollow" name="patterns[<?php echo $pattern ?>][nofollow]" class="sq-switch" <?php echo(($type['nofollow'] == 0) ? 'checked="checked"' : '') ?> value="0"/>
                                                                            <label for="sq_patterns_<?php echo $pattern ?>_nofollow" class="ml-2"><?php _e('Send Authority to it', _SQ_PLUGIN_NAME_); ?></label>
                                                                            <div class="offset-1 small text-black-50"><?php _e('If you sq-switch off this option, Squirrly will add nofollow meta for this post type.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 row mb-1 ml-1">
                                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') || !SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_sitemap" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_sitemap" data-action="sq_ajax_seosettings_save" data-name="sq_auto_sitemap"><?php echo __('Activate Sitemap', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo $pattern ?>][do_sitemap]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo $pattern ?>_do_sitemap" name="patterns[<?php echo $pattern ?>][do_sitemap]" class="sq-switch" <?php echo(($type['do_sitemap'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo $pattern ?>_do_sitemap" class="ml-2"><?php _e('Include In Sitemap', _SQ_PLUGIN_NAME_); ?></label>
                                                                            <div class="offset-1 small text-black-50"><?php _e('Let Squirrly SEO include this post type in Squirrly Sitemap XML.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php
                                                                if(!isset($type['do_redirects'])){
                                                                    $type['do_redirects'] = 0;
                                                                }
                                                                ?>
                                                                <div class="col-sm-12 row mb-1 ml-1">
                                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                                            <input type="hidden" name="patterns[<?php echo $pattern ?>][do_redirects]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo $pattern ?>_do_redirects" name="patterns[<?php echo $pattern ?>][do_redirects]" class="sq-switch" <?php echo(($type['do_redirects'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo $pattern ?>_do_redirects" class="ml-2"><?php _e('Redirect Broken URLs', _SQ_PLUGIN_NAME_); ?></label>
                                                                            <div class="offset-1 small text-black-50"><?php _e('Redirect the broken URL in case it is changed with a new one in Post Editor.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php if ($pattern == 'attachment') { ?>
                                                                    <div class="col-sm-12 row mb-1 ml-1">
                                                                        <div class="checker col-sm-12 row my-2 py-1">
                                                                            <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                                                <input type="hidden" name="sq_attachment_redirect" value="0"/>
                                                                                <input type="checkbox" id="sq_attachment_redirect" name="sq_attachment_redirect" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_attachment_redirect') ? 'checked="checked"' : '') ?> value="1"/>
                                                                                <label for="sq_attachment_redirect" class="ml-2"><?php _e('Redirect Attachments Page', _SQ_PLUGIN_NAME_); ?></label>
                                                                                <div class="offset-1 small text-black-50"><?php _e('Redirect the attachment page to its image URL.', _SQ_PLUGIN_NAME_); ?></div>
                                                                                <div class="offset-1 small text-black-50"><?php _e('Recommended if your website is not a photography website.', _SQ_PLUGIN_NAME_); ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>

                                                            <div class="col-sm-12 py-4 border-bottom tab-panel sq_advanced">

                                                                <div class="col-sm-12 row mb-1 ml-1">
                                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_metas" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_metas" data-action="sq_ajax_seosettings_save" data-name="sq_auto_metas"><?php echo __('Activate Metas', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo $pattern ?>][do_metas]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo $pattern ?>_do_metas" name="patterns[<?php echo $pattern ?>][do_metas]" class="sq-switch" <?php echo(($type['do_metas'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo $pattern ?>_do_metas" class="ml-2"><?php _e('Load Squirrly SEO METAs', _SQ_PLUGIN_NAME_); ?></label>
                                                                            <div class="offset-1 small text-black-50"><?php _e('Let Squirrly SEO load the Title, Description, Keyword METAs for this post type.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 row mb-1 ml-1">
                                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_pattern" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_pattern" data-action="sq_ajax_seosettings_save" data-name="sq_auto_pattern"><?php echo __('Activate Patterns', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo $pattern ?>][do_pattern]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo $pattern ?>_do_pattern" name="patterns[<?php echo $pattern ?>][do_pattern]" class="sq-switch" <?php echo(($type['do_pattern'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo $pattern ?>_do_pattern" class="ml-2"><?php _e('Load Squirrly Patterns', _SQ_PLUGIN_NAME_); ?></label>
                                                                            <div class="offset-1 small text-black-50"><?php _e('Let Squirrly SEO load the Patterns for this post type.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 row mb-1 ml-1">
                                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_jsonld" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_jsonld" data-action="sq_ajax_seosettings_save" data-name="sq_auto_jsonld"><?php echo __('Activate Json-Ld', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo $pattern ?>][do_jsonld]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo $pattern ?>_do_jsonld" name="patterns[<?php echo $pattern ?>][do_jsonld]" class="sq-switch" <?php echo(($type['do_jsonld'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo $pattern ?>_do_jsonld" class="ml-2"><?php _e('Load JSON-LD Structured Data', _SQ_PLUGIN_NAME_); ?></label>
                                                                            <div class="offset-1 small text-black-50"><?php _e('Let Squirrly SEO load the JSON-LD META for this post type.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>


                                                            <div class="col-sm-12 py-4 border-bottom tab-panel sq_advanced">
                                                                <div class="col-sm-12 row py-2 mx-0 my-3">
                                                                    <div class="col-sm-12 my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_social')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_social" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_social" data-action="sq_ajax_seosettings_save" data-name="sq_auto_social"><?php echo __('Activate Social Media', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-sm-12 row m-0 p-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_social')) ? 'sq_deactivated' : ''); ?>">
                                                                            <div class="col-sm-5 p-1 pr-2">
                                                                                <div class="font-weight-bold"><?php _e('Open Graph & JSON-LD Type', _SQ_PLUGIN_NAME_); ?>:</div>
                                                                                <div class="small text-black-50"><?php echo __('Select which Open Graph type to load for this post type.', _SQ_PLUGIN_NAME_); ?></div>
                                                                                <div class="small text-black-50"><?php echo __('JSON-LD will try to load the relevant data for this type.', _SQ_PLUGIN_NAME_); ?></div>
                                                                            </div>
                                                                            <?php
                                                                            $post_types = json_decode(SQ_ALL_JSONLD_TYPES, true);
                                                                            ?>
                                                                            <div class="col-sm-4 p-0 input-group">
                                                                                <select name="patterns[<?php echo $pattern ?>][og_type]" class="form-control bg-input mb-1">
                                                                                    <?php foreach ($post_types as $post_type => $og_type) { ?>
                                                                                        <option <?php echo(($type['og_type'] == $og_type) ? 'selected="selected"' : '') ?> value="<?php echo $og_type ?>">
                                                                                            <?php echo ucfirst($og_type) ?>
                                                                                        </option>
                                                                                    <?php } ?>

                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 row mb-1 ml-1 ">
                                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_social')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_social" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_social" data-action="sq_ajax_seosettings_save" data-name="sq_auto_social"><?php echo __('Activate Social Media', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_og" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_og" data-action="sq_ajax_seosettings_save" data-name="sq_auto_facebook"><?php echo __('Activate Open Graph', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_social') || !SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo $pattern ?>][do_og]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo $pattern ?>_do_og" name="patterns[<?php echo $pattern ?>][do_og]" class="sq-switch" <?php echo(($type['do_og'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo $pattern ?>_do_og" class="ml-2"><?php _e('Load Squirrly Open Graph', _SQ_PLUGIN_NAME_); ?></label>
                                                                            <div class="offset-1 small text-black-50"><?php _e('Let Squirrly SEO load the Open Graph for this post type.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-sm-12 row mb-1 ml-1 ">
                                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_social')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_social" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_social" data-action="sq_ajax_seosettings_save" data-name="sq_auto_social"><?php echo __('Activate Social Media', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_twc" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_twc" data-action="sq_ajax_seosettings_save" data-name="sq_auto_twitter"><?php echo __('Activate Twitter Card', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_social') || !SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo $pattern ?>][do_twc]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo $pattern ?>_do_twc" name="patterns[<?php echo $pattern ?>][do_twc]" class="sq-switch" <?php echo(($type['do_twc'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo $pattern ?>_do_twc" class="ml-2"><?php _e('Load Squirrly Twitter Card', _SQ_PLUGIN_NAME_); ?></label>
                                                                            <div class="offset-1 small text-black-50"><?php _e('Let Squirrly SEO load the Twitter Card for this post type.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="col-sm-12 py-4 border-bottom tab-panel sq_advanced">

                                                                <div class="col-sm-12 row mb-1 ml-1 ">
                                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_ganalytics" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_ganalytics" data-action="sq_ajax_seosettings_save" data-name="sq_auto_tracking"><?php echo __('Activate Trackers', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo $pattern ?>][do_analytics]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo $pattern ?>_do_analytics" name="patterns[<?php echo $pattern ?>][do_analytics]" class="sq-switch" <?php echo(($type['do_analytics'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo $pattern ?>_do_analytics" class="ml-2"><?php _e('Load Google Analytics Tracking Script', _SQ_PLUGIN_NAME_); ?></label>
                                                                            <div class="offset-1 small text-black-50"><?php _e('Let Google Analytics Tracking to load for this post type.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 row mb-1 ml-1 ">
                                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking')) { ?>
                                                                            <div class="sq_deactivated_label col-sm-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-sm-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_fpixel" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_fpixel" data-action="sq_ajax_seosettings_save" data-name="sq_auto_tracking"><?php echo __('Activate Trackers', _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo $pattern ?>][do_fpixel]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo $pattern ?>_do_fpixel" name="patterns[<?php echo $pattern ?>][do_fpixel]" class="sq-switch" <?php echo(($type['do_fpixel'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo $pattern ?>_do_fpixel" class="ml-2"><?php _e('Load Facebook Pixel Tracking Script', _SQ_PLUGIN_NAME_); ?></label>
                                                                            <div class="offset-1 small text-black-50"><?php _e('Let Facebook Pixel Tracking to load for this post type.', _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php if ($pattern <> 'custom' && (!isset($type['protected']) || !$type['protected'])) { ?>
                                                                <div class="checker col-sm-12 row m-0 p-3 sq_save_ajax">
                                                                    <div class="col-sm-12 p-0 text-right">
                                                                        <input type="hidden" id="sq_delete_post_types_<?php echo $pattern ?>" value="<?php echo $pattern ?>"/>
                                                                        <button type="button" data-confirm="<?php echo sprintf(__('Do you want to delete the automation for %s?', _SQ_PLUGIN_NAME_), ucwords(str_replace(array('-', '_'), array(' '), $pattern))); ?>" data-input="sq_delete_post_types_<?php echo $pattern ?>" data-action="sq_ajax_automation_deletepostype" data-name="post_type" class="btn btn-link btn-sm text-black-50 rounded-0"><?php echo sprintf(__('Remove automation for %s', _SQ_PLUGIN_NAME_), ucwords(str_replace(array('-', '_'), array(' '), $pattern))); ?></button>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>

                                                    <?php } ?>
                                                    <div class="col-sm-12 my-3 p-0">
                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) { ?>
                                                            <div class="py-0 float-right text-right m-2">
                                                                <button type="button" class="show_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0"><?php _e('Show Advanced Options', _SQ_PLUGIN_NAME_); ?></button>
                                                                <button type="button" class="hide_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0" style="display: none"><?php _e('Hide Advanced Options', _SQ_PLUGIN_NAME_); ?></button>
                                                            </div>
                                                        <?php } ?>
                                                        <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php _e('Save Settings', _SQ_PLUGIN_NAME_); ?></button>

                                                    </div>

                                                </div>

                                            </div>


                                        </div>




                                        <div class="bg-title p-2">
                                            <h3 class="card-title"><?php _e('Squirrly Patterns', _SQ_PLUGIN_NAME_); ?>:<a href="https://howto.squirrly.co/kb/seo-automation/#add_patterns" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;font-size: 20px !important;"></i></a></h3>
                                            <div class="col-sm-12 text-left m-0 p-0">
                                                <div class="card-title-description mb-0"><?php _e("Use the Pattern system to prevent Title and Description duplicates between posts", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 py-4 border-bottom tab-panel ">

                                            <div class="col-sm-12 text-left m-0 p-0">
                                                <div class="card-title-description m-3"><?php _e("Patterns change the codes like {{title}} with the actual value of the post Title.", _SQ_PLUGIN_NAME_); ?></div>
                                                <div class="card-title-description m-3"><?php _e("In Squirrly, each post type in your site comes with a predefined posting pattern when displayed onto your website. However, based on your site's purpose and needs, you can also decide what information these patterns will include.", _SQ_PLUGIN_NAME_); ?></div>
                                                <div class="card-title-description m-3"><?php _e("Once you set up a pattern for a particular post type, only the content required by your custom sequence will be displayed.", _SQ_PLUGIN_NAME_); ?></div>
                                                <div class="card-title-description m-3"><?php echo sprintf(__("Squirrly lets you see how the customized patterns will apply when posts/pages are shared across social media or search engine feeds. You just need to go to the %sBulk SEO%s and see the meta information for each post type.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo') . '" ><strong>', '</strong></a>'); ?></div>
                                            </div>
                                        </div>

                                        <?php
                                        $metas = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('sq_metas')));
                                        ?>
                                        <div class="bg-title p-2 sq_advanced">
                                            <h3 class="card-title"><?php _e('META Lengths', _SQ_PLUGIN_NAME_); ?>:<a href="https://howto.squirrly.co/kb/seo-automation/#automation_custom_lengths" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;font-size: 20px !important;"></i></a></h3>
                                            <div class="col-sm-12 text-left m-0 p-0">
                                                <div class="card-title-description mb-0"><?php _e("Change the lengths for each META on automation", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 py-4 border-bottom tab-panel sq_advanced">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-1 pr-3 font-weight-bold">
                                                    <?php _e('Title Length', _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-sm-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[title_maxlength]" value="<?php echo (int)$metas->title_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-1 pr-3 font-weight-bold">
                                                    <?php _e('Description Length', _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-sm-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[description_maxlength]" value="<?php echo (int)$metas->description_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-1 pr-3 font-weight-bold">
                                                    <?php _e('Open Graph Title Length', _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-sm-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[og_title_maxlength]" value="<?php echo (int)$metas->og_title_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-1 pr-3 font-weight-bold">
                                                    <?php _e('Open Graph Description Length', _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-sm-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[og_description_maxlength]" value="<?php echo (int)$metas->og_description_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-1 pr-3 font-weight-bold">
                                                    <?php _e('Twitter Card Title Length', _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-sm-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[tw_title_maxlength]" value="<?php echo (int)$metas->tw_title_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-1 pr-3 font-weight-bold">
                                                    <?php _e('Twitter Card Description Length', _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-sm-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[tw_description_maxlength]" value="<?php echo (int)$metas->tw_description_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-1 pr-3 font-weight-bold">
                                                    <?php _e('JSON-LD Title Length', _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-sm-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[jsonld_title_maxlength]" value="<?php echo (int)$metas->jsonld_title_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-1 pr-3 font-weight-bold">
                                                    <?php _e('JSON-LD Description Length', _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-sm-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[jsonld_description_maxlength]" value="<?php echo (int)$metas->jsonld_description_maxlength ?>"/>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12 my-3 p-0">
                            <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) { ?>
                                <div class="py-0 float-right text-right m-2">
                                    <button type="button" class="show_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0"><?php _e('Show Advanced Options', _SQ_PLUGIN_NAME_); ?></button>
                                    <button type="button" class="hide_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0" style="display: none"><?php _e('Hide Advanced Options', _SQ_PLUGIN_NAME_); ?></button>
                                </div>
                            <?php } ?>
                            <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php _e('Save Settings', _SQ_PLUGIN_NAME_); ?></button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="sq_col sq_col_side ">
                <div class="card col-sm-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
