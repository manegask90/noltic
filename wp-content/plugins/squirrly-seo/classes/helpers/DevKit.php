<?php

class SQ_Classes_Helpers_DevKit {

    public static $plugin;
    public static $package;

    public function __construct() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_devkit_name') <> '') {
            if (isset($_SERVER['REQUEST_URI']) && function_exists('get_plugin_data')) {
                if (strpos($_SERVER['REQUEST_URI'], '/plugins.php') !== false) {
                    $data = get_plugin_data(_SQ_ROOT_DIR_ . 'squirrly.php');
                    if (isset($data['Name'])) {
                        self::$plugin['name'] = $data['Name'];
                        add_filter('pre_kses', array($this, 'changeString'), 1, 1);
                    }
                }
            }
        }
    }

    /**
     * Check if Dev Kit is installed
     *
     * @return bool
     */
    public function updatePluginData() {
        $package_file = _SQ_ROOT_DIR_ . 'package.json';
        if (!file_exists($package_file)) {
            return false;
        }

        /* load configuration blocks data from core config files */
        $config = json_decode(file_get_contents($package_file), 1);
        if (isset($config['package'])) {
            self::$package = $config['package'];

            if (isset(self::$package['settings']) && !empty(SQ_Classes_Helpers_Tools::$options)) {
                SQ_Classes_Helpers_Tools::$options = @array_replace_recursive(SQ_Classes_Helpers_Tools::$options, self::$package['settings']);

                if (isset(self::$package['name']) && self::$package['name'] <> '') {
                    SQ_Classes_Helpers_Tools::$options['sq_devkit_name'] = self::$package['name'];
                }

                SQ_Classes_Helpers_Tools::saveOptions();
                @unlink($package_file);

                wp_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard'));
                exit();
            }
        }


        //remove the package after activation
        @unlink($package_file);

        return true;
    }


    /**
     * Change the plugin name
     * @param $string
     * @return mixed
     */
    public function changeString($string) {
        if (isset(self::$plugin['name']) && SQ_Classes_Helpers_Tools::getOption('sq_devkit_name') <> '') {
            return str_replace(self::$plugin['name'], SQ_Classes_Helpers_Tools::getOption('sq_devkit_name'), $string);
        }
        return $string;
    }


    //Get the package info in case of custom details
    public function getPackageInfo($key) {
        if (isset(self::$package[$key])) {
            return self::$package[$key];
        }

        return false;
    }

}
