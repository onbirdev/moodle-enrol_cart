# Moodle Cart Enrolment Method

This is a complete shopping cart plugin for Moodle that adds a "Cart" enrolment
method to courses, allowing users to add courses to their cart and complete the
payment using the available payment methods in Moodle.

Users can view their shopping cart using the cart icon in the top navigation bar 
and see their purchase history through the "My Purchases" option in the user menu.
Additionally, users can add courses to their cart before logging in, with the cart 
information stored in a cookie. After logging in, the cart is transferred from the 
cookie to the database, allowing the user to complete the payment.

This plugin allows the admin to set a discount amount or percentage for each course. 
Additionally, by implementing the `enrol_cart\local\object\coupon_interface` class and setting 
the `coupon_class` in the cart enrollment settings, users can use discount coupons during 
checkout.


## Requirements
1. Moodle version 3.10 or later
2. PHP 7.4 or later


## Translations available
- Persian (fa)


## Installation
1. Download latest release ".zip" file.
2. Install from "Site administration > Plugins > Install plugins".
3. Visit the "Site Administration > Plugins > Enrolments" page.
4. Click the eye symbol next to "Cart" to enable the plugin.

> During installation, you need to set up the "Payment Account", "Currency", and
> "Payment Gateway" in three steps. These settings can also be adjusted later under
> "Site Administration > Plugins > Enrolments > Cart".


## License
Released Under the GNU http://www.gnu.org/copyleft/gpl.html