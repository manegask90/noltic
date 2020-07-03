<?php

class SQ_Models_Compatibility {

    /**
     * Check compatibility for late loading buffer
     */
    public function checkCompatibility() {
        if (defined('CE_FILE')) { //compatible with other cache plugins
            add_filter('sq_lateloading', '__return_true');
        }

        if (SQ_Classes_Helpers_Tools::isPluginInstalled('hummingbird-performance/wp-hummingbird.php')) { //compatible with hummingbird
            add_filter('sq_lateloading', '__return_true');
        }

        if (SQ_Classes_Helpers_Tools::isPluginInstalled('cachify/cachify.php')) { //compatible with cachify
            add_filter('sq_lateloading', '__return_true');
        }

        global $wp_super_cache_late_init;
        if (isset($wp_super_cache_late_init) && $wp_super_cache_late_init == 1 && !did_action('init')) {
            add_filter('sq_lateloading', '__return_true');
        }
    }

    /**
     * Prevent other plugins javascript
     */
    public function fixEnqueueErrors() {
        global $wp_styles, $wp_scripts;
        $corelib = array('admin-bar', 'colors', 'ie', 'common', 'utils', 'wp-auth-check', 'dismissible-notices',
            'media-editor', 'media-audiovideo', 'media-views', 'imgareaselect', 'mce-view', 'image-edit',
            'wp-color-picker', 'migrate_style', 'jquery-ui-draggable', 'jquery-ui-core',
            'wordfence-global-style', 'ip2location_country_blocker_admin_menu_styles', 'wf-adminbar', 'autoptimize-toolbar',
            'yoast-seo-adminbar', 'bbp-admin-css', 'bp-admin-common-css', 'bp-admin-bar', 'elementor-common', 'ithemes-icon-font',
            'wordfence-ls-admin-global', 'woocommerce_admin_menu_styles', 'besclwp_cpt_admin_style', 'uabb-notice-settings',
            'besclwp_cpt_admin_script', 'itsec-core-admin-notices', 'sandbox-website', 'flatsome-panel-css'
        );

        foreach ($wp_styles->queue as $key => $queue) {
            if (!in_array($queue, $corelib)) {
                unset($wp_styles->queue[$key]);
            }
        }

        foreach ($wp_scripts->queue as $key => $queue) {
            if (!in_array($queue, $corelib)) {
                unset($wp_scripts->queue[$key]);
            }
        }
    }

    /**
     * Clear the styles from other plugins
     */
    public function clearStyles() {
        //clear the other plugins styles
        global $wp_styles;
        $wp_styles->queue = array();
    }
}
