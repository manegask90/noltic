<?php

class SQ_Models_ImportExport {

    public function __construct() {
        add_filter('sq_themes', array($this, 'getAvailableThemes'), 10, 1);
        add_filter('sq_importList', array($this, 'importList'));
    }

    public function importList() {
        if ($list = SQ_Classes_Helpers_Tools::getOption('importList')) {
            return $list;
        }

        $themes = array(
            'builder' => array(
                'title' => '_builder_seo_title',
                'descriptionn' => '_builder_seo_description',
                'keywords' => '_builder_seo_keywords',
            ),
            'catalyst' => array(
                'title' => '_catalyst_title',
                'descriptionn' => '_catalyst_description',
                'keywords' => '_catalyst_keywords',
                'noindex' => '_catalyst_noindex',
                'nofollow' => '_catalyst_nofollow',
                'noarchive' => '_catalyst_noarchive',
            ),
            'frugal' => array(
                'title' => '_title',
                'descriptionn' => '_description',
                'keywords' => '_keywords',
                'noindex' => '_noindex',
                'nofollow' => '_nofollow',
            ),
            'genesis' => array(
                'title' => '_genesis_title',
                'descriptionn' => '_genesis_description',
                'keywords' => '_genesis_keywords',
                'noindex' => '_genesis_noindex',
                'nofollow' => '_genesis_nofollow',
                'noarchive' => '_genesis_noarchive',
                'canonical' => '_genesis_canonical_uri',
                'redirect' => 'redirect',
            ),
            'headway' => array(
                'title' => '_title',
                'descriptionn' => '_description',
                'keywords' => '_keywords',
            ),
            'hybrid' => array(
                'title' => 'Title',
                'descriptionn' => 'Description',
                'keywords' => 'Keywords',
            ),
            'thesis' => array(
                'title' => 'thesis_title',
                'description' => 'thesis_description',
                'keywords' => 'thesis_keywords',
                'redirect' => 'thesis_redirect',
            ),
            'wooframework' => array(
                'title' => 'seo_title',
                'description' => 'seo_description',
                'keywords' => 'seo_keywords',
            ),
        );

        $plugins = array(
            'add-meta-tags' => array(
                'title' => '_amt_title',
                'description' => '_amt_description',
                'keywords' => '_amt_keywords',
            ),
            'gregs-high-performance-seo' => array(
                'title' => '_ghpseo_secondary_title',
                'description' => '_ghpseo_alternative_description',
                'keywords' => '_ghpseo_keywords',
            ),
            'headspace2' => array(
                'title' => '_headspace_page_title',
                'description' => '_headspace_description',
                'keywords' => '_headspace_keywords',
            ),
            'wpmu-dev-seo' => array(
                'title' => '_wds_title',
                'description' => '_wds_metadesc',
                'keywords' => '_wds_keywords',
                'noindex' => '_wds_meta-robots-noindex',
                'nofollow' => '_wds_meta-robots-nofollow',
                'robots' => '_wds_meta-robots-adv',
                'canonical' => '_wds_canonical',
                'redirect' => '_wds_redirect',
            ),
            'jetpack' => array(
                'description' => 'advanced_seo_description',
            ),
            'platinum-seo-pack' => array(
                'title' => 'title',
                'description' => 'description',
                'keywords' => 'keywords',
            ),
            'seo-pressor' => array(
                'title' => '_seopressor_meta_title',
                'description' => '_seopressor_meta_description',
            ),
            'seo-title-tag' => array(
                'Custom Doctitle' => 'title_tag',
                'META Description' => 'meta_description',
            ),
            'seo-ultimate' => array(
                'title' => '_su_title',
                'description' => '_su_description',
                'keywords' => '_su_keywords',
                'noindex' => '_su_meta_robots_noindex',
                'nofollow' => '_su_meta_robots_nofollow',
            ),
            'rank-math' => array(
                'title' => 'rank_math_title',
                'description' => 'rank_math_description',
                'keywords' => 'rank_math_focus_keyword',
                'canonical' => 'rank_math_canonical_url',
                'og_title' => 'rank_math_facebook_title',
                'og_description' => 'rank_math_facebook_description',
                'og_media' => 'rank_math_facebook_image',
                'tw_title' => 'rank_math_twitter_title',
                'tw_description' => 'rank_math_twitter_description',
                'tw_media' => 'rank_math_twitter_image',
            ),
            'wordpress-seo' => array(
                'title' => '_yoast_wpseo_title',
                'description' => '_yoast_wpseo_metadesc',
                'keywords' => '_yoast_wpseo_focuskw',
                'noindex' => '_yoast_wpseo_meta-robots-noindex',
                'nofollow' => '_yoast_wpseo_meta-robots-nofollow',
                'robots' => '_yoast_wpseo_meta-robots-adv',
                'canonical' => '_yoast_wpseo_canonical',
                'redirect' => '_yoast_wpseo_redirect',
                'focuspage' => 'yst_is_cornerstone',
                'og_title' => '_yoast_wpseo_opengraph-title',
                'og_description' => '_yoast_wpseo_opengraph-description',
                'og_media' => '_yoast_wpseo_opengraph-image',
                'tw_title' => '_yoast_wpseo_twitter-title',
                'tw_description' => '_yoast_wpseo_twitter-description',
                'tw_media' => '_yoast_wpseo_twitter-image',
            ),
            'all-in-one-seo-pack' => array(
                'title' => '_aioseop_title',
                'description' => '_aioseop_description',
                'keywords' => '_aioseop_keywords',
                'noindex' => '_aioseop_noindex',
                'nofollow' => '_aioseop_nofollow',
                'canonical' => '_aioseop_custom_link',
            ),
//            'squirrly-seo' => array(
//                'title' => '_sq_fp_title',
//                'description' => '_sq_fp_description',
//                'keywords' => '_sq_fp_keywords',
//                'canonical' => '_sq_canonical',
//            ),
            'quickseo-by-squirrly' => array(),
            'premium-seo-pack' => array(),
        );
        $themes = apply_filters('sq_themes', $themes);
        $plugins = apply_filters('sq_plugins', $plugins);

        $list = array_merge((array)$plugins, (array)$themes);
        return $list;
    }

    /**
     * Get the actual name of the plugin/theme
     * @param $path
     * @return string
     */
    public function getName($path) {
        switch ($path) {
            case 'wpmu-dev-seo':
                return 'Infinite SEO';
            case 'wordpress-seo':
                return 'Yoast SEO';
//            case 'squirrly-seo':
//                return 'Squirrly SEO version < 8.2';
            default:
                return ucwords(str_replace('-', ' ', $path));
        }
    }


    /**
     * Rename all the plugin names with a hash
     */
    public function getAvailablePlugins($plugins) {
        $found = array();

        $all_plugins = array_keys(get_plugins());
        if (is_multisite()) {
            $all_plugins = array_merge($all_plugins, array_keys(get_mu_plugins()));
        }
        foreach ($all_plugins as $plugin) {
            if (strpos($plugin, '/') !== false) {
                $plugin = substr($plugin, 0, strpos($plugin, '/'));
            }
            if (isset($plugins[$plugin])) {
                $found[$plugin] = $plugins[$plugin];
            }
        }
        return $found;
    }

    /**
     * Rename all the themes name with a hash
     */
    public function getAvailableThemes($themes) {
        $found = array();

        $all_themes = search_theme_directories();

        foreach ($all_themes as $theme => $value) {
            if (isset($themes[$theme])) {
                $found[] = $themes[$theme];
            }
        }

        return $found;
    }

    /**
     * @param $platform
     * @return boolean
     */
    public function importDBSettings($platform) {
        $imported = false;
        $platforms = apply_filters('sq_importList', false);
        if ($platform <> '' && isset($platforms[$platform])) {

            if ($platform == 'wordpress-seo') {

                if ($yoast_socials = get_option('wpseo_social')) {
                    $socials = SQ_Classes_Helpers_Tools::getOption('socials');
                    $codes = SQ_Classes_Helpers_Tools::getOption('codes');
                    foreach ($yoast_socials as $key => $yoast_social) {
                        if ($yoast_social <> '' && isset($socials[$key])) {
                            $socials[$key] = $yoast_social;
                        }
                    }
                    if (!empty($socials)) {
                        if (isset($yoast_socials['plus-publisher']) && $yoast_socials['plus-publisher'] <> '') {
                            $socials['plus_publisher'] = $yoast_socials['plus-publisher'];
                        }
                        if (isset($yoast_socials['pinterestverify']) && $yoast_socials['plus-publisher'] <> '') {
                            $codes['pinterest_verify'] = $yoast_socials['pinterestverify'];
                        }
                        SQ_Classes_Helpers_Tools::saveOptions('socials', $socials);
                        SQ_Classes_Helpers_Tools::saveOptions('codes', $codes);
                        $imported = true;
                    }
                }

                if ($yoast_codes = get_option('wpseo')) {
                    $codes = SQ_Classes_Helpers_Tools::getOption('codes');
                    if (!empty($codes)) {
                        if (isset($yoast_codes['msverify']) && $yoast_codes['msverify'] <> '') {
                            $codes['bing_wt'] = $yoast_codes['msverify'];
                        }
                        if (isset($yoast_codes['googleverify']) && $yoast_codes['googleverify'] <> '') {
                            $codes['google_wt'] = $yoast_codes['googleverify'];
                        }
                        SQ_Classes_Helpers_Tools::saveOptions('codes', $codes);
                        $imported = true;
                    }
                }
            }

            if ($platform == 'all-in-one-seo-pack') {
                if ($options = get_option('aioseop_options')) {
                    $socials = SQ_Classes_Helpers_Tools::getOption('socials');
                    $codes = SQ_Classes_Helpers_Tools::getOption('codes');

                    if (isset($options['aiosp_google_publisher']) && $options['aiosp_google_publisher'] <> '') $socials['plus_publisher'] = $options['aiosp_google_publisher'];

                    SQ_Classes_Helpers_Tools::saveOptions('socials', $socials);

                    if (isset($options['aiosp_google_verify']) && $options['aiosp_google_verify'] <> '') $codes['google_wt'] = $options['aiosp_google_verify'];
                    if (isset($options['aiosp_bing_verify']) && $options['aiosp_bing_verify'] <> '') $codes['bing_wt'] = $options['aiosp_bing_verify'];
                    if (isset($options['aiosp_pinterest_verify']) && $options['aiosp_pinterest_verify'] <> '') $codes['pinterest_verify'] = $options['aiosp_pinterest_verify'];
                    if (isset($options['aiosp_google_analytics_id']) && $options['aiosp_google_analytics_id'] <> '') $codes['google_analytics'] = $options['aiosp_google_analytics_id'];

                    SQ_Classes_Helpers_Tools::saveOptions('codes', $codes);

                    $imported = true;
                }
            }

            if ($platform == 'rank-math') {
                if ($options = get_option('rank-math-options-general')) {
                    $codes = SQ_Classes_Helpers_Tools::getOption('codes');

                    if (isset($options['attachment_redirect_urls'])) {
                        SQ_Classes_Helpers_Tools::saveOptions('sq_attachment_redirect', ($options['attachment_redirect_urls'] == 'on'));
                    }

                    if (isset($options['google_verify']) && $options['google_verify'] <> '') $codes['google_wt'] = $options['google_verify'];
                    if (isset($options['bing_verify']) && $options['bing_verify'] <> '') $codes['bing_wt'] = $options['bing_verify'];
                    if (isset($options['pinterest_verify']) && $options['pinterest_verify'] <> '') $codes['pinterest_verify'] = $options['pinterest_verify'];

                    SQ_Classes_Helpers_Tools::saveOptions('codes', $codes);

                    $imported = true;
                }
            }

            if ($platform == 'squirrly-seo') {
                if ($options = json_decode(get_option('sq_options'), true)) {
                    $socials = SQ_Classes_Helpers_Tools::getOption('socials');
                    $codes = SQ_Classes_Helpers_Tools::getOption('codes');
                    $jsonld = SQ_Classes_Helpers_Tools::getOption('sq_jsonld');

                    if (isset($options['sq_facebook_insights']) && $options['sq_facebook_insights'] <> '') $socials['fb_admins'] = array(array('id' => $options['sq_facebook_insights']));
                    if (isset($options['sq_facebook_account']) && $options['sq_facebook_account'] <> '') $socials['facebook_site'] = $options['sq_facebook_account'];
                    if (isset($options['sq_twitter_account']) && $options['sq_twitter_account'] <> '') $socials['twitter_site'] = $options['sq_twitter_account'];
                    if (isset($options['sq_twitter_account']) && $options['sq_twitter_account'] <> '') $socials['twitter'] = $options['sq_twitter_account'];
                    if (isset($options['sq_instagram_account']) && $options['sq_instagram_account'] <> '') $socials['instagram_url'] = $options['sq_instagram_account'];
                    if (isset($options['sq_linkedin_account']) && $options['sq_linkedin_account'] <> '') $socials['linkedin_url'] = $options['sq_linkedin_account'];
                    if (isset($options['sq_pinterest_account']) && $options['sq_pinterest_account'] <> '') $socials['pinterest_url'] = $options['sq_pinterest_account'];
                    if (isset($options['sq_auto_twittersize']) && $options['sq_auto_twittersize'] <> '') $socials['twitter_card_type'] = ($options['sq_auto_twittersize'] == 0) ? 'summary' : 'summary_large_image';

                    SQ_Classes_Helpers_Tools::saveOptions('socials', $socials);

                    if (isset($options['sq_google_wt']) && $options['sq_google_wt'] <> '') $codes['google_wt'] = $options['sq_google_wt'];
                    if (isset($options['sq_google_analytics']) && $options['sq_google_analytics'] <> '') $codes['google_analytics'] = $options['sq_google_analytics'];
                    if (isset($options['sq_facebook_analytics']) && $options['sq_facebook_analytics'] <> '') $codes['facebook_pixel'] = $options['sq_facebook_analytics'];
                    if (isset($options['sq_bing_wt']) && $options['sq_bing_wt'] <> '') $codes['bing_wt'] = $options['sq_bing_wt'];
                    if (isset($options['sq_pinterest']) && $options['sq_pinterest'] <> '') $codes['pinterest_verify'] = $options['sq_pinterest'];
                    if (isset($options['sq_alexa']) && $options['sq_alexa'] <> '') $codes['alexa_verify'] = $options['sq_alexa'];

                    SQ_Classes_Helpers_Tools::saveOptions('codes', $codes);

                    if (isset($options['sq_jsonld_type']) && $options['sq_jsonld_type'] <> '') SQ_Classes_Helpers_Tools::saveOptions('sq_jsonld_type', $options['sq_jsonld_type']);
                    if (isset($options['sq_jsonld_type']) && $options['sq_jsonld_type'] <> '') $jsonld[$options['sq_jsonld_type']] = $options['sq_jsonld'][$options['sq_jsonld_type']];

                    SQ_Classes_Helpers_Tools::saveOptions('sq_jsonld', $jsonld);

                    $imported = true;
                }
            }

            if ($platform == 'quickseo-by-squirrly') {
                if ($options = json_decode(get_option('_qss_options'), true)) {
                    $socials = $options['socials'];
                    $codes = $options['codes'];
                    $jsonld = $options['qss_jsonld'];

                    SQ_Classes_Helpers_Tools::saveOptions('socials', $socials);
                    SQ_Classes_Helpers_Tools::saveOptions('codes', $codes);
                    SQ_Classes_Helpers_Tools::saveOptions('sq_jsonld', $jsonld);

                    $imported = true;
                }
            }

            if ($platform == 'premium-seo-pack') {
                if ($options = json_decode(get_option('_psp_options'), true)) {
                    $socials = $options['socials'];
                    $codes = $options['codes'];
                    $jsonld = $options['psp_jsonld'];

                    SQ_Classes_Helpers_Tools::saveOptions('socials', $socials);
                    SQ_Classes_Helpers_Tools::saveOptions('codes', $codes);
                    SQ_Classes_Helpers_Tools::saveOptions('sq_jsonld', $jsonld);

                    $imported = true;
                }
            }
        }

        return $imported;
    }

    public function importDBSeo($platform) {
        global $wpdb;

        $platforms = apply_filters('sq_importList', false);
        if ($platform <> '' && isset($platforms[$platform])) {
            $meta_keys = $platforms[$platform];
            $metas = array();

            if (!empty($meta_keys)) {
                $query = "SELECT * FROM " . $wpdb->postmeta . " WHERE meta_key IN ('" . join("','", array_values($meta_keys)) . "');";
                $meta_keys = array_flip($meta_keys);

                if ($rows = $wpdb->get_results($query, OBJECT)) {
                    foreach ($rows as $row) {

                        if (isset($meta_keys[$row->meta_key]) && $row->meta_value <> '') {
                            $metas[md5($row->post_id)]['post_id'] = $row->post_id;
                            $metas[md5($row->post_id)]['url'] = get_permalink($row->post_id);

                            $value = $row->meta_value;
                            if (function_exists('mb_detect_encoding') && function_exists('iconv')) {
                                if ($encoding = mb_detect_encoding($value)) {
                                    if ($encoding <> 'UTF-8') {
                                        if (function_exists('iconv')) {
                                            $value = iconv($encoding, 'UTF-8', $value);
                                        }
                                        if (strpos($value, '%%') !== false) {
                                            $value = preg_replace('/%%([^\%]+)%%/', '{{$1}}', $value);
                                        }
                                    }
                                }
                            }
                            $metas[md5($row->post_id)][$meta_keys[$row->meta_key]] = stripslashes($value);
                        }
                    }
                }

                if ($platform == 'wordpress-seo') {
                    //get taxonomies
                    if ($taxonomies = get_option('wpseo_taxonomy_meta')) {
                        if (!empty($taxonomies)) {
                            foreach ($taxonomies as $taxonomie => $terms) {
                                if (!empty($terms)) {
                                    if ($taxonomie <> 'category') {
                                        $taxonomie = 'tax-' . $taxonomie;
                                    }
                                    foreach ($terms as $term_id => $taxmetas) {
                                        if (!empty($taxmetas)) {
                                            if (!is_wp_error(get_term_link($term_id))) {
                                                $metas[md5($taxonomie . $term_id)]['url'] = get_term_link($term_id);
                                                $metas[md5($taxonomie . $term_id)]['term_id'] = $term_id;
                                                $metas[md5($taxonomie . $term_id)]['taxonomie'] = $taxonomie;
                                                foreach ($taxmetas as $meta_key => $meta_value) {
                                                    if ($meta_key == 'wpseo_desc') {
                                                        $meta_key = '_yoast_wpseo_metadesc';
                                                    } else {
                                                        $meta_key = '_yoast_' . $meta_key;
                                                    }

                                                    if (isset($meta_keys[$meta_key])) {
                                                        $metas[md5($taxonomie . $term_id)][$meta_keys[$meta_key]] = stripslashes($meta_value);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    //get all patterns from Yoast
                    if ($yoast_patterns = get_option('wpseo_titles')) {
                        if (!empty($yoast_patterns)) {
                            $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');
                            foreach ($patterns as $path => &$values) {
                                if ($path == 'profile') {
                                    $path = 'author';
                                }
                                if (isset($yoast_patterns['separator']) && $yoast_patterns['separator'] <> '') {
                                    $values['sep'] = $yoast_patterns['separator'];
                                }
                                if (isset($yoast_patterns["title-$path-wpseo"]) && $yoast_patterns["title-$path-wpseo"] <> '') {
                                    $values['title'] = $yoast_patterns["title-$path-wpseo"];
                                }
                                if (isset($yoast_patterns["metadesc-$path-wpseo"]) && $yoast_patterns["metadesc-$path-wpseo"] <> '') {
                                    $values['description'] = $yoast_patterns["metadesc-$path-wpseo"];
                                }
                                if (isset($yoast_patterns["noindex-$path-wpseo"])) {
                                    $values['noindex'] = (int)$yoast_patterns["noindex-$path-wpseo"];
                                }
                                if (isset($yoast_patterns["disable-$path-wpseo"])) {
                                    $values['disable'] = (int)$yoast_patterns["disable-$path-wpseo"];
                                }

                                if (isset($yoast_patterns["title-$path"]) && $yoast_patterns["title-$path"] <> '') {
                                    $values['title'] = $yoast_patterns["title-$path"];

                                }
                                if (isset($yoast_patterns["metadesc-$path"]) && $yoast_patterns["metadesc-$path"] <> '') {
                                    $values['description'] = $yoast_patterns["metadesc-$path"];
                                }
                                if (isset($yoast_patterns["noindex-$path"])) {
                                    $values['noindex'] = (int)$yoast_patterns["noindex-$path"];
                                }
                                if (isset($yoast_patterns["disable-$path"])) {
                                    $values['disable'] = (int)$yoast_patterns["disable-$path"];
                                }

                                foreach ($values as &$value) {
                                    if (strpos($value, '%%') !== false) {
                                        $value = preg_replace('/%%([^\%]+)%%/', '{{$1}}', $value);
                                    }
                                }
                            }


                            SQ_Classes_Helpers_Tools::saveOptions('patterns', $patterns);
                        }
                    }
                }

                if ($platform == 'all-in-one-seo-pack') {
                    if ($options = get_option('aioseop_options')) {
                        $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');

                        $find = array('page_title', 'post_title', 'archive_title', 'blog_title', 'blog_description', 'category_title', 'author', 'page_author_nicename', 'description', 'request_words', 'search', 'current_date');
                        $replace = array('title', 'title', 'title', 'sitename', 'sitedesc', 'category', 'name', 'name', 'excerpt', 'searchphrase', 'searchphrase', 'currentdate');

                        if (isset($options['aiosp_page_title_format']) && $options['aiosp_page_title_format'] <> '') {
                            $patterns['home']['title'] = preg_replace('/%([^\%]+)%/', '{{$1}}', str_replace($find, $replace, $options['aiosp_page_title_format']));
                        };
                        if (isset($options['aiosp_post_title_format']) && $options['aiosp_post_title_format'] <> '') {
                            $patterns['post']['title'] = preg_replace('/%([^\%]+)%/', '{{$1}}', str_replace($find, $replace, $options['aiosp_post_title_format']));
                        };
                        if (isset($options['aiosp_category_title_format']) && $options['aiosp_category_title_format'] <> '') {
                            $patterns['category']['title'] = preg_replace('/%([^\%]+)%/', '{{$1}}', str_replace($find, $replace, $options['aiosp_category_title_format']));
                        };
                        if (isset($options['aiosp_archive_title_format']) && $options['aiosp_archive_title_format'] <> '') {
                            $patterns['archive']['title'] = preg_replace('/%([^\%]+)%/', '{{$1}}', str_replace($find, $replace, $options['aiosp_archive_title_format']));
                        };
                        if (isset($options['aiosp_author_title_format']) && $options['aiosp_author_title_format'] <> '') {
                            $patterns['profile']['title'] = preg_replace('/%([^\%]+)%/', '{{$1}}', str_replace($find, $replace, $options['aiosp_author_title_format']));
                        };
                        if (isset($options['aiosp_tag_title_format']) && $options['aiosp_tag_title_format'] <> '') {
                            $patterns['tag']['title'] = preg_replace('/%([^\%]+)%/', '{{$1}}', str_replace($find, $replace, $options['aiosp_tag_title_format']));
                        };
                        if (isset($options['aiosp_search_title_format']) && $options['aiosp_search_title_format'] <> '') {
                            $patterns['search']['title'] = preg_replace('/%([^\%]+)%/', '{{$1}}', str_replace($find, $replace, $options['aiosp_search_title_format']));
                        };
                        if (isset($options['aiosp_404_title_format']) && $options['aiosp_404_title_format'] <> '') {
                            $patterns['404']['title'] = preg_replace('/%([^\%]+)%/', '{{$1}}', str_replace($find, $replace, $options['aiosp_404_title_format']));
                        };
                        if (isset($options['aiosp_product_title_format']) && $options['aiosp_product_title_format'] <> '') {
                            $patterns['product']['title'] = preg_replace('/%([^\%]+)%/', '{{$1}}', str_replace($find, $replace, $options['aiosp_product_title_format']));
                        };

                        SQ_Classes_Helpers_Tools::saveOptions('patterns', $patterns);
                    }
                }


            }

            if ($platform == 'squirrly-seo') {
                $title = SQ_Classes_Helpers_Tools::getOption('sq_fp_title');
                $description = SQ_Classes_Helpers_Tools::getOption('sq_fp_description');
                $keywords = SQ_Classes_Helpers_Tools::getOption('sq_fp_keywords');

                $post_type = '';

                if ($title <> '' || $description <> '' || $keywords <> '') {
                    if ($post_id = get_option('page_on_front')) {
                        $hash = md5($post_id);
                        $url = home_url();
                    } elseif ($post_id = get_option('page_for_posts')) {
                        $hash = md5($post_id);
                        $url = get_permalink($post_id);
                    } else {
                        $hash = md5('wp_homepage');
                        $url = home_url();
                        $post_id = 0;
                        $post_type = 'home';
                    }


                    $metas[$hash]['post_id'] = $post_id;
                    $metas[$hash]['post_type'] = $post_type;
                    $metas[$hash]['url'] = $url;
                    $metas[$hash]['title'] = $title;
                    $metas[$hash]['description'] = $description;
                    $metas[$hash]['keywords'] = $keywords;
                }

            }

            if ($platform == 'quickseo-by-squirrly') {
                global $wpdb;

                $tables = $wpdb->get_col('SHOW TABLES');
                foreach ($tables as $table) {
                    if ($table == $wpdb->prefix . strtolower('psp')) {
                        $query = "SELECT * FROM " . $wpdb->prefix . "qss";
                        if ($rows = $wpdb->get_results($query, OBJECT)) {
                            foreach ($rows as $row) {
                                if (isset($row->post_id)) {
                                    $metas[$row->url_hash]['post_id'] = $row->post_id;
                                } else {
                                    $metas[$row->url_hash]['post_id'] = 0;
                                }
                                $metas[$row->url_hash]['url'] = $row->URL;
                                $metas[$row->url_hash]['seo'] = $row->seo;
                            }
                        }
                        break;
                    }
                }
                return $metas;
            }

            if ($platform == 'premium-seo-pack') {
                global $wpdb;

                $tables = $wpdb->get_col('SHOW TABLES');
                foreach ($tables as $table) {
                    if ($table == $wpdb->prefix . strtolower('psp')) {
                        $query = "SELECT * FROM " . $wpdb->prefix . "psp";
                        if ($rows = $wpdb->get_results($query, OBJECT)) {
                            foreach ($rows as $row) {
                                if (isset($row->post_id)) {
                                    $metas[$row->url_hash]['post_id'] = $row->post_id;
                                } else {
                                    $metas[$row->url_hash]['post_id'] = 0;
                                }
                                $metas[$row->url_hash]['url'] = $row->URL;
                                $metas[$row->url_hash]['seo'] = $row->seo;
                            }
                        }
                        break;
                    }
                }
                return $metas;
            }
        }

        return $metas;
    }


    function createTableBackup() {
        global $wpdb;

        $tables = $wpdb->get_col('SHOW TABLES');
        $output = '';
        foreach ($tables as $table) {
            if ($table == $wpdb->prefix . _SQ_DB_) {
                $result = $wpdb->get_results("SELECT * FROM {$table}", ARRAY_N);
                $columns = $wpdb->get_results('SHOW COLUMNS FROM ' . $table, ARRAY_N);
                $row2 = $wpdb->get_row('SHOW CREATE TABLE ' . $table, ARRAY_N);
                $output .= "\n\n" . str_replace('CREATE TABLE ', 'CREATE TABLE IF NOT EXISTS ', $row2[1]) . ";\n\n";
                for ($i = 0; $i < count((array)$result); $i++) {
                    $row = $result[$i];
                    $output .= 'INSERT INTO ' . $table . ' (';
                    for ($col = 0; $col < count((array)$columns); $col++) {
                        $output .= (isset($columns[$col][0]) ? $columns[$col][0] : "''");
                        if ($col < (count((array)$columns) - 1)) {
                            $output .= ',';
                        }
                    }
                    $output .= ') VALUES(';
                    for ($j = 0; $j < count((array)$result[0]); $j++) {
                        $row[$j] = str_replace(array("\'", "'"), array("'", "\'"), $row[$j]);
                        $output .= (isset($row[$j]) ? "'" . $row[$j] . "'" : "''");
                        if ($j < (count((array)$result[0]) - 1)) {
                            $output .= ',';
                        }
                    }
                    $output .= ") ON DUPLICATE KEY UPDATE ";
                    for ($j = 0; $j < count((array)$result[0]); $j++) {
                        $row[$j] = str_replace(array("\'", "'"), array("'", "\'"), $row[$j]);
                        $output .= $columns[$j][0] . '=' . (isset($row[$j]) ? "'" . $row[$j] . "'" : "''");
                        if ($j < (count((array)$result[0]) - 1)) {
                            $output .= ',';
                        }
                    }
                    $output .= ";\n";
                }
                $output .= "\n";
                break;
            }
        }
        $wpdb->flush();

        return $output;
    }

    public function executeSql($queries) {
        if (is_array($queries) && !empty($queries)) {
            global $wpdb;

            for ($i = 0; $i < count((array)$queries); $i++) {
                if (strlen($queries[$i]) > 1) {
                    $wpdb->query($queries[$i]);
                }
            }
            $wpdb->flush();

            return true;
        }
        return false;
    }
}
