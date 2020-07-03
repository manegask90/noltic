<?php

/**
 * Set the ajax action and call for wordpress
 */
class SQ_Classes_ActionController extends SQ_Classes_FrontController {

    /** @var array with all form and ajax actions */
    var $actions = array();

    /** @var array from core config */
    private static $config;

    /**
     * The hookAjax is loaded as custom hook in hookController class
     *
     * @return void
     */
    public function hookInit() {
        /* Only if ajax */
        if (SQ_Classes_Helpers_Tools::isAjax()) {
            $this->getActions();
        }
    }

    /**
     * The hookSubmit is loaded when action si posted
     *
     * @return void
     */
    public function hookMenu() {
        /* Only if post */
        if (!SQ_Classes_Helpers_Tools::isAjax()) {
            $this->getActions();
        }
    }

    /**
     * The hookHead is loaded as admin hook in hookController class for script load
     * Is needed for security check as nonce
     *
     * @return void
     */
    public function hookHead() {
        echo '<script>
                  var sqQuery = {
                    "adminurl": "' . admin_url() . '",
                    "ajaxurl": "' . admin_url('admin-ajax.php') . '",
                    "adminposturl": "' . admin_url('post.php') . '",
                    "adminlisturl": "' . admin_url('edit.php') . '",
                    "nonce": "' . wp_create_nonce(_SQ_NONCE_ID_) . '"
                  }
              </script>';
    }

    public function hookFronthead() {
        if (SQ_Classes_Helpers_Tools::isFrontAdmin()) {
            echo '<script>
                  var sqQuery = {
                    "adminurl": "' . admin_url() . '",
                    "ajaxurl": "' . admin_url('admin-ajax.php') . '",
                    "nonce": "' . wp_create_nonce(_SQ_NONCE_ID_) . '"
                  }
              </script>';
        }
    }

    /**
     * Get all actions from config.json in core directory and add them in the WP
     *
     */
    public function getActions() {
        $this->actions = array();
        $cur_action = SQ_Classes_Helpers_Tools::getValue('action', false);
        $sq_nonce = SQ_Classes_Helpers_Tools::getValue('sq_nonce', false);

        if (!function_exists('is_user_logged_in')) {
            return;
        }

        //Let only the logged users to access the actions
        if ($cur_action <> '' && $sq_nonce <> '' && is_admin()) {
            /* if config allready in cache */
            if (!isset(self::$config)) {
                $config_file = _SQ_ROOT_DIR_ . 'config.json';
                if (!file_exists($config_file)) {
                    return;
                }

                /* load configuration blocks data from core config files */
                self::$config = json_decode(file_get_contents($config_file), 1);
            }

            if (is_array(self::$config))
                foreach (self::$config['blocks']['block'] as $block) {
                    if (isset($block['active']) && $block['active'] == 1) {
                        /* if there is a single action */
                        if (isset($block['actions']['action']))
                            if (isset($block['admin']) && (($block['admin'] == 1 && is_user_logged_in()) || $block['admin'] == 0)) {
                                /* if there are more actions for the current block */
                                if (!is_array($block['actions']['action'])) {
                                    /* add the action in the actions array */
                                    if ($block['actions']['action'] == $cur_action) {
                                        $this->actions[] = array('class' => $block['name']);
                                    }
                                } else {
                                    /* if there are more actions for the current block */
                                    foreach ($block['actions']['action'] as $action) {
                                        /* add the actions in the actions array */
                                        if ($action == $cur_action) {
                                            $this->actions[] = array('class' => $block['name']);
                                        }
                                    }
                                }
                            }

                    }
                }

            if (!empty($this->actions)) {
                /* add the actions in WP */
                foreach ($this->actions as $actions) {
                    if (SQ_Classes_Helpers_Tools::isAjax()) {
                        check_ajax_referer(_SQ_NONCE_ID_, 'sq_nonce');
                        add_action('wp_ajax_' . $cur_action, array(SQ_Classes_ObjController::getClass($actions['class']), 'action'));
                    } else {
                        check_admin_referer($cur_action, 'sq_nonce');
                        SQ_Classes_ObjController::getClass($actions['class'])->action();
                    }
                }
            }
        }

    }

}
