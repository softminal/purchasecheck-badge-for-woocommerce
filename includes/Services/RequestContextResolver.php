<?php

namespace PurchaseCheck\Badge\Includes\Services;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * RequestContextResolver
 * 
 * Detects which products are being rendered on the current page.
 * This helps avoid N+1 queries by collecting all product IDs upfront.
 */
class RequestContextResolver
{
    /**
     * Cache for detected product IDs
     * 
     * @var array|null
     */
    private static $product_ids = null;

    /**
     * Get all product IDs currently being rendered on the page
     * 
     * @return array Array of product IDs
     */
    public static function getProductIds()
    {
        if (self::$product_ids !== null) {
            return self::$product_ids;
        }

        $product_ids = [];

        // Method 1: WooCommerce product query (shop, category, tag pages)
        if (function_exists('wc_get_loop_prop')) {
            global $woocommerce_loop;
            
            // Check if we're in a WooCommerce loop
            if (wc_get_loop_prop('is_shortcode') || wc_get_loop_prop('is_paginated')) {
                // Get products from the current query
                global $wp_query;
                if ($wp_query && $wp_query->posts) {
                    foreach ($wp_query->posts as $post) {
                        if ($post->post_type === 'product') {
                            $product_ids[] = $post->ID;
                        }
                    }
                }
            }
        }

        // Method 2: Single product page
        if (is_product()) {
            global $product;
            if ($product && is_a($product, 'WC_Product')) {
                $product_ids[] = $product->get_id();
                
                // If variable product, also check variations
                if ($product->is_type('variable')) {
                    $variations = $product->get_children();
                    $product_ids = array_merge($product_ids, $variations);
                }
            }
        }

        // Method 3: WooCommerce shortcodes (products, product_category, etc.)
        // This is handled via filter hooks (see hooks integration)

        // Method 4: Check for products in the current WP_Query
        global $wp_query;
        if ($wp_query && isset($wp_query->posts)) {
            foreach ($wp_query->posts as $post) {
                if (isset($post->post_type) && $post->post_type === 'product') {
                    $product_ids[] = $post->ID;
                }
            }
        }

        // Method 5: Check WooCommerce product loop
        if (function_exists('woocommerce_product_loop')) {
            // Products might be rendered via template hooks
            // We'll collect them via filter hooks instead
        }

        // Remove duplicates and filter out invalid IDs
        $product_ids = array_unique(array_filter(array_map('intval', $product_ids)));

        self::$product_ids = $product_ids;

        return $product_ids;
    }

    /**
     * Add product ID to the collection
     * Called via filter hooks when products are rendered
     * 
     * @param int $product_id
     * @return void
     */
    public static function addProductId($product_id)
    {
        if (self::$product_ids === null) {
            self::$product_ids = [];
        }

        $product_id = (int) $product_id;
        if ($product_id > 0 && !in_array($product_id, self::$product_ids)) {
            self::$product_ids[] = $product_id;
        }
    }

    /**
     * Clear the cached product IDs
     * Useful for testing or when context changes
     * 
     * @return void
     */
    public static function clearCache()
    {
        self::$product_ids = null;
    }

    /**
     * Get product IDs from a specific source
     * 
     * @param string $source 'query', 'loop', 'single', 'all'
     * @return array
     */
    public static function getProductIdsFromSource($source = 'all')
    {
        $all_ids = self::getProductIds();
        
        if ($source === 'all') {
            return $all_ids;
        }

        // For now, return all IDs regardless of source
        // This can be extended later if needed
        return $all_ids;
    }
}
