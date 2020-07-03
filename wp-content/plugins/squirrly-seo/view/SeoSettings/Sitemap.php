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
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_sitemap', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_sitemap"/>

                    <div class="card col-sm-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top row">
                            <div class="col-sm-8 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_sitemap_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php _e('Sitemap XML', _SQ_PLUGIN_NAME_); ?>:</h3>
                            </div>
                            <div class="col-sm-4 text-right">
                                <div class="checker col-sm-12 row my-2 py-1 mx-0 px-0 ">
                                    <div class="col-sm-12 p-0 sq-switch redgreen sq-switch-sm ">
                                        <label for="sq_auto_sitemap" class="mr-2"><?php _e('Activate Sitemap', _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_sitemap" value="0"/>
                                        <input type="checkbox" id="sq_auto_sitemap" name="sq_auto_sitemap" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_sitemap"></label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php
                        $sitemap = SQ_Classes_Helpers_Tools::getOption('sq_sitemap');
                        $sitemapshow = SQ_Classes_Helpers_Tools::getOption('sq_sitemap_show');
                        ?>
                        <div id="sq_seosettings" class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap') ? '' : 'sq_deactivated') ?>">

                            <div class="card-body p-0">
                                <div class="col-sm-12 m-0 p-0">
                                    <div class="card col-sm-12 p-0 border-0 ">

                                        <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-1">
                                                    <div class="font-weight-bold"><?php _e('Blogging Frequency', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo __('How often do you write new posts?', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group">
                                                    <select name="sq_sitemap_frequency" class="form-control bg-input mb-1">
                                                        <option value="hourly" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency') == 'hourly') ? 'selected="selected"' : ''); ?>><?php _e('every hour', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="daily" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency') == 'daily') ? 'selected="selected"' : ''); ?>><?php _e('every day', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="weekly" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency') == 'weekly') ? 'selected="selected"' : ''); ?>><?php _e('1-3 times per week', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="monthly" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency') == 'monthly') ? 'selected="selected"' : ''); ?>><?php _e('1-3 times per month', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="yearly" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency') == 'yearly') ? 'selected="selected"' : ''); ?>><?php _e('1-3 times per year', _SQ_PLUGIN_NAME_); ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1 sq_advanced">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_sitemap_ping" value="0"/>
                                                        <input type="checkbox" id="sq_sitemap_ping" name="sq_sitemap_ping" class="sq-switch" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sitemap_ping')) ? 'checked="checked"' : ''); ?> value="1"/>
                                                        <label for="sq_sitemap_ping" class="ml-2"><?php _e('Ping New Posts to Google', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Ping your sitemap to Google and Bing when a new post is published.', _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php _e('Not recommended if you added your sitemap in Google Search Console.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php if (function_exists('pll_get_post_translations')) { ?>
                                                <div class="col-sm-12 row mb-1 ml-1 sq_advanced">
                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="hidden" name="sq_sitemap_combinelangs" value="0"/>
                                                            <input type="checkbox" id="sq_sitemap_combinelangs" name="sq_sitemap_combinelangs" class="sq-switch" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sitemap_combinelangs')) ? 'checked="checked"' : ''); ?> value="1"/>
                                                            <label for="sq_sitemap_combinelangs" class="ml-2"><?php _e('Combine Languages in Sitemap', _SQ_PLUGIN_NAME_); ?></label>
                                                            <div class="offset-1 small text-black-50"><?php _e('Add all languages in the same sitemap.xml file', _SQ_PLUGIN_NAME_); ?></div>
                                                            <div class="offset-1 small text-black-50"><?php _e('If not selected, you have to add the language slug for each snippet. e.g. /en/sitemap.xml', _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>


                                        <div class="bg-title p-2">
                                            <h3 class="card-title"><?php _e('Build Sitemaps for', _SQ_PLUGIN_NAME_); ?>:</h3>
                                            <div class="col-sm-12 text-left m-0 p-0">
                                                <div class="card-title-description mb-2"><?php echo sprintf(__('Check the sitemap you want Squirrly to build for your website. Your sitemap will be %s', _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_ObjController::getClass('SQ_Controllers_Sitemaps')->getXmlUrl('sitemap') . '" target="_blank"><strong>' . SQ_Classes_ObjController::getClass('SQ_Controllers_Sitemaps')->getXmlUrl('sitemap') . '</strong></a>'); ?></div>
                                                <div class="card-title-description mb-0"><?php _e("Verify your sitemaps after you activate them to have data. Uncheck them if they don't have URLs to avoid Google errors.", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">
                                            <div class="row mt-3 col-sm-12 border-bottom border-light">
                                                <div class="col-sm mb-1 ml-1">
                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="checkbox" id="sq_sitemap_home" name="sitemap[sitemap-home]" class="sq-switch" value="1" <?php echo(($sitemap['sitemap-home'][1] == 1) ? 'checked="checked"' : ''); ?> />
                                                            <label for="sq_sitemap_home" class="ml-2"><?php _e('Home Page', _SQ_PLUGIN_NAME_); ?></label>
                                                            <div class="offset-2 small text-black-50"><?php _e('Build the sitemap for the home page.', _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm mb-1 ml-1">
                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="checkbox" id="sq_sitemap_news" name="sitemap[sitemap-news]" class="sq-switch" value="1" <?php echo(($sitemap['sitemap-news'][1] == 1) ? 'checked="checked"' : ''); ?> />
                                                            <label for="sq_sitemap_news" class="ml-2"><?php _e('Google News', _SQ_PLUGIN_NAME_); ?></label>
                                                            <div class="offset-2 small text-black-50"><?php echo sprintf(__('Only if you have a news website. Make sure you submit your website to %sGoogle News%s first.', _SQ_PLUGIN_NAME_), '<a href="https://partnerdash.google.com/partnerdash/d/news" target="_blank">', '</a>'); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row mt-3 col-sm-12 border-bottom border-light">
                                                <div class="col-sm mb-1 ml-1">
                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="checkbox" id="sq_sitemap_post" name="sitemap[sitemap-post]" class="sq-switch" value="1" <?php echo(($sitemap['sitemap-post'][1] == 1) ? 'checked="checked"' : ''); ?> />
                                                            <label for="sq_sitemap_post" class="ml-2"><?php _e('Posts', _SQ_PLUGIN_NAME_); ?></label>
                                                            <div class="offset-2 small text-black-50"><?php _e('Build the sitemap for your posts.', _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm mb-1 ml-1">
                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="checkbox" id="sq_sitemap_attachment" name="sitemap[sitemap-attachment]" class="sq-switch" value="1" <?php echo(($sitemap['sitemap-attachment'][1] == 1) ? 'checked="checked"' : ''); ?> />
                                                            <label for="sq_sitemap_attachment" class="ml-2"><?php _e('Attachments', _SQ_PLUGIN_NAME_); ?></label>
                                                            <div class="offset-2 small text-black-50"><?php _e('Only recommended if you have a photography website.', _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3 col-sm-12 border-bottom border-light">
                                                <div class="col-sm mb-1 ml-1">
                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="checkbox" id="sq_sitemap_category" name="sitemap[sitemap-category]" class="sq-switch" value="1" <?php echo(($sitemap['sitemap-category'][1] == 1) ? 'checked="checked"' : ''); ?> />
                                                            <label for="sq_sitemap_category" class="ml-2"><?php _e('Categories', _SQ_PLUGIN_NAME_); ?></label>
                                                            <div class="offset-2 small text-black-50"><?php _e('Build the sitemap for your post categories.', _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm mb-1 ml-1">
                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="checkbox" id="sq_sitemap_post_tag" name="sitemap[sitemap-post_tag]" class="sq-switch" value="1" <?php echo(($sitemap['sitemap-post_tag'][1] == 1) ? 'checked="checked"' : ''); ?> />
                                                            <label for="sq_sitemap_post_tag" class="ml-2"><?php _e('Tags', _SQ_PLUGIN_NAME_); ?></label>
                                                            <div class="offset-2 small text-black-50"><?php _e('Build the sitemap for your post tags.', _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3 col-sm-12 border-bottom border-light">
                                                <div class="col-sm mb-1 ml-1">
                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="checkbox" id="sq_sitemap_page" name="sitemap[sitemap-page]" class="sq-switch" value="1" <?php echo(($sitemap['sitemap-page'][1] == 1) ? 'checked="checked"' : ''); ?> />
                                                            <label for="sq_sitemap_page" class="ml-2"><?php _e('Pages', _SQ_PLUGIN_NAME_); ?></label>
                                                            <div class="offset-2 small text-black-50"><?php _e('Build the sitemap for your pages.', _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm mb-1 ml-1">
                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="checkbox" id="sq_sitemap_archive" name="sitemap[sitemap-archive]" class="sq-switch" value="1" <?php echo(($sitemap['sitemap-archive'][1] == 1) ? 'checked="checked"' : ''); ?> />
                                                            <label for="sq_sitemap_archive" class="ml-2"><?php _e('Archive', _SQ_PLUGIN_NAME_); ?></label>
                                                            <div class="offset-2 small text-black-50"><?php _e('Build the sitemap for your archive links.', _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3 col-sm-12 border-bottom border-light">
                                                <div class="col-sm mb-1 ml-1">
                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="checkbox" id="sq_sitemap_custom-tax" name="sitemap[sitemap-custom-tax]" class="sq-switch" value="1" <?php echo(($sitemap['sitemap-custom-tax'][1] == 1) ? 'checked="checked"' : ''); ?> />
                                                            <label for="sq_sitemap_custom-tax" class="ml-2"><?php _e('Custom Taxonomies', _SQ_PLUGIN_NAME_); ?></label>
                                                            <div class="offset-2 small text-black-50"><?php _e('Build the sitemap for your custom post type categories and tags.', _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm mb-1 ml-1">
                                                    <div class="checker col-sm-12 row my-2 py-1">
                                                        <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="checkbox" id="sq_sitemap_custom-post" name="sitemap[sitemap-custom-post]" class="sq-switch" value="1" <?php echo(($sitemap['sitemap-custom-post'][1] == 1) ? 'checked="checked"' : ''); ?> />
                                                            <label for="sq_sitemap_custom-post" class="ml-2"><?php _e('Custom Posts', _SQ_PLUGIN_NAME_); ?></label>
                                                            <div class="offset-2 small text-black-50"><?php _e('Build the sitemap for your custom post types (other than WP posts and pages).', _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php if (SQ_Classes_Helpers_Tools::isEcommerce()) { //check for ecommerce product ?>
                                                <div class="row mt-3 col-sm-12 border-bottom border-light">
                                                    <div class="col-sm mb-1 ml-1">
                                                        <div class="checker col-sm-12 row my-2 py-1">
                                                            <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                                <input type="checkbox" id="sq_sitemap_product" name="sitemap[sitemap-product]" class="sq-switch" value="1" <?php echo(($sitemap['sitemap-product'][1] == 1) ? 'checked="checked"' : ''); ?> />
                                                                <label for="sq_sitemap_product" class="ml-2"><?php _e('Products', _SQ_PLUGIN_NAME_); ?></label>
                                                                <div class="offset-2 small text-black-50"><?php _e('Build the sitemap for your e-commerce products.', _SQ_PLUGIN_NAME_); ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm mb-1 ml-1">
                                                        <div class="checker col-sm-12 row my-2 py-1">
                                                            <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="col-sm-12 py-4 border-bottom tab-panel">
                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_sitemap_show[images]" value="0"/>
                                                        <input type="checkbox" id="sq_sitemap_show_images" name="sq_sitemap_show[images]" class="sq-switch" <?php echo(($sitemapshow['images']) ? 'checked="checked"' : ''); ?> value="1"/>
                                                        <label for="sq_sitemap_show_images" class="ml-2"><?php _e('Include Images in Sitemap', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Add the image tag for each post with feature image to index your images in Google Image Search.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_sitemap_show[videos]" value="0"/>
                                                        <input type="checkbox" id="sq_sitemap_show_video" name="sq_sitemap_show[videos]" class="sq-switch" <?php echo(($sitemapshow['videos']) ? 'checked="checked"' : ''); ?> value="1"/>
                                                        <label for="sq_sitemap_show_video" class="ml-2"><?php _e('Include Videos in Sitemap', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Add the video tag for each post with embed video in it.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-sm-12 py-4 border-bottom tab-panel sq_advanced">

                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-1">
                                                    <div class="font-weight-bold"><?php _e('Sitemap Pagination', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo __('How many Posts per page to show in sitemap?', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-5 p-0 input-group">
                                                    <select name="sq_sitemap_perpage" class="form-control bg-input mb-1">
                                                        <option value="100" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sitemap_perpage') == '100') ? 'selected="selected"' : ''); ?>>100</option>
                                                        <option value="500" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sitemap_perpage') == '500') ? 'selected="selected"' : ''); ?>>500</option>
                                                        <option value="1000" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sitemap_perpage') == '1000') ? 'selected="selected"' : ''); ?>>1000</option>
                                                        <option value="5000" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sitemap_perpage') == '5000') ? 'selected="selected"' : ''); ?>>5000</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_url_fix" value="0"/>
                                                        <input type="checkbox" id="sq_url_fix" name="sq_url_fix" class="sq-switch" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_url_fix')) ? 'checked="checked"' : ''); ?> value="1"/>
                                                        <label for="sq_url_fix" class="ml-2"><?php _e('Fix Relative URLs', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(__("Make sure that all URLs have the absolute path in each Sitemap. It's important to prevent broken links especially when you export your Sitemap to %sFeedburner%s", _SQ_PLUGIN_NAME_), '<a href="https://feedburner.google.com" target="_blank" >', '</a>'); ?></div>
                                                    </div>
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
            <div class="sq_col_side sticky">
                <div class="card col-sm-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
