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

namespace enrol_cart\observer;

use core\event\user_loggedin;
use enrol_cart\local\helper\cart_helper;

/**
 * The user_observer class observes user login events and performs actions accordingly.
 */
class user_observer {
    /**
     * Handles the user_loggedin event, triggered when a user successfully logs in.
     *
     * @param user_loggedin $event The user_loggedin event object.
     * @return void
     */
    public static function user_logged_in(user_loggedin $event) {
        // Move the contents of the user's cookie cart to the database upon login.
        cart_helper::move_cookie_cart_to_db();
    }
}
