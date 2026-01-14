<?php

namespace WooAlreadyPurchased\Includes\Settings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Shop Page Settings
 * 
 * Handles settings for shop and category page badges.
 */
class ShopPageSettings
{
    /**
     * Section prefix
     */
    const PREFIX = 'wooap_shop_';

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
                'title' => __('Shop Page Display Settings', 'woo-already-purchased'),
                'type' => 'title',
                'desc' => __('Configure badge display on shop and category pages.', 'woo-already-purchased'),
                'id' => self::PREFIX . 'display_title'
            ],
            [
                'title' => __('Enable on Shop Page', 'woo-already-purchased'),
                'desc' => __('Display badge on shop/archive pages', 'woo-already-purchased'),
                'id' => 'wooap_show_shop',
                'default' => 'yes',
                'type' => 'checkbox'
            ],
            [
                'title' => __('Enable on Category Pages', 'woo-already-purchased'),
                'desc' => __('Display badge on product category pages', 'woo-already-purchased'),
                'id' => 'wooap_show_category',
                'default' => 'yes',
                'type' => 'checkbox'
            ],
            [
                'title' => __('Badge Text', 'woo-already-purchased'),
                'desc' => __('Text to display on the badge (shop pages)', 'woo-already-purchased'),
                'id' => 'wooap_shop_badge_text',
                'default' => __('Purchased', 'woo-already-purchased'),
                'type' => 'text',
                'css' => 'min-width:300px;'
            ],
            [
                'title' => __('Badge Position', 'woo-already-purchased'),
                'desc' => __('Choose where to display the badge on shop/category pages', 'woo-already-purchased'),
                'id' => 'wooap_shop_badge_position',
                'default' => 'topleft',
                'type' => 'select',
                'class' => 'wc-enhanced-select',
                'css' => 'min-width:300px;',
                'options' => [
                    'topleft' => __('Top Left', 'woo-already-purchased'),
                    'topright' => __('Top Right', 'woo-already-purchased'),
                    'bottomleft' => __('Bottom Left', 'woo-already-purchased'),
                    'bottomright' => __('Bottom Right', 'woo-already-purchased'),
                    'center' => __('Center', 'woo-already-purchased'),
                ]
            ],
            [
                'type' => 'sectionend',
                'id' => self::PREFIX . 'display_end'
            ],
            // Design Settings
            [
                'title' => __('Shop Page Badge Design', 'woo-already-purchased'),
                'type' => 'title',
                'desc' => __('Customize the appearance of the badge on shop pages.', 'woo-already-purchased'),
                'id' => self::PREFIX . 'design_title'
            ],
            [
                'title' => __('Background Color', 'woo-already-purchased'),
                'desc' => __('Badge background color (e.g., #28a745 or rgba(40, 167, 69, 0.9))', 'woo-already-purchased'),
                'id' => 'wooap_shop_badge_bg_color',
                'default' => '#28a745',
                'type' => 'text',
                'css' => 'min-width:200px;',
                'placeholder' => '#28a745'
            ],
            [
                'title' => __('Text Color', 'woo-already-purchased'),
                'desc' => __('Badge text color (e.g., #ffffff)', 'woo-already-purchased'),
                'id' => 'wooap_shop_badge_text_color',
                'default' => '#ffffff',
                'type' => 'text',
                'css' => 'min-width:200px;',
                'placeholder' => '#ffffff'
            ],
            [
                'title' => __('Font Size', 'woo-already-purchased'),
                'desc' => __('Badge font size in pixels', 'woo-already-purchased'),
                'id' => 'wooap_shop_badge_font_size',
                'default' => '12',
                'type' => 'number',
                'css' => 'width:100px;',
                'custom_attributes' => [
                    'min' => '8',
                    'step' => '1'
                ]
            ],
            [
                'title' => __('Padding', 'woo-already-purchased'),
                'desc' => __('Badge padding in pixels (vertical horizontal, e.g., 6 12)', 'woo-already-purchased'),
                'id' => 'wooap_shop_badge_padding',
                'default' => '6 12',
                'type' => 'text',
                'css' => 'min-width:150px;',
                'placeholder' => '6 12'
            ],
            [
                'title' => __('Border Width', 'woo-already-purchased'),
                'desc' => __('Badge border width in pixels (0 to disable)', 'woo-already-purchased'),
                'id' => 'wooap_shop_badge_border_width',
                'default' => '0',
                'type' => 'number',
                'css' => 'width:100px;',
                'custom_attributes' => [
                    'min' => '0',
                    'step' => '1'
                ]
            ],
            [
                'title' => __('Border Color', 'woo-already-purchased'),
                'desc' => __('Badge border color (e.g., #ffffff)', 'woo-already-purchased'),
                'id' => 'wooap_shop_badge_border_color',
                'default' => '#ffffff',
                'type' => 'text',
                'css' => 'min-width:200px;',
                'placeholder' => '#ffffff'
            ],
            [
                'title' => __('Border Radius', 'woo-already-purchased'),
                'desc' => __('Badge border radius in pixels', 'woo-already-purchased'),
                'id' => 'wooap_shop_badge_border_radius',
                'default' => '3',
                'type' => 'number',
                'css' => 'width:100px;',
                'custom_attributes' => [
                    'min' => '0',
                    'step' => '1'
                ]
            ],
            [
                'title' => __('Blur Background', 'woo-already-purchased'),
                'desc' => __('Enable blur/glass effect on badge background', 'woo-already-purchased'),
                'id' => 'wooap_shop_badge_blur_bg',
                'default' => 'no',
                'type' => 'checkbox'
            ],
            [
                'title' => __('Blur Amount', 'woo-already-purchased'),
                'desc' => __('Blur intensity in pixels (only applies if blur background is enabled)', 'woo-already-purchased'),
                'id' => 'wooap_shop_badge_blur_amount',
                'default' => '10',
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
     * Check if badge should show on shop page
     * 
     * @return bool
     */
    public static function showOnShop()
    {
        return SettingsManager::get('wooap_show_shop', true);
    }

    /**
     * Check if badge should show on category pages
     * 
     * @return bool
     */
    public static function showOnCategory()
    {
        return SettingsManager::get('wooap_show_category', true);
    }

    /**
     * Get shop page badge text
     * 
     * @return string
     */
    public static function getBadgeText()
    {
        return SettingsManager::get('wooap_shop_badge_text', __('Purchased', 'woo-already-purchased'));
    }

    /**
     * Get shop page badge position
     * 
     * @return string
     */
    public static function getBadgePosition()
    {
        return SettingsManager::get('wooap_shop_badge_position', 'topleft');
    }

    /**
     * Get shop badge background color
     * 
     * @return string
     */
    public static function getBgColor()
    {
        return SettingsManager::get('wooap_shop_badge_bg_color', '#28a745');
    }

    /**
     * Get shop badge text color
     * 
     * @return string
     */
    public static function getTextColor()
    {
        return SettingsManager::get('wooap_shop_badge_text_color', '#ffffff');
    }

    /**
     * Get shop badge font size
     * 
     * @return int
     */
    public static function getFontSize()
    {
        return (int) SettingsManager::get('wooap_shop_badge_font_size', 12);
    }

    /**
     * Get shop badge padding
     * 
     * @return string
     */
    public static function getPadding()
    {
        return SettingsManager::get('wooap_shop_badge_padding', '6 12');
    }

    /**
     * Get shop badge border width
     * 
     * @return int
     */
    public static function getBorderWidth()
    {
        return (int) SettingsManager::get('wooap_shop_badge_border_width', 0);
    }

    /**
     * Get shop badge border color
     * 
     * @return string
     */
    public static function getBorderColor()
    {
        return SettingsManager::get('wooap_shop_badge_border_color', '#ffffff');
    }

    /**
     * Get shop badge border radius
     * 
     * @return int
     */
    public static function getBorderRadius()
    {
        return (int) SettingsManager::get('wooap_shop_badge_border_radius', 3);
    }

    /**
     * Check if shop badge blur background is enabled
     * 
     * @return bool
     */
    public static function isBlurBgEnabled()
    {
        return SettingsManager::get('wooap_shop_badge_blur_bg', false);
    }

    /**
     * Get shop badge blur amount
     * 
     * @return int
     */
    public static function getBlurAmount()
    {
        return (int) SettingsManager::get('wooap_shop_badge_blur_amount', 10);
    }
}
