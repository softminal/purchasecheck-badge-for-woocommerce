<?php

namespace WooAlreadyPurchased\Includes\Badges;

use WooAlreadyPurchased\Includes\Services\PurchaseChecker;
use WooAlreadyPurchased\Includes\Settings\GeneralSettings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Base Badge
 * 
 * Abstract base class for badge handlers.
 */
abstract class BaseBadge
{
    /**
     * Initialize badge hooks
     */
    abstract public function init();

    /**
     * Check if this badge type is enabled
     * 
     * @return bool
     */
    abstract protected function isEnabled();

    /**
     * Get badge text
     * 
     * @return string
     */
    abstract protected function getBadgeText();

    /**
     * Check if user has purchased a product
     * 
     * @param int $product_id
     * @return bool
     */
    protected function hasPurchased($product_id)
    {
        $user_id = get_current_user_id();
        
        if (!$user_id || !$product_id) {
            return false;
        }

        return PurchaseChecker::hasUserPurchasedProduct($user_id, $product_id);
    }

    /**
     * Check if badge feature is globally enabled
     * 
     * @return bool
     */
    protected function isGloballyEnabled()
    {
        return GeneralSettings::isBadgeEnabled();
    }

    /**
     * Check common prerequisites for badge display
     * 
     * @return bool
     */
    protected function canDisplay()
    {
        // Must be globally enabled
        if (!$this->isGloballyEnabled()) {
            return false;
        }

        // Must be enabled for this specific badge type
        if (!$this->isEnabled()) {
            return false;
        }

        // User must be logged in
        if (!is_user_logged_in()) {
            return false;
        }

        return true;
    }

    /**
     * Generate checkmark icon SVG
     * 
     * @param int $width
     * @param int $height
     * @return string
     */
    protected function getCheckmarkIcon($width = 14, $height = 14)
    {
        return sprintf(
            '<svg class="apwoo_icon" width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>',
            absint($width),
            absint($height)
        );
    }
}
