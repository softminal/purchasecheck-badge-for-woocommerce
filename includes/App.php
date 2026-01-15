<?php

namespace WooAlreadyPurchased\Includes;

if (!defined('ABSPATH')) {
    exit;
}

use WooAlreadyPurchased\Includes\Enqueue;
use WooAlreadyPurchased\Includes\Menu;
use WooAlreadyPurchased\Includes\Settings\SettingsManager;
use WooAlreadyPurchased\Includes\Badges\ShopBadge;
use WooAlreadyPurchased\Includes\Badges\ProductBadge;
use WooAlreadyPurchased\Includes\Badges\CartBadge;
use Exception;

/**
 * Class App
 * @package WooAlreadyPurchased\Includes
 *
 * This class is responsible for loading all the necessary components of the plugin.
 */
class App
{
    private static ?self $instance = null;
    private Enqueue $enqueue;
    private Menu $menu;
    private SettingsManager $settings;
    private ShopBadge $shop_badge;
    private ProductBadge $product_badge;
    private CartBadge $cart_badge;

    /**
     * Get the singleton instance
     */
    static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Private constructor to prevent direct instantiation
     */
    function __construct()
    {
        try {
            $this->loadDependencies();
            $this->initializeClasses();
        } catch (Exception $e) {
            // Log the error and handle it appropriately
            throw $e;
        }
    }

    /**
     * Load all required dependencies
     * @throws Exception
     */
    function loadDependencies(): void
    {
        $requiredFiles = [
            // Services
            'includes/Services/PurchaseChecker.php',
            
            // Core
            'includes/Enqueue.php',
            'includes/Menu.php',
            
            // Settings
            'includes/Settings/SettingsManager.php',
            'includes/Settings/GeneralSettings.php',
            'includes/Settings/ShopPageSettings.php',
            'includes/Settings/ProductPageSettings.php',
            'includes/Settings/CartSettings.php',
            
            // Badges
            'includes/Badges/BaseBadge.php',
            'includes/Badges/ShopBadge.php',
            'includes/Badges/ProductBadge.php',
            'includes/Badges/CartBadge.php',
        ];

        foreach ($requiredFiles as $file) {
            $filePath = WOO_ALREADY_PURCHASED_DIR . $file;
            if (!file_exists($filePath)) {
                throw new Exception( esc_html( "Required file not found: {$file}" ) );
            }
            require_once $filePath;
        }
    }

    /**
     * Initialize all required classes
     */
    function initializeClasses(): void
    {
        $this->enqueue = new Enqueue();
        $this->menu = new Menu();
        $this->settings = new SettingsManager();
        $this->shop_badge = new ShopBadge();
        $this->product_badge = new ProductBadge();
        $this->cart_badge = new CartBadge();
    }

    /**
     * Run the application
     * @throws Exception
     */
    function run(): void
    {
        // Double-check WooCommerce is active before running
        if (!class_exists('WooCommerce')) {
            return;
        }

        try {
            // Core initialization
            $this->enqueue->init();
            $this->menu->init();
            $this->settings->init();
            
            // Badge initialization (frontend only)
            if (!is_admin()) {
                $this->shop_badge->init();
                $this->product_badge->init();
                $this->cart_badge->init();
            }
            
            // Register cache clearing hooks
            $this->registerCacheClearingHooks();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Register cache clearing hooks
     */
    private function registerCacheClearingHooks(): void
    {
        add_action('woocommerce_order_status_changed', [$this, 'clearUserPurchaseCache'], 10, 3);
        add_action('woocommerce_new_order', [$this, 'clearUserPurchaseCache'], 10);
    }

    /**
     * Clear user purchase cache when order status changes
     * 
     * @param int $order_id
     */
    public function clearUserPurchaseCache($order_id): void
    {
        $order = wc_get_order($order_id);
        if (!$order) {
            return;
        }

        $customer_id = $order->get_customer_id();
        if ($customer_id) {
            Services\PurchaseChecker::clearCache($customer_id);
        }
    }
}
