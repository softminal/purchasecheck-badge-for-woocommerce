<?php

namespace WooAlreadyPurchased\Includes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Settings
 * 
 * Handles WooCommerce settings tab for WooAP plugin.
 * Adds settings under WooCommerce → Settings → WooAP
 */
class Settings
{
    /**
     * Tab ID
     */
    const TAB_ID = 'wooap';

    /**
     * Section ID
     */
    const SECTION_ID = 'wooap_purchased_badge';

    /**
     * Initialize settings
     */
    public function init()
    {
        // Only run if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            return;
        }

        // Add settings tab - hook early to ensure it's registered
        add_filter('woocommerce_settings_tabs_array', [$this, 'addSettingsTab'], 50);

        // Add settings section and fields
        add_action('woocommerce_settings_' . self::TAB_ID, [$this, 'renderSettings']);

        // Save settings
        add_action('woocommerce_update_options_' . self::TAB_ID, [$this, 'saveSettings']);
    }
    

    /**
     * Add WooCommerce settings tab
     * 
     * @param array $tabs
     * @return array
     */
    public function addSettingsTab($tabs)
    {
        if (!is_array($tabs)) {
            $tabs = [];
        }
        
        $tabs[self::TAB_ID] = __('WooAP', 'woo-already-purchased');
        
        return $tabs;
    }

    /**
     * Render settings page
     */
    public function renderSettings()
    {
        // Output settings fields
        woocommerce_admin_fields($this->getSettingsFields());
        
        // Add save button
        ?>
        <p class="submit">
            <button name="save" class="button-primary woocommerce-save-button" type="submit" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
        </p>
        <?php
    }

    /**
     * Save settings
     */
    public function saveSettings()
    {
        woocommerce_update_options($this->getSettingsFields());
    }

    /**
     * Get all settings fields
     * 
     * @return array
     */
    private function getSettingsFields()
    {
        return [
            [
                'title' => __('Purchased Badge Settings', 'woo-already-purchased'),
                'type' => 'title',
                'desc' => __('Configure the "Already Purchased" badge display and behavior.', 'woo-already-purchased'),
                'id' => self::SECTION_ID . '_title'
            ],
            [
                'title' => __('Enable Badge', 'woo-already-purchased'),
                'desc' => __('Enable the purchased badge feature', 'woo-already-purchased'),
                'id' => 'wooap_enable_badge',
                'default' => 'yes',
                'type' => 'checkbox'
            ],
            [
                'title' => __('Badge Text', 'woo-already-purchased'),
                'desc' => __('Text to display on the purchased badge', 'woo-already-purchased'),
                'id' => 'wooap_badge_text',
                'default' => __('Purchased', 'woo-already-purchased'),
                'type' => 'text',
                'css' => 'min-width:300px;'
            ],
            [
                'title' => __('Order Statuses', 'woo-already-purchased'),
                'desc' => __('Select which order statuses count as "purchased". Hold Ctrl/Cmd to select multiple.', 'woo-already-purchased'),
                'id' => 'wooap_order_statuses',
                'default' => ['wc-completed', 'wc-processing'],
                'type' => 'multiselect',
                'class' => 'wc-enhanced-select',
                'css' => 'min-width:300px;',
                'options' => $this->getOrderStatusOptions()
            ],
            [
                'title' => __('Display Settings', 'woo-already-purchased'),
                'type' => 'title',
                'desc' => __('Choose where to display the purchased badge.', 'woo-already-purchased'),
                'id' => self::SECTION_ID . '_display_title'
            ],
            [
                'title' => __('Show on Shop Page', 'woo-already-purchased'),
                'desc' => __('Display badge on shop/archive pages', 'woo-already-purchased'),
                'id' => 'wooap_show_shop',
                'default' => 'yes',
                'type' => 'checkbox'
            ],
            [
                'title' => __('Show on Category Pages', 'woo-already-purchased'),
                'desc' => __('Display badge on product category pages', 'woo-already-purchased'),
                'id' => 'wooap_show_category',
                'default' => 'yes',
                'type' => 'checkbox'
            ],
            [
                'title' => __('Show on Product Page', 'woo-already-purchased'),
                'desc' => __('Display badge on single product pages', 'woo-already-purchased'),
                'id' => 'wooap_show_product',
                'default' => 'yes',
                'type' => 'checkbox'
            ],
            [
                'type' => 'sectionend',
                'id' => self::SECTION_ID . '_end'
            ]
        ];
    }

    /**
     * Get WooCommerce order status options
     * 
     * @return array
     */
    private function getOrderStatusOptions()
    {
        if (!function_exists('wc_get_order_statuses')) {
            return [];
        }

        $statuses = wc_get_order_statuses();
        
        // Return as associative array
        return $statuses;
    }

    /**
     * Get a setting value
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $value = get_option($key, $default);

        // Handle checkbox values (WooCommerce stores 'yes'/'no')
        if ($value === 'yes') {
            return true;
        }
        if ($value === 'no') {
            return false;
        }

        // Handle multiselect (stored as array)
        if (is_array($value)) {
            return $value;
        }

        return $value;
    }

    /**
     * Check if badge is enabled
     * 
     * @return bool
     */
    public static function isBadgeEnabled()
    {
        return self::get('wooap_enable_badge', true);
    }

    /**
     * Get badge text
     * 
     * @return string
     */
    public static function getBadgeText()
    {
        return self::get('wooap_badge_text', __('Purchased', 'woo-already-purchased'));
    }

    /**
     * Get order statuses
     * 
     * @return array
     */
    public static function getOrderStatuses()
    {
        $statuses = get_option('wooap_order_statuses', ['wc-completed', 'wc-processing']);
        
        // WooCommerce multiselect may be stored as serialized string
        if (is_string($statuses)) {
            $statuses = maybe_unserialize($statuses);
        }
        
        // Ensure it's an array
        if (!is_array($statuses)) {
            return ['wc-completed', 'wc-processing'];
        }

        // Filter out empty values
        $statuses = array_filter($statuses);
        
        // If empty, return defaults
        if (empty($statuses)) {
            return ['wc-completed', 'wc-processing'];
        }

        return $statuses;
    }

    /**
     * Check if badge should show on shop page
     * 
     * @return bool
     */
    public static function showOnShop()
    {
        return self::get('wooap_show_shop', true);
    }

    /**
     * Check if badge should show on category pages
     * 
     * @return bool
     */
    public static function showOnCategory()
    {
        return self::get('wooap_show_category', true);
    }

    /**
     * Check if badge should show on product page
     * 
     * @return bool
     */
    public static function showOnProduct()
    {
        return self::get('wooap_show_product', true);
    }
}
