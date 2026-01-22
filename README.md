# Woo Already Purchased

Display a "Purchased" badge on products that customers have already bought, helping them identify items they own and improving their shopping experience.

## Description

Woo Already Purchased is a lightweight WordPress plugin that enhances your WooCommerce store by displaying a customizable badge on products that logged-in customers have already purchased. This helps customers quickly identify products they own, reducing duplicate purchases and improving user experience.

### Key Features

* **Smart Purchase Detection**: Automatically detects if a customer has purchased a product based on configurable order statuses
* **Flexible Display Options**: Show badges on shop pages, category pages, and single product pages
* **Customizable Badge Text**: Change the badge text to match your brand
* **Order Status Control**: Choose which order statuses count as "purchased" (completed, processing, etc.)
* **Performance Optimized**: Uses efficient caching to minimize database queries
* **Variation Support**: Handles product variations correctly, marking parent products as purchased when any variation is bought
* **WooCommerce Integration**: Seamlessly integrates with WooCommerce settings panel

### How It Works

The plugin checks a logged-in customer's order history and displays a badge on products they've previously purchased. The badge appears:
- On shop/archive pages as an overlay on product images
- On category pages as an overlay on product images
- On single product pages inline with the product title

### Settings

Configure the plugin through **WooCommerce → Settings → WooAP**:
- Enable/disable the badge feature
- Customize badge text
- Select which order statuses count as purchased
- Control where badges are displayed (shop, category, product pages)

## Installation

### Automatic Installation

1. Log in to your WordPress admin panel
2. Navigate to **Plugins → Add New**
3. Search for "Woo Already Purchased"
4. Click **Install Now** and then **Activate**

### Manual Installation

1. Download the plugin zip file
2. Log in to your WordPress admin panel
3. Navigate to **Plugins → Add New**
4. Click **Upload Plugin**
5. Choose the zip file and click **Install Now**
6. Click **Activate Plugin**

### Via FTP

1. Extract the plugin zip file
2. Upload the `woo-already-purchased` folder to `/wp-content/plugins/`
3. Log in to your WordPress admin panel
4. Navigate to **Plugins** and activate **Woo Already Purchased**

## Configuration

After activation, configure the plugin:

1. Go to **WooCommerce → Settings → WooAP**
2. Configure the following options:

   **Purchased Badge Settings:**
   - **Enable Badge**: Toggle the badge feature on/off
   - **Badge Text**: Customize the text displayed on the badge (default: "Purchased")
   - **Order Statuses**: Select which order statuses count as purchased (default: Completed, Processing)

   **Display Settings:**
   - **Show on Shop Page**: Display badges on shop/archive pages
   - **Show on Category Pages**: Display badges on product category pages
   - **Show on Product Page**: Display badges on single product pages

3. Click **Save changes**

## Frequently Asked Questions

### Does this plugin work with product variations?

Yes! If a customer purchases any variation of a variable product, both the variation and the parent product will be marked as purchased.

### Which order statuses should I select?

Typically, you'll want to select "Completed" and "Processing" statuses. However, you can customize this based on your business needs. For example, if you want to show badges only for fully completed orders, select only "Completed".

### Will the badge show for guest users?

No, the badge only displays for logged-in users. This is because the plugin needs to check the user's order history, which requires authentication.

### Does this affect site performance?

The plugin is optimized for performance using caching. Purchase data is cached per user and automatically cleared when new orders are placed. The plugin uses efficient WooCommerce APIs to minimize database queries.

### Can I customize the badge appearance?

Yes! The badge uses CSS classes that you can style:
- `.wooap-purchased-badge` - Base badge class
- `.wooap-badge-overlay` - Badge on shop/category pages
- `.wooap-badge-inline` - Badge on product pages

Add custom CSS to your theme's stylesheet or through **Appearance → Customize → Additional CSS**.

### What happens when an order status changes?

The plugin automatically clears the cache when order statuses change, ensuring badges are always up-to-date.

## Customization

### Styling the Badge

You can customize the badge appearance by adding CSS to your theme. Here's an example:

```css
.wooap-purchased-badge {
    background-color: #28a745;
    color: #ffffff;
    padding: 5px 10px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: bold;
}

.wooap-badge-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
}
```

### Using Filters

The plugin provides hooks for developers to extend functionality. Check the code for available filters and actions.

## Requirements

* WordPress 5.0 or higher
* WooCommerce 3.0 or higher
* PHP 7.4 or higher

## Screenshots

1. Badge displayed on shop page
2. Badge displayed on product page
3. Plugin settings page

## Changelog

### 1.0.0
* Initial release
* Badge display on shop, category, and product pages
* Configurable badge text and order statuses
* Display location controls
* Performance optimization with caching
* Support for product variations

## Support

For support, feature requests, or bug reports, please visit:
- **Plugin URI**: https://wooalreadypurchased.com/
- **Author URI**: https://softminal.com/

## Credits

Developed by [Softminal LLC](https://softminal.com/)

## License

This plugin is licensed under the GPL-2.0+ license.

---

**Note**: This plugin requires WooCommerce to be installed and activated. The badge feature only works for logged-in users.
