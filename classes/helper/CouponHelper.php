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

namespace enrol_cart\helper;

use enrol_cart\object\CartDto;
use enrol_cart\object\CouponInterface;
use enrol_cart\object\CouponResultDto;

/**
 * Class CouponHelper
 * Provides helper functions to manage coupon-related functionalities in the shopping cart.
 */
class CouponHelper {
    /**
     * Retrieves the name of the coupon class from the configuration.
     *
     * @return string|null The name of the coupon class, or null if not defined.
     */
    public static function get_coupon_class_name(): ?string {
        return (string) CartHelper::get_config('coupon_class') ?: null;
    }

    /**
     * Checks if the coupon class is defined and implements the CouponInterface.
     *
     * @return bool True if the coupon class is defined and valid, false otherwise.
     */
    public static function exists_coupon_class(): bool {
        $couponclass = self::get_coupon_class_name();

        return $couponclass &&
            class_exists($couponclass) &&
            in_array('enrol_cart\object\CouponInterface', class_implements($couponclass));
    }

    /**
     * Checks if the coupon functionality is enabled in the configuration.
     *
     * @return bool True if the coupon functionality is enabled, false otherwise.
     */
    public static function is_coupon_enable(): bool {
        return CartHelper::get_config('coupon_enable') && static::exists_coupon_class();
    }

    /**
     * Retrieves the ID of a coupon based on its code.
     *
     * @param string $couponcode The code of the coupon.
     * @return int|null The ID of the coupon, or null if not found or disabled.
     */
    public static function get_coupon_id(string $couponcode): ?int {
        if (!self::is_coupon_enable()) {
            return null;
        }

        /** @var CouponInterface $couponclassname */
        $couponclassname = self::get_coupon_class_name();

        return $couponclassname::get_coupon_id($couponcode);
    }

    /**
     * Validates a coupon for a given cart.
     *
     * @param CartDto $cart The cart to validate the coupon for.
     * @param int $couponid The ID of the coupon to validate.
     * @return CouponResultDto The result of the coupon validation.
     */
    public static function coupon_validate(CartDto $cart, int $couponid): CouponResultDto {
        if (!self::is_coupon_enable()) {
            return new CouponResultDto();
        }

        /** @var CouponInterface $couponclassname */
        $couponclassname = self::get_coupon_class_name();

        return $couponclassname::validate_coupon($cart, $couponid);
    }

    /**
     * Applies a coupon to a given cart.
     *
     * @param CartDto $cart The cart to apply the coupon to.
     * @param int $couponid The ID of the coupon to apply.
     * @return CouponResultDto The result of the coupon application.
     */
    public static function coupon_apply(CartDto $cart, int $couponid): CouponResultDto {
        if (!static::is_coupon_enable()) {
            return new CouponResultDto();
        }

        /** @var CouponInterface $couponclassname */
        $couponclassname = self::get_coupon_class_name();

        return $couponclassname::apply_coupon($cart, $couponid);
    }

    /**
     * Cancels the usage of a coupon for a given cart.
     *
     * @param CartDto $cart The cart to cancel the coupon for.
     * @return CouponResultDto The result of the coupon cancellation.
     */
    public static function coupon_cancel(CartDto $cart): CouponResultDto {
        if (!static::is_coupon_enable()) {
            return new CouponResultDto();
        }

        /** @var CouponInterface $couponclassname */
        $couponclassname = self::get_coupon_class_name();

        return $couponclassname::cancel_coupon($cart);
    }
}
