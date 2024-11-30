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
 * Data Transfer Object for Cart.
 *
 * This class is used to transfer data related to a shopping cart in the enrolment system.
 */
class cart_dto {
    /**
     * @var cart The cart object to be used for data transfer.
     */
    private cart $cart;

    /**
     * Constructor for cart_dto.
     *
     * @param cart $cart The cart object to be used for data transfer.
     */
    public function __construct(cart $cart) {
        $this->cart = $cart;
    }

    /**
     * Get the cart ID.
     *
     * @return int The ID of the cart.
     */
    public function get_cart_id(): int {
        return $this->cart->id;
    }

    /**
     * Get the user ID associated with the cart.
     *
     * @return int The ID of the user.
     */
    public function get_user_id(): int {
        return $this->cart->user_id;
    }

    /**
     * Get the coupon ID applied to the cart.
     *
     * @return int|null The ID of the coupon, or null if no coupon is applied.
     */
    public function get_coupon_id(): ?int {
        return $this->cart->coupon_id;
    }

    /**
     * Get the coupon code applied to the cart.
     *
     * @return string|null The coupon code, or null if no coupon is applied.
     */
    public function get_coupon_code(): ?string {
        return $this->cart->coupon_code;
    }

    /**
     * Get the coupon usage ID.
     *
     * @return int|null The ID of the coupon usage, or null if no coupon is used.
     */
    public function get_coupon_usage_id(): ?int {
        return $this->cart->coupon_usage_id;
    }

    /**
     * Get the discount amount provided by the coupon.
     *
     * @return string|null The discount amount, or null if no coupon is applied.
     */
    public function get_coupon_discount_amount(): ?string {
        return $this->cart->coupon_discount_amount;
    }

    /**
     * Get the final price of the cart before any discounts.
     *
     * @return float The final price of the cart.
     */
    public function get_final_price(): float {
        return $this->cart->final_price;
    }

    /**
     * Get the final payable amount of the cart after applying discounts.
     *
     * @return float The final payable amount.
     */
    public function get_final_payable(): float {
        return $this->cart->final_payable;
    }

    /**
     * Get the items in the cart.
     *
     * @return cart_item_dto[] An array of cart_item_dto objects representing the items in the cart.
     */
    public function get_cart_items(): array {
        $items = [];
        foreach ($this->cart->items as $cartitem) {
            $items[] = new cart_item_dto($cartitem);
        }

        return $items;
    }
}
