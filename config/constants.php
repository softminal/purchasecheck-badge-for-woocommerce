<?php

if (!defined('ABSPATH')) {
    exit;
}

// Plugin Basic Information
define('WOO_ALREADY_PURCHASED_VERSION', '1.0.0');
define('WOO_ALREADY_PURCHASED_DIR', plugin_dir_path(dirname(__FILE__)));
define('WOO_ALREADY_PURCHASED_URL', plugin_dir_url(dirname(__FILE__)));
define('WOO_ALREADY_PURCHASED_PLUGIN_BASE', plugin_basename(dirname(__FILE__)));
define('WOO_ALREADY_PURCHASED_PLUGIN_NAME', 'woo-already-purchased');

// Database Tables
define('WOO_ALREADY_PURCHASED_TABLE_PREFIX', 'wooap_');

// API Information
define('WOO_ALREADY_PURCHASED_API_VERSION', 'v1');
define('WOO_ALREADY_PURCHASED_API_NAMESPACE', 'woo-already-purchased/' . WOO_ALREADY_PURCHASED_API_VERSION);