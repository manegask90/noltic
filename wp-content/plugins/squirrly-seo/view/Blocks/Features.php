<?php
$codes = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));
$connect = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('connect')));

$features = array(
    array(
        'title' => __('Focus Pages', _SQ_PLUGIN_NAME_),
        'description' => __('The Assistant who maps the road to Better Rankings. For every single page. Always with different specifics.', _SQ_PLUGIN_NAME_),
        'mode' => __('Freemium', _SQ_PLUGIN_NAME_),
        'option' => true,
        'logo' => 'focuspages_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'pagelist'),
        'details' => 'https://plugin.squirrly.co/focus-pages/',
    ), //Focus Pages
    array(
        'title' => __('Keyword Research', _SQ_PLUGIN_NAME_),
        'description' => __('Find the Best Keywords that your own website can rank for and get personalized competition data for each keyword.', _SQ_PLUGIN_NAME_),
        'mode' => __('Freemium', _SQ_PLUGIN_NAME_),
        'option' => true,
        'logo' => 'kr_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research'),
        'details' => 'https://plugin.squirrly.co/best-keyword-research-tool-for-seo/',
    ), //Keyword Research
    array(
        'title' => __('SEO Briefcase', _SQ_PLUGIN_NAME_),
        'description' => __('Add keywords in your portfolio based on your current Campaigns, Trends, Performance for a successful SEO strategy.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => true,
        'logo' => 'briefcase_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase'),
        'details' => 'https://plugin.squirrly.co/briefcase-keyword-management-tool/',
    ),//SEO Briefcase
    array(
        'title' => __('Live Assistant', _SQ_PLUGIN_NAME_),
        'description' => __('Publish content that is fully optimized for BOTH Search Engines and Humans – every single time!', _SQ_PLUGIN_NAME_),
        'mode' => __('Freemium', _SQ_PLUGIN_NAME_),
        'option' => true,
        'logo' => 'sla_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant'),
        'details' => 'https://plugin.squirrly.co/seo-virtual-assistant/',
    ),//Live Assistant
    array(
        'title' => __('Google SERP with GSC', _SQ_PLUGIN_NAME_),
        'description' => __('Get Google Search Console average possitions, clicks and impressions for organic keywords.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => true,
        'logo' => 'ranking_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'rankings'),
        'details' => 'https://plugin.squirrly.co/google-serp-checker/',
    ),//Google SERP with GSC
    array(
        'title' => __('SEO Automation', _SQ_PLUGIN_NAME_),
        'description' => __("Configure the SEO in 2 minutes for the entire website without writing a line of code.", _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern'),
        'logo' => 'automation_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation'),
        'details' => false,
    ),//SEO Automation
    array(
        'title' => __('Bulk SEO & Snippets', _SQ_PLUGIN_NAME_),
        'description' => __('Simplify the SEO process for all your posts types and optimize them in just minutes.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => true,
        'logo' => 'bulkseo_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
        'details' => 'https://plugin.squirrly.co/bulk-seo-settings/',
    ),//Bulk SEO
    array(
        'title' => __('Daily SEO Goals', _SQ_PLUGIN_NAME_),
        'description' => __('The Non-Human SEO Consultant that prepares you goals that take you closer to the first page of Google.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => true,
        'logo' => 'goals_92.png',
        'link' => '#tasks',
        'details' => false,
    ),//Daily SEO Goals
    array(
        'title' => __('Open Graph Optimization', _SQ_PLUGIN_NAME_),
        'description' => __('Add Social Open Graph protocol so that your Facebook shares look good.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook'),
        'logo' => 'social_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social'),
        'details' => 'https://plugin.squirrly.co/wordpress-open-graph/',
    ),//Open Graph Optimization
    array(
        'title' => __('Twitter Card Optimization', _SQ_PLUGIN_NAME_),
        'description' => __('Add Twitter Card in your tweets so that your Twitter shares look good.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter'),
        'logo' => 'social_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social'),
        'details' => 'https://plugin.squirrly.co/wordpress-open-graph/',
    ),//Twitter Card Optimization
    array(
        'title' => __('XML Sitemap', _SQ_PLUGIN_NAME_),
        'description' => __('Use Squirrly’s Sitemap Generator and Settings to help your website get crawled and indexed by Google.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap'),
        'logo' => 'sitemap_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'sitemap'),
        'details' => 'https://plugin.squirrly.co/auto-xml-sitemap-generator/',
    ), //XML Sitemap
    array(
        'title' => __('JSON-LD Optimizaition', _SQ_PLUGIN_NAME_),
        'description' => __('Edit your website’s JSON-LD Schema with Squirrly’s powerful semantic SEO Markup Solution.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld'),
        'logo' => 'jsonld_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'jsonld'),
        'details' => 'https://plugin.squirrly.co/json-ld-semantic-seo-markup/',
    ), //JSON-LD Optimizaition
    array(
        'title' => __('Google Analytics Tracking', _SQ_PLUGIN_NAME_),
        'description' => __('Add the Google Analytics and Google Tag Manager tracking on your website.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => (SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking') && isset($codes->google_analytics) && $codes->google_analytics <> ''),
        'logo' => 'traffic_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'tracking'),
        'details' => false,
    ), //Google Analytics Tracking
    array(
        'title' => __('Facebook Pixel Tracking', _SQ_PLUGIN_NAME_),
        'description' => __('Track visitors with website and e-commerce events for better Retargeting Campaigns.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => (SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking') && isset($codes->facebook_pixel) && $codes->facebook_pixel <> ''),
        'logo' => 'traffic_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'tracking'),
        'details' => false,
    ), //Facebook Pixel Tracking
    array(
        'title' => __('Google Search Console', _SQ_PLUGIN_NAME_),
        'description' => __('Connect your website with Google Search Console and get insights based on organic searched keywords.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => (SQ_Classes_Helpers_Tools::getOption('sq_auto_webmasters') && isset($connect->google_search_console) && $connect->google_search_console <> ''),
        'logo' => 'websites_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'tracking'),
        'details' => false,
    ), //Google Search Console
    array(
        'title' => __('Robots.txt File', _SQ_PLUGIN_NAME_),
        'description' => __("Tell search engine crawlers which pages or files the crawler can or can't request from your site.", _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => SQ_Classes_Helpers_Tools::getOption('sq_auto_robots'),
        'logo' => 'robots_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'robots'),
        'details' => false,
    ), //Robots.txt File
    array(
        'title' => __('Favicon Site Icon', _SQ_PLUGIN_NAME_),
        'description' => __("Add your website icon in the browser tabs and on other devices like iPhone, iPad and Android phones.", _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => SQ_Classes_Helpers_Tools::getOption('sq_auto_favicon'),
        'logo' => 'favicon_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'favicon'),
        'details' => false,
    ), //Favicon Site Icon
    array(
        'title' => __('On-Page SEO METAs', _SQ_PLUGIN_NAME_),
        'description' => __("Add all Search Engine METAs like Title, Description, Canonical, Dublin Core, Robots and more.", _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => (SQ_Classes_Helpers_Tools::getOption('sq_auto_title') || SQ_Classes_Helpers_Tools::getOption('sq_auto_description') || SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical') || SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')),
        'logo' => 'metas_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas'),
        'details' => 'https://howto.squirrly.co/kb/seo-metas/',
    ), //On-Page SEO METAs
    array(
        'title' => __('Remove META Duplicate', _SQ_PLUGIN_NAME_),
        'description' => __("Fix Duplicate Titles and Descriptions without writing a line of code.", _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => (SQ_Classes_Helpers_Tools::getOption('sq_auto_title') || SQ_Classes_Helpers_Tools::getOption('sq_auto_description') || SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical') || SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex') || (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_clearcode') && SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld')) ),
        'logo' => 'metas_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas'),
        'details' => 'https://plugin.squirrly.co/duplicate-removal-tool/',
    ), //Remove META Duplicate
    array(
        'title' => __('404 Redirects', _SQ_PLUGIN_NAME_),
        'description' => __('Automatically redirect the old posts and pages URLs to the new URLs to keep the post authority.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => true,
        'logo' => 'redirect_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation'),
        'details' => false,
    ), //404 Redirects
    array(
        'title' => __('SEO Audit', _SQ_PLUGIN_NAME_),
        'description' => __('Improve your Online Presence by knowing how your website is performing.', _SQ_PLUGIN_NAME_),
        'mode' => __('Freemium', _SQ_PLUGIN_NAME_),
        'option' => true,
        'logo' => 'audit_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'audits'),
        'details' => 'https://plugin.squirrly.co/site-seo-audit-tool/',
    ), //SEO Audit
    array(
        'title' => __('14 Days Journey Course', _SQ_PLUGIN_NAME_),
        'description' => __('Improve your Online Presence by knowing how your website is performing.', _SQ_PLUGIN_NAME_),
        'mode' => __('Free', _SQ_PLUGIN_NAME_),
        'option' => (SQ_Classes_Helpers_Tools::getOption('sq_seojourney') <> ''),
        'logo' => 'jsonld_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step2.1'),
        'details' => 'https://www.squirrly.co/seo/journey/',
    ), //14 Days Journey Course
    array(
        'title' => __('Blogging Assistant', _SQ_PLUGIN_NAME_),
        'description' => __('Add relevant Copyright-free images, Tweets, Wikis, Blog Excerpts in your posts.', _SQ_PLUGIN_NAME_),
        'mode' => __('Pro', _SQ_PLUGIN_NAME_),
        'option' => 'na',
        'logo' => 'sla_92.png',
        'link' => 'https://plugin.squirrly.co/research-tools-for-writers/',
        'details' => 'https://plugin.squirrly.co/research-tools-for-writers/',
    ), //Blogging Assistant
    array(
        'title' => __('Google SERP Checker', _SQ_PLUGIN_NAME_),
        'description' => __('Accurately track your rankings with Squirrly’s user-friendly Google SERP Checker.', _SQ_PLUGIN_NAME_),
        'mode' => __('Business', _SQ_PLUGIN_NAME_),
        'option' => 'na',
        'logo' => 'ranking_92.png',
        'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'rankings'),
        'details' => 'https://plugin.squirrly.co/google-serp-checker/',
    ), //Google SERP Checker

);
?>
<a name="features"></a>
<div class="sq_features border my-3 py-3">
    <div class="row text-left m-0 p-3">
        <div class="px-2 text-center" style="width: 38%;">
            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/onboarding/speedometer.png' ?>" style="width: 100%; max-width: 320px;">
        </div>
        <div class="col-sm px-2 py-5">
            <div class="col-sm-12 m-0 p-0">
                <h3><?php echo __('Squirrly SEO Feature Categories', _SQ_PLUGIN_NAME_) ?></h3>
            </div>
            <div class="sq_separator"></div>
            <div class="col-sm-12 m-2 p-0">
                <div class="my-2"><?php echo sprintf(__("With a total of over %s200%s free in-depth features that only Squirrly can offer.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?>
                    <a href="https://trello.com/c/BSOkxHSv/116-official-list-squirrly-seo-2019-strategy-features-grouped-by-tools-given-to-you-when-you-install-squirrly" target="_blank">See the full list</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row px-3 py-0">
        <?php foreach ($features

        as $index => $feature){ ?>
        <?php
        $color = 'text-info';
        $background_color = '#fff';
        switch (strtolower($feature['mode'])) {
            case 'free':
                $color = 'text-success';
                $background_color = '#f6fff966';
                break;
            case 'freemium':
                $color = 'text-info';
                $background_color = '#f6f7ff57';
                break;
            case 'pro':
            case 'business':
                $color = 'text-warning';
                $background_color = '#fff6f64d';
                break;
        }
        if($feature['option'] == false){
            $background_color = '#d6d6d6';
        }
        ?>
        <?php if ($index % 3 == 0){ ?></div>
    <div class="row px-3 py-0"><?php } ?>
        <div class="col-sm-4 px-2">
            <div class="card py-3 px-3 shadow-sm" style="background-color: <?php echo $background_color ?>">
                <div class="card-body m-0 p-0">
                    <div class="row px-3">
                        <div class="col-sm-1 p-0">
                            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/logos/' . $feature['logo'] ?>" style="width: 24px; vertical-align: middle;">
                        </div>
                        <div class="col-sm-11 p-0 pl-3"><h5><?php echo $feature['title'] ?></h5></div>
                    </div>
                    <div class="row px-3">

                        <div class="col-sm-12  font-weight-bold text-right" style="font-size: 14px">
                            <a href="https://plugin.squirrly.co/squirrly-seo-pricing/" target="_blank" class="<?php echo $color ?>"><?php echo $feature['mode'] ?></a>
                        </div>
                    </div>
                    <div class="my-2 text-black-50" style="min-height: 70px"><?php echo $feature['description'] ?></div>
                    <div class="row my-2 px-3">
                        <div class="col-sm-6 p-0 text-left">
                            <a href="<?php echo $feature['link'] ?>" target="_blank">
                                <?php if ($feature['option'] === 'na') { ?>
                                    <strong class="text-info"><?php echo __('Go to feature', _SQ_PLUGIN_NAME_) ?></strong>
                                <?php } elseif ($feature['option'] == true) { ?>
                                    <strong class="text-success"><?php echo __('Active', _SQ_PLUGIN_NAME_) ?></strong>
                                <?php } elseif ($feature['option'] == false) { ?>
                                    <strong class="text-danger"><?php echo __('Inactive', _SQ_PLUGIN_NAME_) ?></strong>
                                <?php } else { ?>
                                    <strong class="text-info"><?php echo $feature['option'] ?></strong>
                                <?php } ?>
                            </a>
                        </div>
                        <div class="col-sm-6 p-0 text-right">
                            <?php if ($feature['details']) { ?>
                                <a href="<?php echo $feature['details'] ?>" target="_blank" class="text-black-50"><?php echo __('more details', _SQ_PLUGIN_NAME_) ?></a>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

</div>