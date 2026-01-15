<?php

namespace WooAlreadyPurchased\Includes\Settings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * General Settings
 * 
 * Handles general/global settings for the Already Purchased for WooCommerce plugin.
 */
class GeneralSettings
{
    /**
     * Section prefix
     */
    const PREFIX = 'apwoo_general_';

    /**
     * Get settings fields
     * 
     * @return array
     */
    public function getFields()
    {
        return [
            [
                'title' => __('General Settings', 'already-purchased-for-woo'),
                'type' => 'title',
                'desc' => __('Configure the basic settings for the "Already Purchased" badge feature.', 'already-purchased-for-woo'),
                'id' => self::PREFIX . 'title'
            ],
            [
                'title' => __('Enable Badge', 'already-purchased-for-woo'),
                'desc' => __('Enable the purchased badge feature globally', 'already-purchased-for-woo'),
                'id' => 'apwoo_enable_badge',
                'default' => 'yes',
                'type' => 'checkbox'
            ],
            [
                'title' => __('Order Statuses', 'already-purchased-for-woo'),
                'desc' => __('Select which order statuses count as "purchased". Hold Ctrl/Cmd to select multiple.', 'already-purchased-for-woo'),
                'id' => 'apwoo_order_statuses',
                'default' => ['wc-completed', 'wc-processing'],
                'type' => 'multiselect',
                'class' => 'wc-enhanced-select',
                'css' => 'min-width:300px;',
                'options' => $this->getOrderStatusOptions()
            ],
            [
                'type' => 'sectionend',
                'id' => self::PREFIX . 'end'
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

        return wc_get_order_statuses();
    }

    // =========================================================================
    // STATIC GETTERS
    // =========================================================================

    /**
     * Check if badge is enabled
     * 
     * @return bool
     */
    public static function isBadgeEnabled()
    {
        return SettingsManager::get('apwoo_enable_badge', true);
    }

    /**
     * Get order statuses
     * 
     * @return array
     */
    public static function getOrderStatuses()
    {
        $statuses = get_option('apwoo_order_statuses', ['wc-completed', 'wc-processing']);
        
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
}
