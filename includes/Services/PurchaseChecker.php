<?php

namespace WooAlreadyPurchased\Includes\Services;

use WooAlreadyPurchased\Includes\Settings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * PurchaseChecker
 * 
 * Checks if a user has purchased products using direct SQL queries.
 */
class PurchaseChecker
{
    /**
     * Cache for purchased product IDs per user
     * 
     * @var array
     */
    private static $purchased_cache = [];

    /**
     * Check if user has purchased a specific product
     * 
     * @param int $user_id
     * @param int $product_id
     * @return bool
     */
    public static function hasUserPurchasedProduct($user_id, $product_id)
    {
        if (!$user_id || !$product_id) {
            return false;
        }
        $purchased_ids = self::getPurchasedProductIds($user_id);
        return in_array($product_id, $purchased_ids);
    }

    /**
     * Get all product IDs that a user has purchased
     * Uses bulk query to avoid N+1 problem
     * 
     * @param int $user_id
     * @return array Array of product IDs
     */
    public static function getPurchasedProductIds($user_id)
    {
        if (!$user_id) {
            return [];
        }

        // Check cache first
        if (isset(self::$purchased_cache[$user_id])) {
            return self::$purchased_cache[$user_id];
        }

        $statuses = Settings::getOrderStatuses();
        $statuses = array_map(function ($status) {
            return str_replace('wc-', '', $status);
        }, $statuses);

        // Ensure we have at least one status
        if (empty($statuses)) {
            $statuses = ['wc-completed', 'wc-processing'];
        }

        $orders = wc_get_orders([
            'customer_id' => $user_id,
            'limit' => -1,
            'status' => $statuses,
            'orderby' => 'date',
            'order' => 'DESC'
        ]);

        $product_ids = [];

        foreach ($orders as $order) {
            foreach ($order->get_items() as $item) {
                $product_ids[] = $item->get_product_id();
            }
        }
        
        $product_ids = array_unique($product_ids);

        // the parent product should also be marked as purchased
        $parent_ids = [];
        foreach ($product_ids as $product_id) {
            $product = wc_get_product($product_id);
            if ($product && $product->is_type('variation')) {
                $parent_id = $product->get_parent_id();
                if ($parent_id) {
                    $parent_ids[] = $parent_id;
                }
            }
        }

        // Merge parent IDs with purchased IDs
        $product_ids = array_merge($product_ids, $parent_ids);
        $product_ids = array_unique($product_ids);

        // Cache the results
        self::$purchased_cache[$user_id] = $product_ids;

        return $product_ids;
    }

    /**
     * Check multiple products at once (bulk check)
     * 
     * @param int $user_id
     * @param array $product_ids
     * @return array Associative array: product_id => bool
     */
    public static function checkMultipleProducts($user_id, $product_ids)
    {
        if (!$user_id || empty($product_ids)) {
            return [];
        }

        $purchased_ids = self::getPurchasedProductIds($user_id);
        $result = [];

        foreach ($product_ids as $product_id) {
            $result[$product_id] = in_array($product_id, $purchased_ids);
        }

        return $result;
    }

    /**
     * Clear cache for a user (useful when new orders are placed)
     * 
     * @param int $user_id
     */
    public static function clearCache($user_id = null)
    {
        if ($user_id) {
            unset(self::$purchased_cache[$user_id]);
        } else {
            self::$purchased_cache = [];
        }
    }
}
