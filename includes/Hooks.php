<?php

namespace WooAlreadyPurchased\Includes;

use WooAlreadyPurchased\Includes\Services\PurchaseChecker;
use WooAlreadyPurchased\Includes\Settings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hooks
 * 
 * Handles WooCommerce hooks for badge display on shop, category, and product pages.
 */
class Hooks
{
    /**
     * Initialize hooks
     */
    public function init()
    {
        // Only run on frontend
        if (is_admin()) {
            return;
        }

        // Check if badge is enabled
        if (!Settings::isBadgeEnabled()) {
            return;
        }

        // Only for logged-in users
        if (!is_user_logged_in()) {
            return;
        }

        // Check if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            return;
        }

        // Badge placement hooks
        $this->registerBadgePlacementHooks();
        
        // Clear cache when orders are updated
        $this->registerCacheClearingHooks();
    }
    
    /**
     * Register hooks to clear purchase cache when orders are updated
     */
    private function registerCacheClearingHooks()
    {
        // Clear cache when order status changes
        add_action('woocommerce_order_status_changed', function($order_id, $old_status, $new_status) {
            $order = wc_get_order($order_id);
            if ($order) {
                $customer_id = $order->get_customer_id();
                if ($customer_id) {
                    PurchaseChecker::clearCache($customer_id);
                }
            }
        }, 10, 3);
        
        // Clear cache when order is created
        add_action('woocommerce_new_order', function($order_id) {
            $order = wc_get_order($order_id);
            if ($order) {
                $customer_id = $order->get_customer_id();
                if ($customer_id) {
                    PurchaseChecker::clearCache($customer_id);
                }
            }
        }, 10, 1);
    }

    /**
     * Register hooks for badge placement
     */
    private function registerBadgePlacementHooks()
    {
        // Shop/Category pages - overlay badge on product image
        // Using woocommerce_before_shop_loop_item_title with high priority to ensure product is available
        add_action('woocommerce_before_shop_loop_item_title', function() {
            // Check if should show on shop/category
            if (is_shop() && !Settings::showOnShop()) {
                return;
            }
            if (is_product_category() && !Settings::showOnCategory()) {
                return;
            }
            
            global $product;
            if ($product && is_a($product, 'WC_Product')) {
                $this->renderBadge($product->get_id(), 'overlay');
            }
        }, 25);
        

        // Single product page - after title
        add_action('woocommerce_single_product_summary', function() {
            // Check if should show on product page
            if (!Settings::showOnProduct()) {
                return;
            }
            
            global $product;
            if ($product && is_a($product, 'WC_Product')) {
                $this->renderBadge($product->get_id(), 'inline');
            }
        }, 6);
    }

    /**
     * Render the purchased badge
     * 
     * @param int $product_id
     * @param string $position 'overlay' for shop/category, 'inline' for product page
     */
    private function renderBadge($product_id, $position = 'overlay')
    {
        $user_id = get_current_user_id();
        
        if (!$user_id || !$product_id) {
            return;
        }

        // Check if user has purchased this product
        $has_purchased = PurchaseChecker::hasUserPurchasedProduct($user_id, $product_id);
        
        if (!$has_purchased) {
            return;
        }

        $badge_text = Settings::getBadgeText();
        $css_class = 'wooap-purchased-badge';
        
        if ($position === 'overlay') {
            $css_class .= ' wooap-badge-overlay';
        } else {
            $css_class .= ' wooap-badge-inline';
        }

        printf(
            '<span class="%s">%s</span>',
            esc_attr($css_class),
            esc_html($badge_text)
        );
    }
}
