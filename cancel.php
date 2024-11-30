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

use enrol_cart\local\object\cart;

global $PAGE, $OUTPUT, $CFG, $USER;

// Retrieve the cart ID from the request parameters.
$cartid = required_param('id', PARAM_ALPHANUM);

// Ensure the user is logged in and the session is valid.
require_login();
require_sesskey();

// Set the page title and URL.
$title = get_string('pluginname', 'enrol_cart') . ' - ' . get_string('cancel', 'enrol_cart');
$url = new moodle_url('/enrol/cart/cancel.php');
$context = context_system::instance();

// Configure the page settings.
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagetype('cart');
$PAGE->set_url($url);

// Fetch the cart object using the provided cart ID.
$cart = cart::find_one($cartid);

// Check if the cart exists, is not empty, can be edited, and belongs to the current user.
if ($cart && !$cart->is_empty && $cart->can_edit_items && $cart->is_current_user_owner) {
    // Cancel the cart.
    $cart->cancel();
}

// Redirect the user to the cart view URL after cancellation.
redirect($cart->view_url);
exit();
