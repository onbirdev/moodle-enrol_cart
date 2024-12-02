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

namespace enrol_cart\local\object;

use enrol_cart\local\helper\cart_helper;

/**
 * The cookie_cart class allows for the creation of a shopping cart based on cookies.
 *
 * Example:
 * ```
 * $courseId = optional_param('course', null, PARAM_INT);
 *
 * $cart = new cookie_cart();
 * $cart->add_course($courseId);
 * ```
 *
 * @property cart_item $items Represents an array of enrolment items in the cart.
 */
class cookie_cart extends base_cart {
    /**
     * The name of the cookie storing cart items.
     *
     * @var string
     */
    public string $cookiename = 'cart_items';

    /**
     * The path for which the cookie is available.
     *
     * @var string
     */
    public string $cookiepath = '/';

    /**
     * The expiration time for the cookie (in seconds). Default is 30 days.
     *
     * @var int
     */
    public int $cookieexpiretime = 86400 * 30; // 30 days

    /**
     * An array of the cart items ids that stored in cookie.
     *
     * @var array
     */
    private array $_cookie_items = [];

    /**
     * Initializes the shopping cart by loading items from the cookie.
     */
    public function init() {
        if (isset($_COOKIE[$this->cookiename])) {
            $this->_cookie_items = json_decode(stripslashes($_COOKIE[$this->cookiename]), true);

            // Validate each item in the decoded data to ensure it is an integer.
            // Remove any invalid (non-integer) items from the list.
            foreach ($this->_cookie_items as $key => $instanceid) {
                if (!is_int($instanceid)) {
                    unset($this->_cookie_items[$key]);
                }
            }
        }
    }

    /**
     * Flushes the cookie cart.
     *
     * @return bool Returns true if the cookie is successfully cleared, false otherwise.
     */
    public function flush(): bool {
        return setcookie($this->cookiename, '', time(), $this->cookiepath);
    }

    /**
     * Updates the cookie with the current items in the cart.
     *
     * @return bool Returns true if the cookie is successfully updated, false otherwise.
     */
    protected function update_cookie(): bool {
        return setcookie(
            $this->cookiename,
            json_encode($this->_cookie_items),
            time() + $this->cookieexpiretime,
            $this->cookiepath,
        );
    }

    /**
     * Adds an enrolment item to the cart.
     *
     * @param int $instanceid The ID of the enrolment instance to be added.
     * @return bool Returns true if the item is successfully added to the cart, false otherwise.
     */
    public function add_item(int $instanceid): bool {
        if (!in_array($instanceid, $this->_cookie_items)) {
            $this->_cookie_items[] = $instanceid;
        }

        $this->refresh();

        return $this->update_cookie();
    }

    /**
     * Removes an enrolment item from the cart.
     *
     * @param int $instanceid The ID of the enrolment instance to be removed.
     * @return bool Returns true if the item is successfully removed from the cart, false otherwise.
     */
    public function remove_item(int $instanceid): bool {
        foreach ($this->_cookie_items as $key => $val) {
            if ($val == $instanceid) {
                unset($this->_cookie_items[$key]);
                $this->refresh();
                return $this->update_cookie();
            }
        }
        return false;
    }

    /**
     * Returns an array of cart_item objects representing the enrolment items in the cart.
     *
     * @return cart_item[] An array of cart_item objects.
     */
    public function get_items(): array {
        if (empty($this->_items)) {
            foreach ($this->_cookie_items as $instanceid) {
                if ($instance = cart_helper::get_instance($instanceid)) {
                    $this->_items[] = cart_item::populate_one([
                        'id' => $instance->id,
                        'cart_id' => 0,
                        'instance_id' => $instance->id,
                        'price' => $instance->price,
                        'payable' => $instance->payable,
                        'cart' => $this,
                    ]);
                }
            }
        }
        return $this->_items;
    }

    /**
     * {@inheritdoc}
     *
     * Performs the checkout operation for the cookie-based shopping cart.
     * However, since cookie carts typically don't involve a traditional checkout process,
     * this implementation always returns false.
     *
     * @return bool Always returns false as checkout is not supported by cookie-based carts.
     */
    public function checkout(): bool {
        return false;
    }

    /**
     * Flush the cookie cart.
     *
     * @return bool
     */
    public function cancel(): bool {
        return $this->flush();
    }

    /**
     * {@inheritDoc}
     * Delivery of order is not supported by the cookie cart, so always returns false.
     */
    public function deliver(): bool {
        return false;
    }
}
