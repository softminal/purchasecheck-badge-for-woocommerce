<?php

namespace WooAlreadyPurchased\Includes;

if (!defined('ABSPATH')) {
    exit;
}

use WooAlreadyPurchased\Includes\Enqueue;
use WooAlreadyPurchased\Includes\Menu;
use WooAlreadyPurchased\Includes\Hooks;
use WooAlreadyPurchased\Includes\Settings;
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
    private Hooks $hooks;
    private Settings $settings;

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
            error_log('Woo Already Purchased Plugin Error: ' . $e->getMessage());
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
            'includes/Services/PurchaseChecker.php',
            'includes/Enqueue.php',
            'includes/Menu.php',
            'includes/Hooks.php',
            'includes/Settings.php',
        ];

        foreach ($requiredFiles as $file) {
            $filePath = WOO_ALREADY_PURCHASED_DIR . $file;
            if (!file_exists($filePath)) {
                throw new Exception("Required file not found: {$file}");
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
        $this->hooks = new Hooks();
        $this->settings = new Settings();
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
            $this->enqueue->init();
            $this->menu->init();
            $this->hooks->init();
            $this->settings->init();
        } catch (Exception $e) {
            error_log('Woo Already Purchased Plugin Error: ' . $e->getMessage());
            throw $e;
        }
    }
}