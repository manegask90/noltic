<?php

/**
 * Called on plugin uninstall
 */
if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

try {

    /* Call config files */
    require(dirname(__FILE__) . '/config/config.php');
    require_once(_SQ_CLASSES_DIR_ . 'ObjController.php');

    /* Delete the record from database */
    SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_Tools');
    if (SQ_Classes_Helpers_Tools::getOption('sq_complete_uninstall')) {
        delete_option(SQ_OPTION);
        delete_option(SQ_TASKS);
        @rrmdir(_SQ_CACHE_DIR_);

        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . _SQ_DB_);
    }

} catch (Exception $e) {
}

/**
 * Remove the icon directory if exists
 * @param string $dir
 */
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir")
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        reset($objects);
        @rmdir($dir);
    }
}
