<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Menu extends SQ_Classes_FrontController {

    /** @var array snippet */
    public $post_type;
    /** @var array snippet */
    var $options = array();

    public function __construct() {
        parent::__construct();

        if (!is_network_admin()) {
            add_action('admin_bar_menu', array($this, 'hookTopmenuDashboard'), 10);
            add_action('admin_bar_menu', array($this, 'hookTopmenuSquirrly'), 91);
            add_action('do_meta_boxes', array($this, 'addMetabox'));

            //run compatibility check on Squirrly settings
            if (SQ_Classes_Helpers_Tools::getIsset('page')) {
                $menus = $this->model->getMainMenu();
                $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', ''));

                if (in_array($page, array_keys($menus))) {
                    add_action('admin_enqueue_scripts', array(SQ_Classes_ObjController::getClass('SQ_Models_Compatibility'), 'fixEnqueueErrors'), PHP_INT_MAX);
                }
            }

            //Hook the Frontend Editors
            $this->hookBuilders();
        }
    }

    /**
     * Hook the Admin load
     */
    public function hookInit() {
        //in case the token is not set
        $menus = $this->model->getMainMenu();
        if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') {
            if (SQ_Classes_Helpers_Tools::getIsset('page')) {
                $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', ''));

                if ($page <> 'sq_dashboard' && in_array($page, array_keys($menus))) {
                    //redirect to dashboard to login
                    wp_safe_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard'));
                    exit();
                }
            }
        } elseif (SQ_Classes_Helpers_Tools::getIsset('page')) {
            $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', ''));

            //check if onboarding should load
            if (SQ_Classes_Helpers_Tools::getMenuVisible('show_tutorial')) {
                if (in_array($page, array_keys($menus))) {
                    //redirect users to onboarding if necessary
                    if (!$onboarding = SQ_Classes_Helpers_Tools::getOption('sq_onboarding')) {
                        if ($page !== 'sq_onboarding') {
                            wp_safe_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding'));
                            die();
                        }
                    }
                }
            }
        }

        //Check if help page is selected
        if (SQ_Classes_Helpers_Tools::getIsset('page')) {
            if (SQ_Classes_Helpers_Tools::getValue('page') == 'sq_help') {
                wp_redirect(_SQ_HOWTO_URL_);
                die();
            }
        }

        //Check if account page is selected
        if (SQ_Classes_Helpers_Tools::getIsset('page')) {
            if (current_user_can('sq_manage_settings')) {
                if (SQ_Classes_Helpers_Tools::getValue('page') == 'sq_account') {
                    wp_redirect(SQ_Classes_RemoteController::getMySquirrlyLink('account'));
                    die();
                }
            }
        }

        //Check if account page is selected
        if (SQ_Classes_Helpers_Tools::getIsset('page')) {
            if (current_user_can('sq_manage_settings')) {
                if (SQ_Classes_Helpers_Tools::getValue('page') == 'sq_import') {
                    wp_safe_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'backup'));
                    die();
                }
            }
        }


        /* add the plugin menu in admin */
        if (current_user_can('manage_options')) {
            try {
                //check if activated
                if (get_transient('sq_activate') == 1) {
                    // Delete the redirect transient
                    delete_transient('sq_activate');

                    //Create Qss table if not exists
                    SQ_Classes_ObjController::getClass('SQ_Models_Qss')->checkTableExists();

                    //This option is use for custom Package installs
                    //update text in case of devkit
                    SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_DevKit')->updatePluginData();

                    if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') {
                        wp_safe_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard'));
                        die();
                    }
                }

                if (get_transient('sq_rewrite') == 1) {
                    // Delete the redirect transient
                    delete_transient('sq_rewrite');
                    flush_rewrite_rules();
                }
            } catch (Exception $e) {
                SQ_Classes_Error::setMessage(sprintf(__("An error occurred during activation. If this error persists, please contact us at: %s", _SQ_PLUGIN_NAME_), _SQ_SUPPORT_URL_));
            }


        }

        //activate the cron job if not exists
        if (!wp_next_scheduled('sq_cron_process')) {
            wp_schedule_event(time(), 'hourly', 'sq_cron_process');
        }

        //Add Squirrly SEO in  Posts list
        SQ_Classes_ObjController::getClass('SQ_Controllers_PostsList')->init();

        //Hook the post save action
        SQ_Classes_ObjController::getClass('SQ_Controllers_Post')->hookPost();

        //Show Admin Toolbar
        add_action('wp_dashboard_setup', array($this, 'hookDashboardSetup'));
    }

    /**
     * Show the Dashboard link when Full Screen
     * @param $wp_admin_bar
     * @return mixed
     */
    public function hookTopmenuDashboard($wp_admin_bar) {
        global $sq_fullscreen;

        if (!is_user_logged_in()) {
            return false;
        }

        if (isset($sq_fullscreen) && $sq_fullscreen) {
            $wp_admin_bar->add_node(array(
                'parent' => 'site-name',
                'id' => 'dashboard',
                'title' => __('Dashboard'),
                'href' => admin_url(),
            ));
        }

        return $wp_admin_bar;
    }

    /**
     * Show the Squirrly Menu in toolbar
     * @param $wp_admin_bar
     */
    public function hookTopmenuSquirrly($wp_admin_bar) {
        global $tag;

        if (!is_admin()) {
            return false;
        }

        if (current_user_can('edit_posts')) {
            //Get count local SEO errors
            $errors = apply_filters('sq_seo_errors', 0);

            $wp_admin_bar->add_node(array(
                'id' => 'sq_toolbar',
                'title' => '<span class="sq_logo" style="margin-right: 2px"></span>' . __('Squirrly SEO', _SQ_PLUGIN_NAME_) . (($errors) ? '<span class="sq_errorcount">' . $errors . '</span>' : ''),
                'href' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard'),
                'parent' => false
            ));

            $mainmenu = $this->model->getMainMenu();
            if (!empty($mainmenu)) {
                foreach ($mainmenu as $menuid => $item) {
                    if ($menuid == 'sq_audits' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_audit')) {
                        continue;
                    } elseif ($menuid == 'sq_rankings' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_rankings')) {
                        continue;
                    } elseif ($menuid == 'sq_focuspages' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_focuspages')) {
                        continue;
                    } elseif ($menuid == 'sq_dashboard') {
                        if(is_rtl()){
                            $item['title'] = (($errors) ? '<span class="sq_errorcount" style="margin: 6px 0 0 0 !important; float: left !important;">' . $errors . '</span>' : '') . $item['title'];

                        }else{
                            $item['title'] = $item['title'] . (($errors) ? '<span class="sq_errorcount" style="margin: 6px 54px 0 0 !important;">' . $errors . '</span>' : '');

                        }
                    } elseif (!isset($item['parent'])) {
                        continue;
                    }

                    //make sure the user has the capabilities
                    if (current_user_can($item['capability'])) {
                        $wp_admin_bar->add_node(array(
                            'id' => $menuid,
                            'title' => $item['title'],
                            'href' => SQ_Classes_Helpers_Tools::getAdminUrl($menuid),
                            'parent' => 'sq_toolbar'
                        ));
                        $tabs = $this->model->getTabs($menuid);
                        if (!empty($tabs)) {
                            foreach ($tabs as $id => $tab) {
                                $array_id = explode('/', $id);
                                if (count((array)$array_id) == 2) {
                                    $wp_admin_bar->add_node(array(
                                        'id' => $menuid . str_replace('/', '_', $id),
                                        'title' => $tab['title'],
                                        'href' => SQ_Classes_Helpers_Tools::getAdminUrl($array_id[0], $array_id[1]),
                                        'parent' => $menuid
                                    ));
                                }
                            }
                        }
                    }
                }
            }

        }

        if (is_admin()) {
            $current_screen = get_current_screen();
            $post = get_post();
            if ('post' == $current_screen->base
                && ($post_type_object = get_post_type_object($post->post_type))
                && (current_user_can('edit_post', $post->ID) || current_user_can('sq_manage_snippets'))
                && ($post_type_object->public)) {
            } elseif ('edit' == $current_screen->base
                && ($post_type_object = get_post_type_object($current_screen->post_type))
                && ($post_type_object->show_in_admin_bar)
                && !('edit-' . $current_screen->post_type === $current_screen->id)) {
            } elseif ('term' == $current_screen->base
                && isset($tag) && is_object($tag) && !is_wp_error($tag)
                && ($tax = get_taxonomy($tag->taxonomy))
                && $tax->public) {
            } else {
                return false;
            }

            $this->model->addMeta(array('sq_blocksnippet',
                ucfirst(_SQ_NAME_) . ' ' . __('SEO Snippet', _SQ_PLUGIN_NAME_),
                array(SQ_Classes_ObjController::getClass('SQ_Controllers_Snippet'), 'init'),
                null,
                'normal',
                'high'
            ));

            //Dev Kit images
            $style = '';
            if (SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo')) {
                $style = '<style>.sq_logo{background-image:url("' . SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo') . '") !important;background-size: 100%;}</style>';
            }

            $wp_admin_bar->add_node(array(
                'id' => 'sq_bar_menu',
                'title' => $style . '<span class="sq_logo"></span> ' . __('Custom SEO', _SQ_PLUGIN_NAME_),
                'parent' => 'top-secondary',
            ));


            //Add snippet body
            $wp_admin_bar->add_menu(array(
                'id' => 'sq_bar_submenu',
                'parent' => 'sq_bar_menu',
                'meta' => array(
                    'html' => SQ_Classes_ObjController::getClass('SQ_Controllers_Snippet')->init(),
                    'tabindex' => PHP_INT_MAX,
                ),
            ));
        }

        return $wp_admin_bar;
    }

    public function hookDashboardSetup() {
        wp_add_dashboard_widget(
            'sq_dashboard_widget',
            __('Squirrly SEO', _SQ_PLUGIN_NAME_),
            array(SQ_Classes_ObjController::getClass('SQ_Controllers_Dashboard'), 'dashboard')
        );

        // Move our widget to top.
        global $wp_meta_boxes;

        $dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
        $ours = array('sq_dashboard_widget' => $dashboard['sq_dashboard_widget']);
        $wp_meta_boxes['dashboard']['normal']['core'] = array_merge($ours, $dashboard);
    }

    /**
     * Creates the Setting menu in Wordpress
     */
    public function hookMenu() {
        //Hook the SEO Errors from Squirrly SEO Check
        add_action('sq_seo_errors', array($this, 'getSEOErrors'));

        //Get all the post types
        $this->post_type = SQ_Classes_Helpers_Tools::getOption('sq_post_types');

        //Push the Analytics Check
        if (strpos($_SERVER['REQUEST_URI'], '?page=sq_dashboard') !== false) {
            SQ_Classes_Helpers_Tools::saveOptions('sq_dashboard', 1);
        }
        if (strpos($_SERVER['REQUEST_URI'], '?page=sq_rankings') !== false) {
            SQ_Classes_Helpers_Tools::saveOptions('sq_analytics', 1);
        }

        //Get count local SEO errors
        $errors = apply_filters('sq_seo_errors', 0);

        ///////////////
        $this->model->addMenu(array(ucfirst(_SQ_NAME_),
            __('Squirrly SEO', _SQ_PLUGIN_NAME_) . (($errors) ? '<span class="sq_errorcount">' . $errors . '</span>' : ''),
            'edit_posts',
            'sq_dashboard',
            null,
            (SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo') ? SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo') : _SQ_ASSETS_URL_ . 'img/logos/menu_icon_16.png')
        ));

        $this->model->addSubmenu(array('sq_none',
            __('Squirrly Onboarding', _SQ_PLUGIN_NAME_),
            __('Onboarding', _SQ_PLUGIN_NAME_),
            'edit_posts',
            'sq_onboarding',
            array(SQ_Classes_ObjController::getClass('SQ_Controllers_Onboarding'), 'init')
        ));

        $mainmenu = $this->model->getMainMenu();
        foreach ($mainmenu as $name => $item) {
            if ($name == 'sq_audits' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_audit')) {
                continue;
            } elseif ($name == 'sq_rankings' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_rankings')) {
                continue;
            } elseif ($name == 'sq_focuspages' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_focuspages')) {
                continue;
            } elseif (!isset($item['parent'])) {
                continue;
            }

            $this->model->addSubmenu(array($item['parent'],
                $item['description'],
                $item['title'],
                $item['capability'],
                $name,
                $item['function'],
            ));

        }

        $this->model->addSubmenu(array('sq_dashboard',
            __("Import & Export SEO", _SQ_PLUGIN_NAME_),
            __("Import SEO", _SQ_PLUGIN_NAME_),
            'sq_manage_settings',
            'sq_import',
            array(SQ_Classes_ObjController::getClass('SQ_Controllers_SeoSettings'), 'init')
        ));

        //show account only for Admins
        if (current_user_can('sq_manage_settings')) {
            if (SQ_Classes_Helpers_Tools::getMenuVisible('show_account_info')) {
                $this->model->addSubmenu(array('sq_dashboard',
                    __('Squirrly Account Info', _SQ_PLUGIN_NAME_),
                    __('Account Info', _SQ_PLUGIN_NAME_),
                    'manage_options',
                    'sq_account',
                    array(SQ_Classes_ObjController::getClass('SQ_Controllers_Account'), 'init')
                ));
            }
        }

        $this->model->addSubmenu(array('sq_dashboard',
            __('Squirrly How To & Support', _SQ_PLUGIN_NAME_),
            __('Help & Support', _SQ_PLUGIN_NAME_),
            'edit_posts',
            'sq_help',
            array(SQ_Classes_ObjController::getClass('SQ_Controllers_Help'), 'init')
        ));


    }

    /**
     * Add Post Editor Meta Box
     * Load Squirrly Live Assistant
     */
    public function addMetabox() {
        $types = get_post_types(array('public' => true));

        //Exclude types for SLA
        $excludes = SQ_Classes_Helpers_Tools::getOption('sq_sla_exclude_post_types');
        if (!empty($types) && !empty($excludes)) {
            foreach ($excludes as $exclude) {
                if (in_array($exclude, $types)) {
                    unset($types[$exclude]);
                }
            }
        }

        //Add Live Assistant For Selected Post Types
        if (!empty($types)) {
            foreach ($types as $type) {
                if ($metabox = unserialize(SQ_Classes_Helpers_Tools::getUserMeta('meta-box-order_' . $type))) {
                    extract($metabox);

                    if (isset($side) && isset($normal)) {
                        $side = explode(',', $side);
                        $normal = explode(',', $normal);
                        if (in_array('post' . _SQ_NAME_, $normal)) {
                            $side = array_merge(array('post' . _SQ_NAME_), $side);
                            $metabox['side'] = join(',', array_unique($side));

                            $normal = array_diff($normal, array('post' . _SQ_NAME_));
                            $metabox['normal'] = join(',', array_unique($normal));
                            SQ_Classes_Helpers_Tools::saveUserMeta('meta-box-order_' . $type, $metabox);
                        }
                    }
                }

                //Load the SLA in Post
                $this->model->addMeta(array('post' . _SQ_NAME_,
                    ucfirst(_SQ_NAME_),
                    array(SQ_Classes_ObjController::getClass('SQ_Controllers_Post'), 'init'),
                    $type,
                    'side',
                    'high'
                ));
            }

        }
    }

    public function hookHead() {
        global $sq_fullscreen;
        if (SQ_Classes_Helpers_Tools::getIsset('page')) {
            $menus = $this->model->getMainMenu();
            $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', ''));

            if (in_array($page, array_keys($menus))) {
                echo '<script type="text/javascript" src="//www.google.com/jsapi"></script>';
                echo '<script>google.load("visualization", "1.0", {packages: ["corechart"]});</script>';
                echo '<div id="sq_preloader" class="sq_loading"></div>';

                if ($page <> 'sq_dashboard') {
                    $sq_fullscreen = true;
                    SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fullwidth', array('trigger' => true, 'media' => 'all'));
                }
            }

        }

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('logo');

        //Dev Kit images
        if (SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo')) {
            echo '<style>.toplevel_page_sq_dashboard .wp-menu-image img{max-width: 24px !important;}.sq_logo{background-image:url("' . SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo') . '") !important;background-size: 100%;}</style>';
        }

        if (!SQ_Classes_Helpers_Tools::getMenuVisible('show_audit')) {
            echo '<style>.sq_offer {display: none !important;}</style>';
        }
    }

    public function hookBuilders() {
        add_action('elementor/editor/footer', array(SQ_Classes_ObjController::getClass('SQ_Controllers_Post'), 'loadLiveAssistant'), 99);
    }

    public function getSEOErrors() {
        return SQ_Classes_ObjController::getClass('SQ_Controllers_CheckSeo')->setCategory('sq_dashboard')->getErrorsCount();
    }
}
