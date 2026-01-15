<?php

namespace WooAlreadyPurchased\Includes\Settings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Cart Settings
 * 
 * Handles settings for cart page badges.
 */
class CartSettings
{
    /**
     * Section prefix
     */
    const PREFIX = 'apwoo_cart_';

    /**
     * Get settings fields
     * 
     * @return array
     */
    public function getFields()
    {
        return [
            // Display Settings
            [
                'title' => __('Cart Page Display Settings', 'already-purchased-for-woo'),
                'type' => 'title',
                'desc' => __('Configure badge display on the cart page for previously purchased items.', 'already-purchased-for-woo'),
                'id' => self::PREFIX . 'display_title'
            ],
            [
                'title' => __('Enable on Cart Page', 'already-purchased-for-woo'),
                'desc' => __('Display badge next to cart items that were previously purchased', 'already-purchased-for-woo'),
                'id' => 'apwoo_show_cart',
                'default' => 'yes',
                'type' => 'checkbox'
            ],
            [
                'title' => __('Badge Text', 'already-purchased-for-woo'),
                'desc' => __('Text to display on the badge (cart page)', 'already-purchased-for-woo'),
                'id' => 'apwoo_cart_badge_text',
                'default' => __('Previously Purchased', 'already-purchased-for-woo'),
                'type' => 'text',
                'css' => 'min-width:300px;'
            ],
            [
                'title' => __('Badge Position', 'already-purchased-for-woo'),
                'desc' => __('Choose where to display the badge in cart', 'already-purchased-for-woo'),
                'id' => 'apwoo_cart_badge_position',
                'default' => 'after_name',
                'type' => 'select',
                'class' => 'wc-enhanced-select',
                'css' => 'min-width:300px;',
                'options' => [
                    'after_name' => __('After Product Name', 'already-purchased-for-woo'),
                    'below_name' => __('Below Product Name', 'already-purchased-for-woo'),
                ]
            ],
            [
                'title' => __('Show Checkmark Icon', 'already-purchased-for-woo'),
                'desc' => __('Display a checkmark icon before badge text', 'already-purchased-for-woo'),
                'id' => 'apwoo_cart_badge_icon',
                'default' => 'yes',
                'type' => 'checkbox'
            ],
            [
                'type' => 'sectionend',
                'id' => self::PREFIX . 'display_end'
            ],
            // Design Settings
            [
                'title' => __('Cart Page Badge Design', 'already-purchased-for-woo'),
                'type' => 'title',
                'desc' => __('Customize the appearance of the badge on the cart page.', 'already-purchased-for-woo'),
                'id' => self::PREFIX . 'design_title'
            ],
            [
                'title' => __('Background Color', 'already-purchased-for-woo'),
                'desc' => __('Badge background color (e.g., #28a745 or rgba(40, 167, 69, 0.9))', 'already-purchased-for-woo'),
                'id' => 'apwoo_cart_badge_bg_color',
                'default' => '#17a2b8',
                'type' => 'text',
                'css' => 'min-width:200px;',
                'placeholder' => '#17a2b8'
            ],
            [
                'title' => __('Text Color', 'already-purchased-for-woo'),
                'desc' => __('Badge text color (e.g., #ffffff)', 'already-purchased-for-woo'),
                'id' => 'apwoo_cart_badge_text_color',
                'default' => '#ffffff',
                'type' => 'text',
                'css' => 'min-width:200px;',
                'placeholder' => '#ffffff'
            ],
            [
                'title' => __('Font Size', 'already-purchased-for-woo'),
                'desc' => __('Badge font size in pixels', 'already-purchased-for-woo'),
                'id' => 'apwoo_cart_badge_font_size',
                'default' => '11',
                'type' => 'number',
                'css' => 'width:100px;',
                'custom_attributes' => [
                    'min' => '8',
                    'step' => '1'
                ]
            ],
            [
                'title' => __('Padding', 'already-purchased-for-woo'),
                'desc' => __('Badge padding in pixels (vertical horizontal, e.g., 4 8)', 'already-purchased-for-woo'),
                'id' => 'apwoo_cart_badge_padding',
                'default' => '4 8',
                'type' => 'text',
                'css' => 'min-width:150px;',
                'placeholder' => '4 8'
            ],
            [
                'title' => __('Border Width', 'already-purchased-for-woo'),
                'desc' => __('Badge border width in pixels (0 to disable)', 'already-purchased-for-woo'),
                'id' => 'apwoo_cart_badge_border_width',
                'default' => '0',
                'type' => 'number',
                'css' => 'width:100px;',
                'custom_attributes' => [
                    'min' => '0',
                    'step' => '1'
                ]
            ],
            [
                'title' => __('Border Color', 'already-purchased-for-woo'),
                'desc' => __('Badge border color (e.g., #ffffff)', 'already-purchased-for-woo'),
                'id' => 'apwoo_cart_badge_border_color',
                'default' => '#ffffff',
                'type' => 'text',
                'css' => 'min-width:200px;',
                'placeholder' => '#ffffff'
            ],
            [
                'title' => __('Border Radius', 'already-purchased-for-woo'),
                'desc' => __('Badge border radius in pixels', 'already-purchased-for-woo'),
                'id' => 'apwoo_cart_badge_border_radius',
                'default' => '3',
                'type' => 'number',
                'css' => 'width:100px;',
                'custom_attributes' => [
                    'min' => '0',
                    'step' => '1'
                ]
            ],
            [
                'type' => 'sectionend',
                'id' => self::PREFIX . 'design_end'
            ]
        ];
    }

    // =========================================================================
    // STATIC GETTERS
    // =========================================================================

    /**
     * Check if badge should show on cart page
     * 
     * @return bool
     */
    public static function showOnCart()
    {
        return SettingsManager::get('apwoo_show_cart', true);
    }

    /**
     * Get cart page badge text
     * 
     * @return string
     */
    public static function getBadgeText()
    {
        return SettingsManager::get('apwoo_cart_badge_text', __('Previously Purchased', 'already-purchased-for-woo'));
    }

    /**
     * Get cart badge position
     * 
     * @return string
     */
    public static function getBadgePosition()
    {
        return SettingsManager::get('apwoo_cart_badge_position', 'after_name');
    }

    /**
     * Check if checkmark icon should be shown
     * 
     * @return bool
     */
    public static function showIcon()
    {
        return SettingsManager::get('apwoo_cart_badge_icon', true);
    }

    /**
     * Get cart badge background color
     * 
     * @return string
     */
    public static function getBgColor()
    {
        return SettingsManager::get('apwoo_cart_badge_bg_color', '#17a2b8');
    }

    /**
     * Get cart badge text color
     * 
     * @return string
     */
    public static function getTextColor()
    {
        return SettingsManager::get('apwoo_cart_badge_text_color', '#ffffff');
    }

    /**
     * Get cart badge font size
     * 
     * @return int
     */
    public static function getFontSize()
    {
        return (int) SettingsManager::get('apwoo_cart_badge_font_size', 11);
    }

    /**
     * Get cart badge padding
     * 
     * @return string
     */
    public static function getPadding()
    {
        return SettingsManager::get('apwoo_cart_badge_padding', '4 8');
    }

    /**
     * Get cart badge border width
     * 
     * @return int
     */
    public static function getBorderWidth()
    {
        return (int) SettingsManager::get('apwoo_cart_badge_border_width', 0);
    }

    /**
     * Get cart badge border color
     * 
     * @return string
     */
    public static function getBorderColor()
    {
        return SettingsManager::get('apwoo_cart_badge_border_color', '#ffffff');
    }

    /**
     * Get cart badge border radius
     * 
     * @return int
     */
    public static function getBorderRadius()
    {
        return (int) SettingsManager::get('apwoo_cart_badge_border_radius', 3);
    }
}
