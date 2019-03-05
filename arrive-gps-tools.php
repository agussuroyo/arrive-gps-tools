<?php

/**
 * Plugin Name: Arrive GPS Tools
 * Description: Used by Arrive to activate and configure GPS device.
 * Version: 1.0.3
 * Author: Agus Suroyo
 *
 * @package AGT
 */

defined( 'ABSPATH' ) || exit();
define( 'AGT_PATH', __DIR__ );

require_once AGT_PATH . DIRECTORY_SEPARATOR . 'includes/class-agt.php';

// Run...
AGT::instance();
