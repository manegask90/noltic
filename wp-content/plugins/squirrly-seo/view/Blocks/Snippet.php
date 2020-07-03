<?php
if (SQ_Classes_Helpers_Tools::getOption('sq_api') <> '') {
    if (SQ_Classes_Helpers_Tools::getOption('sq_use')) {
        if (isset($view->post) && $view->post && isset($view->post->hash) && $view->post->hash <> '') {
            $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');
            $socials = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('socials')));
            $codes = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));

            //Check if the patterns are loaded for this post
            $loadpatterns = true;
            if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern') || !$view->post->sq->do_pattern) {
                $loadpatterns = false;
            }

            //Clear the Title and Description for admin use only
            $view->post->sq->title = $view->post->sq->getClearedTitle();
            $view->post->sq->description = $view->post->sq->getClearedDescription();

            if ($view->post->sq->og_media == '') {
                if ($og = SQ_Classes_ObjController::getClass('SQ_Models_Services_OpenGraph')) {
                    $images = $og->getPostImages();

                    if (!empty($images)) {
                        $image = current($images);
                        if (isset($image['src'])) {
                            if ($view->post->sq->og_media == '') $view->post->sq->og_media = $image['src'];
                        }
                    }
                }
            }

            if ($view->post->sq->tw_media == '') {
                if ($tc = SQ_Classes_ObjController::getClass('SQ_Models_Services_TwitterCard')) {
                    $images = $tc->getPostImages();

                    if (!empty($images)) {
                        $image = current($images);
                        if (isset($image['src'])) {
                            if ($view->post->sq->tw_media == '') $view->post->sq->tw_media = $image['src'];
                        }
                    }
                }
            }

            if ($view->post->ID > 0 && function_exists('get_sample_permalink')) {
                list($permalink, $post_name) = get_sample_permalink($view->post->ID);
                if (strpos($permalink, '%postname%') !== false || strpos($permalink, '%pagename%') !== false) {
                    $view->post->url = str_replace(array('%pagename%', '%postname%'), esc_html($post_name), esc_html(urldecode($permalink)));
                }
            }

            //Set the preview title and description in case Squirrly SEO is switched off for Title and Description
            $preview_title = (SQ_Classes_Helpers_Tools::getOption('sq_auto_title') ? $view->post->sq->title : $view->post->post_title);
            $preview_description = (SQ_Classes_Helpers_Tools::getOption('sq_auto_description') ? $view->post->sq->description : $view->post->post_excerpt);
            $preview_keywords = (SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords') ? $view->post->sq->keywords : '');

            ?>


            <input type="hidden" name="sq_url" value="<?php echo $view->post->url; ?>">
            <input type="hidden" name="sq_post_id" value="<?php echo (int)$view->post->ID; ?>">
            <input type="hidden" name="sq_post_type" value="<?php echo $view->post->post_type; ?>">
            <input type="hidden" name="sq_term_id" value="<?php echo (int)$view->post->term_id; ?>">
            <input type="hidden" name="sq_taxonomy" value="<?php echo $view->post->taxonomy; ?>">
            <input type="hidden" name="sq_hash" id="sq_hash" value="<?php echo $view->post->hash; ?>">

            <?php
            //Run only is frontend admin and ajax call
            if (SQ_Classes_Helpers_Tools::isAjax()) { ?>
                <div id="snippet_<?php echo $view->post->hash ?>" class="sq_snippet_wrap sq-card sq-col-sm-12 sq-p-0 sq-pr-1 sq-m-0 sq-border-0">

                    <div class="sq-card-body sq-p-0">
                        <div class="sq-close sq-close-absolute">x</div>

                        <div class="sq-d-flex sq-flex-row sq-m-0">

                            <!-- ================= Tabs ==================== -->
                            <div class="sq_snippet_menu sq-d-flex sq-flex-column sq-bg-nav sq-mb-0 sq-border-right" role="sqtablist">
                                <ul class="sq-nav sq-nav-tabs sq-nav-tabs--vertical sq-nav-tabs--left">
                                    <li class="sq-nav-item">
                                        <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_metas" style="float: right; z-index: 1; margin: 13px !important;" target="_blank"><i class="fa fa-question-circle-o m-0 px-2" style="display: inline;color: #999 !important;"></i></a>
                                        <a href="#sqtab<?php echo $view->post->hash ?>1" class="sq-nav-item sq-nav-link sq-py-3 sq-text-info" id="sq-nav-item_metas" data-category="metas" data-toggle="sqtab"><?php _e('Meta Tags', _SQ_PLUGIN_NAME_) ?></a>
                                    </li>
                                    <?php if (SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) { ?>
                                        <li class="sq-nav-item">
                                            <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_jsonld" style="float: right; z-index: 1; margin: 13px !important;" target="_blank"><i class="fa fa-question-circle-o m-0 px-2" style="display: inline;color: #999 !important;"></i></a>
                                            <a href="#sqtab<?php echo $view->post->hash ?>2" class="sq-nav-item sq-nav-link sq-py-3 sq-text-info" id="sq-nav-item_jsonld" data-category="jsonld" data-toggle="sqtab"><?php _e('JSON-LD', _SQ_PLUGIN_NAME_) ?></a>
                                        </li>
                                    <?php } ?>
                                    <li class="sq-nav-item">
                                        <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_og" style="float: right; z-index: 1; margin: 13px !important;" target="_blank"><i class="fa fa-question-circle-o m-0 px-2" style="display: inline;color: #999 !important;"></i></a>
                                        <a href="#sqtab<?php echo $view->post->hash ?>3" class="sq-nav-item sq-nav-link sq-py-3 sq-text-info" id="sq-nav-item_opengraph" data-category="opengraph" data-toggle="sqtab"><?php _e('Open Graph', _SQ_PLUGIN_NAME_) ?></a>
                                    </li>
                                    <li class="sq-nav-item">
                                        <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_twittercard" style="float: right; z-index: 1; margin: 13px !important;" target="_blank"><i class="fa fa-question-circle-o m-0 px-2" style="display: inline;color: #999 !important;"></i></a>
                                        <a href="#sqtab<?php echo $view->post->hash ?>4" class="sq-nav-item sq-nav-link sq-py-3 sq-text-info" id="sq-nav-item_twittercard" data-category="twittercard" data-toggle="sqtab"><?php _e('Twitter Card', _SQ_PLUGIN_NAME_) ?></a>
                                    </li>
                                    <li class="sq-nav-item">
                                        <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_visibility" style="float: right; z-index: 1; margin: 13px !important;" target="_blank"><i class="fa fa-question-circle-o m-0 px-2" style="display: inline;color: #999 !important;"></i></a>
                                        <a href="#sqtab<?php echo $view->post->hash ?>6" class="sq-nav-item sq-nav-link sq-py-3 sq-text-info" id="sq-nav-item_visibility" data-category="visibility" data-toggle="sqtab"><?php _e('Visibility', _SQ_PLUGIN_NAME_) ?></a>
                                    </li>
                                </ul>
                            </div>
                            <!-- =================== Optimize ==================== -->

                            <div class="sq-tab-content sq-d-flex sq-flex-column sq-flex-grow-1 sq-bg-white sq-px-3">
                                <div id="sqtab<?php echo $view->post->hash ?>1" class="sq-tab-pane" role="tabpanel">
                                    <div class="sq-card sq-border-0">
                                        <?php if (!$view->post->sq->do_metas) { ?>
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-5 sq-mx-0 sq-px-0 sq-text-danger"><?php echo sprintf(__('Post Type (%s) was excluded from %sSquirrly > SEO Settings%s. Squirrly SEO will not load for this post type on the frontend', _SQ_PLUGIN_NAME_), '<strong>' . $view->post->post_type . '</strong>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="sq-card-body sq_tab_meta sq_tabcontent <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-d-none' : ''; ?>">
                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) { ?>
                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                            <input type="hidden" id="activate_sq_auto_metas" value="1"/>
                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-lg" data-input="activate_sq_auto_metas" data-action="sq_ajax_seosettings_save" data-name="sq_auto_metas"><?php echo __('Activate Metas', _SQ_PLUGIN_NAME_); ?></button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="<?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) ? 'sq_deactivated' : ''); ?>">

                                                    <div class="sq_tab_preview">
                                                        <div class="sq-row sq-border-bottom sq-mb-2 sq-pb-2">
                                                            <div class="sq-col-sm-7">
                                                                <div class="sq_message"><?php _e('How this page will appear on Search Engines', _SQ_PLUGIN_NAME_) ?>:</div>
                                                            </div>
                                                            <div class="sq-col-sm-5 sq-text-right ">
                                                                <div class="sq-refresh"></div>
                                                                <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-warning sq-px-3 sq-rounded-0" value="<?php _e('Refresh', _SQ_PLUGIN_NAME_) ?>"/>
                                                                <input type="button" class="sq_snippet_btn_edit sq-btn sq-btn-sm sq-btn-primary sq-px-3 sq-rounded-0" value="<?php _e('Edit Snippet', _SQ_PLUGIN_NAME_) ?>"/>
                                                            </div>
                                                        </div>
                                                        <?php if ($view->post->post_title <> __('Auto Draft') && $view->post->post_title <> __('AUTO-DRAFT')) { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-mx-auto sq-border">
                                                                <ul class="sq-p-3 sq-m-0" style="min-height: 125px;">
                                                                    <li class="sq_snippet_title sq-text-info sq-font-weight-bold" title="<?php echo $preview_title ?>"><?php echo $preview_title ?></li>
                                                                    <li class="sq_snippet_url sq-text-link" title="<?php echo urldecode($view->post->url) ?>"><?php echo urldecode($view->post->url) ?></li>
                                                                    <li class="sq_snippet_description sq-text-black-50" title="<?php echo $preview_description ?>"><?php echo $preview_description ?></li>
                                                                    <li class="sq_snippet_keywords sq-text-black-50"><?php echo $preview_keywords ?></li>
                                                                </ul>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-border">
                                                                <div style="padding: 20px"><?php echo __('Please save the post first to be able to edit the Squirrly SEO Snippet', _SQ_PLUGIN_NAME_) ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="sq_tab_edit">
                                                        <div class="sq-row">
                                                            <div class="sq-col-sm  sq-border-bottom sq-text-right sq-mb-2 sq-pb-2">
                                                                <input type="button" class="sq_snippet_btn_cancel sq-btn sq-btn-sm sq-btn-warning sq-rounded-0" value="<?php _e('Cancel', _SQ_PLUGIN_NAME_) ?>"/>
                                                                <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-rounded-0" value="<?php _e('Save', _SQ_PLUGIN_NAME_) ?>"/>
                                                            </div>
                                                        </div>

                                                        <div class="sq-row">
                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_title')) { ?>
                                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                            <input type="hidden" id="activate_sq_auto_title" value="1"/>
                                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_title" data-action="sq_ajax_seosettings_save" data-name="sq_auto_title"><?php echo __('Activate Title', _SQ_PLUGIN_NAME_); ?></button>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_title')) ? 'sq_deactivated' : ''); ?>">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Title', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(__('Tips: Length %s-%s chars', _SQ_PLUGIN_NAME_), 10, $view->post->sq_adm->title_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo $view->post->hash ?>">
                                                                        <textarea autocomplete="off" rows="1" name="sq_title" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? __('Pattern: ', _SQ_PLUGIN_NAME_) . $view->post->sq_adm->patterns->title : $view->post->sq->title) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearTitle($view->post->sq_adm->title) ?></textarea>
                                                                        <input type="hidden" id="sq_title_preview_<?php echo $view->post->hash ?>" name="sq_title_preview" value="<?php echo $view->post->sq->title ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo $view->post->sq_adm->title_maxlength ?>"><?php echo strlen($view->post->sq_adm->title) ?>/<?php echo $view->post->sq_adm->title_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <div class="sq-action">
                                                                                <span style="display: none" class="sq-value sq-title-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq->title) ?>"></span>
                                                                                <span class="sq-action-title" title="<?php echo $view->post->sq->title ?>"><?php _e('Current Title', _SQ_PLUGIN_NAME_) ?>: <span class="sq-title-value"><?php echo $view->post->sq->title ?></span></span>
                                                                            </div>
                                                                            <?php if (isset($view->post->post_title) && $view->post->post_title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->post_title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->post_title ?>"><?php _e('Default Title', _SQ_PLUGIN_NAME_) ?>: <span><?php echo $view->post->post_title ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq_adm->patterns->title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->sq_adm->patterns->title ?>"><?php echo($loadpatterns ? __('Pattern', _SQ_PLUGIN_NAME_) . ': <span>' . $view->post->sq_adm->patterns->title . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>


                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_description')) { ?>
                                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                            <input type="hidden" id="activate_sq_auto_description" value="1"/>
                                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_description" data-action="sq_ajax_seosettings_save" data-name="sq_auto_description"><?php echo __('Activate Description', _SQ_PLUGIN_NAME_); ?></button>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_description')) ? 'sq_deactivated' : ''); ?>">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Meta Description', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(__('Tips: Length %s-%s chars', _SQ_PLUGIN_NAME_), 10, $view->post->sq_adm->description_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo $view->post->hash ?>">
                                                                        <textarea autocomplete="off" rows="3" name="sq_description" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? __('Pattern: ', _SQ_PLUGIN_NAME_) . $view->post->sq_adm->patterns->description : $view->post->sq->description) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearDescription($view->post->sq_adm->description) ?></textarea>
                                                                        <input type="hidden" id="sq_description_preview_<?php echo $view->post->hash ?>" name="sq_description_preview" value="<?php echo $view->post->sq->description ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo $view->post->sq_adm->description_maxlength ?>"><?php echo strlen($view->post->sq_adm->description) ?>/<?php echo $view->post->sq_adm->description_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <?php if (isset($view->post->sq->description) && $view->post->sq->description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value sq-description-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq->description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->sq->description ?>"><?php _e('Current Description', _SQ_PLUGIN_NAME_) ?>: <span><?php echo $view->post->sq->description ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if (isset($view->post->post_excerpt) && $view->post->post_excerpt <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->post_excerpt) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->post_excerpt ?>"><?php _e('Default Description', _SQ_PLUGIN_NAME_) ?>: <span><?php echo $view->post->post_excerpt ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq_adm->patterns->description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->sq_adm->patterns->description ?>"><?php echo($loadpatterns ? __('Pattern', _SQ_PLUGIN_NAME_) . ': <span>' . $view->post->sq_adm->patterns->description . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>


                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) { ?>
                                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                            <input type="hidden" id="activate_sq_auto_keywords" value="1"/>
                                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_keywords" data-action="sq_ajax_seosettings_save" data-name="sq_auto_keywords"><?php echo __('Activate Keywords', _SQ_PLUGIN_NAME_); ?></button>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) ? 'sq_deactivated' : ''); ?>">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Meta Keywords', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg">
                                                                        <input type="text" autocomplete="off" name="sq_keywords" class="sq-form-control sq-input-lg" value="<?php echo SQ_Classes_Helpers_Sanitize::clearKeywords($view->post->sq_adm->keywords) ?>" placeholder="<?php _e('+ Add keyword', _SQ_PLUGIN_NAME_) ?>"/>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical')) { ?>
                                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                            <input type="hidden" id="activate_sq_auto_canonical" value="1"/>
                                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_canonical" data-action="sq_ajax_seosettings_save" data-name="sq_auto_canonical"><?php echo __('Activate Canonical', _SQ_PLUGIN_NAME_); ?></button>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-input-group sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical')) ? 'sq_deactivated' : ''); ?>">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Canonical link', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php echo __("Leave it blank if you don't have an external canonical", _SQ_PLUGIN_NAME_); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg">
                                                                        <input type="text" autocomplete="off" name="sq_canonical" class="sq-form-control sq-input-lg sq-toggle" value="<?php echo urldecode($view->post->sq_adm->canonical) ?>" placeholder="<?php echo __('Found: ', _SQ_PLUGIN_NAME_) . urldecode($view->post->url) ?>"/>

                                                                        <div class="sq-actions">
                                                                            <?php if (!is_admin() && !is_network_admin()) { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value sq-canonical-value" data-value=""></span>
                                                                                    <span class="sq-action-title"><?php _e('Current', _SQ_PLUGIN_NAME_) ?>: <span class="sq-canonical-value"></span></span>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <?php if (isset($view->post->url) && $view->post->url <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo urldecode($view->post->url) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo urldecode($view->post->url) ?>"><?php _e('Default Link', _SQ_PLUGIN_NAME_) ?>: <span><?php echo urldecode($view->post->url) ?></span></span>
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
                                        <?php } ?>

                                        <div class="sq-card-footer sq-py-0 sq-my-0 <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-mt-5' : ''; ?>">
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ($view->post->sq_adm->doseo == 1) ? 'display: none' : ''; ?>">
                                                    <?php _e('To edit the snippet, you have to activate Squirrly SEO for this page first', _SQ_PLUGIN_NAME_) ?>
                                                </div>
                                            </div>
                                            <div class="sq-row">

                                                <div class="sq-col-sm-8 sq-row sq-my-0 sq-mx-0 sq-px-0">
                                                    <div class="sq-checker sq-col-sm-12 sq-row sq-my-2 sq-py-1 sq-px-4">
                                                        <div class="sq-col-sm-12 sq-p-0 sq-switch redgreen sq-switch-sm">
                                                            <input type="checkbox" id="sq_doseo_<?php echo $view->post->hash ?>" name="sq_doseo" class="sq-switch" <?php echo ($view->post->sq_adm->doseo == 1) ? 'checked="checked"' : ''; ?> value="1"/>
                                                            <label for="sq_doseo_<?php echo $view->post->hash ?>" class="sq-ml-2"><?php _e('Activate Squirrly Snippet for this page', _SQ_PLUGIN_NAME_); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="sq-col-sm-4 sq-text-right sq-small sq-py-3 sq-px-2 sq-font-italic sq-text-black-50">
                                                    <?php _e('Post Type', _SQ_PLUGIN_NAME_) ?>:
                                                    <strong><?php echo $view->post->post_type ?></strong> |
                                                    <?php _e('OG Type', _SQ_PLUGIN_NAME_) ?>:
                                                    <strong><?php echo $view->post->sq->og_type ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="sqtab<?php echo $view->post->hash ?>2" class="sq-tab-pane" role="tabpanel">
                                    <div class="sq-card sq-border-0">
                                        <div class="sq-card-body sq_tab_jsonld sq_tabcontent <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-d-none' : ''; ?>">
                                            <div class="sq-row">
                                                <div class="sq-col-sm  sq-border-bottom sq-text-right sq-mb-2 sq-pb-2">
                                                    <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-warning sq-px-3 sq-rounded-0" value="<?php _e('Refresh', _SQ_PLUGIN_NAME_) ?>"/>
                                                    <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-rounded-0" value="<?php _e('Save', _SQ_PLUGIN_NAME_) ?>"/>
                                                </div>
                                            </div>

                                            <div class="sq-row">

                                                <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                    <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld')) { ?>
                                                        <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                            <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                                <input type="hidden" id="activate_sq_auto_jsonld" value="1"/>
                                                                <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-lg" data-input="activate_sq_auto_jsonld" data-action="sq_ajax_seosettings_save" data-name="sq_auto_jsonld"><?php echo __('Activate JSON-LD', _SQ_PLUGIN_NAME_); ?></button>
                                                            </div>
                                                        </div>
                                                    <?php } elseif (!$view->post->sq->do_jsonld) { ?>
                                                        <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                            <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                                <?php echo sprintf(__('JSON-LD is disable for this Post Type (%s). See %sSquirrly > SEO Settings > Automation%s.', _SQ_PLUGIN_NAME_), $view->post->post_type, '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php
                                                    SQ_Classes_ObjController::getClass('SQ_Models_Services_JsonLD');
                                                    //remove_all_filters('sq_json_ld');
                                                    if ($jsonld_data = (($view->post->sq_adm->jsonld <> '') ? $view->post->sq_adm->jsonld : (apply_filters('sq_json_ld', false) ? wp_json_encode(apply_filters('sq_json_ld', false)) : false))) {
                                                        $jsonld_data = wp_unslash($jsonld_data);
                                                        $jsonld_data = trim($jsonld_data, '""');
                                                        $jsonld_data = strip_tags($jsonld_data);
                                                    } else {
                                                        $jsonld_data = '';
                                                    }
                                                    ?>

                                                    <div class="sq-col-sm-12 sq-row sq-py-0 sq-m-0 sq-px-0  <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld') || !$view->post->sq->do_jsonld) ? 'sq_deactivated' : ''); ?>">
                                                        <div class="sq-col-sm-12 sq-row sq-my-0 sq-mx-0 sq-px-0">

                                                            <div class="sq-col-sm-12 sq-row sq-my-2 sq-px-0 sq-mx-0 sq-py-1 sq-px-2">

                                                                <div class="sq-col-sm-12 sq-row sq-p-0 sq-m-0">
                                                                    <div class="sq-col-sm-4 sq-p-0 pr-3 sq-font-weight-bold">
                                                                        <?php _e('JSON-LD Code', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-8 sq-p-0 sq-input-group">
                                                                        <select class="sq_jsonld_code_type sq-form-control sq-bg-input sq-mb-1" name="sq_jsonld_code_type">
                                                                            <option <?php echo(($view->post->sq_adm->jsonld == '') ? 'selected="selected"' : '') ?> value="auto"><?php echo __('(Auto)', _SQ_PLUGIN_NAME_) ?></option>
                                                                            <option <?php echo(($view->post->sq_adm->jsonld <> '') ? 'selected="selected"' : '') ?> value="custom"><?php echo __('Custom Code', _SQ_PLUGIN_NAME_) ?></option>
                                                                        </select>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="sq_jsonld_custom_code sq-col-sm-12 sq-row sq-my-2 sq-mx-0 sq-py-1 sq-px-2" <?php echo(($view->post->sq_adm->jsonld == '') ? 'style="display: none;"' : '') ?>>
                                                                <div class="sq-col-sm-4 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                    <?php _e('Custom JSON-LD Code', _SQ_PLUGIN_NAME_); ?>:
                                                                    <div class="sq-small text-black-50 sq-my-1"><?php echo sprintf(__('Add JSON-LD code from %sSchema Generator Online%s.', _SQ_PLUGIN_NAME_), '<a href="https://technicalseo.com/seo-tools/schema-markup-generator/" class="sq-m-0 sq-p-0" target="_blank">', '</a>'); ?></div>
                                                                </div>
                                                                <div class="sq-col-sm-8 sq-p-0 sq-sq-m-0">
                                                                    <textarea class="sq-form-control sq-m-0" name="sq_jsonld" rows="5" style="font-size: 12px !important;"><?php echo $jsonld_data ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="sq-col-sm-12 sq-my-2 sq-py-1 sq-px-2">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-pb-2 sq-mb-2 sq-font-weight-bold sq-border-bottom">
                                                                    <?php _e('Current JSON-LD Code', _SQ_PLUGIN_NAME_); ?>:
                                                                </div>
                                                                <div class="sq-col-sm-12 sq-p-0 sq-small" style="word-break: break-word !important;">
                                                                    <div class="sq-form-control sq-m-0 " style="min-height: 135px; height: auto; border: none; background-color: lightgrey;font-size: 12px !important;" disabled="disabled"><?php echo $jsonld_data; ?></div>
                                                                </div>
                                                                <div class="sq-col-sm-12 sq-p-0 sq-py-1 sq-small">
                                                                    <form method="post" target="_blank" action="https://search.google.com/structured-data/testing-tool">
                                                                        <button type="submit" class="sq-btn sq-btn-secondary sq-btn-block">
                                                                            <i class="fa fa-google"></i><?php _e('Validate', _SQ_PLUGIN_NAME_) ?>
                                                                        </button>
                                                                        <textarea name="code" style="display: none"><script type="application/ld+json"><?php echo $jsonld_data; ?></script></textarea>
                                                                    </form>
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="sq-card-footer sq-py-0 sq-my-0 <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-mt-5' : ''; ?>">
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ($view->post->sq_adm->doseo == 1) ? 'display: none' : ''; ?>">
                                                    <?php _e('To edit the snippet, you have to activate Squirrly SEO for this page first', _SQ_PLUGIN_NAME_) ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div id="sqtab<?php echo $view->post->hash ?>3" class="sq-tab-pane" role="tabpanel">
                                    <div class="sq-card sq-border-0">
                                        <?php if (!$view->post->sq->do_og) { ?>
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-5 sq-mx-0 sq-px-0 sq-text-danger"><?php echo sprintf(__('Post Type (%s) was excluded from %sSquirrly > SEO Settings%s. Squirrly SEO will not load for this post type on the frontend', _SQ_PLUGIN_NAME_), '<strong>' . $view->post->post_type . '</strong>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="sq-card-body sq_tab_facebook sq_tabcontent <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-d-none' : ''; ?>">
                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) { ?>
                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                            <input type="hidden" id="activate_sq_auto_facebook" value="1"/>
                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-lg" data-input="activate_sq_auto_facebook" data-action="sq_ajax_seosettings_save" data-name="sq_auto_facebook"><?php echo __('Activate Open Graph', _SQ_PLUGIN_NAME_); ?></button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="<?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) ? 'sq_deactivated' : ''); ?>">

                                                    <div class="sq_tab_preview">
                                                        <div class="sq-row sq-border-bottom sq-mb-2 sq-pb-2">
                                                            <div class="sq-col-sm">
                                                                <div class="sq_message"><?php _e('How this page appears on Facebook', _SQ_PLUGIN_NAME_) ?>:</div>

                                                            </div>
                                                            <div class="sq-col-sm sq-text-right ">
                                                                <div class="sq-refresh"></div>
                                                                <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-warning sq-px-3 sq-rounded-0" value="<?php _e('Refresh', _SQ_PLUGIN_NAME_) ?>"/>
                                                                <input type="button" class="sq_snippet_btn_edit sq-btn sq-btn-sm sq-btn-primary sq-px-3 sq-rounded-0" value="<?php _e('Edit Open Graph', _SQ_PLUGIN_NAME_) ?>"/>
                                                            </div>
                                                            <?php
                                                            if ($view->post->sq->og_media <> '') {
                                                                @list($width, $height) = getimagesize($view->post->sq->og_media);
                                                                if ((int)$width > 0 && (int)$width < 500) {
                                                                    ?>
                                                                    <div class="sq-col-sm-12">
                                                                        <div class="sq-alert sq-alert-danger"><?php _e('The image size must be at least 500 pixels wide', _SQ_PLUGIN_NAME_) ?></div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php if ($view->post->post_title <> __('Auto Draft') && $view->post->post_title <> __('AUTO-DRAFT')) { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-mx-auto sq-border">
                                                                <ul class="sq-p-3 sq-m-0" style="min-height: 125px;">
                                                                    <?php if ($view->post->sq->og_media <> '') { ?>
                                                                        <li class="sq_snippet_image">
                                                                            <img src="<?php echo $view->post->sq->og_media ?>">
                                                                        </li>
                                                                    <?php } elseif ($view->post->post_attachment <> '') { ?>
                                                                        <li class="sq_snippet_image sq_snippet_post_atachment">
                                                                            <img src="<?php echo $view->post->post_attachment ?>" title="<?php echo __('This is the Featured Image. You can change it if you edit the snippet and upload another image. ', _SQ_PLUGIN_NAME_) ?>">
                                                                        </li>
                                                                    <?php } ?>

                                                                    <li class="sq_snippet_title sq-text-info sq-font-weight-bold"><?php echo($view->post->sq->og_title <> '' ? $view->post->sq->og_title : SQ_Classes_Helpers_Sanitize::truncate($view->post->sq->title, 10, $view->post->sq->og_title_maxlength)) ?></li>
                                                                    <li class="sq_snippet_description sq-text-black-50"><?php echo($view->post->sq->og_description <> '' ? $view->post->sq->og_description : SQ_Classes_Helpers_Sanitize::truncate($view->post->sq->description, 10, $view->post->sq->og_description_maxlength)) ?></li>
                                                                    <li class="sq_snippet_author sq-text-link"><?php echo str_replace(array('//facebook.com/', '//www.facebook.com/', 'https:', 'http:'), '', $view->post->sq->og_author) ?></li>
                                                                    <li class="sq_snippet_sitename sq-text-black-50"><?php echo get_bloginfo('title') ?></li>
                                                                </ul>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-border">
                                                                <div style="padding: 20px"><?php echo __('Please save the post first to be able to edit the Squirrly SEO Snippet', _SQ_PLUGIN_NAME_) ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="sq_tab_edit">
                                                        <div class="sq-row">
                                                            <div class="sq-col-sm  sq-border-bottom sq-text-right sq-mb-2 sq-pb-2">
                                                                <input type="button" class="sq_snippet_btn_cancel sq-btn sq-btn-sm sq-btn-warning sq-rounded-0" value="<?php _e('Cancel', _SQ_PLUGIN_NAME_) ?>"/>
                                                                <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-rounded-0" value="<?php _e('Save', _SQ_PLUGIN_NAME_) ?>"/>
                                                            </div>
                                                        </div>

                                                        <div class="sq-row">
                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Media Image', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg">
                                                                        <button class="sq_get_og_media sq-btn sq-btn-warning sq-form-control sq-input-lg"><?php _e('Upload', _SQ_PLUGIN_NAME_) ?></button>
                                                                        <span><?php _e('Image size must be at least 500 pixels wide', _SQ_PLUGIN_NAME_) ?></span>
                                                                    </div>

                                                                </div>

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <input type="hidden" name="sq_og_media" value="<?php echo $view->post->sq_adm->og_media ?>"/>
                                                                    <div style="max-width: 470px;" class="sq-position-relative sq-offset-sm-3">
                                                                        <span class="sq_og_image_close">x</span>
                                                                        <img class="sq_og_media_preview" src=""/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Title', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(__('Tips: Length %s-%s chars', _SQ_PLUGIN_NAME_), 10, $view->post->sq_adm->og_title_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo $view->post->hash ?>">
                                                                        <textarea autocomplete="off" rows="1" name="sq_og_title" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? __('Pattern: ', _SQ_PLUGIN_NAME_) . $view->post->sq_adm->patterns->title : $view->post->sq->og_title) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearTitle($view->post->sq_adm->og_title) ?></textarea>
                                                                        <input type="hidden" id="sq_title_preview_<?php echo $view->post->hash ?>" name="sq_title_preview" value="<?php echo $view->post->sq->og_title ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo $view->post->sq_adm->og_title_maxlength ?>"><?php echo strlen($view->post->sq_adm->og_title) ?>/<?php echo $view->post->sq_adm->og_title_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <div class="sq-action">
                                                                                <span style="display: none" class="sq-value sq-title-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq->og_title) ?>"></span>
                                                                                <span class="sq-action-title" title="<?php echo $view->post->sq->og_title ?>"><?php _e('Current Title', _SQ_PLUGIN_NAME_) ?>: <span class="sq-title-value"><?php echo $view->post->sq->og_title ?></span></span>
                                                                            </div>
                                                                            <?php if (isset($view->post->post_title) && $view->post->post_title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->post_title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->post_title ?>"><?php _e('Default Title', _SQ_PLUGIN_NAME_) ?>: <span><?php echo $view->post->post_title ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq_adm->patterns->title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->sq_adm->patterns->title ?>"><?php echo($loadpatterns ? __('Pattern', _SQ_PLUGIN_NAME_) . ': <span>' . $view->post->sq_adm->patterns->title . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Description', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(__('Tips: Length %s-%s chars', _SQ_PLUGIN_NAME_), 10, $view->post->sq_adm->og_description_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo $view->post->hash ?>">
                                                                        <textarea autocomplete="off" rows="3" name="sq_og_description" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? __('Pattern: ', _SQ_PLUGIN_NAME_) . $view->post->sq_adm->patterns->description : $view->post->sq->og_description) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearDescription($view->post->sq_adm->og_description) ?></textarea>
                                                                        <input type="hidden" id="sq_description_preview_<?php echo $view->post->hash ?>" name="sq_description_preview" value="<?php echo $view->post->sq->og_description ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo $view->post->sq_adm->og_description_maxlength ?>"><?php echo strlen($view->post->sq_adm->og_description) ?>/<?php echo $view->post->sq_adm->og_description_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <?php if (isset($view->post->sq->og_description) && $view->post->sq->og_description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value sq-description-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq->og_description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->sq->og_description ?>"><?php _e('Current Description', _SQ_PLUGIN_NAME_) ?>: <span><?php echo $view->post->sq->og_description ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if (isset($view->post->post_excerpt) && $view->post->post_excerpt <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->post_excerpt) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->post_excerpt ?>"><?php _e('Default Description', _SQ_PLUGIN_NAME_) ?>: <span><?php echo $view->post->post_excerpt ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq_adm->patterns->description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->sq_adm->patterns->description ?>"><?php echo($loadpatterns ? __('Pattern', _SQ_PLUGIN_NAME_) . ': <span>' . $view->post->sq_adm->patterns->description . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Author Link', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php echo __("For multiple authors, separate their Facebook links with commas", _SQ_PLUGIN_NAME_); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg">
                                                                        <input type="text" autocomplete="off" name="sq_og_author" class="sq-form-control sq-input-lg " value="<?php echo urldecode($view->post->sq_adm->og_author) ?>"/>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('OG Type', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"></div>
                                                                    </div>
                                                                    <?php
                                                                    $post_types = json_decode(SQ_ALL_JSONLD_TYPES, true);
                                                                    ?>
                                                                    <div class="sq-col-sm-4 sq-p-0 sq-input-group">
                                                                        <select name="sq_og_type" class="sq-form-control sq-bg-input sq-mb-1">
                                                                            <option <?php echo(($view->post->sq_adm->og_type == '') ? 'selected="selected"' : '') ?> value=""><?php echo __('(Auto)', _SQ_PLUGIN_NAME_) ?></option>
                                                                            <?php foreach ($post_types as $post_type => $og_type) { ?>
                                                                                <option <?php echo(($view->post->sq_adm->og_type == $og_type) ? 'selected="selected"' : '') ?> value="<?php echo $og_type ?>">
                                                                                    <?php echo ucfirst($og_type) ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>

                                                                </div>

                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sq-card-footer sq-py-0 sq-my-0 <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-mt-5' : ''; ?>">
                                                <div class="sq-row">
                                                    <div class="sq-text-center sq-col-sm-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ($view->post->sq_adm->doseo == 1) ? 'display: none' : ''; ?>">
                                                        <?php _e('To edit the snippet, you have to activate Squirrly SEO for this page first', _SQ_PLUGIN_NAME_) ?>
                                                    </div>
                                                </div>
                                                <div class="sq-row">
                                                    <div class="sq-col-sm-12 sq-text-right sq-small sq-py-3 sq-px-2 sq-font-italic sq-text-black-50">
                                                        <?php _e('Post Type', _SQ_PLUGIN_NAME_) ?>:
                                                        <strong><?php echo $view->post->post_type ?></strong> |
                                                        <?php _e('OG Type', _SQ_PLUGIN_NAME_) ?>:
                                                        <strong><?php echo $view->post->sq->og_type ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>
                                <div id="sqtab<?php echo $view->post->hash ?>4" class="sq-tab-pane" role="tabpanel">
                                    <div class="sq-card sq-border-0">
                                        <?php if (!$view->post->sq->do_twc) { ?>
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-5 sq-mx-0 sq-px-0 sq-text-danger"><?php echo sprintf(__('Post Type (%s) was excluded from %sSquirrly > SEO Settings%s. Squirrly SEO will not load for this post type on the frontend', _SQ_PLUGIN_NAME_), '<strong>' . $view->post->post_type . '</strong>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="sq-card-body sq_tab_twitter sq_tabcontent <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-d-none' : ''; ?>">
                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) { ?>
                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                            <input type="hidden" id="activate_sq_auto_twitter" value="1"/>
                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-lg" data-input="activate_sq_auto_twitter" data-action="sq_ajax_seosettings_save" data-name="sq_auto_twitter"><?php echo __('Activate Twitter Card', _SQ_PLUGIN_NAME_); ?></button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="<?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) ? 'sq_deactivated' : ''); ?>">

                                                    <div class="sq_tab_preview">
                                                        <div class="sq-row sq-border-bottom sq-mb-2 sq-pb-2">
                                                            <div class="sq-col-sm">
                                                                <div class="sq_message"><?php _e('How this page appears on Twitter', _SQ_PLUGIN_NAME_) ?>:</div>

                                                            </div>
                                                            <div class="sq-col-sm sq-text-right ">
                                                                <div class="sq-refresh"></div>
                                                                <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-warning sq-px-3 sq-rounded-0" value="<?php _e('Refresh', _SQ_PLUGIN_NAME_) ?>"/>
                                                                <input type="button" class="sq_snippet_btn_edit sq-btn sq-btn-sm sq-btn-primary sq-px-3 sq-rounded-0" value="<?php _e('Edit Twitter Card', _SQ_PLUGIN_NAME_) ?>"/>
                                                            </div>

                                                            <?php
                                                            if ($view->post->sq->tw_media <> '') {
                                                                @list($width, $height) = getimagesize($view->post->sq->tw_media);
                                                                if ((int)$width > 0 && (int)$width < 500) {
                                                                    ?>
                                                                    <div class="sq-col-sm-12">
                                                                        <div class="sq-alert sq-alert-danger"><?php _e('The image size must be at least 500 pixels wide', _SQ_PLUGIN_NAME_) ?></div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>

                                                        </div>
                                                        <?php if ($view->post->post_title <> __('Auto Draft') && $view->post->post_title <> __('AUTO-DRAFT')) { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-mx-auto sq-border">
                                                                <ul class="sq-p-3 sq-m-0" style="min-height: 125px;">
                                                                    <?php if ($view->post->sq->tw_media <> '') { ?>
                                                                        <li class="sq_snippet_image <?php echo((($view->post->sq_adm->tw_type == '' && $socials->twitter_card_type == 'summary') || $view->post->sq_adm->tw_type == 'summary') ? 'sq_snippet_smallimage' : '') ?>">
                                                                            <img src="<?php echo $view->post->sq->tw_media ?>">
                                                                        </li>
                                                                    <?php } elseif ($view->post->post_attachment <> '') { ?>
                                                                        <li class="sq_snippet_image sq_snippet_post_atachment <?php echo((($view->post->sq_adm->tw_type == '' && $socials->twitter_card_type == 'summary') || $view->post->sq_adm->tw_type == 'summary') ? 'sq_snippet_smallimage' : '') ?>">
                                                                            <img src="<?php echo $view->post->post_attachment ?>" title="<?php echo __('This is the Featured Image. You can change it if you edit the snippet and upload another image.', _SQ_PLUGIN_NAME_) ?>">
                                                                        </li>
                                                                    <?php } ?>

                                                                    <li class="sq_snippet_title sq-text-info sq-font-weight-bold"><?php echo($view->post->sq->tw_title <> '' ? $view->post->sq->tw_title : SQ_Classes_Helpers_Sanitize::truncate($view->post->sq->title, 10, $view->post->sq->tw_title_maxlength)) ?></li>
                                                                    <li class="sq_snippet_description sq-text-black-50"><?php echo($view->post->sq->tw_description <> '' ? $view->post->sq->tw_description : SQ_Classes_Helpers_Sanitize::truncate($view->post->sq->description, 10, $view->post->sq->tw_description_maxlength)) ?></li>
                                                                    <li class="sq_snippet_sitename sq-text-black-50"><?php echo parse_url(get_bloginfo('url'), PHP_URL_HOST) ?></li>
                                                                </ul>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-border">
                                                                <div style="padding: 20px"><?php echo __('Please save the post first to be able to edit the Squirrly SEO Snippet', _SQ_PLUGIN_NAME_) ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="sq_tab_edit">
                                                        <div class="sq-row">
                                                            <div class="sq-col-sm  sq-border-bottom sq-text-right sq-mb-2 sq-pb-2">
                                                                <input type="button" class="sq_snippet_btn_cancel sq-btn sq-btn-sm sq-btn-warning sq-rounded-0" value="<?php _e('Cancel', _SQ_PLUGIN_NAME_) ?>"/>
                                                                <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-rounded-0" value="<?php _e('Save', _SQ_PLUGIN_NAME_) ?>"/>
                                                            </div>
                                                        </div>

                                                        <div class="sq-row">
                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Media Image', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg">
                                                                        <button class="sq_get_tw_media sq-btn sq-btn-warning sq-form-control sq-input-lg"><?php _e('Upload', _SQ_PLUGIN_NAME_) ?></button>
                                                                        <span><?php _e('Image size must be at least 500 pixels wide', _SQ_PLUGIN_NAME_) ?></span>
                                                                    </div>

                                                                </div>

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <input type="hidden" name="sq_tw_media" value="<?php echo $view->post->sq_adm->tw_media ?>"/>
                                                                    <div style="max-width: 470px;" class="sq-position-relative sq-offset-sm-3">
                                                                        <span class="sq_tw_image_close">x</span>
                                                                        <img class="sq_tw_media_preview" src=""/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Title', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(__('Tips: Length %s-%s chars', _SQ_PLUGIN_NAME_), 10, $view->post->sq_adm->og_title_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo $view->post->hash ?>">
                                                                        <textarea autocomplete="off" rows="1" name="sq_tw_title" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? __('Pattern: ', _SQ_PLUGIN_NAME_) . $view->post->sq_adm->patterns->title : $view->post->sq->tw_title) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearTitle($view->post->sq_adm->tw_title) ?></textarea>
                                                                        <input type="hidden" id="sq_title_preview_<?php echo $view->post->hash ?>" name="sq_title_preview" value="<?php echo $view->post->sq->tw_title ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo $view->post->sq_adm->tw_title_maxlength ?>"><?php echo strlen($view->post->sq_adm->tw_title) ?>/<?php echo $view->post->sq_adm->tw_title_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <div class="sq-action">
                                                                                <span style="display: none" class="sq-value sq-title-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq->tw_title) ?>"></span>
                                                                                <span class="sq-action-title" title="<?php echo $view->post->sq->tw_title ?>"><?php _e('Current Title', _SQ_PLUGIN_NAME_) ?>: <span class="sq-title-value"><?php echo $view->post->sq->tw_title ?></span></span>
                                                                            </div>
                                                                            <?php if (isset($view->post->post_title) && $view->post->post_title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->post_title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->post_title ?>"><?php _e('Default Title', _SQ_PLUGIN_NAME_) ?>: <span><?php echo $view->post->post_title ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq_adm->patterns->title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->sq_adm->patterns->title ?>"><?php echo($loadpatterns ? __('Pattern', _SQ_PLUGIN_NAME_) . ': <span>' . $view->post->sq_adm->patterns->title . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Description', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(__('Tips: Length %s-%s chars', _SQ_PLUGIN_NAME_), 10, $view->post->sq_adm->og_description_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo $view->post->hash ?>">
                                                                        <textarea autocomplete="off" rows="3" name="sq_tw_description" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? __('Pattern: ', _SQ_PLUGIN_NAME_) . $view->post->sq_adm->patterns->description : $view->post->sq->tw_description) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearDescription($view->post->sq_adm->tw_description) ?></textarea>
                                                                        <input type="hidden" id="sq_description_preview_<?php echo $view->post->hash ?>" name="sq_description_preview" value="<?php echo $view->post->sq->tw_description ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo $view->post->sq_adm->tw_description_maxlength ?>"><?php echo strlen($view->post->sq_adm->tw_description) ?>/<?php echo $view->post->sq_adm->tw_description_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <?php if (isset($view->post->sq->tw_description) && $view->post->sq->tw_description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value sq-description-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq->tw_description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->sq->tw_description ?>"><?php _e('Current Description', _SQ_PLUGIN_NAME_) ?>: <span><?php echo $view->post->sq->tw_description ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if (isset($view->post->post_excerpt) && $view->post->post_excerpt <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->post_excerpt) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->post_excerpt ?>"><?php _e('Default Description', _SQ_PLUGIN_NAME_) ?>: <span><?php echo $view->post->post_excerpt ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo str_replace('"', '\\"', $view->post->sq_adm->patterns->description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo $view->post->sq_adm->patterns->description ?>"><?php echo($loadpatterns ? __('Pattern', _SQ_PLUGIN_NAME_) . ': <span>' . $view->post->sq_adm->patterns->description . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>


                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php _e('Card Type', _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php echo sprintf(__('Every change needs %sTwitter Card Validator%s', _SQ_PLUGIN_NAME_), '<br /><a href="https://cards-dev.twitter.com/validator?url=' . $view->post->url . '" target="_blank" ><strong>', '</strong></a>'); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-6 sq-p-0 sq-input-group">
                                                                        <select name="sq_tw_type" class="sq-form-control sq-bg-input sq-mb-1">
                                                                            <option <?php echo(($view->post->sq_adm->tw_type == '') ? 'selected="selected"' : '') ?> value=""><?php echo __('(Auto)', _SQ_PLUGIN_NAME_) ?></option>
                                                                            <option <?php echo(($view->post->sq_adm->tw_type == 'summary') ? 'selected="selected"' : '') ?> value="summary"><?php echo __('summary', _SQ_PLUGIN_NAME_) ?></option>
                                                                            <option <?php echo(($view->post->sq_adm->tw_type == 'summary_large_image') ? 'selected="selected"' : '') ?> value="summary_large_image"><?php echo __('summary_large_image', _SQ_PLUGIN_NAME_) ?></option>

                                                                        </select>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sq-card-footer sq-py-0 sq-my-0 <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-mt-5' : ''; ?>">
                                                <div class="sq-row">
                                                    <div class="sq-text-center sq-col-sm-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ($view->post->sq_adm->doseo == 1) ? 'display: none' : ''; ?>">
                                                        <?php _e('To edit the snippet, you have to activate Squirrly SEO for this page first', _SQ_PLUGIN_NAME_) ?>
                                                    </div>
                                                </div>
                                                <div class="sq-row">
                                                    <div class="sq-col-sm-12 sq-text-right sq-small sq-py-3 sq-px-2 sq-font-italic sq-text-black-50">
                                                        <?php _e('Post Type', _SQ_PLUGIN_NAME_) ?>:
                                                        <strong><?php echo $view->post->post_type ?></strong> |
                                                        <?php _e('Twitter Type', _SQ_PLUGIN_NAME_) ?>:
                                                        <strong><?php echo($view->post->sq_adm->tw_type <> '' ? $view->post->sq_adm->tw_type : $socials->twitter_card_type) ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div id="sqtab<?php echo $view->post->hash ?>6" class="sq-tab-pane" role="tabpanel">
                                    <div class="sq-card sq-border-0">
                                        <?php if (get_option('blog_public') == 0) { ?>
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-5 sq-mx-0 sq-px-0 sq-text-danger">
                                                    <?php echo sprintf(__("You selected '%s' in %sSettings > Reading%s. It's important to uncheck that option.", _SQ_PLUGIN_NAME_), __('Discourage search engines from indexing this site'), '<a href="' . admin_url('options-reading.php') . '" target="_blank"><strong>', '</strong></a>') ?>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="sq-card-body sq_tab_visibility sq_tabcontent <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-d-none' : ''; ?>">

                                                <div class="sq-row">
                                                    <div class="sq-col-sm  sq-border-bottom sq-text-right sq-mb-2 sq-pb-2">
                                                        <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-warning sq-px-3 sq-rounded-0" value="<?php _e('Refresh', _SQ_PLUGIN_NAME_) ?>"/>
                                                        <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-rounded-0" value="<?php _e('Save', _SQ_PLUGIN_NAME_) ?>"/>
                                                    </div>
                                                </div>

                                                <div class="sq-row">


                                                    <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                        <?php if (isset($patterns[$view->post->post_type]['noindex']) && $patterns[$view->post->post_type]['noindex']) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                                    <?php echo sprintf(__('This Post Type (%s) has Nofollow set in Automation. See %sSquirrly > SEO Settings > Automation%s.', _SQ_PLUGIN_NAME_), $view->post->post_type, '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?>
                                                                </div>
                                                            </div>
                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                    <input type="hidden" id="activate_sq_auto_noindex" value="1"/>
                                                                    <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_noindex" data-action="sq_ajax_seosettings_save" data-name="sq_auto_noindex"><?php echo __('Activate Robots Meta', _SQ_PLUGIN_NAME_); ?></button>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex') || $patterns[$view->post->post_type]['noindex']) ? 'sq_deactivated' : ''); ?>">
                                                            <div class="sq-col-sm-12 sq-row sq-my-0 sq-mx-0 sq-px-0">


                                                                <div class="sq-checker sq-col-sm-12 sq-row sq-my-2 sq-py-1 sq-px-4">
                                                                    <div class="sq-col-sm-12 sq-p-0 sq-switch redgreen sq-switch-sm">
                                                                        <input type="checkbox" id="sq_noindex_<?php echo $view->post->hash ?>" name="sq_noindex" class="sq-switch" <?php echo ($view->post->sq_adm->noindex == 0) ? 'checked="checked"' : ''; ?> value="0"/>
                                                                        <label for="sq_noindex_<?php echo $view->post->hash ?>" class="sq-ml-2"><?php _e('Let Google Index This Page', _SQ_PLUGIN_NAME_); ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                        <?php if (isset($patterns[$view->post->post_type]['nofollow']) && $patterns[$view->post->post_type]['nofollow']) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                                    <?php echo sprintf(__('This Post Type (%s) has Nofollow set in Automation. See %sSquirrly > SEO Settings > Automation%s.', _SQ_PLUGIN_NAME_), $view->post->post_type, '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?>
                                                                </div>
                                                            </div>
                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                    <input type="hidden" id="activate_sq_auto_noindex" value="1"/>
                                                                    <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_noindex" data-action="sq_ajax_seosettings_save" data-name="sq_auto_noindex"><?php echo __('Activate Robots Meta', _SQ_PLUGIN_NAME_); ?></button>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex') || $patterns[$view->post->post_type]['nofollow']) ? 'sq_deactivated' : ''); ?>">
                                                            <div class="sq-col-sm-12 sq-row sq-my-0 sq-mx-0 sq-px-0">


                                                                <div class="sq-checker sq-col-sm-12 sq-row sq-my-2 sq-py-1 sq-px-4">
                                                                    <div class="sq-col-sm-12 sq-p-0 sq-switch redgreen sq-switch-sm">
                                                                        <input type="checkbox" id="sq_nofollow_<?php echo $view->post->hash ?>" name="sq_nofollow" class="sq-switch" <?php echo ($view->post->sq_adm->nofollow == 0) ? 'checked="checked"' : ''; ?> value="0"/>
                                                                        <label for="sq_nofollow_<?php echo $view->post->hash ?>" class="sq-ml-2"><?php _e('Send Authority to this page', _SQ_PLUGIN_NAME_); ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                        <?php if (!$view->post->sq->do_sitemap) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                                    <?php echo sprintf(__('Show in sitemap for this Post Type (%s) was excluded from %sSquirrly > SEO Settings > Automation%s.', _SQ_PLUGIN_NAME_), $view->post->post_type, '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?>
                                                                </div>
                                                            </div>
                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap')) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                    <input type="hidden" id="activate_sq_auto_sitemap" value="1"/>
                                                                    <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_sitemap" data-action="sq_ajax_seosettings_save" data-name="sq_auto_sitemap"><?php echo __('Activate Sitemap', _SQ_PLUGIN_NAME_); ?></button>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap') || !$view->post->sq->do_sitemap) ? 'sq_deactivated' : ''); ?>">
                                                            <div class="sq-col-sm-12 sq-row sq-my-0 sq-mx-0 sq-px-0">

                                                                <div class="sq-checker sq-col-sm-12 sq-row sq-my-2 sq-py-1 sq-px-4">
                                                                    <div class="sq-col-sm-12 sq-p-0 sq-switch redgreen sq-switch-sm">
                                                                        <input type="checkbox" id="sq_nositemap_<?php echo $view->post->hash ?>" name="sq_nositemap" class="sq-switch" <?php echo ($view->post->sq_adm->nositemap == 0) ? 'checked="checked"' : ''; ?> value="0"/>
                                                                        <label for="sq_nositemap_<?php echo $view->post->hash ?>" class="sq-ml-2"><?php _e('Show it in Sitemap.xml', _SQ_PLUGIN_NAME_); ?></label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="sq-card-footer sq-py-0 sq-my-0 <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-mt-5' : ''; ?>">
                                                <div class="sq-row">
                                                    <div class="sq-text-center sq-col-sm-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ($view->post->sq_adm->doseo == 1) ? 'display: none' : ''; ?>">
                                                        <?php _e('To edit the snippet, you have to activate Squirrly SEO for this page first', _SQ_PLUGIN_NAME_) ?>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- ================ End Tabs ================= -->
                            </div>


                        </div>

                    </div>
                </div>
                <?php
            } else { ?>

                <div class="sq_snippet_wrap sq-card sq-col-sm-12 sq-p-0 sq-m-0 sq-border-0">
                    <div class="sq-card-body sq-p-0">
                        <div class="sq-close sq-close-absolute sq-m-2">x</div>
                        <div class="sq-col-sm-12 sq-m-4 sq-text-center sq-text-black-50">
                            <?php _e("Loading Squirrly Snippet ...", _SQ_PLUGIN_NAME_) ?>
                        </div>
                    </div>
                </div>

                <?php
            }
        } else { ?>

            <div class="sq_snippet_wrap sq-card sq-col-sm-12 sq-p-0 sq-m-0 sq-border-0">
                <div class="sq-card-body sq-p-0">
                    <div class="sq-close sq-close-absolute sq-m-2">x</div>
                    <div class="sq-col-sm-12 sq-m-4 sq-text-center sq-text-black-50">

                    </div>
                </div>
            </div>

            <?php
        }
    } else {
        ?>
        <div class="sq_snippet_wrap sq-card sq-col-sm-12 sq-p-0 sq-m-0 sq-border-0">
            <div class="sq-card-body sq-p-0">
                <div class="sq-close sq-close-absolute sq-m-2">x</div>
                <div class="sq-col-sm-12 sq-m-4 sq-text-center sq-text-danger">
                    <?php _e("Enable Squirrly SEO to load Squirrly Snippet", _SQ_PLUGIN_NAME_) ?>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <div class="sq_snippet_wrap sq-card sq-col-sm-12 sq-p-0 sq-m-0 sq-border-0">
        <div class="sq-card-body sq-p-0">
            <div class="sq-close sq-close-absolute sq-m-2">x</div>
            <div class="sq-col-sm-12 sq-m-4 sq-text-center sq-text-danger">
                <?php echo sprintf(__("%sPlease connect to SquirrlyCloud first%s", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') . '" >', '</a>') ?>
            </div>
        </div>
    </div>

    <?php
}

