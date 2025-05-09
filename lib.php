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

use enrol_cart\local\helper\cart_helper;

/**
 * Renders the shopping cart button in the Moodle navbar.
 *
 * This function checks if the "cart" enrolment plugin is enabled. If it is,
 * it retrieves the current cart and renders a button in the navbar displaying
 * the number of items in the cart and a link to the cart view page.
 *
 * @param renderer_base $renderer The renderer instance used to output the template.
 *
 * @return string The rendered HTML for the cart button, or an empty string if the
 *                "cart" enrolment plugin is disabled.
 */
function enrol_cart_render_navbar_output(renderer_base $renderer) {
    if (!enrol_is_enabled('cart')) {
        return '';
    }

    $cart = cart_helper::get_current();
    return $renderer->render_from_template('enrol_cart/cart_button', [
        'count' => $cart ? $cart->count : 0,
        'view_url' => cart_helper::get_cart_view_url(),
    ]);
}
