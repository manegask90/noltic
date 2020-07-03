<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Frontend extends SQ_Classes_FrontController {

    /** @var  SQ_Models_Frontend */
    public $model;

    public function __construct() {
        if (is_admin() || is_network_admin() || SQ_Classes_Helpers_Tools::isAjax()) {
            return;
        }

        //load the hooks
        parent::__construct();

        //For favicon and Robots
        $this->hookCheckFiles();

        //Check cache plugin compatibility
        SQ_Classes_ObjController::getClass('SQ_Models_Compatibility')->checkCompatibility();

        //Check if late loading is on
        if (!apply_filters('sq_lateloading', SQ_Classes_Helpers_Tools::getOption('sq_laterload'))) {
            //Hook the buffer on both actions in case one fails
            add_action('plugins_loaded', array($this, 'hookBuffer'), 9);
        }

        //In case plugins_loaded hook is disabled
        add_action('template_redirect', array($this, 'hookBuffer'), 1);

        //Set the post so that Squirrly will know which one to process
        if (defined('BP_REQUIRED_PHP_VERSION')) {
            add_action('template_redirect', array($this->model, 'setPost'), 10);
        } else {
            add_action('template_redirect', array($this->model, 'setPost'), 9);
        }

        //Check if attachment to image redirect is needed
        if (SQ_Classes_Helpers_Tools::getOption('sq_attachment_redirect')) {
            add_action('template_redirect', array($this->model, 'redirectAttachments'), 10);
        }

        //Check the old permalink and redirect to the new permalink
        if (SQ_Classes_Helpers_Tools::getOption('sq_permalink_redirect')) {
            add_action('template_redirect', array($this->model, 'redirectPermalinks'), 10);
        }

        /* Check if sitemap is on and Load the Sitemap */
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap')) {
            SQ_Classes_ObjController::getClass('SQ_Controllers_Sitemaps');
        }

        /* Fix the Links for feed*/
        if (SQ_Classes_Helpers_Tools::getOption('sq_url_fix')) {
            add_action('the_content', array($this, 'fixFeedLinks'), 11);
        }
    }

    /**
     * HOOK THE BUFFER
     */
    public function hookBuffer() {
        //remove the action is already hocked in plugins_loaded
        if (!did_action('template_redirect')) {
            remove_action('template_redirect', array($this, 'hookBuffer'), 1);
        }

        $this->model->startBuffer();
    }

    /**
     * Called after plugins are loaded
     */
    public function hookCheckFiles() {
        //Check for sitemap and robots
        if ($basename = $this->getFileName($_SERVER['REQUEST_URI'])) {
            if (SQ_Classes_Helpers_Tools::getOption('sq_auto_robots') == 1) {
                if ($basename == "robots.txt") {
                    SQ_Classes_ObjController::getClass('SQ_Models_Services_Robots');
                    apply_filters('sq_robots', false);
                    exit();
                }
            }

            if (SQ_Classes_Helpers_Tools::getOption('sq_auto_favicon') && SQ_Classes_Helpers_Tools::getOption('favicon') <> '') {
                if ($basename == "favicon.icon") {
                    SQ_Classes_Helpers_Tools::setHeader('ico');
                    @readfile(_SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption('favicon'));
                    exit();
                } elseif ($basename == "touch-icon.png") {
                    SQ_Classes_Helpers_Tools::setHeader('png');
                    @readfile(_SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption('favicon'));
                    exit();
                } else {
                    $appleSizes = preg_split('/[,]+/', _SQ_MOBILE_ICON_SIZES);
                    foreach ($appleSizes as $appleSize) {
                        if ($basename == "touch-icon$appleSize.png") {
                            SQ_Classes_Helpers_Tools::setHeader('png');
                            @readfile(_SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption('favicon') . $appleSize);
                            exit();
                        }
                    }
                }
            }

        }

    }


    /**
     * Hook the Header load
     */
    public function hookFronthead() {
        if (!is_admin() && (!SQ_Classes_Helpers_Tools::getOption('sq_load_css') || defined('SQ_NOCSS') && SQ_NOCSS)) {
            return;
        }

        if (!SQ_Classes_Helpers_Tools::isAjax()) {
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia(_SQ_ASSETS_URL_ . 'css/frontend' . (SQ_DEBUG ? '' : '.min') . '.css');
        }
    }


    /**
     * Change the image path to absolute when in feed
     * @param string $content
     *
     * @return string
     */
    public function fixFeedLinks($content) {
        if (is_feed()) {
            $find = $replace = $urls = array();

            @preg_match_all('/<img[^>]*src=[\'"]([^\'"]+)[\'"][^>]*>/i', $content, $out);
            if (is_array($out)) {
                if (!is_array($out[1]) || empty($out[1]))
                    return $content;

                foreach ($out[1] as $row) {
                    if (strpos($row, '//') === false) {
                        if (!in_array($row, $urls)) {
                            $urls[] = $row;
                        }
                    }
                }
            }

            @preg_match_all('/<a[^>]*href=[\'"]([^\'"]+)[\'"][^>]*>/i', $content, $out);
            if (is_array($out)) {
                if (!is_array($out[1]) || empty($out[1]))
                    return $content;

                foreach ($out[1] as $row) {
                    if (strpos($row, '//') === false) {
                        if (!in_array($row, $urls)) {
                            $urls[] = $row;
                        }
                    }
                }
            }
            if (!is_array($urls) || (is_array($urls) && empty($urls))) {
                return $content;
            }

            $urls = array_unique($urls);
            foreach ($urls as $url) {
                $find[] = "'" . $url . "'";
                $replace[] = "'" . esc_url(home_url() . $url) . "'";
                $find[] = '"' . $url . '"';
                $replace[] = '"' . esc_url(home_url() . $url) . '"';
            }
            if (!empty($find) && !empty($replace)) {
                $content = str_replace($find, $replace, $content);
            }
        }
        return $content;
    }

    /**
     * Hook the footer
     */
    public function hookFrontfooter() {
        echo $this->model->getFooter();
    }

    /**
     * Get the File Name if itțs a file in URL
     * @param null $url
     * @return bool|string|null
     */
    public function getFileName($url = null) {
        if (isset($url) && $url <> '') {
            $url = basename($url);
            if (strpos($url, '?') <> '') {
                $url = substr($url, 0, strpos($url, '?'));
            }

            $files = array('ico', 'icon', 'txt', 'jpg', 'jpeg', 'png', 'bmp', 'gif', 'webp',
                'css', 'scss', 'js',
                'pdf', 'doc', 'docx', 'csv', 'xls', 'xslx',
                'mp4', 'mpeg',
                'zip', 'rar');

            if (strrpos($url, '.') !== false) {
                $ext = substr($url, strrpos($url, '.') + 1);
                if (in_array($ext, $files)) {
                    return $url;
                }
            }
        }

        return false;

    }
}
