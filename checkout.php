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
use enrol_cart\local\form\coupon_code_form;
use enrol_cart\local\helper\cart_helper;
use enrol_cart\local\helper\coupon_helper;
use enrol_cart\local\helper\payment_helper;
use enrol_cart\local\object\cart;

global $PAGE, $OUTPUT, $CFG;

// Retrieve the cart ID from the request.
$id = optional_param('id', null, PARAM_INT);

// Ensure the user is logged in.
require_login();

// Set up the page context and layout.
$title = get_string('pluginname', 'enrol_cart') . ' - ' . get_string('checkout', 'enrol_cart');
$url = cart_helper::get_cart_checkout_url($id);
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
    cart_helper::get_cart_view_url($id),
    navigation_node::TYPE_CONTAINER,
);
$node2->add(get_string('checkout', 'enrol_cart'), $url)->make_active();

// Retrieve the cart object.
$cart = $id ? cart::find_one($id) : cart_helper::get_current();

// Check if the cart is empty or invalid.
if (!$cart || $cart->is_empty || !$cart->is_current_user_owner || $cart->is_delivered) {
    redirect(cart_helper::get_cart_view_url());
    exit();
}

// Initialize the coupon form.
$couponform = new coupon_code_form(null, ['cart' => $cart]);

// Cancel the coupon if requested.
if ($couponform->is_cancelled()) {
    $cart->coupon_cancel();
    redirect($url);
    exit();
}

// Refresh the cart to update item prices and totals.
$cart->refresh();

// Check if the cart has changed during the process.
if ($cart->has_changed) {
    notification::warning(get_string('msg_cart_changed', 'enrol_cart'));
    redirect($url);
    exit();
}

// Process the cart if the final payable amount is zero.
if ($cart->is_final_payable_zero) {
    $cart->process_free_items();
    redirect($cart->view_url);
    exit();
}

// Apply the coupon code if the form is submitted.
if (($couponformdata = $couponform->get_data()) && $cart->can_use_coupon) {
    if ($cart->coupon_code && $cart->coupon_code != $couponformdata->coupon_code) {
        $cart->coupon_cancel();
    }
    $cart->coupon_validate($couponformdata->coupon_code);
}

// Render the checkout page.
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('enrol_cart/checkout', [
    'cart' => $cart,
    'items' => $cart->items,
    'payment_url' => new moodle_url('/enrol/cart/payment.php'),
    'coupon_form' => $cart->can_edit_items && coupon_helper::is_coupon_enable() ? $couponform->render() : '',
    'session_key' => sesskey(),
    'gateways' => payment_helper::get_allowed_payment_gateways(),
    'show_gateway' => !$cart->is_final_payable_zero,
]);
echo $OUTPUT->footer();
