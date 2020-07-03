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
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_seosettings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">

                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_metas', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_metas"/>

                    <div class="card col-sm-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top row">
                            <div class="col-sm-12 text-left m-0 p-0">
                                <div class="sq_help_question float-right"><a href="https://howto.squirrly.co/kb/seo-metas/" target="_blank"><i class="fa fa-question-circle"></i></a></div>
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_metas_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php _e('SEO Metas', _SQ_PLUGIN_NAME_); ?>:</h3>
                            </div>

                        </div>

                        <div id="sq_seosettings" class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') ? '' : 'sq_deactivated') ?>">

                            <div class="card-body p-0">
                                <div class="col-sm-12 m-0 p-0">
                                    <div class="card col-sm-12 p-0 border-0 ">

                                        <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">
                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_title" value="0"/>
                                                        <input type="checkbox" id="sq_auto_title" name="sq_auto_title" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_title') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_title" class="ml-2"><?php _e('Optimize the Titles', _SQ_PLUGIN_NAME_); ?><a href="https://howto.squirrly.co/kb/seo-metas/#Optimize-The-Titles" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Add the Title Tag in the page header. You can customize it using the Bulk SEO and Squirrly SEO Snippet.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_description" value="0"/>
                                                        <input type="checkbox" id="sq_auto_description" name="sq_auto_description" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_description') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_description" class="ml-2"><?php _e('Optimize Descriptions', _SQ_PLUGIN_NAME_); ?><a href="https://howto.squirrly.co/kb/seo-metas/#Optimize-The-Description" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Add the Description meta in the page header. You can customize it using the Bulk SEO and Squirrly SEO Snippet.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_keywords" value="0"/>
                                                        <input type="checkbox" id="sq_auto_keywords" name="sq_auto_keywords" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_keywords" class="ml-2"><?php _e('Optimize Keywords', _SQ_PLUGIN_NAME_); ?><a href="https://howto.squirrly.co/kb/seo-metas/#Optimize-Keywords" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Add the Keyword meta in the page header. You can customize it using the Bulk SEO and Squirrly SEO Snippet.', _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php _e('This meta is not mandatory for Google but other search engines still use it for ranking', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_canonical" value="0"/>
                                                        <input type="checkbox" id="sq_auto_canonical" name="sq_auto_canonical" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_canonical" class="ml-2"><?php _e('Add Canonical Meta Link', _SQ_PLUGIN_NAME_); ?><a href="https://howto.squirrly.co/kb/seo-metas/#Add-Canonical-Meta-Link" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Add canonical link meta in the page header. You can customize the canonical link on each page.', _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php _e('Also add prev & next links metas in the page header when navigate between blog pages.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_dublincore" value="0"/>
                                                        <input type="checkbox" id="sq_auto_dublincore" name="sq_auto_dublincore" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_dublincore') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_dublincore" class="ml-2"><?php _e('Add Dublin Core Meta', _SQ_PLUGIN_NAME_); ?><a href="https://howto.squirrly.co/kb/seo-metas/#Add-Dublin-Core-Meta" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Add the Dublin Core meta in the page header.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_noindex" value="0"/>
                                                        <input type="checkbox" id="sq_auto_noindex" name="sq_auto_noindex" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_noindex" class="ml-2"><?php _e('Add Robots Meta', _SQ_PLUGIN_NAME_); ?><a href="https://howto.squirrly.co/kb/seo-metas/#Add-Robots-Meta" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Add the Index/Noindex and Follow/Nofollow options in Squirrly SEO Snippet.', _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php _e('Add googlebot and bingbot METAs for better performance.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bg-title p-2 sq_advanced">
                                            <h3 class="card-title"><?php _e('More SEO Settings', _SQ_PLUGIN_NAME_); ?>:</h3>
                                        </div>
                                        <div class="col-sm-12 py-4 border-bottom tab-panel sq_advanced">
                                            <div class="col-sm-12 row mb-1 ml-1 sq_advanced">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_keywordtag" value="0"/>
                                                        <input type="checkbox" id="sq_keywordtag" name="sq_keywordtag" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_keywordtag') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_keywordtag" class="ml-2"><?php _e('Add the Post tags in Keyword META', _SQ_PLUGIN_NAME_); ?><a href="https://howto.squirrly.co/kb/seo-metas/#Add-The-Post-Tags-in-Keyword-Meta" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Add all the tags from your posts as keywords. Not recommended when you use Keywords in Squirrly SEO Snippet.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_use_frontend" value="0"/>
                                                        <input type="checkbox" id="sq_use_frontend" name="sq_use_frontend" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_use_frontend') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_use_frontend" class="ml-2"><?php _e('Activate Snippet in Frontend', _SQ_PLUGIN_NAME_); ?><a href="https://howto.squirrly.co/kb/seo-metas/#Add-Snippet-in-Frontend" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Load Squirrly SEO Snippet in Frontend to customize the SEO directly from page preview.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <?php if ( !get_option('page_on_front')) { ?>

                                        <div class="bg-title p-2">
                                            <h3 class="card-title"><?php _e('First Page Optimization', _SQ_PLUGIN_NAME_); ?>:</h3>
                                            <div class="col-sm-12 text-left m-0 p-0">
                                                <div class="card-title-description mb-0"><?php _e("Needed when you didn't set a specific page as Homepage in Settings > Reading page", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 py-4 border-bottom tab-panel">
                                            <?php
                                            $post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setHomePage();
                                            $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');
                                            ?>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Title', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php _e('Tips: Length 10-75 chars', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_fp_title" value="<?php echo(($post->sq->title <> '') ? $post->sq->title : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Description', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php _e('Tips: Length 70-320 chars', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0">
                                                    <textarea class="form-control" name="sq_fp_description" rows="5"><?php echo(($post->sq->description <> '') ? $post->sq->description : '') ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Keywords', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php _e('Tips: use 2-4 keywords', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_fp_keywords" value="<?php echo(($post->sq->keywords <> '') ? $post->sq->keywords : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('OG Image', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                                    <input id="sq_fp_ogimage" type="text" class="form-control bg-input" name="sq_fp_ogimage" value="<?php echo(($post->sq->og_media <> '') ? $post->sq->og_media : '') ?>"/>
                                                    <input type="button" class="sq_imageselect form-control btn btn-primary rounded-right col-sm-3" data-destination="sq_fp_ogimage" value="<?php echo __('Select Image', _SQ_PLUGIN_NAME_) ?>"/>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="bg-title p-2">
                                            <h3 class="card-title"><?php _e('First Page Preview', _SQ_PLUGIN_NAME_); ?>:</h3>
                                            <div class="col-sm-12 text-left m-0 p-0">
                                                <div class="card-title-description mb-0"><?php _e("See how the social snippet will look like for the front page", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 py-4 border-bottom tab-panel">
                                            <div class="sq_snippet_preview text-center m-auto" class="px-1 mx-auto" style="max-width: 500px;">
                                                <div class="sq_snippet_name"><?php _e('Squirrly Snippet', _SQ_PLUGIN_NAME_) ?></div>

                                                <ul class="sq_snippet_ul p-2">
                                                    <div class="sq_select_ogimage_preview" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) ? '' : 'style="display:none"') ?>>
                                                        <div class="sq_fp_ogimage"><?php echo(($post->sq->og_media <> '') ? '<img src="' . $post->sq->og_media . '" />' : '') ?></div>
                                                    </div>
                                                    <li class="sq_snippet_title"><?php echo(($post->sq->title <> '') ? $post->sq->title : '') ?></li>
                                                    <li class="sq_snippet_description"><?php echo(($post->sq->description <> '') ? $post->sq->description : '') ?></li>
                                                    <li class="sq_snippet_url"><?php echo(($post->url <> '') ? '<a href="' . $post->url . '" target="_blank">' . $post->url . '</a>' : '') ?></li>
                                                </ul>

                                                <div class="sq_snippet_disclaimer"><?php _e("If you don't see any changes in your Google snippet, check if other SEO themes or plugins affect Squirrly.", _SQ_PLUGIN_NAME_) ?></div>
                                            </div>
                                        </div>
                                    <?php } ?>


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
                </form>
            </div>
            <div class="sq_col_side sticky">
                <div class="card col-sm-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
