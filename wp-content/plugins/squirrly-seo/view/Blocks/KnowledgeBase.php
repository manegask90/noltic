<?php $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', '')); ?>
<div class="mt-2">
    <div class="sq_knowledge p-2">
        <h4 class="mt-2 text-center">

            <?php echo __('Knowledge Base', _SQ_PLUGIN_NAME_) ?>
            <a href="https://howto.squirrly.co/" target="_blank">
                <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/knowledge.png' ?>" style="width: 150px;display: block;margin: 0 auto;">
            </a>
        </h4>
        <div>
            <?php if ($page == 'sq_dashboard') { ?>
                <ul class="list-group list-group-flush">
                    <?php if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') { ?>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/install-squirrly-seo-plugin/#connect_to_cloud" target="_blank">Why do I need to connect to Squirrly Cloud?</a>
                        </li>
                        <li class="list-group-item" text-left>
                            <a href="https://howto.squirrly.co/kb/install-squirrly-seo-plugin/#connect_to_cloud" target="_blank">How to connect to Squirrly Cloud.</a>
                        </li>
                    <?php } ?>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/install-squirrly-seo-plugin/#import_seo" target="_blank">How to Import SEO from other SEO plugins.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/install-squirrly-seo-plugin/#top_10_race" target="_blank">How to get on TOP 10 Google?</a>
                    </li>
                </ul>
                <div class="text-center m-2">
                    <a href="https://howto.squirrly.co/kb/" target="_blank">[ go to knowledge base ]</a></div>
            <?php } ?>
            <?php if ($page == 'sq_research') { ?>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#find_new_keywords" target="_blank">How to do a Keyword Research.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#find_new_keywords" target="_blank">How to do a Keyword Research.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_add_keyword" target="_blank">How to add Keywords into Briefcase.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_label" target="_blank">How to add Labels to Keywords.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_optimize_sla" target="_blank">How to optimize a post with Briefcase.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_backup_keywords" target="_blank">How to backup/restore Briefcase Keywords.</a>
                    </li>
                </ul>
                <div class="text-center m-2">
                    <a href="https://howto.squirrly.co/kb/" target="_blank">[ go to knowledge base ]</a></div>
            <?php } ?>
            <?php if ($page == 'sq_assistant') { ?>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#all_tasks_green" target="_blank">How to 100% optimize a post, page or product with Squirrly Live Assistant.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#add_keyword" target="_blank">How to add Copyright Free Images.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/faq/why-is-the-squirrly-live-assistant-not-loading-in-the-post-editor/" target="_blank">Squirrly Live Assistant not showing.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#after_optimization" target="_blank">What to do after I optimize a post.</a>
                    </li>
                </ul>
                <div class="text-center m-2">
                    <a href="https://howto.squirrly.co/kb/" target="_blank">[ go to knowledge base ]</a></div>
            <?php } ?>
            <?php if ($page == 'sq_seosettings') { ?>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/seo-automation/" target="_blank">How to set the SEO in just 2 minutes.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_og" target="_blank">How to optimize Social Media for each post.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_jsonld" target="_blank">How to activate Rich Snippets for Google.</a>
                    </li>
                </ul>
                <div class="text-center m-2">
                    <a href="https://howto.squirrly.co/kb/" target="_blank">[ go to knowledge base ]</a></div>
            <?php } ?>
            <?php if ($page == 'sq_focuspages') { ?>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/focus-pages-page-audits/#add_new_focus_page" target="_blank">How to add a New Focus Page.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/focus-pages-page-audits/#remove_focus_page" target="_blank">How to remove a Focus Page.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/focus-pages-page-audits/#chance_to_rank" target="_blank">What is Chance to Rank.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/focus-pages-page-audits/#keyword" target="_blank">How to add a keyword in a Focus Page.</a>
                    </li>
                </ul>
                <div class="text-center m-2">
                    <a href="https://howto.squirrly.co/kb/" target="_blank">[ go to knowledge base ]</a></div>
            <?php } ?>
            <?php if ($page == 'sq_audits') { ?>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/seo-audit/#how_seo_audit_works" target="_blank">How does the Audit work?</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/seo-audit/" target="_blank">How to add a Page in Audits.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/seo-audit/" target="_blank">How to remove a page from Audits.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/seo-audit/#google_search_console" target="_blank">Connect to Google Search Console.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/seo-audit/#google_analytics" target="_blank">Connect to Google Analytics.</a>
                    </li>
                </ul>
                <div class="text-center m-2">
                    <a href="https://howto.squirrly.co/kb/" target="_blank">[ go to knowledge base ]</a></div>
            <?php } ?>
            <?php if ($page == 'sq_rankings') { ?>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/ranking-serp-checker/#add_keyword_ranking" target="_blank">How to add a Keyword in Rankings.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/ranking-serp-checker/#remove_keyword_ranking" target="_blank">How to remove a keyword from Rankings.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://howto.squirrly.co/kb/ranking-serp-checker/#check_keyword_information" target="_blank">Check the Keyword Impressions, Clicks and Optimization.</a>
                    </li>
                    <li class="list-group-item text-left">
                        <a href="https://fourhourseo.com/why-does-neil-patel-use-squirrly-seo-for-every-blog-post-that-he-publishes/" target="_blank">Why Does Neil Patel Use Squirrly SEO For Every Blog Post that He Publishes?</a>
                    </li>
                </ul>
                <div class="text-center m-2">
                    <a href="https://howto.squirrly.co/kb/" target="_blank">[ go to knowledge base ]</a></div>
            <?php } ?>
        </div>
    </div>

</div>