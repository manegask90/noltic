<?php
/**
 *
 *  @package HREFLANG Tags Pro\Init
 *  @since 1.3.3
 *
 */

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if (file_exists(HREFLANG_PLUGIN_MAIN_PATH. 'includes/notices.php')) {
	include_once(HREFLANG_PLUGIN_MAIN_PATH. 'includes/notices.php');
}
else {
	die('Notices are missing');
}

if (file_exists(HREFLANG_PLUGIN_MAIN_PATH. 'includes/functions.php')) {
	include_once(HREFLANG_PLUGIN_MAIN_PATH. 'includes/functions.php');
}
else {
	die('Functions are missing');
}

if (file_exists(HREFLANG_PLUGIN_MAIN_PATH. 'includes/variables.php')) {
	include_once(HREFLANG_PLUGIN_MAIN_PATH. 'includes/variables.php');
}
else {
	die('Variables are missing');
}

if (file_exists(HREFLANG_PLUGIN_MAIN_PATH. 'includes/actions.php')) {
	include_once(HREFLANG_PLUGIN_MAIN_PATH. 'includes/actions.php');
}
else {
	die('Actions are missing');
}
global $hreflanguages;

register_activation_hook(__FILE__,'hreflang_admin_actions');
// init text domain

// add this link only if admin and option is enabled
if (get_option('hreflang-enable-admin-menu', 'false' ) == 'true' ){
	if (is_admin()) {
		add_action( 'wp_before_admin_bar_render', 'hreflang_admin_bar' );
	}
}
$plugin = plugin_basename( HREFLANG_PLUGIN_FILE );
add_filter( "plugin_action_links_$plugin", "hreflang_plugin_settings_link", 10, 4 );
$notices = HREFLangTags_Admin_Notices::get_instance();
$date_now = date("Y-m-d");
if ($date_now >= '2020-03-21') {
	$text = __('Upgrade to one of our premium licenses and receive free upgrades and support. <strong><i>Save 60%</i></strong> on all our premium plans. Offer expires Saturday, June 13, 2020. No coupon code needed. Visit our <a href="https://www.hreflangtags.com/pricing/#utm_source=plugin-page&utm_medium=notice&utm_campaign=COVID19">Annual Plans</a> and <a href="https://www.hreflangtags.com/lifetime-pricing/#utm_source=plugin-page&utm_medium=notice&utm_campaign=COVID19-Lifetime">Lifetime Plans</a>','hreflang-tags-by-dcgws');
	$notices->info( $text, 'global-crisis-4' );
}
