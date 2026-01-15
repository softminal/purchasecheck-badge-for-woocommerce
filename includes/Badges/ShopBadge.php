<?php

namespace WooAlreadyPurchased\Includes\Badges;

use WooAlreadyPurchased\Includes\Settings\ShopPageSettings;
use WooAlreadyPurchased\Includes\Services\PurchaseChecker;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Shop Badge
 * 
 * Handles badge display on shop and category pages.
 */
class ShopBadge extends BaseBadge
{
    /**
     * Track products that already have badges rendered via filter
     * 
     * @var array
     */
    private static $badge_rendered = [];

    /**
     * Initialize badge hooks
     */
    public function init()
    {
        if (!$this->canDisplay()) {
            return;
        }

        // Hook into shop loop to render badge
        add_action(
            'woocommerce_before_shop_loop_item_title',
            [$this, 'renderBadge'],
            25
        );

        // Also filter product image for better overlay positioning
        add_filter(
            'woocommerce_product_get_image',
            [$this, 'wrapProductImageWithBadge'],
            10,
            5
        );
    }

    /**
     * Check if shop badge is enabled
     * 
     * @return bool
     */
    protected function isEnabled()
    {
        return ShopPageSettings::showOnShop() || ShopPageSettings::showOnCategory();
    }

    /**
     * Get badge text
     * 
     * @return string
     */
    protected function getBadgeText()
    {
        return ShopPageSettings::getBadgeText();
    }

    /**
     * Render badge on shop & category pages
     */
    public function renderBadge()
    {
        if (is_shop() && !ShopPageSettings::showOnShop()) {
            return;
        }

        if (is_product_category() && !ShopPageSettings::showOnCategory()) {
            return;
        }

        global $product;

        if (!$product || !is_a($product, 'WC_Product')) {
            return;
        }

        $product_id = $product->get_id();

        // Skip if badge was already rendered via filter
        if (isset(self::$badge_rendered[$product_id])) {
            return;
        }

        if (!$this->hasPurchased($product_id)) {
            return;
        }

        echo esc_html($this->getBadgeHtml());
    }

    /**
     * Wrap product image with badge container for better overlay positioning
     * 
     * @param string $image HTML image tag
     * @param object $product WC_Product object
     * @param string $size Image size
     * @param array $attr Image attributes
     * @param bool $placeholder Whether this is a placeholder
     * @return string Modified image HTML
     */
    public function wrapProductImageWithBadge($image, $product, $size, $attr, $placeholder)
    {
        // Only on shop/category pages
        if (!is_shop() && !is_product_category()) {
            return $image;
        }

        if (is_shop() && !ShopPageSettings::showOnShop()) {
            return $image;
        }

        if (is_product_category() && !ShopPageSettings::showOnCategory()) {
            return $image;
        }

        // Check if user has purchased this product
        $user_id = get_current_user_id();
        if (!$user_id || !$product) {
            return $image;
        }

        $product_id = $product->get_id();
        if (!PurchaseChecker::hasUserPurchasedProduct($user_id, $product_id)) {
            return $image;
        }

        // Mark this product as having badge rendered
        self::$badge_rendered[$product_id] = true;

        // Get badge HTML
        $badge_html = $this->getBadgeHtml();

        // Wrap image in a container with the badge
        return '<div class="apwoo_product-image-wrapper" style="position: relative; display: block;">' . $image . $badge_html . '</div>';
    }

    /**
     * Get badge HTML
     * 
     * @return string
     */
    private function getBadgeHtml()
    {
        $badge_text = $this->getBadgeText();
        $position = ShopPageSettings::getBadgePosition();
        $position_class = 'apwoo_position-' . esc_attr($position);
        
        return sprintf(
            '<span class="apwoo_purchased-badge apwoo_badge-overlay apwoo_shop-badge %s">%s</span>',
            esc_attr($position_class),
            $badge_text
        );
    }
}
