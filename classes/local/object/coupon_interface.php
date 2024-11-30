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
 * Interface for managing coupons in the shopping cart enrolment plugin.
 *
 * This interface defines the methods required for handling coupons in the shopping cart.
 */
interface coupon_interface {
    /**
     * Get the ID of a coupon based on its code.
     *
     * @param string $couponcode The coupon code.
     * @return int|null The ID of the coupon, or null if the coupon does not exist.
     */
    public static function get_coupon_id(string $couponcode): ?int;

    /**
     * Validate a coupon for a given cart.
     *
     * @param cart_dto $cart The cart object.
     * @param int $couponid The ID of the coupon to be validated.
     * @return coupon_result_dto The result of the coupon validation.
     */
    public static function validate_coupon(cart_dto $cart, int $couponid): coupon_result_dto;

    /**
     * Apply a coupon to a given cart.
     *
     * @param cart_dto $cart The cart object.
     * @param int $couponid The ID of the coupon to be applied.
     * @return coupon_result_dto The result of the coupon application.
     */
    public static function apply_coupon(cart_dto $cart, int $couponid): coupon_result_dto;

    /**
     * Cancel the applied coupon for a given cart.
     *
     * @param cart_dto $cart The cart object.
     * @return coupon_result_dto The result of the coupon cancellation.
     */
    public static function cancel_coupon(cart_dto $cart): coupon_result_dto;
}
