<?php

namespace PurchaseCheck\Badge\Includes\Settings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Settings Manager
 * 
 * Main settings handler that coordinates all setting tabs.
 * Adds settings under WooCommerce → Settings → Purchased Badge
 */
class SettingsManager
{
    /**
     * Tab ID
     */
    const TAB_ID = 'pcbw_settings';

    /**
     * Settings instances
     */
    private $general_settings;
    private $shop_settings;
    private $product_settings;
    private $cart_settings;

    /**
     * Initialize settings
     */
    public function init()
    {
        // Only run if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            return;
        }

        // Initialize settings classes
        $this->general_settings = new GeneralSettings();
        $this->shop_settings = new ShopPageSettings();
        $this->product_settings = new ProductPageSettings();
        $this->cart_settings = new CartSettings();

        // Add settings tab
        add_filter('woocommerce_settings_tabs_array', [$this, 'addSettingsTab'], 50);

        // Add settings sections (subtabs)
        add_action('woocommerce_sections_' . self::TAB_ID, [$this, 'outputSections']);

        // Add settings fields
        add_action('woocommerce_settings_' . self::TAB_ID, [$this, 'renderSettings']);

        // Save settings
        add_action('woocommerce_update_options_' . self::TAB_ID, [$this, 'saveSettings']);
    }

    /**
     * Get settings sections (subtabs)
     * 
     * @return array
     */
    public function getSections()
    {
        return [
            '' => __('General', 'purchasecheck-badge-for-woocommerce'),
            'shop_page' => __('Shop Page', 'purchasecheck-badge-for-woocommerce'),
            'product_page' => __('Product Page', 'purchasecheck-badge-for-woocommerce'),
            'cart' => __('Cart', 'purchasecheck-badge-for-woocommerce'),
        ];
    }

    /**
     * Output sections navigation
     */
    public function outputSections()
    {
        global $current_section;

        $sections = $this->getSections();

        if (empty($sections) || count($sections) <= 1) {
            return;
        }

        echo '<ul class="subsubsub">';

        $section_keys = array_keys($sections);

        foreach ($sections as $id => $label) {
            $url = admin_url('admin.php?page=wc-settings&tab=' . self::TAB_ID . '&section=' . $id);
            $current_class = ($current_section === $id) ? 'current' : '';
            $separator = (end($section_keys) === $id) ? '' : ' | ';

            echo '<li><a href="' . esc_url($url) . '" class="' . esc_attr($current_class) . '">' . esc_html($label) . '</a>' . esc_html($separator) . '</li>';
        }

        echo '</ul><br class="clear" />';
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
        
        $tabs[self::TAB_ID] = __('Purchased Badge', 'purchasecheck-badge-for-woocommerce');
        
        return $tabs;
    }

    /**
     * Render settings page
     */
    public function renderSettings()
    {
        global $current_section;

        $settings = $this->getSettingsForSection($current_section);
        woocommerce_admin_fields($settings);
    }

    /**
     * Save settings
     */
    public function saveSettings()
    {
        global $current_section;

        $settings = $this->getSettingsForSection($current_section);
        woocommerce_update_options($settings);
    }

    /**
     * Get settings fields for a specific section
     * 
     * @param string $section
     * @return array
     */
    private function getSettingsForSection($section)
    {
        switch ($section) {
            case 'shop_page':
                return $this->shop_settings->getFields();
            case 'product_page':
                return $this->product_settings->getFields();
            case 'cart':
                return $this->cart_settings->getFields();
            default:
                return $this->general_settings->getFields();
        }
    }

    /**
     * Get a setting value (static helper)
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
}
