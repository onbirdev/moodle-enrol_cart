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

namespace enrol_cart\event;

use core\event\base;
use moodle_url;

/**
 * Event class for when a cart is deleted in Moodle.
 */
class cart_deleted extends base {
    /**
     * Initializes the event data.
     *
     * Sets the basic event data, such as CRUD operation type, educational level,
     * and the object table for cart deletion events.
     */
    protected function init() {
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'enrol_cart';
    }

    /**
     * Returns the event name.
     *
     * @return string The event name, fetched from the language string.
     */
    public static function get_name() {
        return get_string('event_cart_deleted', 'enrol_cart');
    }

    /**
     * Returns a description of the event.
     *
     * @return string A description of the cart deletion event, including the user and cart IDs.
     */
    public function get_description() {
        return "The user with id '{$this->userid}' deleted the cart with id '{$this->objectid}'.";
    }

    /**
     * Returns the URL associated with the event.
     *
     * @return moodle_url The URL for viewing the cart, including the cart ID.
     */
    public function get_url() {
        return new moodle_url('/enrol/cart/view.php', ['id' => $this->objectid]);
    }
}
