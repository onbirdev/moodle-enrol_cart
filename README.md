# Moodle Shopping Cart

This plugin adds a complete shopping cart system to Moodle by introducing a new "Cart" enrolment method.
Users can add courses to their cart and proceed to payment using any of the supported Moodle payment gateways

Users can access their shopping cart from the cart icon in the top navigation bar and view their purchase history via the "My Purchases" option in the user menu.
Courses can also be added to the cart before logging in — the cart data is stored in a cookie and automatically transferred to the database upon login, allowing users to proceed with payment seamlessly.

This plugin allows administrators to define a fixed discount amount or a percentage discount for each course.
Additionally, it supports the use of coupon codes during checkout by implementing the `enrol_cart\local\object\coupon_interface` interface and configuring the `coupon_class` in the cart enrollment settings.

An example implementation (`enrol_cart\local\object\coupon_example` class) is included in the plugin to demonstrate how to build your own coupon logic.

## Requirements
1. Moodle version 3.11 or later
2. PHP 7.4 or later


## Translations available
- Persian (fa)
- French (fr)


## Installation
1. Download latest release ".zip" file.
2. Install from "Site administration > Plugins > Install plugins".
3. Visit the "Site Administration > Plugins > Enrolments" page.
4. Click the eye symbol next to "Cart" to enable the plugin.

> During installation, you’ll need to configure the **Payment Account** and **Currency** settings.
> You can always update these settings later by navigating to:
> **Site Administration > Plugins > Enrolments > Cart**


## License
Released Under the GNU http://www.gnu.org/copyleft/gpl.html


## 💖 Love This Plugin?

Keep it updated and free for everyone!

[☕ Buy Me a Coffee (Ko-fi)](https://ko-fi.com/onbirdev) | [💸 Support via PayPal](https://www.paypal.me/onbirdev)
