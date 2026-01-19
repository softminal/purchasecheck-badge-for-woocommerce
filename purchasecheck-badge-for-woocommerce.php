<?php

/**
 * Plugin Name:       PurchaseCheck Badge for WooCommerce
 * Plugin URI:        https://github.com/softminal/purchasecheck-badge-for-woocommerce
 * Description:       Display a "Purchased" badge on WooCommerce products that customers have already bought to prevent duplicate orders.
 * Version:           1.0.0
 * Author:            Softminal
 * Author URI:        https://github.com/softminal
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       purchasecheck-badge-for-woocommerce
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce
 * Requires at least: 5.0
 * Requires PHP:      7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'config/constants.php';
require_once PCBW_DIR . 'includes/App.php';

// Initialize the plugin
add_action('plugins_loaded', function() {
    if (class_exists('WooCommerce')) {
        \PurchaseCheck\Badge\Includes\App::getInstance()->run();
    }
}, 10);
