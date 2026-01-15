<?php

namespace WooAlreadyPurchased\Includes;

use WooAlreadyPurchased\Includes\Settings\GeneralSettings;
use WooAlreadyPurchased\Includes\Settings\ShopPageSettings;
use WooAlreadyPurchased\Includes\Settings\ProductPageSettings;
use WooAlreadyPurchased\Includes\Settings\CartSettings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue
 * 
 * Handles CSS and JavaScript enqueuing for the plugin.
 */
class Enqueue
{
    /**
     * Initialize enqueue hooks
     */
    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
    }

    /**
     * Enqueue frontend assets only for logged-in users on WooCommerce pages
     */
    public function enqueue_frontend_assets()
    {
        // Only run on frontend
        if (is_admin()) {
            return;
        }

        // Only for logged-in users
        if (!is_user_logged_in()) {
            return;
        }

        // Check if badge is enabled
        if (!GeneralSettings::isBadgeEnabled()) {
            return;
        }

        // Enqueue CSS for badge styling
        wp_enqueue_style(
            'already-purchased-for-woo-badge-style',
            WOO_ALREADY_PURCHASED_URL . 'assets/css/badge.css',
            [],
            WOO_ALREADY_PURCHASED_VERSION
        );

        // Add inline dynamic CSS based on settings
        add_action('wp_head', [$this, 'output_dynamic_badge_css'], 100);
    }

    /**
     * Output dynamic CSS based on badge design settings
     */
    public function output_dynamic_badge_css()
    {
        $css = '';

        // Shop page badge styles
        $css .= $this->getShopBadgeCss();

        // Product page badge styles
        $css .= $this->getProductBadgeCss();

        // Cart page badge styles
        $css .= $this->getCartBadgeCss();

        // Output CSS
        echo '<style id="apwoo-dynamic-badge-css">' . esc_attr($css) . '</style>' . "\n";
    }

    /**
     * Get Shop page badge CSS
     * 
     * @return string
     */
    private function getShopBadgeCss()
    {
        return $this->buildBadgeCss('.apwoo_shop-badge', [
            'bg_color' => ShopPageSettings::getBgColor(),
            'text_color' => ShopPageSettings::getTextColor(),
            'border_width' => ShopPageSettings::getBorderWidth(),
            'border_color' => ShopPageSettings::getBorderColor(),
            'border_radius' => ShopPageSettings::getBorderRadius(),
            'blur_enabled' => ShopPageSettings::isBlurBgEnabled(),
            'blur_amount' => ShopPageSettings::getBlurAmount(),
            'font_size' => ShopPageSettings::getFontSize(),
            'padding' => ShopPageSettings::getPadding(),
        ]);
    }

    /**
     * Get Product page badge CSS
     * 
     * @return string
     */
    private function getProductBadgeCss()
    {
        return $this->buildBadgeCss('.apwoo_product-badge', [
            'bg_color' => ProductPageSettings::getBgColor(),
            'text_color' => ProductPageSettings::getTextColor(),
            'border_width' => ProductPageSettings::getBorderWidth(),
            'border_color' => ProductPageSettings::getBorderColor(),
            'border_radius' => ProductPageSettings::getBorderRadius(),
            'blur_enabled' => false,
            'blur_amount' => 0,
            'font_size' => ProductPageSettings::getFontSize(),
            'padding' => ProductPageSettings::getPadding(),
        ]);
    }

    /**
     * Get Cart page badge CSS
     * 
     * @return string
     */
    private function getCartBadgeCss()
    {
        return $this->buildBadgeCss('.apwoo_cart-badge', [
            'bg_color' => CartSettings::getBgColor(),
            'text_color' => CartSettings::getTextColor(),
            'border_width' => CartSettings::getBorderWidth(),
            'border_color' => CartSettings::getBorderColor(),
            'border_radius' => CartSettings::getBorderRadius(),
            'blur_enabled' => false,
            'blur_amount' => 0,
            'font_size' => CartSettings::getFontSize(),
            'padding' => CartSettings::getPadding(),
        ]);
    }

    /**
     * Build badge CSS from settings
     * 
     * @param string $selector CSS selector
     * @param array $settings Badge settings
     * @return string CSS string
     */
    private function buildBadgeCss($selector, $settings)
    {
        $bg_color = $settings['bg_color'];
        $text_color = $settings['text_color'];
        $border_width = $settings['border_width'];
        $border_color = $settings['border_color'];
        $border_radius = $settings['border_radius'];
        $blur_enabled = $settings['blur_enabled'];
        $blur_amount = $settings['blur_amount'];
        $font_size = $settings['font_size'];
        $padding = $settings['padding'];

        // Parse padding (format: "vertical horizontal" or single value)
        $padding_parts = array_filter(explode(' ', trim($padding)));
        $padding_top = isset($padding_parts[0]) ? absint($padding_parts[0]) . 'px' : '6px';
        $padding_right = isset($padding_parts[1]) ? absint($padding_parts[1]) . 'px' : (isset($padding_parts[0]) ? absint($padding_parts[0]) . 'px' : '12px');
        $padding_bottom = $padding_top;
        $padding_left = $padding_right;

        // Build CSS
        $css = $selector . ' {';
        
        // Background color - handle blur effect
        if ($blur_enabled) {
            // For blur effect, make background semi-transparent
            if (strpos($bg_color, 'rgba') === false && strpos($bg_color, '#') === 0) {
                // Convert hex to rgba with opacity
                $hex = str_replace('#', '', $bg_color);
                if (strlen($hex) === 6) {
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                    $css .= 'background-color: rgba(' . $r . ', ' . $g . ', ' . $b . ', 0.75);';
                } else {
                    $css .= 'background-color: ' . esc_attr($bg_color) . ';';
                }
            } else {
                $css .= 'background-color: ' . esc_attr($bg_color) . ';';
            }
            // Add blur effect
            $css .= 'backdrop-filter: blur(' . absint($blur_amount) . 'px);';
            $css .= '-webkit-backdrop-filter: blur(' . absint($blur_amount) . 'px);';
        } else {
            $css .= 'background-color: ' . esc_attr($bg_color) . ';';
        }
        
        $css .= 'color: ' . esc_attr($text_color) . ';';
        $css .= 'font-size: ' . absint($font_size) . 'px;';
        $css .= 'padding: ' . esc_attr($padding_top) . ' ' . esc_attr($padding_right) . ' ' . esc_attr($padding_bottom) . ' ' . esc_attr($padding_left) . ';';
        $css .= 'border-radius: ' . absint($border_radius) . 'px;';

        if ($border_width > 0) {
            $css .= 'border: ' . absint($border_width) . 'px solid ' . esc_attr($border_color) . ';';
        } else {
            $css .= 'border: none;';
        }

        $css .= '}';

        return $css;
    }

    /**
     * Enqueue admin assets
     * 
     * @param string $hook
     */
    public function enqueue_admin_assets($hook)
    {
        // No admin assets needed for now
    }
}
