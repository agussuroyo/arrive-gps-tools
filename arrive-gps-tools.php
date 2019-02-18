<?php

/*
  Plugin Name: Arrive GPS Tools
  Description: Used by Arrive to activate and configure GPS device.
  Version: 1.0.0
  Author: Agus Suroyo
 */

defined('ABSPATH') || exit();

define('AGT_PATH', __DIR__);

class AGT
{

    protected static $instance = null;

    /**
     * Singleton
     * 
     * @return object
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->includes();
        $this->hooks();
    }

    /**
     * Load all files
     */
    public function includes()
    {
        $plugin_path = AGT_PATH . DIRECTORY_SEPARATOR;

        include_once $plugin_path . 'vendor/autoload.php';
        include_once $plugin_path . 'includes/class-agt-admin.php';
        include_once $plugin_path . 'includes/class-agt-shortcode.php';
        include_once $plugin_path . 'includes/template-functions.php';
    }

    /**
     * Running the hooks
     */
    public function hooks()
    {
        // form and the handler
        $shortcode = new AGT_Shortcode();
        add_action('wp', array($shortcode, 'handle'));
        add_shortcode('arrive_activation_form', array($shortcode, 'form'));


        // Administration area
        $admin = new AGT_Admin();
        if (is_admin()) {
            add_action('admin_init', array($admin, 'setting_handle'));
            add_action('admin_menu', array($admin, 'menu'));
        }
    }

}

// Run...
AGT::instance();
