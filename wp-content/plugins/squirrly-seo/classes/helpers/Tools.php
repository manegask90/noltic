<?php

/**
 * Handles the parameters and url
 *
 * @author Squirrly
 */
class SQ_Classes_Helpers_Tools {

    /** @var array Options, User Metas, Package and Plugin details */
    public static $options, $usermeta = array();

    public function __construct() {
        self::$options = $this->getOptions();

        $maxmemory = self::getMaxMemory();
        if ($maxmemory && $maxmemory < 60) {
            @ini_set('memory_limit', apply_filters('admin_memory_limit', WP_MAX_MEMORY_LIMIT));
        }

        SQ_Classes_ObjController::getClass('SQ_Classes_HookController')->setHooks($this);
    }

    public static function getMaxMemory() {
        try {
            $memory_limit = @ini_get('memory_limit');
            if ((int)$memory_limit > 0) {
                if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
                    if ($matches[2] == 'G') {
                        $memory_limit = $matches[1] * 1024 * 1024 * 1024; // nnnM -> nnn MB
                    } elseif ($matches[2] == 'M') {
                        $memory_limit = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
                    } elseif ($matches[2] == 'K') {
                        $memory_limit = $matches[1] * 1024; // nnnK -> nnn KB
                    }
                }

                if ((int)$memory_limit > 0) {
                    return number_format($memory_limit / 1024 / 1024, 0, '', '');
                }
            }
        } catch (Exception $e) {
        }

        return false;

    }

    public static function getUsedMemory() {
        return number_format(memory_get_usage() / 1024 / 1024, 0);
    }

    public static function isAjax() {
        return (defined('DOING_AJAX') && DOING_AJAX);
    }

    /**
     * This hook will save the current version in database
     *
     * @return void
     */
    function hookInit() {
        //Load the languages pack
        $this->loadMultilanguage();
        //Check the Dev Kit settings
        SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_DevKit');
        //add extra links to the plugin in the Plugins list
        add_filter("plugin_row_meta", array($this, 'hookExtraLinks'), 10, 4);
        //add setting link in plugin
        add_filter('plugin_action_links', array($this, 'hookActionlink'), 5, 2);
    }

    /**
     * Add a link to settings in the plugin list
     *
     * @param array $links
     * @param string $file
     * @return array
     */
    public function hookActionlink($links, $file) {
        if ($file == _SQ_PLUGIN_NAME_ . '/squirrly.php') {
            $link = '<a href="' . self::getAdminUrl('sq_dashboard') . '">' . __('Getting started', _SQ_PLUGIN_NAME_) . '</a>';
            array_unshift($links, $link);
        }

        return $links;
    }

    /**
     * Adds extra links to plugin  page
     *
     * @param $meta
     * @param $file
     * @param $data
     * @param $status
     * @return array
     */
    public function hookExtraLinks($meta, $file, $data = null, $status = null) {
        if ($file == _SQ_PLUGIN_NAME_ . '/squirrly.php') {
            echo '<style>
                .ml-stars{display:inline-block;color:#ffb900;position:relative;top:3px}
                .ml-stars svg{fill:#ffb900}
                .ml-stars svg:hover{fill:#ffb900}
                .ml-stars svg:hover ~ svg{fill:none}
            </style>';

            $meta[] = "<a href='https://howto.squirrly.co/wordpress-seo/' target='_blank'>" . __('Documentation', _SQ_PLUGIN_NAME_) . "</a>";
            $meta[] = "<a href='https://wordpress.org/support/plugin/squirrly-seo/reviews/#new-post' target='_blank' title='" . __('Leave a review', _SQ_PLUGIN_NAME_) . "'><i class='ml-stars'><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg></i></a>";
        }
        return $meta;
    }

    /**
     * Load the Options from user option table in DB
     *
     * @param string $action
     * @return array|mixed|object
     */
    public static function getOptions($action = '') {
        $default = array(
            //Global settings
            'sq_api' => '',
            //
            'sq_cloud_connect' => 0,
            'sq_cloud_token' => false,
            'sq_offer' => false,
            // dev kit
            'sq_devkit_logo' => false,
            'sq_devkit_name' => false,
            //Advanced settings
            'sq_seoexpert' => 0,
            //later buffer load
            'sq_laterload' => 0,
            'sq_audit_email' => '',
            //SEO Journey
            'sq_seojourney' => 0,
            'sq_seojourney_congrats' => 1,
            'sq_onboarding' => 0,
            'sq_menu_visited' => array(),
            //minify Squirrly Metas
            'sq_load_css' => 1,
            'sq_minify' => 0,
            //Settings Assistant
            'sq_assistant' => 1,
            'sq_complete_uninstall' => 0,

            //Live Assistant
            'sq_sla' => 1,
            'sq_sla_frontend' => 0,
            'sq_sla_type' => 'auto',
            'sq_sla_exclude_post_types' => array(),
            'sq_keyword_information' => 0,
            'sq_keyword_help' => 1,
            'sq_local_images' => 1,
            'sq_img_licence' => 1,

            //JsonLD
            'sq_auto_jsonld' => 1,
            'sq_jsonld_type' => 'Organization',
            'sq_jsonld_breadcrumbs' => 1,
            'sq_jsonld_woocommerce' => 1,
            'sq_jsonld_clearcode' => 0,
            'sq_jsonld_product_defaults' => 1,
            'sq_jsonld' => array(
                'Organization' => array(
                    'name' => '',
                    'logo' => '',
                    'telephone' => '',
                    'contactType' => '',
                    'description' => ''
                ),
                'Person' => array(
                    'name' => '',
                    'logo' => '',
                    'telephone' => '',
                    'jobTitle' => '',
                    'description' => ''
                )),

            //Sitemap
            'sq_auto_sitemap' => 1,
            'sq_sitemap_ping' => 0,
            'sq_sitemap_show' => array(
                'images' => 1,
                'videos' => 0,
            ),
            'sq_sitemap_perpage' => 200,
            'sq_sitemap_frequency' => 'weekly',
            'sq_url_fix' => 1,
            'sq_sitemap_combinelangs' => 1,
            'sq_sitemap' => array(
                'sitemap' => array('sitemap.xml', 1),
                'sitemap-home' => array('sitemap-home.xml', 1),
                'sitemap-news' => array('sitemap-news.xml', 0),
                'sitemap-product' => array('sitemap-product.xml', 1),
                'sitemap-post' => array('sitemap-posts.xml', 1),
                'sitemap-page' => array('sitemap-pages.xml', 1),
                'sitemap-category' => array('sitemap-categories.xml', 1),
                'sitemap-post_tag' => array('sitemap-tags.xml', 1),
                'sitemap-archive' => array('sitemap-archives.xml', 1),
                'sitemap-author' => array('sitemap-authors.xml', 0),
                'sitemap-custom-tax' => array('sitemap-custom-taxonomies.xml', 0),
                'sitemap-custom-post' => array('sitemap-custom-posts.xml', 0),
                'sitemap-attachment' => array('sitemap-attachment.xml', 0),
            ),

            //Robots
            'sq_auto_robots' => 1,
            'sq_robots_permission' => array(
                'User-agent: *',
                'Disallow: */trackback/',
                'Disallow: */xmlrpc.php',
                'Disallow: /wp-*.php',
                'Disallow: /cgi-bin/',
                'Disallow: /wp-admin/',
                'Allow: */wp-content/uploads/',),

            //Metas
            'sq_use' => 1,
            'sq_auto_metas' => 1,
            'sq_auto_title' => 1,
            'sq_auto_description' => 1,
            'sq_auto_keywords' => 1,
            'sq_keywordtag' => 0,
            'sq_auto_canonical' => 1,
            'sq_auto_dublincore' => 1,
            'sq_auto_feed' => 0,
            'sq_auto_noindex' => 1,
            'sq_use_frontend' => 1,
            'sq_attachment_redirect' => 0,
            'sq_permalink_redirect' => 1,
            'sq_metas' => array(
                'title_maxlength' => 75,
                'description_maxlength' => 320,
                'og_title_maxlength' => 75,
                'og_description_maxlength' => 110,
                'tw_title_maxlength' => 75,
                'tw_description_maxlength' => 280,
                'jsonld_title_maxlength' => 75,
                'jsonld_description_maxlength' => 110,
            ),

            //favicon
            'sq_auto_favicon' => 0,
            'sq_favicon_apple' => 1,
            'favicon' => '',

            //Ranking Option
            'sq_google_country' => 'com',
            'sq_google_language' => 'en',
            'sq_google_serpsperhour' => 500,
            'connect' => array(
                'google_analytics' => 0,
                'google_search_console' => 0,
            ),

            //pages visited
            'sq_dashboard' => 0,
            'sq_analytics' => 0,

            //menu restrictions
            'menu' => array(
                'show_account_info' => 1,
                'show_panel' => 1,
                'show_tutorial' => 1,
                'show_audit' => 1,
                'show_rankings' => 1,
                'show_focuspages' => 1,
                'show_ads' => 1,
            ),

            //socials
            'sq_auto_social' => 1,
            'sq_auto_facebook' => 1,
            'sq_auto_twitter' => 1,
            'sq_og_locale' => 'en_US',

            'socials' => array(
                'fb_admins' => array(),
                'fbconnectkey' => "",
                'fbadminapp' => "",

                'facebook_site' => "",
                'twitter_site' => "https://twitter.com/twitter",
                'twitter' => "",
                'instagram_url' => "",
                'linkedin_url' => "",
                'myspace_url' => "",
                'pinterest_url' => "",
                'youtube_url' => "",
                'twitter_card_type' => "summary_large_image",
                'plus_publisher' => ""
            ),

            //Webmasters and Tracking
            'sq_auto_amp' => 0,
            'sq_auto_tracking' => 1,
            'sq_tracking_logged_users' => 1,
            'sq_auto_webmasters' => 1,
            'sq_analytics_google_js' => 'analytics',
            'codes' => array(
                'google_wt' => "",
                'google_analytics' => "",
                'facebook_pixel' => "",

                'bing_wt' => "",
                'pinterest_verify' => "",
                'alexa_verify' => "",
            ),

            //Patterns
            'sq_auto_pattern' => 1,
            'patterns' => array(
                'home' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{sitename}} {{page}} {{sep}} {{sitedesc}}',
                    'description' => '{{excerpt}} {{page}} {{sep}} {{sitename}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'post' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{title}} {{page}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'article',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 1,
                ),
                'page' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{title}} {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 1,
                ),
                'category' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{category}} {{page}} {{sep}} {{sitename}}',
                    'description' => '{{category_description}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 0,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'tag' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{tag}} {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 0,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'tax-post_format' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{term_title}} ' . __('Format', _SQ_PLUGIN_NAME_) . ' {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'tax-category' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{term_title}} ' . __('Category', _SQ_PLUGIN_NAME_) . ' {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'tax-post_tag' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{term_title}} ' . __('Tag', _SQ_PLUGIN_NAME_) . ' {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'tax-product_cat' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{term_title}} ' . __('Category', _SQ_PLUGIN_NAME_) . ' {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'tax-product_tag' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{term_title}} ' . __('Tag', _SQ_PLUGIN_NAME_) . ' {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'tax-product_shipping_class' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{term_title}} ' . __('Shipping Option', _SQ_PLUGIN_NAME_) . ' {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'profile' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{name}}, ' . __('Author at', _SQ_PLUGIN_NAME_) . ' {{sitename}} {{page}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'profile',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'shop' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{title}} {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'product' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{title}} {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'product',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 1,
                ),
                'archive' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{date}} {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'search' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => __('Are you looking for', _SQ_PLUGIN_NAME_) . ' {{searchphrase}}? {{page}} {{sep}} {{sitename}}',
                    'description' => __('These are the results for', _SQ_PLUGIN_NAME_) . ' {{searchphrase}} ' . __('that you can find on our website.', _SQ_PLUGIN_NAME_) . ' {{excerpt}}',
                    'noindex' => 1,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 0,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                ),
                'attachment' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{title}} {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 1,
                ),
                '404' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => __('Page not found', _SQ_PLUGIN_NAME_) . ' {{sep}} {{sitename}}',
                    'description' => __('This page could not be found on our website.', _SQ_PLUGIN_NAME_) . ' {{excerpt}}',
                    'noindex' => 1,
                    'nofollow' => 1,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 0,
                    'do_jsonld' => 0,
                    'do_pattern' => 1,
                    'do_og' => 0,
                    'do_twc' => 0,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
                'custom' => array(
                    'protected' => 1,
                    'sep' => '|',
                    'title' => '{{title}} {{page}} {{sep}} {{sitename}}',
                    'description' => '{{excerpt}}',
                    'noindex' => 0,
                    'nofollow' => 0,
                    'og_type' => 'website',
                    'do_metas' => 1,
                    'do_sitemap' => 1,
                    'do_jsonld' => 1,
                    'do_pattern' => 1,
                    'do_og' => 1,
                    'do_twc' => 1,
                    'do_analytics' => 1,
                    'do_fpixel' => 1,
                    'do_redirects' => 0,
                ),
            )

        );
        $options = json_decode(get_option(SQ_OPTION), true);

        if ($action == 'reset') {
            $init['sq_api'] = $options['sq_api'];
            return $init;
        }

        if (is_array($options)) {
            //$options['patterns'] = @array_replace_recursive($default['patterns'], $options['patterns']);
            $options = @array_replace_recursive($default, $options);
            return $options;
        }

        return $default;
    }

    /**
     * Get the option from database
     * @param $key
     * @return mixed
     */
    public static function getOption($key) {
        if (!isset(self::$options[$key])) {
            self::$options = self::getOptions();

            if (!isset(self::$options[$key])) {
                self::$options[$key] = false;
            }
        }

        return apply_filters('sq_option_' . $key, self::$options[$key]);
    }

    /**
     * Save the Options in user option table in DB
     *
     * @param null $key
     * @param string $value
     */
    public static function saveOptions($key = null, $value = '') {
        if (isset($key)) {
            self::$options[$key] = $value;
        }

        update_option(SQ_OPTION, json_encode(self::$options));
    }

    /**
     * Get user metas
     * @param null $user_id
     * @return array|mixed
     */
    public static function getUserMetas($user_id = null) {
        if (!isset($user_id)) {
            $user_id = get_current_user_id();
        }

        $default = array('sq_auto_sticky' => 0,);

        $usermeta = get_user_meta($user_id);
        $usermetatmp = array();
        if (is_array($usermeta)) foreach ($usermeta as $key => $values) {
            $usermetatmp[$key] = $values[0];
        }
        $usermeta = $usermetatmp;

        if (is_array($usermeta)) {
            $usermeta = @array_merge($default, $usermeta);
        } else {
            $usermeta = $default;
        }
        self::$usermeta = $usermeta;
        return $usermeta;
    }

    /**
     * Get use meta
     * @param $value
     * @return bool
     */
    public static function getUserMeta($value) {
        if (!isset(self::$usermeta[$value])) {
            self::getUserMetas();
        }

        if (isset(self::$usermeta[$value])) {
            return apply_filters('sq_usermeta_' . $value, self::$usermeta[$value]);
        }

        return false;
    }

    /**
     * Save user meta
     * @param $key
     * @param $value
     * @param null $user_id
     */
    public static function saveUserMeta($key, $value, $user_id = null) {
        if (!isset($user_id)) {
            $user_id = get_current_user_id();
        }
        self::$usermeta[$key] = $value;
        update_user_meta($user_id, $key, $value);
    }

    /**
     * Delete User meta
     * @param $key
     * @param null $user_id
     */
    public static function deleteUserMeta($key, $user_id = null) {
        if (!isset($user_id)) {
            $user_id = get_current_user_id();
        }
        unset(self::$usermeta[$key]);
        delete_user_meta($user_id, $key);
    }

    /**
     * Get the option from database
     * @param $key
     * @return mixed
     */
    public static function getMenuVisible($key) {
        if (!isset(self::$options['menu'][$key])) {
            self::$options = self::getOptions();

            if (!isset(self::$options['menu'][$key])) {
                self::$options['menu'][$key] = false;
            }
        }

        return apply_filters('sq_menu_visible', self::$options['menu'][$key]);

    }

    /**
     * Set the header type
     * @param string $type
     */
    public static function setHeader($type) {
        if (self::getValue('sq_debug') == 'on') {
            // header("Content-type: text/html");
            return;
        }

        switch ($type) {
            case 'json':
                header('Content-Type: application/json');
                break;
            case 'ico':
                header('Content-Type: image/x-icon');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            case'text':
                header("Content-type: text/plain");
                break;
            case'html':
                header("Content-type: text/html");
                break;
        }
    }

    /**
     * Set the Nonce action
     * @param $action
     * @param string $name
     * @param bool $referer
     * @param bool $echo
     * @return string
     */
    public static function setNonce($action, $name = '_wpnonce', $referer = true, $echo = true) {
        $name = esc_attr($name);
        $nonce_field = '<input type="hidden" name="' . $name . '" value="' . wp_create_nonce($action) . '" />';

        if ($referer) {
            $nonce_field .= wp_referer_field(false);
        }

        if ($echo) {
            echo $nonce_field;
        }

        return $nonce_field;
    }

    /**
     * Get a value from $_POST / $_GET
     * if unavailable, take a default value
     *
     * @param string $key Value key
     * @param mixed $defaultValue (optional)
     * @param bool $htmlcode
     * @param bool $keep_newlines
     * @return mixed Value
     */
    public static function getValue($key, $defaultValue = false, $keep_newlines = false) {
        if (!isset($key) || (isset($key) && $key == '')) {
            return $defaultValue;
        }

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : ''));
        } else {
            $ret = (isset($_GET[$key]) ? $_GET[$key] : '');
        }

        if (is_array($ret)) {
            if (!empty($ret)) {
                foreach ($ret as &$row) {
                    if (!is_array($row)) {
                        $row = sanitize_text_field($row);
                    }
                }
            }
        } elseif (is_string($ret) && $ret <> '') {
            if ($keep_newlines && function_exists('sanitize_textarea_field')) {
                $ret = sanitize_textarea_field($ret);
            } else {
                $ret = sanitize_text_field($ret);
            }
        }

        if (!$ret) {
            return $defaultValue;
        } else {
            return wp_unslash($ret);
        }

    }

    /**
     * Check if the parameter is set
     *
     * @param string $key
     * @return boolean
     */
    public static function getIsset($key) {
        return (isset($_GET[$key]) || isset($_POST[$key]));
    }


    /**
     * Find the string in the content
     *
     * @param string $content
     * @param string $string
     * @return bool|false|int
     */
    public static function findStr($content, $string) {
        if (function_exists('mb_stripos')) {
            return mb_stripos($content, $string);
        } else {
            SQ_Classes_Error::setMessage(sprintf(__("For better text comparison you need to install PHP mbstring extension.", _SQ_PLUGIN_NAME_), _QSS_PLUGIN_NAME_));

            return stripos($content, $string);
        }
    }

    /**
     * Load the multilanguage support from .mo
     */
    private function loadMultilanguage() {
        if (!defined('WP_PLUGIN_DIR')) {
            load_plugin_textdomain(_SQ_PLUGIN_NAME_, _SQ_PLUGIN_NAME_ . '/languages/');
        } else {
            load_plugin_textdomain(_SQ_PLUGIN_NAME_, null, _SQ_PLUGIN_NAME_ . '/languages/');
        }
    }


    /**
     * Hook the activate process
     */
    public function sq_activate() {
        set_transient('sq_activate', true);
        set_transient('sq_rewrite', true);
        set_transient('sq_import', true);
        SQ_Classes_ObjController::getClass('SQ_Models_RoleManager')->addSQRoles();
    }

    /**
     * Hook the deactivate process
     */
    public function sq_deactivate() {
        SQ_Classes_ObjController::getClass('SQ_Models_RoleManager')->removeSQCaps();
        SQ_Classes_ObjController::getClass('SQ_Models_RoleManager')->removeSQRoles();
    }

    /**
     * Triggered when a plugin update is made
     */
    public static function checkUpgrade($upgrader_object, $options) {
        // If an update has taken place and the updated type is plugins and the plugins element exists
        if ($options['action'] == 'update' && $options['type'] == 'plugin' && isset($options['plugins'])) {
            // Iterate through the plugins being updated and check if ours is there
            foreach ($options['plugins'] as $plugin) {
                if ($plugin == _SQ_PLUGIN_NAME_ . '/squirrly.php') {
                    //Create Qss table if not exists
                    SQ_Classes_ObjController::getClass('SQ_Models_Qss')->checkTableExists();
                }
            }
        }
    }

    /**
     * Empty the cache from other plugins
     * @param null $post_id
     */
    public static function emptyCache($post_id = null) {
        if (function_exists('w3tc_pgcache_flush')) {
            w3tc_pgcache_flush();
        }

        if (function_exists('w3tc_minify_flush')) {
            w3tc_minify_flush();
        }
        if (function_exists('w3tc_dbcache_flush')) {
            w3tc_dbcache_flush();
        }
        if (function_exists('w3tc_objectcache_flush')) {
            w3tc_objectcache_flush();
        }

        if (function_exists('wp_cache_clear_cache')) {
            wp_cache_clear_cache();
        }

        if (function_exists('rocket_clean_domain')) {
            // Remove all cache files
            rocket_clean_domain();
        }

        if (function_exists('opcache_reset')) {
            // Remove all opcache if enabled
            opcache_reset();
        }

        if (function_exists('apc_clear_cache')) {
            // Remove all apc if enabled
            apc_clear_cache();
        }

        if (class_exists('Cache_Enabler_Disk') && method_exists('Cache_Enabler_Disk', 'clear_cache')) {
            // clear disk cache
            Cache_Enabler_Disk::clear_cache();
        }

        //Clear the fastest cache
        global $wp_fastest_cache;
        if (isset($wp_fastest_cache) && method_exists($wp_fastest_cache, 'deleteCache')) {
            $wp_fastest_cache->deleteCache();
        }
    }


    /**
     * Check if a plugin is installed
     * @param $name
     * @return bool
     */
    public static function isPluginInstalled($name) {
        switch ($name) {
            case 'instapage':
                return defined('INSTAPAGE_PLUGIN_PATH');
            case 'quick-seo':
                return defined('QSS_VERSION') && defined('_QSS_ROOT_DIR_');
            case 'premium-seo-pack':
                return defined('PSP_VERSION') && defined('_PSP_ROOT_DIR_');
            default:
                $plugins = (array)get_option('active_plugins', array());

                if (is_multisite()) {
                    $plugins = array_merge(array_values($plugins), array_keys(get_site_option('active_sitewide_plugins')));
                }

                return in_array($name, $plugins, true);

        }
    }

    /**
     * Check if frontend and user is logged in
     * @return bool
     */
    public static function isFrontAdmin() {
        return (!is_admin() && is_user_logged_in());
    }

    /**
     * Check if user is in dashboard
     * @return bool
     */
    public static function isBackedAdmin() {
        return (is_admin() || is_network_admin());
    }

    /**
     * Check if the current website is an E-commerce website
     * @return bool
     */
    public static function isEcommerce() {
        $products = array('product', 'wpsc-product');
        $post_types = get_post_types(array('public' => true));

        foreach ($products as $type) {
            if (in_array($type, array_keys($post_types))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the admin url for the specific age
     *
     * @param string $page
     * @param string $tab
     * @param array $args
     * @return string
     */
    public static function getAdminUrl($page, $tab = null, $args = array()) {
        if (strpos($page, '.php')) {
            $url = admin_url($page);
        } else {
            $url = admin_url('admin.php?page=' . $page);
        }

        if (isset($tab) && $tab <> '') {
            $url .= '&tab=' . $tab;
        }

        if (!empty($args)) {
            if (strpos($url, '?') !== false) {
                $url .= '&';
            } else {
                $url .= '?';
            }
            $url .= join('&', $args);
        }

        return apply_filters('sq_menu_url', $url, $page, $tab, $args);
    }

}
