=== PurchaseCheck Badge for WooCommerce ===
Contributors: softminal, diptosoftminal
Tags: woocommerce, purchased, badge, customer, orders
Requires at least: 5.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Display a "Purchased" badge on WooCommerce products customers have already bought to prevent duplicate orders.

== Description ==

PurchaseCheck Badge for WooCommerce is a lightweight WordPress plugin that enhances your WooCommerce store by displaying a customizable badge on products that logged-in customers have already purchased. This helps customers quickly identify products they own, reducing duplicate purchases and improving user experience.

= Key Features =

* **Smart Purchase Detection**: Automatically detects if a customer has purchased a product based on configurable order statuses
* **Flexible Display Options**: Show badges on shop pages, category pages, and single product pages
* **Customizable Badge Text**: Change the badge text to match your brand
* **Order Status Control**: Choose which order statuses count as "purchased" (completed, processing, etc.)
* **Performance Optimized**: Uses efficient caching to minimize database queries
* **Variation Support**: Handles product variations correctly, marking parent products as purchased when any variation is bought
* **WooCommerce Integration**: Seamlessly integrates with WooCommerce settings panel

= How It Works =

The plugin checks a logged-in customer's order history and displays a badge on products they've previously purchased. The badge appears:

* On shop/archive pages as an overlay on product images
* On category pages as an overlay on product images
* On single product pages inline with the product title

= Settings =

Configure the plugin through **WooCommerce → Settings → Purchased Badge**:

* Enable/disable the badge feature
* Customize badge text
* Select which order statuses count as purchased
* Control where badges are displayed (shop, category, product pages)

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin panel
2. Navigate to **Plugins → Add New**
3. Search for "PurchaseCheck Badge for WooCommerce"
4. Click **Install Now** and then **Activate**

= Manual Installation =

1. Download the plugin zip file
2. Log in to your WordPress admin panel
3. Navigate to **Plugins → Add New**
4. Click **Upload Plugin**
5. Choose the zip file and click **Install Now**
6. Click **Activate Plugin**

== Configuration ==

After activation, configure the plugin:

1. Go to **WooCommerce → Settings → Purchased Badge**
2. Configure the following options:

**Purchased Badge Settings:**

* **Enable Badge**: Toggle the badge feature on/off
* **Badge Text**: Customize the text displayed on the badge (default: "Purchased")
* **Order Statuses**: Select which order statuses count as purchased (default: Completed, Processing)

**Display Settings:**

* **Show on Shop Page**: Display badges on shop/archive pages
* **Show on Category Pages**: Display badges on product category pages
* **Show on Product Page**: Display badges on single product pages

3. Click **Save changes**

== Frequently Asked Questions ==

= Does this plugin work with product variations? =

Yes! If a customer purchases any variation of a variable product, both the variation and the parent product will be marked as purchased.

= Which order statuses should I select? =

Typically, you'll want to select "Completed" and "Processing" statuses. However, you can customize this based on your business needs. For example, if you want to show badges only for fully completed orders, select only "Completed".

= Will the badge show for guest users? =

No, the badge only displays for logged-in users. This is because the plugin needs to check the user's order history, which requires authentication.

= Does this affect site performance? =

The plugin is optimized for performance using caching. Purchase data is cached per user and automatically cleared when new orders are placed. The plugin uses efficient WooCommerce APIs to minimize database queries.

= What happens when an order status changes? =

The plugin automatically clears the cache when order statuses change, ensuring badges are always up-to-date.

== Requirements ==

* WordPress 5.0 or higher
* WooCommerce 3.0 or higher
* PHP 7.4 or higher


== Changelog ==

= 1.0.0 =
* Initial release
* Badge display on shop, category, and product pages
* Configurable badge text and order statuses
* Display location controls
* Performance optimization with caching
* Support for product variations

== Upgrade Notice ==

= 1.0.0 =
Initial release.

== Credits ==

Developed by [Softminal](https://github.com/softminal)

= Links =

* [GitHub Repository](https://github.com/softminal/purchasecheck-badge-for-woocommerce)
* [Report Issues](https://github.com/softminal/purchasecheck-badge-for-woocommerce/issues)

== License ==

This plugin is licensed under the GPL-2.0+ license.
