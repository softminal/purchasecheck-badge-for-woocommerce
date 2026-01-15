<?php

/**
 * Plugin Name:       Already Purchased for Woo
 * Plugin URI:        https://wooalreadypurchased.com/
 * Description:       A plugin that adds a custom field to the product page to check if the customer has already purchased the product.
 * Version:           1.0.0
 * Author:            Softminal LLC
 * Author URI:        https://softminal.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       already-purchased-for-woo
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'config/constants.php';
require_once WOO_ALREADY_PURCHASED_DIR . 'includes/App.php';

// Initialize the plugin
add_action('plugins_loaded', function() {
    if (class_exists('WooCommerce')) {
        \WooAlreadyPurchased\Includes\App::getInstance()->run();
    }
}, 10);