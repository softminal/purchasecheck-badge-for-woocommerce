<?php

namespace WooAlreadyPurchased\Includes\Badges;

use WooAlreadyPurchased\Includes\Settings\CartSettings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Cart Badge
 * 
 * Handles badge display on cart page.
 */
class CartBadge extends BaseBadge
{
    /**
     * Initialize badge hooks
     */
    public function init()
    {
        if (!$this->canDisplay()) {
            return;
        }

        // Filter cart item name to add badge
        add_filter(
            'woocommerce_cart_item_name',
            [$this, 'addBadgeToCartItem'],
            10,
            3
        );
    }

    /**
     * Check if cart badge is enabled
     * 
     * @return bool
     */
    protected function isEnabled()
    {
        return CartSettings::showOnCart();
    }

    /**
     * Get badge text
     * 
     * @return string
     */
    protected function getBadgeText()
    {
        return CartSettings::getBadgeText();
    }

    /**
     * Add badge to cart item name
     * 
     * @param string $product_name Product name HTML
     * @param array $cart_item Cart item data
     * @param string $cart_item_key Cart item key
     * @return string Modified product name with badge
     */
    public function addBadgeToCartItem($product_name, $cart_item, $cart_item_key)
    {
        // Only show on cart page (not mini-cart, checkout, etc.)
        if (!is_cart()) {
            return $product_name;
        }

        $user_id = get_current_user_id();
        if (!$user_id) {
            return $product_name;
        }

        $product_id = $cart_item['product_id'];

        // Check if user has previously purchased this product
        if (!$this->hasPurchased($product_id)) {
            return $product_name;
        }

        // Build badge HTML
        $badge_html = $this->getBadgeHtml();

        // Get position setting
        $position = CartSettings::getBadgePosition();

        if ($position === 'below_name') {
            return $product_name . '<br>' . $badge_html;
        }

        // Default: after_name (inline)
        return $product_name . ' ' . $badge_html;
    }

    /**
     * Get badge HTML
     * 
     * @return string
     */
    private function getBadgeHtml()
    {
        $badge_text = $this->getBadgeText();
        $show_icon = CartSettings::showIcon();

        $classes = [
            'apwoo_purchased-badge',
            'apwoo_badge-inline',
            'apwoo_cart-badge',
        ];

        if ($show_icon) {
            $classes[] = 'apwoo_has-icon';
        }

        // Build badge content
        $badge_content = '';
        
        if ($show_icon) {
            $badge_content .= $this->getCheckmarkIcon(12, 12);
        }
        
        $badge_content .= esc_html($badge_text);

        return sprintf(
            '<span class="%s">%s</span>',
            esc_attr(implode(' ', $classes)),
            $badge_content
        );
    }
}
