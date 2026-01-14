<?php

namespace WooAlreadyPurchased\Includes\Settings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Product Page Settings
 * 
 * Handles settings for single product page badges.
 */
class ProductPageSettings
{
    /**
     * Section prefix
     */
    const PREFIX = 'wooap_product_';

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
                'title' => __('Product Page Display Settings', 'woo-already-purchased'),
                'type' => 'title',
                'desc' => __('Configure badge display on single product pages.', 'woo-already-purchased'),
                'id' => self::PREFIX . 'display_title'
            ],
            [
                'title' => __('Enable on Product Page', 'woo-already-purchased'),
                'desc' => __('Display badge on single product pages', 'woo-already-purchased'),
                'id' => 'wooap_show_product',
                'default' => 'yes',
                'type' => 'checkbox'
            ],
            [
                'title' => __('Badge Text', 'woo-already-purchased'),
                'desc' => __('Text to display on the badge (product pages)', 'woo-already-purchased'),
                'id' => 'wooap_product_badge_text',
                'default' => __('Purchased', 'woo-already-purchased'),
                'type' => 'text',
                'css' => 'min-width:300px;'
            ],
            [
                'title' => __('Badge Position', 'woo-already-purchased'),
                'desc' => __('Choose where to display the badge on single product pages', 'woo-already-purchased'),
                'id' => 'wooap_product_badge_position',
                'default' => 'after_title',
                'type' => 'select',
                'class' => 'wc-enhanced-select',
                'css' => 'min-width:300px;',
                'options' => [
                    'top_title' => __('Top of Title', 'woo-already-purchased'),
                    'bottom_title' => __('Bottom of Title', 'woo-already-purchased'),
                    'after_title' => __('After Title (Inline)', 'woo-already-purchased'),
                ]
            ],
            [
                'title' => __('Badge Style', 'woo-already-purchased'),
                'desc' => __('Choose the badge style for single product pages', 'woo-already-purchased'),
                'id' => 'wooap_product_badge_style',
                'default' => 'default',
                'type' => 'select',
                'class' => 'wc-enhanced-select',
                'css' => 'min-width:300px;',
                'options' => [
                    'default' => __('Default', 'woo-already-purchased'),
                    'pill' => __('Pill / Tag', 'woo-already-purchased'),
                    'rounded' => __('Rounded', 'woo-already-purchased'),
                ]
            ],
            [
                'title' => __('Show Checkmark Icon', 'woo-already-purchased'),
                'desc' => __('Display a checkmark icon before badge text', 'woo-already-purchased'),
                'id' => 'wooap_product_badge_icon',
                'default' => 'no',
                'type' => 'checkbox'
            ],
            [
                'type' => 'sectionend',
                'id' => self::PREFIX . 'display_end'
            ],
            // Design Settings
            [
                'title' => __('Product Page Badge Design', 'woo-already-purchased'),
                'type' => 'title',
                'desc' => __('Customize the appearance of the badge on product pages.', 'woo-already-purchased'),
                'id' => self::PREFIX . 'design_title'
            ],
            [
                'title' => __('Background Color', 'woo-already-purchased'),
                'desc' => __('Badge background color (e.g., #28a745 or rgba(40, 167, 69, 0.9))', 'woo-already-purchased'),
                'id' => 'wooap_product_badge_bg_color',
                'default' => '#28a745',
                'type' => 'text',
                'css' => 'min-width:200px;',
                'placeholder' => '#28a745'
            ],
            [
                'title' => __('Text Color', 'woo-already-purchased'),
                'desc' => __('Badge text color (e.g., #ffffff)', 'woo-already-purchased'),
                'id' => 'wooap_product_badge_text_color',
                'default' => '#ffffff',
                'type' => 'text',
                'css' => 'min-width:200px;',
                'placeholder' => '#ffffff'
            ],
            [
                'title' => __('Font Size', 'woo-already-purchased'),
                'desc' => __('Badge font size in pixels', 'woo-already-purchased'),
                'id' => 'wooap_product_badge_font_size',
                'default' => '14',
                'type' => 'number',
                'css' => 'width:100px;',
                'custom_attributes' => [
                    'min' => '8',
                    'step' => '1'
                ]
            ],
            [
                'title' => __('Padding', 'woo-already-purchased'),
                'desc' => __('Badge padding in pixels (vertical horizontal, e.g., 8 16)', 'woo-already-purchased'),
                'id' => 'wooap_product_badge_padding',
                'default' => '8 16',
                'type' => 'text',
                'css' => 'min-width:150px;',
                'placeholder' => '8 16'
            ],
            [
                'title' => __('Border Width', 'woo-already-purchased'),
                'desc' => __('Badge border width in pixels (0 to disable)', 'woo-already-purchased'),
                'id' => 'wooap_product_badge_border_width',
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
                'id' => 'wooap_product_badge_border_color',
                'default' => '#ffffff',
                'type' => 'text',
                'css' => 'min-width:200px;',
                'placeholder' => '#ffffff'
            ],
            [
                'title' => __('Border Radius', 'woo-already-purchased'),
                'desc' => __('Badge border radius in pixels', 'woo-already-purchased'),
                'id' => 'wooap_product_badge_border_radius',
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
     * Check if badge should show on product page
     * 
     * @return bool
     */
    public static function showOnProduct()
    {
        return SettingsManager::get('wooap_show_product', true);
    }

    /**
     * Get product page badge text
     * 
     * @return string
     */
    public static function getBadgeText()
    {
        return SettingsManager::get('wooap_product_badge_text', __('Purchased', 'woo-already-purchased'));
    }

    /**
     * Get single product page badge position
     * 
     * @return string
     */
    public static function getBadgePosition()
    {
        return SettingsManager::get('wooap_product_badge_position', 'after_title');
    }

    /**
     * Get single product badge style
     * 
     * @return string
     */
    public static function getBadgeStyle()
    {
        return SettingsManager::get('wooap_product_badge_style', 'default');
    }

    /**
     * Check if checkmark icon should be shown
     * 
     * @return bool
     */
    public static function showIcon()
    {
        return SettingsManager::get('wooap_product_badge_icon', false);
    }

    /**
     * Get product badge background color
     * 
     * @return string
     */
    public static function getBgColor()
    {
        return SettingsManager::get('wooap_product_badge_bg_color', '#28a745');
    }

    /**
     * Get product badge text color
     * 
     * @return string
     */
    public static function getTextColor()
    {
        return SettingsManager::get('wooap_product_badge_text_color', '#ffffff');
    }

    /**
     * Get product badge font size
     * 
     * @return int
     */
    public static function getFontSize()
    {
        return (int) SettingsManager::get('wooap_product_badge_font_size', 14);
    }

    /**
     * Get product badge padding
     * 
     * @return string
     */
    public static function getPadding()
    {
        return SettingsManager::get('wooap_product_badge_padding', '8 16');
    }

    /**
     * Get product badge border width
     * 
     * @return int
     */
    public static function getBorderWidth()
    {
        return (int) SettingsManager::get('wooap_product_badge_border_width', 0);
    }

    /**
     * Get product badge border color
     * 
     * @return string
     */
    public static function getBorderColor()
    {
        return SettingsManager::get('wooap_product_badge_border_color', '#ffffff');
    }

    /**
     * Get product badge border radius
     * 
     * @return int
     */
    public static function getBorderRadius()
    {
        return (int) SettingsManager::get('wooap_product_badge_border_radius', 3);
    }
}
