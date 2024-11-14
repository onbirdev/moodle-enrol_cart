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

require_once('../../config.php');

use core\notification;
use enrol_cart\form\CouponCodeForm;
use enrol_cart\helper\CartHelper;
use enrol_cart\helper\CouponHelper;
use enrol_cart\helper\PaymentHelper;
use enrol_cart\object\Cart;

global $PAGE, $OUTPUT, $CFG;

// Retrieve the cart ID from the request.
$id = optional_param('id', null, PARAM_INT);

// Ensure the user is logged in.
require_login();

// Set up the page context and layout.
$title = get_string('pluginname', 'enrol_cart') . ' - ' . get_string('checkout', 'enrol_cart');
$url = CartHelper::getCartCheckoutUrl($id);
$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagetype('cart');
$PAGE->set_url($url);

// Add navigation nodes.
$node1 = $PAGE->navigation->add(
    get_string('my_purchases', 'enrol_cart'),
    new moodle_url('/enrol/cart/my.php'),
    navigation_node::TYPE_CONTAINER,
);
$node2 = $node1->add(
    get_string('pluginname', 'enrol_cart'),
    CartHelper::getCartViewUrl($id),
    navigation_node::TYPE_CONTAINER,
);
$node2->add(get_string('checkout', 'enrol_cart'), $url)->make_active();

// Retrieve the cart object.
$cart = $id ? Cart::findOne($id) : CartHelper::getCurrent();

// Check if the cart is empty or invalid.
if (!$cart || $cart->isEmpty || !$cart->isCurrentUserOwner || $cart->isDelivered) {
    redirect(CartHelper::getCartViewUrl());
    exit();
}

// Initialize the coupon form.
$couponform = new CouponCodeForm(null, ['cart' => $cart]);

// Cancel the coupon if requested.
if ($couponform->is_cancelled()) {
    $cart->couponCancel();
    redirect($url);
    exit();
}

// Refresh the cart to update item prices and totals.
$cart->refresh();

// Check if the cart has changed during the process.
if ($cart->hasChanged) {
    notification::warning(get_string('msg_cart_changed', 'enrol_cart'));
    redirect($url);
    exit();
}

// Process the cart if the final payable amount is zero.
if ($cart->isFinalPayableZero) {
    $cart->processFreeItems();
    redirect($cart->viewUrl);
    exit();
}

// Apply the coupon code if the form is submitted.
if (($couponformdata = $couponform->get_data()) && $cart->canUseCoupon) {
    if ($cart->coupon_code && $cart->coupon_code != $couponformdata->coupon_code) {
        $cart->couponCancel();
    }
    $cart->couponValidate($couponformdata->coupon_code);
}

// Render the checkout page.
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('enrol_cart/checkout', [
    'cart' => $cart,
    'items' => $cart->items,
    'payment_url' => new moodle_url('/enrol/cart/payment.php'),
    'coupon_form' => $cart->canEditItems && CouponHelper::isCouponEnable() ? $couponform->render() : '',
    'session_key' => sesskey(),
    'gateways' => PaymentHelper::getAllowedPaymentGateways(),
    'show_gateway' => !CartHelper::getConfig('auto_select_payment_gateway'),
]);
echo $OUTPUT->footer();
