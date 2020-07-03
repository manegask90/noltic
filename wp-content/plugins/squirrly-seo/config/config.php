<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * The configuration file
 */
if (!defined('_SQ_NONCE_ID_')) {
    if (defined('NONCE_KEY')) {
        define('_SQ_NONCE_ID_', NONCE_KEY);
    } else {
        define('_SQ_NONCE_ID_', md5(date('Y-d')));
    }
}

define('_SQ_MOBILE_ICON_SIZES', '76,120,152');

define('SQ_ONBOARDING', '9.0.0');
defined('SQ_DEBUG') || define('SQ_DEBUG', 0);
define('SQ_REQUEST_TIME', microtime(true));

/* No path file? error ... */
require_once(dirname(__FILE__) . '/paths.php');

/* Define the record name in the Option and UserMeta tables */
defined('SQ_OPTION') || define('SQ_OPTION', 'sq_options');
defined('SQ_TASKS') || define('SQ_TASKS', 'sq_tasks');
defined('_SQ_DB_') || define('_SQ_DB_', 'qss');

define('SQ_ALL_PATTERNS', json_encode(array(
    '{{sep}}' => __("Places a separator between the elements of the post description", _SQ_PLUGIN_NAME_),
    '{{title}}' => __("Adds the title of the post/page/term once it’s published", _SQ_PLUGIN_NAME_),
    '{{excerpt}}' => __("Will display an excerpt from the post/page/term (if not customized, the excerpt will be auto-generated)", _SQ_PLUGIN_NAME_),
    '{{excerpt_only}}' => __("Will display an excerpt from the post/page (no auto-generation)", _SQ_PLUGIN_NAME_),
    '{{keyword}}' => __("Adds the post's keyword to the post description", _SQ_PLUGIN_NAME_),
    '{{page}}' => __("Displays the number of the current page (i.e. 1 of 6)", _SQ_PLUGIN_NAME_),
    '{{sitename}}' => __("Adds the site's name to the post description", _SQ_PLUGIN_NAME_),
    '{{sitedesc}}' => __("Adds the tagline/description of your site", _SQ_PLUGIN_NAME_),
    '{{category}}' => __("Adds the post category (several categories will be comma-separated)", _SQ_PLUGIN_NAME_),
    '{{primary_category}}' => __("Adds the primary category of the post/page", _SQ_PLUGIN_NAME_),
    '{{category_description}}' => __("Adds the category description to the post description", _SQ_PLUGIN_NAME_),
    '{{tag}}' => __("Adds the current tag(s) (several tags will be comma-separated)", _SQ_PLUGIN_NAME_),
    '{{tag_description}}' => __("Adds the tag description", _SQ_PLUGIN_NAME_),
    '{{term_title}}' => __("Adds the term name", _SQ_PLUGIN_NAME_),
    '{{term_description}}' => __("Adds the term description", _SQ_PLUGIN_NAME_),
    '{{searchphrase}}' => __("Displays the search phrase (if it appears in the post)", _SQ_PLUGIN_NAME_),
    '{{modified}}' => __("Replaces the publication date of a post/page with the modified one", _SQ_PLUGIN_NAME_),
    '{{name}}' => __("Displays the author's nicename", _SQ_PLUGIN_NAME_),
    '{{user_description}}' => __("Adds the author's biographical info to the post description", _SQ_PLUGIN_NAME_),
    '{{currentdate}}' => __("Displays the current date", _SQ_PLUGIN_NAME_),
    '{{date}}' => __("Displays the date of the post/page once it's published", _SQ_PLUGIN_NAME_),
    '{{currentday}}' => __("Adds the current day", _SQ_PLUGIN_NAME_),
    '{{currentmonth}}' => __("Adds the current month", _SQ_PLUGIN_NAME_),
    '{{currentyear}}' => __("Adds the current year", _SQ_PLUGIN_NAME_),
    '{{parent_title}}' => __('Adds the title of a page\'s parent page', _SQ_PLUGIN_NAME_),
    '{{product_name}}' => __('Adds the product name from Woocommerce for the current product', _SQ_PLUGIN_NAME_),
    '{{product_price}}' => __('Adds the product price from Woocommerce for the current product', _SQ_PLUGIN_NAME_),
    '{{product_sale}}' => __('Adds the product sale price from Woocommerce for the current product', _SQ_PLUGIN_NAME_),
    '{{product_currency}}' => __('Adds the product price currency from Woocommerce for the current product', _SQ_PLUGIN_NAME_),
)));

define('SQ_ALL_JSONLD_TYPES', json_encode(array('website','profile','article','book','music','product','video')));

define('SQ_ALL_SEP', json_encode(array(
    'sc-dash' => '-',
    'sc-ndash' => '&ndash;',
    'sc-mdash' => '&mdash;',
    'sc-middot' => '&middot;',
    'sc-bull' => '&bull;',
    'sc-star' => '*',
    'sc-smstar' => '&#8902;',
    'sc-pipe' => '|',
    'sc-tilde' => '~',
    'sc-laquo' => '&laquo;',
    'sc-raquo' => '&raquo;',
    'sc-lt' => '&lt;',
    'sc-gt' => '&gt;',
)));
