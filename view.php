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

use enrol_cart\local\helper\cart_helper;
use enrol_cart\local\object\cart;

global $PAGE, $OUTPUT, $CFG, $USER;

// Retrieve the cart ID from the request.
$id = optional_param('id', null, PARAM_INT);

// Set up the page context and layout.
$title = get_string($id ? 'order' : 'pluginname', 'enrol_cart');
$url = cart_helper::get_cart_view_url($id);
$context = context_system::instance();

// Require login if cart ID is provided.
// If guest cart access is disabled, require user login.
$enableguestcart = cart_helper::get_config('enable_guest_cart');
if ($id || !$enableguestcart) {
    require_login();
}

// Check if the user is logged in, then verify that the user has the 'enrol/cart:view' capability in the current context.
if ($USER && $USER->id) {
    require_capability('enrol/cart:view', $context);
}

$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagetype('cart');
$PAGE->set_url($url);

// Retrieve the cart object.
$cart = $id ? cart::find_one($id) : cart_helper::get_current();

// Check if the current user can manage the cart.
$canmanage = has_capability('enrol/cart:manage', $context);

// Add navigation nodes.
if ($cart && $cart->is_current_user_owner) {
    $node1 = $PAGE->navigation->add(
        get_string('my_purchases', 'enrol_cart'),
        new moodle_url('/enrol/cart/my.php'),
        navigation_node::TYPE_CONTAINER,
    );
    $node1->add($title, $url)->make_active();
} else {
    $PAGE->navigation->add($title, $url, navigation_node::TYPE_CONTAINER);
}

// Render an empty cart view if the cart is empty or invalid.
if (!$cart || $cart->is_empty) {
    echo $OUTPUT->header();
    echo $OUTPUT->render_from_template('enrol_cart/view_empty', []);
    echo $OUTPUT->footer();
    exit();
}

// Ensure the current user owns the cart or has management capability.
if (!$cart->is_current_user_owner && !$canmanage) {
    throw new moodle_exception('error_invalid_cart', 'enrol_cart');
}

// Refresh the cart to validate and update item prices.
$cart->refresh();

// Render a cart view based on the user's capabilities and cart state.
if (!$cart->is_current || (!$cart->is_current_user_owner && $canmanage)) {
    echo $OUTPUT->header();
    echo $OUTPUT->render_from_template('enrol_cart/view', [
        'cart' => $cart,
        'items' => $cart->items,
        'show_detail' => $canmanage,
        'show_actions' => $cart->is_current_user_owner && ($cart->is_current || $cart->is_checkout),
        'checkout_url' => $cart->checkout_url,
        'cancel_url' => new moodle_url('/enrol/cart/cancel.php'),
        'session_key' => sesskey(),
    ]);
    echo $OUTPUT->footer();
    exit();
}

// Render the current cart view for the owner.
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('enrol_cart/view_current', [
    'cart' => $cart,
    'items' => $cart->items,
    'checkout_url' => new moodle_url('/enrol/cart/checkout.php'),
    'can_remove_items' => $cart->can_edit_items,
]);
echo $OUTPUT->footer();
