<?php

if (!defined('ABSPATH')) {
    exit;
}

// Plugin Basic Information
define('PCBW_VERSION', '1.0.0');
define('PCBW_DIR', plugin_dir_path(dirname(__FILE__)));
define('PCBW_URL', plugin_dir_url(dirname(__FILE__)));
define('PCBW_PLUGIN_BASE', plugin_basename(dirname(__FILE__)));
define('PCBW_PLUGIN_NAME', 'purchasecheck-badge-for-woocommerce');

// Database Tables
define('PCBW_TABLE_PREFIX', 'pcbw_');

// API Information
define('PCBW_API_VERSION', 'v1');
define('PCBW_API_NAMESPACE', 'purchasecheck-badge/' . PCBW_API_VERSION);
