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
$string['privacy:metadata'] = 'The cart enrolment plugin does not store any personal data.';

$string['cart:config'] = 'Configure cart enrol instances';
$string['cart:manage'] = 'Manage enrolled users';
$string['cart:unenrol'] = 'Unenrol users from course';
$string['cart:unenrolself'] = 'Unenrol self from the course';

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
$string['unknown'] = 'Unknown';
$string['never'] = 'Never';
$string['unlimited'] = 'Unlimited';
$string['one_day'] = 'One day';
$string['a_week'] = 'A week';
$string['one_month'] = 'One month';
$string['three_months'] = 'Three months';
$string['six_months'] = 'Six months';
$string['user'] = 'User';
$string['choose_gateway'] = 'Choose a payment gateway:';

$string['payment_account'] = 'Payment Account';
$string['payment_currency'] = 'Currency';
$string['payment_gateways'] = 'Allowed Payment Gateways';
$string['payment_gateways_desc'] = 'Specify the payment gateways that the user can use to make payments.';
$string['auto_select_payment_gateway'] = 'Auto-select Payment Gateway';
$string['auto_select_payment_gateway_desc'] =
    'When this option is selected, the user will be directed to one of the above payment gateways without needing to select a gateway.';
$string['canceled_cart_lifetime'] = 'Lifetime of Canceled Carts';
$string['canceled_cart_lifetime_desc'] =
    'Canceled carts will be completely removed after the specified time. A value of zero means unlimited.';
$string['pending_payment_cart_lifetime'] = 'Lifetime of Pending Payment Carts';
$string['pending_payment_cart_lifetime_desc'] =
    'Pending payment carts will be completely removed after the specified time. A value of zero means unlimited.';
$string['verify_payment_on_delivery'] = 'Verify Final Amount with Payment on Delivery';
$string['verify_payment_on_delivery_desc'] =
    'When this option is selected, the final cart amount will be compared with the payment amount during delivery, and the cart will be delivered if they match.';
$string['convert_irr_to_irt'] = 'Convert IRR to IRT';
$string['convert_irr_to_irt_desc'] =
    'When this option is selected, amounts in Iranian Rial will be converted to Toman and displayed. <b>(This setting is only applicable for displaying amounts to the user. When creating or editing enrolment methods, amounts must still be entered in Rial.)</b>';
$string['convert_numbers_to_persian'] = 'Convert English Numbers to Persian';
$string['convert_numbers_to_persian_desc'] =
    'When this option is selected, English numbers will be converted to Persian numbers when displaying amounts.';
$string['enrol_instance_defaults'] = 'Enrolment Defaults';
$string['enrol_instance_defaults_desc'] = 'Default settings for enrolling in new courses';
$string['payment_completion_time'] = 'Payment Completion Time';
$string['payment_completion_time_desc'] =
    'This variable specifies the maximum time a user has to complete their payment after initiating it. During this period, the items, cart amount, and discount code will be locked for the user.';
$string['coupon_enable'] = 'Enable Discount Coupon';
$string['coupon_enable_desc'] =
    'The shopping cart supports the use of discount coupons if the discount coupon plugin is available in the system. If so, it can be used in the shopping cart.';
$string['coupon_class'] = 'Discount Coupon Class';
$string['coupon_class_desc'] =
    'Specify the path to the discount coupon class. For example: <code>local_coupon\object\coupon</code>. The discount coupon class must implement <code>enrol_cart\object\CouponInterface</code>.';
$string['not_delete_cart_with_payment_record'] = 'Do not delete carts with payment records';
$string['not_delete_cart_with_payment_record_desc'] =
    'If this option is selected, carts with records in the payment table will not be deleted.';
$string['enable_guest_cart'] = 'Allow guests to add and remove courses from cart';
$string['enable_guest_cart_desc'] = 'If enabled, guest users will be able to add courses to their cart and remove them.';

$string['status'] = 'Enable manual enrolments';
$string['status_desc'] = 'Allow users to add a course to cart by default.';
$string['payment_account'] = 'Payment account';
$string['payment_account_help'] = 'Enrolment fees will be paid to this account.';
$string['cost'] = 'Cost';
$string['cost_help'] = 'The cost of the course can start from 0. The value 0 means that the course is free.';
$string['currency'] = 'Currency';
$string['discount_type'] = 'Discount type';
$string['discount_amount'] = 'Discount amount';
$string['assign_role'] = 'Assign role';
$string['assign_role_desc'] = 'Select the role to assign to users after making a payment.';
$string['enrol_period'] = 'Enrolment duration';
$string['enrol_period_desc'] =
    'Default length of time that the enrolment is valid. If set to zero, the enrolment duration will be unlimited by default.';
$string['enrol_period_help'] =
    'Length of time that the enrolment is valid, starting with the moment the user is enrolled. If disabled, the enrolment duration will be unlimited.';
$string['enrol_start_date'] = 'Start date';
$string['enrol_start_date_help'] = 'If enabled, users can only be enrolled from this date onwards.';
$string['enrol_end_date'] = 'End date';
$string['enrol_end_date_help'] = 'If enabled, users can be enrolled until this date only.';

$string['error_no_payment_accounts_available'] = 'No payment accounts available.';
$string['error_no_payment_currency_available'] =
    'Payments cannot be made in any currency. Please ensure at least one payment gateway is active.';
$string['error_no_payment_gateway_available'] =
    'No payment gateway is available. Please specify the payment account and payment gateway to select a payment gateway.';
$string['error_enrol_end_date'] = 'The enrolment end date cannot be earlier than the start date.';
$string['error_cost'] = 'The cost must be a number.';
$string['error_status_no_payment_account'] = 'Enrolments can not be enabled without specifying the payment account.';
$string['error_status_no_payment_currency'] = 'Enrolments can not be enabled without specifying the payment currency';
$string['error_status_no_payment_gateways'] = 'Enrolments can not be enabled without specifying the payment gateway.';
$string['error_invalid_cart'] = 'Invalid cart';
$string['error_disabled'] = 'The cart is disabled.';
$string['error_coupon_disabled'] = 'Coupon disabled.';
$string['error_coupon_apply_failed'] = 'Coupon apply failed';
$string['error_coupon_is_invalid'] = 'The coupon is invalid.';
$string['error_discount_type_is_invalid'] = 'The discount type is invalid.';
$string['error_discount_amount_is_invalid'] = 'The discount amount is invalid.';
$string['error_discount_amount_is_higher'] = 'The discount amount cannot be higher than the original amount';
$string['error_discount_amount_must_be_a_number'] = 'The discount amount must be a number.';
$string['error_discount_amount_percentage_is_invalid'] =
    'The discount percentage must be an integer between 0 and 100.';
$string['error_gateway_is_invalid'] = 'The selected gateway is invalid.';
$string['error_coupon_class_not_found'] = 'Discount coupon class not found.';
$string['error_coupon_class_not_implemented'] = 'Discount coupon class not implemented correctly.';

$string['msg_delivery_successful'] = 'Your enrolment for the course(s) below has been successfully completed.';
$string['msg_delivery_filed'] = 'There was a problem with your enrolment process.';
$string['msg_instance_deleted'] = 'One of the course enrolments has been deleted.';
$string['msg_already_enrolled'] = 'You have already enrolled for "{$a->title}" course.';
$string['msg_cart_changed'] = 'The item(s) or the payable amount in the cart have changed.';
$string['msg_cancel_successful'] = 'Your cart has been canceled.';
$string['msg_cancel_filed'] = 'There was a problem with your cart process.';
$string['msg_cart_cannot_be_edited'] = 'It is currently not possible to edit or change the shopping cart.';
