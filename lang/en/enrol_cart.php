<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Shopping Cart Enrolment Plugin for Moodle
 *
 * @package     enrol_cart
 * @author      MohammadReza PourMohammad <onbirdev@gmail.com>
 * @copyright   2024 MohammadReza PourMohammad
 * @link        https://onbir.dev
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Cart';
$string['pluginname_desc'] =
    'The cart enrolment method creates a shopping cart on the whole site and provides the possibility of adding the course to the shopping cart.';
$string['privacy:metadata:reason'] = 'The enrol_cart plugin does not store any user data directly.';
$string['privacy:metadata:enrol_cart'] = 'Details of the shopping carts used for enrolment.';
$string['privacy:metadata:enrol_cart:user_id'] = 'The ID of the user associated with the cart.';
$string['privacy:metadata:enrol_cart:status'] = 'The status of the cart (e.g., pending, completed).';
$string['privacy:metadata:enrol_cart:currency'] = 'The currency used in the cart.';
$string['privacy:metadata:enrol_cart:price'] = 'The total price of the cart.';
$string['privacy:metadata:enrol_cart:payable'] = 'The total amount payable in the cart.';
$string['privacy:metadata:enrol_cart:coupon_id'] = 'The ID of the coupon applied to the cart, if any.';
$string['privacy:metadata:enrol_cart:coupon_code'] = 'The code of the coupon applied to the cart, if any.';
$string['privacy:metadata:enrol_cart:checkout_at'] = 'The timestamp when the cart was checked out.';
$string['privacy:metadata:enrol_cart:created_at'] = 'The timestamp when the cart was created.';
$string['privacy:metadata:enrol_cart_items'] = 'Details of the items in a shopping cart.';
$string['privacy:metadata:enrol_cart_items:cart_id'] = 'The ID of the cart containing the item.';
$string['privacy:metadata:enrol_cart_items:instance_id'] = 'The ID of the enrolment instance associated with the item.';
$string['privacy:metadata:enrol_cart_items:price'] = 'The price of the item.';
$string['privacy:metadata:enrol_cart_items:payable'] = 'The amount payable for the item.';

$string['cart:config'] = 'Configure cart enrol instances';
$string['cart:manage'] = 'Manage enrolled users';
$string['cart:unenrol'] = 'Unenrol users from course';
$string['cart:unenrolself'] = 'Unenrol self from the course';
$string['cart:view'] = 'View shopping cart';

$string['delete_expired_carts'] = 'Delete expired carts';
$string['event_cart_deleted'] = 'Cart cleared';

$string['add_to_cart'] = 'Add to cart';
$string['cart_is_empty'] = 'Your cart is empty';
$string['price'] = 'Price';
$string['payable'] = 'Payable';
$string['total'] = 'Total';
$string['free'] = 'Free';
$string['checkout'] = 'Checkout';
$string['select_payment_method'] = 'Select payment method';
$string['status_current'] = 'Current active';
$string['status_checkout'] = 'Checkout';
$string['status_canceled'] = 'Canceled';
$string['status_delivered'] = 'Delivered';
$string['unknown'] = 'Unknown';
$string['cart_status'] = 'Status';
$string['coupon_code'] = 'Coupon code';
$string['coupon_discount'] = 'Coupon discount';
$string['apply'] = 'Apply';
$string['total_order_amount'] = 'Total amount';
$string['IRR'] = 'IRR';
$string['IRT'] = 'IRT';
$string['payment'] = 'Payment';
$string['pay'] = 'Pay';
$string['proceed_to_checkout'] = 'Proceed to checkout';
$string['discount'] = 'Discount';
$string['complete_purchase'] = 'Complete purchase';
$string['cancel_cart'] = 'Cancel';
$string['cancel'] = 'Cancel';
$string['gateway_wait'] = 'Please wait...';
$string['order'] = 'Order';
$string['order_id'] = 'Order ID';
$string['my_purchases'] = 'My purchases';
$string['view'] = 'View';
$string['date'] = 'Date';
$string['no_items'] = 'No item found.';
$string['no_discount'] = 'No discount';
$string['percentage'] = 'Percentage';
$string['fixed'] = 'Fixed amount';
$string['never'] = 'Never';
$string['unlimited'] = 'Unlimited';
$string['one_day'] = 'One day';
$string['a_week'] = 'A week';
$string['one_month'] = 'One month';
$string['three_months'] = 'Three months';
$string['six_months'] = 'Six months';
$string['user'] = 'User';
$string['choose_gateway'] = 'Choose a payment gateway:';

$string['payment_account'] = 'Payment account';
$string['payment_currency'] = 'Currency unit';
$string['canceled_cart_lifetime'] = 'Cancelled cart retention period';
$string['canceled_cart_lifetime_desc'] =
    'Cancelled shopping carts will be permanently deleted after the specified period. A value of zero means unlimited.';
$string['pending_payment_cart_lifetime'] = 'Pending payment cart retention period';
$string['pending_payment_cart_lifetime_desc'] =
    'Shopping carts with pending payment will be permanently deleted after the specified period. A value of zero means unlimited.';
$string['verify_payment_on_delivery'] = 'Match final amount with payment on delivery';
$string['verify_payment_on_delivery_desc'] =
    'If enabled, the final cart amount will be compared with the amount paid at the time of delivery. The cart will only be delivered if the amounts match.';
$string['convert_irr_to_irt'] = 'Convert IRR to Toman';
$string['convert_irr_to_irt_desc'] =
    'If enabled, Iranian Rial amounts will be converted to Toman for display purposes. <b>(This setting only affects how the amount is shown to users; when creating or editing enrolment methods, amounts must still be entered in Rial.)</b>';
$string['convert_numbers_to_persian'] = 'Convert English numbers to Persian';
$string['convert_numbers_to_persian_desc'] =
    'If enabled, English numerals will be converted to Persian numerals when displaying amounts.';
$string['enrol_instance_defaults'] = 'Enrolment defaults';
$string['enrol_instance_defaults_desc'] = 'Default settings for enrolling in new courses';
$string['payment_completion_time'] = 'Payment completion time';
$string['payment_completion_time_desc'] =
    'This setting defines the maximum allowed time after initiating a payment for the user to complete it. During this time, cart items, amount, and any discount code will be locked for payment.';
$string['choose_gateway'] = 'Choose payment gateway:';
$string['coupon_enable'] = 'Enable discount coupons';
$string['coupon_enable_desc'] =
    'The shopping cart supports the use of discount coupons if a compatible coupon plugin is installed in the system.';
$string['coupon_class'] = 'Discount coupon class';
$string['coupon_class_desc'] =
    'Specify the class path of the discount coupon. Example: <code dir="ltr">local_coupon\object\coupon</code>. The coupon class must implement <code dir="ltr">enrol_cart\local\object\coupon_interface</code>.';
$string['not_delete_cart_with_payment_record'] = 'Do not delete carts with payment records';
$string['not_delete_cart_with_payment_record_desc'] =
    'If enabled, carts that have records in the payment table will not be deleted.';
$string['enable_guest_cart'] = 'Allow guests to add/remove courses to/from cart';
$string['enable_guest_cart_desc'] =
    'If enabled, guest users can add courses to the shopping cart and remove them if needed.';

$string['status'] = 'Enable enrolment via shopping cart';
$string['status_desc'] = 'Allows users to add courses to the shopping cart by default.';
$string['payment_account_help'] = 'Payments will be deposited into this account.';
$string['cost'] = 'Cost';
$string['cost_help'] = 'The course price can start from 0. A value of 0 means the course is free.';
$string['currency'] = 'Currency';
$string['discount_type'] = 'Discount type';
$string['discount_amount'] = 'Discount amount';
$string['assign_role'] = 'User role';
$string['assign_role_desc'] = 'The role assigned to users after payment and enrolment.';
$string['enrol_period'] = 'Enrolment duration';
$string['enrol_period_desc'] = 'The period users remain enrolled in the course. A value of 0 means unlimited.';
$string['enrol_period_help'] = 'The duration of enrolment after the user is enrolled. A value of 0 means unlimited.';
$string['enrol_start_date'] = 'Enrolment start date';
$string['enrol_start_date_help'] = 'If enabled, users can enrol starting from this date.';
$string['enrol_end_date'] = 'Enrolment end date';
$string['enrol_end_date_help'] = 'If enabled, users can enrol until this date.';

$string['error_no_payment_accounts_available'] = 'No payment account is available.';
$string['error_no_payment_currency_available'] = 'Payments cannot be made in any currency. Please ensure that at least one payment gateway is active.';
$string['error_no_payment_gateway_available'] = 'No payment gateway is available. Please specify both the payment account and currency before selecting a gateway.';
$string['error_enrol_end_date'] = 'The enrolment end date cannot be earlier than the start date.';
$string['error_cost'] = 'The amount must be a number.';
$string['error_status_no_payment_account'] = 'Enrolment via cart cannot be enabled without specifying a payment account.';
$string['error_status_no_payment_currency'] = 'Enrolment via cart cannot be enabled without specifying a payment currency.';
$string['error_invalid_cart'] = 'The cart is invalid.';
$string['error_disabled'] = 'The cart is disabled.';
$string['error_coupon_disabled'] = 'The discount code is disabled.';
$string['error_coupon_apply_failed'] = 'Failed to apply the discount code.';
$string['error_coupon_is_invalid'] = 'The discount code is invalid.';
$string['error_discount_type_is_invalid'] = 'The discount type is invalid.';
$string['error_discount_amount_is_invalid'] = 'The discount amount is invalid.';
$string['error_discount_amount_is_higher'] = 'The discount amount cannot exceed the original price.';
$string['error_discount_amount_must_be_a_number'] = 'The discount amount must be a number.';
$string['error_discount_amount_percentage_is_invalid'] = 'The discount percentage must be an integer between 0 and 100.';
$string['error_gateway_is_invalid'] = 'The selected payment gateway is invalid.';
$string['error_coupon_class_not_found'] = 'The discount coupon class was not found.';
$string['error_coupon_class_not_implemented'] = 'The discount coupon class is not implemented correctly.';

$string['msg_enrolment_success'] = 'Your enrolment for the course(s) below has been successfully completed.';
$string['msg_enrolment_failed'] = 'There was a problem with your enrolment process.';
$string['msg_enrolment_deleted'] = 'One of the course enrolments has been deleted.';
$string['msg_enrolment_already'] = 'You have already enrolled for "{$a->title}" course.';
$string['msg_cart_changed'] = 'The item(s) or the payable amount in the cart have changed.';
$string['msg_cart_cancel_success'] = 'Your cart has been canceled.';
$string['msg_cart_cancel_failed'] = 'There was a problem with your cart process.';
$string['msg_cart_edit_blocked'] = 'It is currently not possible to edit or change the shopping cart.';
