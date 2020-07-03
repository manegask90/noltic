<?php

class SQ_Classes_RemoteController {

    public static $cache = array();
    public static $apimethod = 'get';

    /**
     * Call the Squirrly Cloud Server
     * @param string $module
     * @param array $args
     * @param array $options
     * @return string
     */
    public static function apiCall($module, $args = array(), $options = array()) {
        $parameters = "";

        //predefined options
        $options = array_merge(
            array(
                'method' => self::$apimethod,
                'sslverify' => SQ_CHECK_SSL,
                'timeout' => 15,
                'headers' => array(
                    'USER-TOKEN' => SQ_Classes_Helpers_Tools::getOption('sq_api'),
                    'USER-URL' => apply_filters('sq_homeurl', get_bloginfo('url')),
                    'LANG' => apply_filters('sq_language', get_bloginfo('language')),
                    'VERSQ' => (int)str_replace('.', '', SQ_VERSION)
                )
            ),
            $options);

        try {
            if (!empty($args)) {
                foreach ($args as $key => $value) {
                    if ($value <> '') {
                        $parameters .= ($parameters == "" ? "" : "&") . $key . "=" . urlencode($value);
                    }
                }
            }

            //call it with http to prevent curl issues with ssls
            $url = self::cleanUrl(_SQ_APIV2_URL_ . $module . "?" . $parameters);

            //print_R($options) . '<br>';echo $url . '<br>';exit();
            if (!isset(self::$cache[md5($url)])) {
                if ($options['method'] == 'post') {
                    $options['body'] = $args;
                }

                self::$cache[md5($url)] = self::sq_wpcall($url, $options);
            }

            return self::$cache[md5($url)];


        } catch (Exception $e) {
            return '';
        }

    }

    /**
     * Clear the url before the call
     * @param string $url
     * @return string
     */
    private static function cleanUrl($url) {
        return str_replace(array(' '), array('+'), $url);
    }

    public static function generatePassword($length = 12) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $password;
    }

    /**
     * Get My Squirrly Link
     *
     * @param $path
     * @return string
     */
    public static function getMySquirrlyLink($path) {
        if (SQ_Classes_Helpers_Tools::getMenuVisible('show_panel') && current_user_can('sq_manage_settings')) {
            return _SQ_DASH_URL_ . 'login/?token=' . SQ_Classes_Helpers_Tools::getOption('sq_api') . '&user_url=' . get_bloginfo('url') . '&redirect_to=' . _SQ_DASH_URL_ . 'user/' . $path;
        } else {
            return _SQ_DASH_URL_;
        }
    }

    /**
     * Get API Link
     *
     * @param string $path
     * @param integer $version
     * @return string
     */
    public static function getApiLink($path) {
        return _SQ_APIV2_URL_ . $path . '?token=' . SQ_Classes_Helpers_Tools::getOption('sq_api') . '&url=' . get_bloginfo('url');
    }

    /**
     * Use the WP remote call
     *
     * @param $url
     * @param $options
     * @return array|bool|string|WP_Error
     */
    public static function sq_wpcall($url, $options) {
        $method = $options['method'];

        switch ($method) {
            case 'get':
                //not accepted as option
                unset($options['method']);

                $response = wp_remote_get($url, $options);
                break;
            case 'post':
                //not accepted as option
                unset($options['method']);

                $response = wp_remote_post($url, $options);
                break;
            default:
                $response = wp_remote_request($url, $options);
                break;
        }

        if (is_wp_error($response)) {
            SQ_Classes_Error::setError($response->get_error_message(), 'sq_error');
            return false;
        }

        $response = self::cleanResponce(wp_remote_retrieve_body($response)); //clear and get the body

        SQ_Debug::dump('wp_remote_get', $method, $url, $options, $response); //output debug
        return $response;
    }

    /**
     * Get the Json from responce if any
     * @param string $response
     * @return string
     */
    private static function cleanResponce($response) {
        return trim($response, '()');
    }

    /**********************  USER ******************************/
    /**
     * @param array $args
     * @return array|mixed|object|WP_Error
     */
    public static function connect($args = array()) {
        self::$apimethod = 'post'; //call method
        $json = json_decode(self::apiCall('api/user/connect', $args));

        if (isset($json->error) && $json->error <> '') {

            if ($json->error == 'invalid_token') {
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', false);
            }
            if ($json->error == 'disconnected') {
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', false);
            }
            if ($json->error == 'banned') {
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', false);
            }
            return (new WP_Error('api_error', $json->error));
        }

        return $json;
    }

    /**
     * Login user to API
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function login($args = array()) {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/user/login', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Register user to API
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function register($args = array()) {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/user/register', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function getCloudToken($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/user/token', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * User Checkin
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function checkin($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/user/checkin', $args));

        if (isset($json->error) && $json->error <> '') {

            //prevent throttling on API
            if ($json->error == 'too_many_requests') {
                SQ_Classes_Error::setError(__("Too many API attempts, please slow down the request.", _SQ_PLUGIN_NAME_));
                SQ_Classes_Error::hookNotices();
                return (new WP_Error('api_error', $json->error));
            } elseif ($json->error == 'maintenance') {
                SQ_Classes_Error::setError(__("Squirrly Cloud is down for a bit of maintenance right now. But we'll be back in a minute.", _SQ_PLUGIN_NAME_));
                SQ_Classes_Error::hookNotices();
                return (new WP_Error('maintenance', $json->error));
            }

            self::connect(); //connect the website
            return (new WP_Error('api_error', $json->error));

        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (isset($json->data->offer) && $json->data->offer <> '') {
            SQ_Classes_Helpers_Tools::saveOptions('sq_offer', $json->data->offer);
        } else {
            SQ_Classes_Helpers_Tools::saveOptions('sq_offer', false);
        }

        //Save the connections into database
        if (isset($json->data->connection_gsc) && isset($json->data->connection_ga)) {
            $connect = SQ_Classes_Helpers_Tools::getOption('connect');
            $connect['google_analytics'] = $json->data->connection_ga;
            $connect['google_search_console'] = $json->data->connection_gsc;
            SQ_Classes_Helpers_Tools::saveOptions('connect', $connect);
        }

        return $json->data;
    }

    /**
     * Get the API stats for this blog
     * @return array
     */
    public static function getStats() {
        self::$apimethod = 'get'; //call method

        $args = $stats = array();
        if ($json = json_decode(self::apiCall('api/user/stats', $args))) {

            if (isset($json->error) && $json->error <> '') {
                self::connect(); //connect the website

                return (new WP_Error('api_error', $json->error));
            } elseif (!isset($json->data)) {
                return (new WP_Error('api_error', 'no_data'));
            }

            if (!isset($json->data)) {
                return (new WP_Error('api_error', 'no_data'));
            }

            $data = $json->data;
            if (isset($data->optimized_articles) && isset($data->average_optimization) && isset($data->kr_research) && isset($data->kr_in_briefcase)
                && isset($data->ranked_top) && isset($data->audits_made)) {


                //Get last month articles
                $stats['all_articles'] = array();
                $stats['all_articles']['value'] = ((int)$data->optimized_articles);
                $stats['all_articles']['text'] = __('Articles optimized so far', _SQ_PLUGIN_NAME_);
                $stats['all_articles']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant', 'assistant');
                $stats['all_articles']['linktext'] = __('add post', _SQ_PLUGIN_NAME_);

                //Get last month articles
                $stats['avg_articles'] = array();
                $stats['avg_articles']['value'] = ((int)$data->average_optimization);
                $stats['avg_articles']['text'] = __('Average optimization', _SQ_PLUGIN_NAME_);
                $stats['avg_articles']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant');
                $stats['avg_articles']['linktext'] = __('add post', _SQ_PLUGIN_NAME_);

                //Get all keyword researched
                $stats['all_researches'] = array();
                $stats['all_researches']['value'] = (int)$data->kr_research;
                $stats['all_researches']['text'] = __('Keyword Researches', _SQ_PLUGIN_NAME_);
                $stats['all_researches']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('sq_research');
                $stats['all_researches']['linktext'] = __('do research', _SQ_PLUGIN_NAME_);

                //Get all keywords from briefcase
                $stats['all_briefcase'] = array();
                $stats['all_briefcase']['value'] = (int)$data->kr_in_briefcase;
                $stats['all_briefcase']['text'] = __('Keywords stored in Squirrly Briefcase', _SQ_PLUGIN_NAME_);
                $stats['all_briefcase']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase');
                $stats['all_briefcase']['linktext'] = __('add keyword', _SQ_PLUGIN_NAME_);

                //Get the top 100 ranking
                $stats['top_ranking'] = array();
                $stats['top_ranking']['value'] = (int)$data->ranked_top;
                $stats['top_ranking']['text'] = __('Pages ranking in top 100 Google', _SQ_PLUGIN_NAME_);
                $stats['top_ranking']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings');
                $stats['top_ranking']['linktext'] = __('see rankings', _SQ_PLUGIN_NAME_);

                //Get last month audits
                $stats['lm_audit'] = array();
                $stats['lm_audit']['value'] = (int)$data->audits_made;
                $stats['lm_audit']['text'] = __('SEO Audits', _SQ_PLUGIN_NAME_);
                $stats['lm_audit']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits');
                $stats['lm_audit']['linktext'] = __('see audits', _SQ_PLUGIN_NAME_);
            }
        }

        return $stats;
    }

    /******************************** NOTIFICATIONS *********************/
    /**
     * Get the Notifications from API for the current blog
     * @return array|WP_Error
     */
    public static function getNotifications() {
        self::$apimethod = 'get'; //call method

        $notifications = array();
        if ($json = json_decode(self::apiCall('api/audits/notifications', array()))) {

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            } elseif (!isset($json->data)) {
                return (new WP_Error('api_error', 'no_data'));
            }

            $notifications = $json->data;

        }

        return $notifications;
    }

    /**
     * Get audits from API
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getBlogAudits($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/audits/get-audits', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!isset($json->data->audits)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        return $json->data->audits;
    }

    /******************************** BRIEFCASE *********************/
    public static function getBriefcase($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/briefcase/get', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function addBriefcaseKeyword($args = array()) {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/add', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function removeBriefcaseKeyword($args = array()) {
        self::$apimethod = 'post'; //call method

        if ($json = json_decode(self::apiCall('api/briefcase/hide', $args))) {
            return $json;
        }

        return false;
    }

    public static function getBriefcaseStats($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/briefcase/stats', $args));

        if (isset($json->error) && $json->error <> '') {
            self::connect(); //connect the website

            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function saveBriefcaseKeywordLabel($args = array()) {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/label/keyword', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }


    public static function addBriefcaseLabel($args = array()) {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/label/add', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function saveBriefcaseLabel($args = array()) {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/label/save', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function removeBriefcaseLabel($args = array()) {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/label/delete', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /******************************** KEYWORD RESEARCH ****************/

    public static function getKROthers($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/kr/other', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Set Keyword Research
     *
     * @param array $args
     * @return array|bool|mixed|object|WP_Error
     */
    public static function setKRSuggestion($args = array()) {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/kr/suggestion', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function getKRSuggestion($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/kr/suggestion', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }


    /**
     * Get Keyword Research History
     * @param array $args
     * @return array|bool|mixed|object|WP_Error
     */
    public static function getKRHistory($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/kr/history', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Get the Kr Found by API
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getKrFound($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/kr/found', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Get KR Countries
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getKrCountries($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/kr/countries', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /******************** WP Posts ***************************/
    /**
     * Save the post status on API
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function savePost($args = array()) {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/posts/update', $args, ['timeout' => 5]));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /**
     * Get the post optimization
     *
     * @param array $args
     * @return array|mixed|object
     */
    public static function getPostOptimization($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/posts/optimizations', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /******************** RANKINGS ***************************/

    /**
     * Add a keyword in Rank Checker
     * @param array $args
     * @return bool|WP_Error
     */
    public static function addSerpKeyword($args = array()) {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/serp', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Delete a keyword from Rank Checker
     * @param array $args
     * @return bool|WP_Error
     */
    public static function deleteSerpKeyword($args = array()) {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/serp-delete', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Get the Ranks for this blog
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getRanksStats($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/serp/stats', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Get the Ranks for this blog
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getRanks($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/serp/get-ranks', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Refresh the rank for a page/post
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function checkPostRank($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/serp/refresh', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /******************** FOCUS PAGES ***********************/

    /**
     * Get all focus pages and add them in the SQ_Models_Domain_FocusPage object
     * Add the audit data for each focus page
     * @param array $args
     * @return SQ_Models_Domain_FocusPage|WP_Error|false
     */
    public static function getFocusPages($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/posts/focus', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Get the focus page audit
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getFocusAudits($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/audits/focus', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Add Focus Page
     * @param array $args
     * @return bool|WP_Error
     */
    public static function addFocusPage($args = array()) {
        self::$apimethod = 'post'; //post call

        $json = json_decode(self::apiCall('api/posts/set-focus', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function updateFocusPage($args = array()) {
        self::$apimethod = 'post'; //post call

        $json = json_decode(self::apiCall('api/posts/update-focus', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Delete the Focus Page
     * @param array $args
     * @return bool|WP_Error
     */
    public static function deleteFocusPage($args = array()) {
        self::$apimethod = 'post'; //post call

        if (isset($args['user_post_id']) && $args['user_post_id'] > 0) {
            $json = json_decode(self::apiCall('api/posts/remove-focus/' . $args['user_post_id']));

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            } elseif (!isset($json->data)) {
                return (new WP_Error('api_error', 'no_data'));
            }

            return $json->data;
        }

        return false;
    }

    /**
     * Get all focus pages and add them in the SQ_Models_Domain_FocusPage object
     * Add the audit data for each focus page
     * @param array $args
     * @return SQ_Models_Domain_FocusPage|WP_Error|false
     */
    public static function getInspectURL($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/posts/crawl', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }
    /**************************************** CONNECTIONS */
    /**
     * Disconnect Google Analytics account
     *
     * @return bool|WP_Error
     */
    public static function revokeGaConnection() {
        self::$apimethod = 'get'; //post call

        $json = json_decode(self::apiCall('api/ga/revoke'));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function getGAToken($args = array()) {
        self::$apimethod = 'get'; //post call

        $json = json_decode(self::apiCall('api/ga/token', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /**
     * Disconnect Google Search Console account
     *
     * @return bool|WP_Error
     */
    public static function revokeGscConnection() {
        self::$apimethod = 'get'; //post call

        $json = json_decode(self::apiCall('api/gsc/revoke'));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    public static function syncGSC($args = array()) {
        self::$apimethod = 'get'; //post call

        $json = json_decode(self::apiCall('api/gsc/sync/kr', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    public static function getGSCToken($args = array()) {
        self::$apimethod = 'get'; //post call

        $json = json_decode(self::apiCall('api/gsc/token', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /******************** AUDITS *****************************/

    public static function getAuditPages($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/posts/audits', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /**
     * Get the audit page
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getAudit($args = array()) {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/audits/audit', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /**
     * Add Audit Page
     * @param array $args
     * @return bool|WP_Error
     */
    public static function addAuditPage($args = array()) {
        self::$apimethod = 'post'; //post call

        $json = json_decode(self::apiCall('api/posts/set-audit', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    public static function updateAudit($args = array()) {
        self::$apimethod = 'post'; //post call

        $json = json_decode(self::apiCall('api/posts/update-audit', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Delete the Audit Page
     * @param array $args
     * @return bool|WP_Error
     */
    public static function deleteAuditPage($args = array()) {
        self::$apimethod = 'post'; //post call

        if (isset($args['user_post_id']) && $args['user_post_id'] > 0) {

            $json = json_decode(self::apiCall('api/posts/remove-audit/' . $args['user_post_id']));

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            } elseif (!isset($json->data)) {
                return (new WP_Error('api_error', 'no_data'));
            }

            if (!empty($json->data)) {
                return $json->data;
            }

        }
        return false;
    }

    /******************** OTHERS *****************************/
    public static function saveSettings($args) {
        self::$apimethod = 'post'; //call method

        self::apiCall('api/user/settings', array('settings' => json_encode($args)));
    }

    /**
     * Get the Facebook APi Code
     * @param $args
     * @return bool|WP_Error
     */
    public static function getFacebookApi($args) {
        self::$apimethod = 'get'; //call method

        if ($json = json_decode(self::apiCall('api/tools/facebook', $args))) {

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            } elseif (!isset($json->data)) {
                return (new WP_Error('api_error', 'no_data'));
            }

            return $json->data;
        }

        return false;

    }

    /**
     * Load the JS for API
     */
    public static function loadJsVars() {
        global $post;
        $referer = '';

        $sq_postID = (isset($post->ID) ? $post->ID : 0);

        if (SQ_Classes_Helpers_Tools::isPluginInstalled('elementor/elementor.php')) {
            if (SQ_Classes_Helpers_Tools::getOption('sq_sla_frontend')) {
                $referer = get_post_meta($sq_postID, '_sq_sla', true);
            }
        }

        echo '<script>
                    var SQ_DEBUG = ' . (int)SQ_DEBUG . ';
                    (function($){
                        $.sq_config = {
                            sq_use: ' . (int)SQ_Classes_Helpers_Tools::getOption('sq_use') . ',
                            sq_version: "' . SQ_VERSION . '",
                            sq_sla_type: "' . SQ_Classes_Helpers_Tools::getOption('sq_sla_type') . '",
                            token: "' . SQ_Classes_Helpers_Tools::getOption('sq_api') . '",
                            sq_baseurl: "' . _SQ_STATIC_API_URL_ . '", 
                            sq_uri: "' . SQ_URI . '", 
                            sq_apiurl: "' . _SQ_APIV2_URL_ . '",
                            user_url: "' . apply_filters('sq_homeurl', get_bloginfo('url')) . '",
                            language: "' . apply_filters('sq_language', get_bloginfo('language')) . '",
                            referer: "' . $referer . '",
                            sq_keywordtag: ' . (int)SQ_Classes_Helpers_Tools::getOption('sq_keywordtag') . ',
                            sq_keyword_help: ' . (int)SQ_Classes_Helpers_Tools::getOption('sq_keyword_help') . ',
                            frontend_css: "' . _SQ_ASSETS_URL_ . 'css/frontend' . (SQ_DEBUG ? '' : '.min') . '.css",
                            postID: "' . $sq_postID . '",
                            prevNonce: "' . wp_create_nonce('post_preview_' . $sq_postID) . '",
                            __keyword: "' . __('Keyword:', _SQ_PLUGIN_NAME_) . '",
                            __date: "' . __('date', _SQ_PLUGIN_NAME_) . '",
                            __saved: "' . __('Saved!', _SQ_PLUGIN_NAME_) . '",
                            __readit: "' . __('Read it!', _SQ_PLUGIN_NAME_) . '",
                            __insertit: "' . __('Insert it!', _SQ_PLUGIN_NAME_) . '",
                            __reference: "' . __('Reference', _SQ_PLUGIN_NAME_) . '",
                            __insertasbox: "' . __('Insert as box', _SQ_PLUGIN_NAME_) . '",
                            __addlink: "' . __('Insert Link', _SQ_PLUGIN_NAME_) . '",
                            __notrelevant: "' . __('Not relevant?', _SQ_PLUGIN_NAME_) . '",
                            __insertparagraph: "' . __('Insert in your article', _SQ_PLUGIN_NAME_) . '",
                            __ajaxerror: "' . __(':( An error occurred while processing your request. Please try again', _SQ_PLUGIN_NAME_) . '",
                            __nofound: "' . __('No results found!', _SQ_PLUGIN_NAME_) . '",
                            __sq_photo_copyright: "' . __('[ ATTRIBUTE: Please check: %s to find out how to attribute this image ]', _SQ_PLUGIN_NAME_) . '",
                            __has_attributes: "' . __('Has creative commons attributes', _SQ_PLUGIN_NAME_) . '",
                            __no_attributes: "' . __('No known copyright restrictions', _SQ_PLUGIN_NAME_) . '",
                            __noopt: "' . __('You haven`t used Squirrly SEO to optimize your article. Do you want to optimize for a keyword before publishing?', _SQ_PLUGIN_NAME_) . '",
                            __subscription_expired: "' . __('Your Subscription has Expired', _SQ_PLUGIN_NAME_) . '",
                            __no_briefcase: "' . __('There are no keywords saved in briefcase yet', _SQ_PLUGIN_NAME_) . '",
                            __fulloptimized: "' . __('Congratulations! Your article is 100% optimized!', _SQ_PLUGIN_NAME_) . '",
                            __toomanytimes: "' . __('appears too many times. Try to remove %s of them', _SQ_PLUGIN_NAME_) . '",
                            __writemorewords: "' . __('write %s more words', _SQ_PLUGIN_NAME_) . '",
                            __keywordinintroduction: "' . __('Add the keyword in the %s of your article', _SQ_PLUGIN_NAME_) . '",
                            __clicktohighlight: "' . __('Click to keep the highlight on', _SQ_PLUGIN_NAME_) . '",
                            __introduction: "' . __('introduction', _SQ_PLUGIN_NAME_) . '",
                            __morewordsafter: "' . __('Write more words after the %s keyword', _SQ_PLUGIN_NAME_) . '",
                            __orusesynonyms: "' . __('or use synonyms', _SQ_PLUGIN_NAME_) . '",
                            __addmorewords: "' . __('add %s more word(s)', _SQ_PLUGIN_NAME_) . '",
                            __removewords: "' . __('or remove %s word(s)', _SQ_PLUGIN_NAME_) . '",
                            __addmorekeywords: "' . __('add %s  more keyword(s)', _SQ_PLUGIN_NAME_) . '",
                            __addminimumwords: "' . __('write %s  more words to start calculating', _SQ_PLUGIN_NAME_) . '",
                            __add_to_briefcase: "' . __('Add to Briefcase', _SQ_PLUGIN_NAME_) . '",
                            __add_keyword_briefcase: "' . __('Add Keyword to Briefcase', _SQ_PLUGIN_NAME_) . '",
                            __usekeyword: "' . __('Select', _SQ_PLUGIN_NAME_) . '",
                            __new_post_title: "' . __('Auto Draft') . '",
                            __frontend_optimized: "' . __('You’ve already used the Live Assistant to optimize this post when creating it in your Page Builder. Please go back and resume your optimization work there.', _SQ_PLUGIN_NAME_) . '",
                        };
                      
                    })(jQuery);
                     </script>';

        echo '<script src="' . _SQ_STATIC_API_URL_ . SQ_URI . '/js/squirrly' . (SQ_DEBUG ? '' : '.min') . '.js?ver=' . SQ_VERSION . '"></script>';

    }

}
