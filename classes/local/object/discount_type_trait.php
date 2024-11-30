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

use coding_exception;

/**
 * Trait providing methods related to coupon discount types.
 *
 * @property int $discount_type
 * @property string $discount_type_name
 * @property bool $is_discount_type_percentage
 * @property bool $is_discount_type_fixed
 */
trait discount_type_trait {
    /**
     * Retrieve a list of available coupon discount type options.
     *
     * @return array An array of discount type options.
     */
    public static function get_discount_type_options(): array {
        return [
            discount_type_interface::NO_DISCOUNT => get_string('no_discount', 'enrol_cart'),
            discount_type_interface::PERCENTAGE => get_string('percentage', 'enrol_cart'),
            discount_type_interface::FIXED => get_string('fixed', 'enrol_cart'),
        ];
    }

    /**
     * Retrieve the name of the discount type.
     *
     * @return string The name of the discount type.
     * @throws coding_exception If the discount type is unknown.
     */
    public function get_discount_type_name(): string {
        $options = static::get_discount_type_options();
        return $options[$this->discount_type] ?? get_string('unknown', 'enrol_cart');
    }

    /**
     * Check if the discount type is no discount.
     *
     * @return bool True if the discount type is no discount, false otherwise.
     */
    public function get_is_discount_type_no_discount(): bool {
        return discount_type_interface::NO_DISCOUNT == $this->discount_type;
    }

    /**
     * Check if the discount type is percentage.
     *
     * @return bool True if the discount type is percentage, false otherwise.
     */
    public function get_is_discount_type_percentage(): bool {
        return discount_type_interface::PERCENTAGE == $this->discount_type;
    }

    /**
     * Check if the discount type is fixed.
     *
     * @return bool True if the discount type is fixed, false otherwise.
     */
    public function get_is_discount_type_fixed(): bool {
        return discount_type_interface::FIXED == $this->discount_type;
    }
}
