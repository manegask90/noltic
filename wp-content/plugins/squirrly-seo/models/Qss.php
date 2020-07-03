<?php

/**
 * Connection between Squirrly and Quick Squirrly SEO Table
 * Class SQ_Models_Qss
 */
class SQ_Models_Qss {


    /**
     * Get the post data by hash
     * @param null $hash
     * @return stdClass
     */
    public function getSqPost($hash = null) {
        global $wpdb;

        $post = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Post');

        if (isset($hash) && $hash <> '') {
            $blog_id = get_current_blog_id();

            $query = "SELECT * FROM " . $wpdb->prefix . _SQ_DB_ . " WHERE blog_id = '" . (int)$blog_id . "' AND url_hash = '" . $hash . "';";

            if ($row = $wpdb->get_row($query, OBJECT)) {
                $post = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Post', maybe_unserialize($row->post));
                $post->url = $row->URL; //set the URL for this post
            }
        }

        return $post;
    }

    /**
     * Get the Sq for a specific Post from database
     * @param string $hash
     * @return mixed|null
     */
    public function getSqSeo($hash = null) {
        global $wpdb;

        $metas = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Sq');

        if (isset($hash) && $hash <> '') {
            $blog_id = get_current_blog_id();

            $query = "SELECT * FROM " . $wpdb->prefix . _SQ_DB_ . " WHERE blog_id = '" . (int)$blog_id . "' AND url_hash = '" . $hash . "';";

            if ($row = $wpdb->get_row($query, OBJECT)) {
                $metas = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Sq', maybe_unserialize($row->seo));
            }
        }

        return $metas;
    }

    /**
     * Save the SEO for a specific Post into database
     * @param $url
     * @param $url_hash
     * @param $post
     * @param $seo
     * @param $date_time
     * @return false|int
     */
    public function saveSqSEO($url, $url_hash, $post, $seo, $date_time) {
        global $wpdb;
        $wpdb->hide_errors();

        $seo = addslashes($seo);
        $blog_id = get_current_blog_id();

        $sq_query = "INSERT INTO " . $wpdb->prefix . _SQ_DB_ . " (blog_id, URL, url_hash, post, seo, date_time)
                VALUES ('$blog_id','$url','$url_hash','$post','$seo','$date_time')
                ON DUPLICATE KEY
                UPDATE blog_id = '$blog_id', URL = '$url', url_hash = '$url_hash', post = '$post', seo = '$seo', date_time = '$date_time'";

        $result = $wpdb->query($sq_query);
        $wpdb->show_errors();

        return $result;
    }

    /**
     * Get the saved Permalink for a specific Post from database
     * @param string $hash
     * @return mixed|null
     */
    public function getPermalink($hash = null) {
        global $wpdb;
        $url = false;

        if (isset($hash) && $hash <> '') {
            $blog_id = get_current_blog_id();

            $query = "SELECT URL FROM " . $wpdb->prefix . _SQ_DB_ . " WHERE blog_id = '" . (int)$blog_id . "' AND url_hash = '" . $hash . "';";

            if ($row = $wpdb->get_row($query, OBJECT)) {
                $url = $row->URL;
            }
        }

        return $url;
    }

    /**
     * Check if the table exists
     * @return bool
     */
    public function checkTableExists(){
        global $wpdb;

        try {
            $wpdb->hide_errors();
            if(!$wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . _SQ_DB_ )){
                $this->createTable();
            }else {
                $this->alterTable();
            }
            $wpdb->show_errors();
        } catch (Exception $e) {
        }

    }

    /**
     * Create DB Table
     */
    public static function createTable() {
        global $wpdb;

        $sq_table_query = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . _SQ_DB_ . ' (
                      `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                      `blog_id` INT(10) NOT NULL,
                      `post` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `URL` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `url_hash` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `seo` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `date_time` DATETIME NOT NULL,
                      PRIMARY KEY(id),
                      UNIQUE url_hash(url_hash) USING BTREE,
                      INDEX blog_id_url_hash(blog_id, url_hash) USING BTREE
                      )  CHARACTER SET utf8 COLLATE utf8_general_ci';

        if (file_exists(ABSPATH . 'wp-admin/includes/upgrade.php')) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            if (function_exists('dbDelta')) {
                dbDelta($sq_table_query, true);
            }
        }

        self::alterTable();
    }

    public static function alterTable() {
        global $wpdb;
        $wpdb->hide_errors();

        if (file_exists(ABSPATH . 'wp-admin/includes/upgrade.php')) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            $count = $wpdb->get_row("SELECT count(*) as count
                              FROM information_schema.columns
                              WHERE table_name = '" . $wpdb->prefix . _SQ_DB_ . "'
                              AND column_name = 'post';");

            if ($count->count == 0) {
                $wpdb->query("ALTER TABLE " . $wpdb->prefix . _SQ_DB_ . " ADD COLUMN `post` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''");
            }

        }
        $wpdb->show_errors();

    }


}