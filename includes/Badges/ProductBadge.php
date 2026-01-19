<?php

namespace PurchaseCheck\Badge\Includes\Badges;

use PurchaseCheck\Badge\Includes\Settings\ProductPageSettings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Product Badge
 * 
 * Handles badge display on single product pages.
 */
class ProductBadge extends BaseBadge
{
    /**
     * Initialize badge hooks
     */
    public function init()
    {
        if (!$this->canDisplay()) {
            return;
        }

        // Hook priority depends on position setting
        $position = ProductPageSettings::getBadgePosition();
        
        if ($position === 'top_title') {
            // Hook before title (title is at priority 5)
            add_action(
                'woocommerce_single_product_summary',
                [$this, 'renderBadge'],
                4
            );
        } elseif ($position === 'bottom_title') {
            // Hook right after title (title is at priority 5)
            add_action(
                'woocommerce_single_product_summary',
                [$this, 'renderBadge'],
                6
            );
        } else {
            // After title (default)
            add_action(
                'woocommerce_single_product_summary',
                [$this, 'renderBadge'],
                6
            );
        }
    }

    /**
     * Check if product badge is enabled
     * 
     * @return bool
     */
    protected function isEnabled()
    {
        return ProductPageSettings::showOnProduct();
    }

    /**
     * Get badge text
     * 
     * @return string
     */
    protected function getBadgeText()
    {
        return ProductPageSettings::getBadgeText();
    }

    /**
     * Render badge on single product page
     */
    public function renderBadge()
    {
        if (!ProductPageSettings::showOnProduct()) {
            return;
        }

        global $product;

        if (!$product || !is_a($product, 'WC_Product')) {
            return;
        }

        if (!$this->hasPurchased($product->get_id())) {
            return;
        }
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $this->getBadgeHtml();
    }

    /**
     * Get badge HTML
     * 
     * @return string
     */
    private function getBadgeHtml()
    {
        $badge_text = $this->getBadgeText();
        $position = ProductPageSettings::getBadgePosition();
        $style = ProductPageSettings::getBadgeStyle();
        $show_icon = ProductPageSettings::showIcon();

        $classes = [
            'pcbw_purchased-badge',
            'pcbw_badge-inline',
            'pcbw_product-badge',
            'pcbw_product-position-' . esc_attr($position),
        ];

        // Add style class
        if ($style !== 'default') {
            $classes[] = 'pcbw_style-' . esc_attr($style);
        }

        // Add icon class if enabled
        if ($show_icon) {
            $classes[] = 'pcbw_has-icon';
        }

        // Build badge content
        $badge_content = '';
        
        if ($show_icon) {
            $badge_content .= $this->getCheckmarkIcon(14, 14);
        }
        
        $badge_content .= esc_html($badge_text);

        return sprintf(
            '<span class="%s">%s</span>',
            esc_attr(implode(' ', $classes)),
            $badge_content
        );
    }
}
