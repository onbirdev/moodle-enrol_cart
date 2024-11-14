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
use core_payment\helper;
use enrol_cart\helper\CartHelper;
use enrol_cart\helper\PaymentHelper;
use enrol_cart\object\Cart;

global $PAGE, $OUTPUT, $CFG, $USER;

// Retrieve parameters from the request.
$cartid = optional_param('id', null, PARAM_ALPHANUM);
$gateway = optional_param('gateway', null, PARAM_ALPHANUM);
$couponcode = optional_param('coupon_code', null, PARAM_ALPHANUM);

// Ensure the user is logged in and has a valid session.
require_login();
require_sesskey();

// Set up the page context and layout.
$title = get_string('pluginname', 'enrol_cart') . ' - ' . get_string('payment', 'enrol_cart');
$url = new moodle_url('/enrol/cart/payment.php');
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
    CartHelper::getCartViewUrl($cartid),
    navigation_node::TYPE_CONTAINER,
);
$node2->add(get_string('payment', 'enrol_cart'), $url)->make_active();

// Get the cart object.
$cart = $cartid ? Cart::findOne($cartid) : CartHelper::getCurrent();

// Check if the cart is payable.
if (
    !$cart ||
    $cart->isEmpty ||
    !($cart->isCheckout || $cart->isCurrent) ||
    !$cart->isCurrentUserOwner ||
    $cart->isDelivered
) {
    redirect(CartHelper::getCartViewUrl());
    exit();
}

// Prepare and validate payment gateway.
$gateway = $gateway ?: PaymentHelper::getRandPaymentGateway();
if (!PaymentHelper::isPaymentGatewayValid($gateway)) {
    notification::error(get_string('error_gateway_is_invalid', 'enrol_cart'));
    redirect($cart->checkoutUrl);
    exit();
}

// Refresh the cart to update item prices and totals.
$cart->refresh();

// Validate the coupon if any is applied.
if (!$cart->couponCheckAvailability() && !$cart->couponCancel()) {
    notification::warning($cart->couponErrorMessage ?: get_string('error_coupon_is_invalid', 'enrol_cart'));
    redirect($cart->checkoutUrl);
    exit();
}

// Check if the cart has changed during the process.
if ($cart->hasChanged) {
    notification::warning(get_string('msg_cart_changed', 'enrol_cart'));
    redirect($cart->checkoutUrl);
    exit();
}

// Apply the coupon code if provided.
if (!$cart->coupon_id && $couponcode && !$cart->couponApply($couponcode)) {
    notification::error($cart->couponErrorMessage ?: get_string('error_coupon_apply_failed', 'enrol_cart'));
    redirect($cart->checkoutUrl);
    exit();
}

// Process the cart if the final payable amount is zero.
if ($cart->isFinalPayableZero) {
    $cart->processFreeItems();
    redirect($cart->viewUrl);
    exit();
}

// Proceed to checkout.
$cart->checkout();

// Prepare payment method details.
$component = 'enrol_cart';
$paymentarea = 'cart';
$itemid = $cart->id;
$description = '';
$successurl = helper::get_success_url($component, $paymentarea, $itemid)->out(false);

// Load payment JavaScript module.
$PAGE->requires->js_call_amd('enrol_cart/payment', 'init', [
    $gateway,
    $component,
    $paymentarea,
    $itemid,
    $successurl,
    $description,
]);

// Render the payment page.
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('enrol_cart/payment', [
    'cart' => $cart,
    'gateway' => $gateway,
    'component' => $component,
    'payment_area' => $paymentarea,
    'item_id' => $itemid,
    'success_url' => $successurl,
    'description' => $description,
]);
echo $OUTPUT->footer();
