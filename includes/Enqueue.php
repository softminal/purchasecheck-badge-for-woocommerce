<?php

namespace WooAlreadyPurchased\Includes;

if (!defined('ABSPATH')) {
    exit;
}

class Enqueue {
    public function init() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
    }

    /**
     * Enqueue frontend assets only for logged-in users on WooCommerce pages
     */
    public function enqueue_frontend_assets() {
        // Only run on frontend
        if (is_admin()) {
            return;
        }

        // Only for logged-in users
        if (!is_user_logged_in()) {
            return;
        }

        // Check if badge is enabled
        if (!\WooAlreadyPurchased\Includes\Settings::isBadgeEnabled()) {
            return;
        }

        // Enqueue CSS for badge styling
        wp_enqueue_style(
            'woo-already-purchased-badge-style',
            WOO_ALREADY_PURCHASED_URL . 'assets/css/badge.css',
            [],
            WOO_ALREADY_PURCHASED_VERSION
        );
    }

    public function enqueue_admin_assets($hook) {
        // No admin assets needed for now
    }
}