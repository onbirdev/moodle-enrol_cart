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

/**
 * Data Transfer Object for Cart Item.
 *
 * This class is used to transfer data related to a cart item in the enrolment system.
 */
class cart_item_dto {
    /** @var cart_item|null The cart item object to be used for data transfer. */
    private ?cart_item $_cart_item;

    /**
     * Constructor for cart_item_dto.
     *
     * @param cart_item $cartitem The cart item object to be used for data transfer.
     */
    public function __construct(cart_item $cartitem) {
        $this->_cart_item = $cartitem;
    }

    /**
     * Get the ID of the cart item.
     *
     * @return int The ID of the cart item.
     */
    public function get_item_id(): int {
        return $this->_cart_item->id;
    }

    /**
     * Get the ID of the course associated with the cart item.
     *
     * @return int The ID of the course.
     */
    public function get_course_id(): int {
        return $this->_cart_item->course->id;
    }

    /**
     * Get the price of the cart item.
     *
     * @return float The price of the cart item.
     */
    public function get_price(): float {
        return $this->_cart_item->price;
    }

    /**
     * Get the payable amount for the cart item after applying any discounts.
     *
     * @return float The payable amount for the cart item.
     */
    public function get_payable(): float {
        return $this->_cart_item->payable;
    }

    /**
     * Check if the cart item has any discount applied.
     *
     * @return bool True if a discount is applied, false otherwise.
     */
    public function has_discount(): bool {
        return $this->_cart_item->has_discount;
    }
}
