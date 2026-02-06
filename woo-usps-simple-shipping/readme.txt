=== USPS Simple Shipping for Woocommerce ===
License: GPLv2 or later
Contributors: dangoodman
Tags: USPS, USPS live rates, USPS WooCommerce, USPS shipping
Requires PHP: 7.2
Requires at least: 4.6
Tested up to: 6.9
WC requires at least: 5.0
WC tested up to: 10.4
Stable tag: 1.16.0


USPS Simple calculates rates for domestic shipping dynamically using API.


== Description ==

**USPS Simple** is a free shipping plugin for WooCommerce that provides accurate, real-time USPS domestic rates to your customers. These rates are calculated based on the customer's shipping address and the size and weight of the items in their cart.

By default, the plugin calculates the shipping price for each item individually, simulating separate shipments for each one. The total price shown to the customer is the sum of these individual item prices.

For regular-sized items, there is an option to group them based on their weight. When this feature is enabled, the dimensions of the grouped items are disregarded in the rate calculation. This helps reduce the shipping cost for orders with many small items in the cart.

Fully functional right after installation.

<br> <br>
= Supported services =

**Priority Mail**
— Regular non-flat rate — based on weight, size, and zone
— Small Flat Rate Box
— Medium Flat Rate Box — 1 (top-loading)
— Medium Flat Rate Box — 2 (side-loading)
— Large Flat Rate Box
<br>

**First-Class Mail**
— Postcard
— Letter
— Large Envelope
<br>

**USPS Ground Advantage**
<br>

**Media Mail**
**Library Mail**


== Installation ==

1. Upload the plugin folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to WooCommerce > Settings > Shipping > USPS Simple to configure the plugin.


== Screenshots ==

1. Configuration


== Changelog ==

= 1.16.0 =
* Support regular Priority Mail based on weight, size, and zone.
* Turn on all services by default for new installations.

= 1.15.0 =
* Support Priority Mail flat rate boxes.
* Don't show the retirement notice to new users.

= 1.14.0 =
* Remove unsupported options: commercial rates, Priority Mail, Priority Mail Express, Retail Ground.
* Stop displaying the retirement notice every 24 hours.

= 1.13.2 =
* Don't try updating the retirement notice when regular users are viewing the site.

= 1.13.1 =
* Fix: apply the new API based on the Commercial Rates option instead of Packing.

= 1.13.0 =
* Switch retail Ground Advantage, First-Class Mail, Media Mail, and Library Mail to the new API.
* Add the notice regarding WebTools API retirement, commercial rates, Priority Mail, and Retail Ground.
* Tested with WordPress 6.9, WooCommerce 10.4.

= 1.12.0 =
* Save shipped items in order shipping details.
* Tested with WooCommerce 10.3.

= 1.11.3 =
* Tested with WooCommerce 10.2.

= 1.11.2 =
* Tested with WooCommerce 10.1.

= 1.11.1 =
* Tested with WooCommerce 9.9.

= 1.11.0 =
* Prevent PHP 8.4 warnings.
* Tested with WordPress 6.8, WooCommerce 9.8.

= 1.10.11 =
* Tested with WooCommerce 9.6.

= 1.10.10 =
* Tested with WooCommerce 9.5.

= 1.10.9 =
* Tested with WordPress 6.7, WooCommerce 9.4.

= 1.10.8 =
* Tested with WooCommerce 9.3.

= 1.10.7 =
* Tested with WooCommerce 9.2.

= 1.10.6 =
* Trim the debug details on copy to make wp.org recognize it as a code fragment.

= 1.10.5 =
* Tested with WordPress 6.6, WooCommerce 9.1.

= 1.10.4 =
* Tested with WooCommerce 8.9, 9.0.

= 1.10.3 =
* Tested with WordPress 6.5, WooCommerce 8.8.

= 1.10.2 =
* Tested with WooCommerce 8.7.

= 1.10.1 =
* Tested with WooCommerce 8.4.

= 1.10.0 =
* Skip calculations if no zip code provided.
* Fix debug mode error on missing product dimensions.

= 1.9.4 =
* Tested with WordPress 6.4, WooCommerce 8.3.
* Raise the min-required WooCommerce version to 5.0.

= 1.9.3 =
* Tested with WooCommerce 8.1.

= 1.9.2 =
* Tested with WordPress 6.3, WooCommerce 8.0.

= 1.9.1 =
* Fixed the default titles of the First-Class Mail Postcard services.
* Tested with WooCommerce 7.9.

= 1.9.0 =
* Replace First-Class Mail Parcel and Package with the new USPS Ground Advantage service (enabled by default).
* Tested with WooCommerce 7.8.

= 1.8.3 =
* Declare HPOS compatibility.
* Tested with WordPress 6.2, WooCommerce 7.7.

= 1.8.2 =
* Media Mail & Library Mail: always show the lowest of the rates to work around the USPS API inconsistency.

= 1.8.1 =
* Enable the plugin for Guam.

= 1.8.0 =
* Fix the Media Mail and Library Mail options not showing up since 22-Jan-2023 due to the USPS API updates.
* Tested with WooCommerce 7.3.

= 1.7.4 =
* Avoid 'Non-numeric value encountered' PHP warnings on missing product dimensions.
* Tested with WooCommerce 7.1.
* Raise the minimum required versions of WordPress and WooCommerce to 4.6 and 3.2 respectively.

= 1.7.3 =
* Tested with WooCommerce 7.0, WordPress 6.1.

= 1.7.2 =
* Tested with WooCommerce 6.9.

= 1.7.1 =
* Fix an error when item quantity is fractional.

= 1.7.0 =
* Workaround a USPS API error for items less than 0.25 inch.
* Check shipped items dimensions against the First-Class Mail size constraints (if 'Quote regular items by weight' is disabled).
* Avoid an additional call to the USPS API if Retail Ground is disabled.
* Fill the shipping origin zip code from Store Address by default.
* Enable the plugin upon installation.
* Remove the '(USPS Simple)' delivery option label suffix.
* Require PHP 7.2+.
* Tested with WooCommerce 6.7.

= 1.6.2 =
* Tested with WooCommerce 6.5, WordPress 6.0.

= 1.6.1 =
* Tested with WooCommerce 6.3.

= 1.6.0 =
* Add the 'First-Class Package Service – Retail' service.
* Small backend cosmetic changes.

= 1.5.7 =
* Avoid 'Non-numeric value encountered' PHP warnings on missing product dimensions or weight.
* Tested with WordPress 5.9, WooCommerce 6.1.

= 1.5.6 =
* Replace the default USPS API user id to fix the authorization issue.
* Tested with WooCommerce 5.6.
* Fix the debug info drawer won't expand after cart update.

= 1.5.5 =
* Tested with WooCommerce 5.6.

= 1.5.4 =
* Tested with WordPress 5.8, WooCommerce 5.5.

= 1.5.3 =
* Tested with WooCommerce 5.3.

= 1.5.2 =
* Tested with WooCommerce 5.1, WordPress 5.7.

= 1.5.1 =
* Reword commercial rates description.
* Refactor USPS API response handling a bit.

= 1.5.0 =
* Check prerequisites on boot, in a user-friendly way.

= 1.4.0 =
* Replace the deprecated WC_Product->length/width/height properties access with get_XXX() calls.
* Switch to the HTTPS USPS API endpoint.
* Disable cache and show debug data on the cart and checkout pages if the WooCommerce shipping debug mode is enabled.
* Tested with WooCommerce 4.8, WordPress 5.6.

= 1.3.1.1 =
* Tested with WooCommerce 4.7.

= 1.3.1 =
* Tested with WooCommerce 4.6.
* Minor changes for better USPS API response parsing.

= 1.3 =
* Tested with WordPress 5.5 and WooCommerce 4.5.
* Refresh the settings page look a bit.

= 1.2.6 =
* Compatible with woocommerce 2.6

= 1.2.5 =
* Fix First-Class Mail Parcel price calculator.
* Added First-Class Mail Large Envelope, Letter, and Postcards.

= 1.2.4 =
* API Request updated

= 1.2.3 =
* Fix - Incorrect work of "Quote regular items by weight" with zero size items.

= 1.2.2 =
* Removed deprecated USPS services:
  Priority Mail Regional Rate Box C;
  Priority Mail Regional Rate Box C, Hold For Pickup;
* Added First-Class Mail Metered Letter;
* Rebranding of Standard Post as Retail Ground.

= 1.2.1 =
* Fix - warning message in cart.

= 1.2.0 =
* Added services:
  Priority Mail, Hold For Pickup;
  Priority Mail Regional Rate Box A, Hold For Pickup;
  Priority Mail Regional Rate Box B, Hold For Pickup;
  Priority Mail Regional Rate Box C, Hold For Pickup.

= 1.1.1 =
* Added mail class id

= 1.1.0 =
* Added grouping by weight.

= 1.0.1 =
* Fix - Standard Post really works.

= 1.0 =
* Supported services: Priority Mail Express, Priority Mail, First-Class Mail, Standard Post, Media Mail, Library Mail