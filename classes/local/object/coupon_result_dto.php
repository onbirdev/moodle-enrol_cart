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

use enrol_cart\local\helper\coupon_helper;

/**
 * Class coupon_result_dto
 * Represents the result of a coupon process.
 *
 * This class is used to encapsulate the result of coupon operations, including validation, application,
 * and cancellation, providing detailed information about the status and effects of the coupon.
 */
class coupon_result_dto {
    /**
     * @var bool Indicates if the coupon process is successful.
     */
    private bool $ok = false;

    /**
     * @var int|null The ID of the coupon.
     */
    private ?int $couponid = null;

    /**
     * @var string|null The code of the coupon.
     */
    private ?string $couponcode = null;

    /**
     * @var string|null The error code if the coupon is invalid.
     */
    private ?string $errorcode = null;

    /**
     * @var string|null The error message if the coupon is invalid.
     */
    private ?string $errormessage = null;

    /**
     * @var float|null The discount amount provided by the coupon.
     */
    private ?float $discountamount = null;

    /**
     * @var float|null The payable amount after applying the coupon.
     */
    private ?float $payableamount = null;

    /**
     * @var array|null The items affected by the coupon.
     */
    private ?array $items = [];

    /**
     * @var int|null The usage ID of the coupon.
     */
    private ?int $couponusageid = null;

    /**
     * CouponResult constructor.
     * Initializes the CouponResult object and checks if the coupon functionality is enabled.
     */
    public function __construct() {
        if (!coupon_helper::is_coupon_enable()) {
            $this->set_ok(false);
            $this->set_error_message(get_string('error_coupon_disabled', 'enrol_cart'));
        }
    }

    /**
     * Returns whether the coupon process is successful.
     *
     * @return bool True if the coupon process is successful, false otherwise.
     */
    public function is_ok(): bool {
        return $this->ok;
    }

    /**
     * Sets the status of the coupon process.
     *
     * @param bool $ok The process status.
     * @return coupon_result_dto The current instance for method chaining.
     */
    public function set_ok(bool $ok): coupon_result_dto {
        $this->ok = $ok;
        return $this;
    }

    /**
     * Returns the coupon ID.
     *
     * @return int|null The coupon ID.
     */
    public function get_coupon_id(): ?int {
        return $this->couponid;
    }

    /**
     * Sets the coupon ID.
     *
     * @param int|null $couponid The coupon ID.
     * @return coupon_result_dto The current instance for method chaining.
     */
    public function set_coupon_id(?int $couponid): coupon_result_dto {
        $this->couponid = $couponid;
        return $this;
    }

    /**
     * Returns the coupon code.
     *
     * @return string|null The coupon code.
     */
    public function get_coupon_code(): ?string {
        return $this->couponcode;
    }

    /**
     * Sets the coupon code.
     *
     * @param string|null $couponcode The coupon code.
     * @return coupon_result_dto The current instance for method chaining.
     */
    public function set_coupon_code(?string $couponcode): coupon_result_dto {
        $this->couponcode = $couponcode;
        return $this;
    }

    /**
     * Returns the error code if the coupon is invalid.
     *
     * @return string|null The error code.
     */
    public function get_error_code(): ?string {
        return $this->errorcode;
    }

    /**
     * Sets the error code.
     *
     * @param string|null $errorcode The error code.
     * @return coupon_result_dto The current instance for method chaining.
     */
    public function set_error_code(?string $errorcode): coupon_result_dto {
        $this->errorcode = $errorcode;
        return $this;
    }

    /**
     * Returns the error message if the coupon is invalid.
     *
     * @return string|null The error message.
     */
    public function get_error_message(): ?string {
        return $this->errormessage;
    }

    /**
     * Sets the error message.
     *
     * @param string|null $errormessage The error message.
     * @return coupon_result_dto The current instance for method chaining.
     */
    public function set_error_message(?string $errormessage): coupon_result_dto {
        $this->errormessage = $errormessage;
        return $this;
    }

    /**
     * Returns the discount amount.
     *
     * @return float|null The discount amount.
     */
    public function get_discount_amount(): ?float {
        return $this->discountamount;
    }

    /**
     * Sets the discount amount.
     *
     * @param float|null $discountamount The discount amount.
     * @return coupon_result_dto The current instance for method chaining.
     */
    public function set_discount_amount(?float $discountamount): coupon_result_dto {
        $this->discountamount = $discountamount;
        return $this;
    }

    /**
     * Returns the payable amount after applying the coupon.
     *
     * @return float|null The payable amount.
     */
    public function get_payable_amount(): ?float {
        return $this->payableamount;
    }

    /**
     * Sets the payable amount.
     *
     * @param float|null $payableamount The payable amount.
     * @return coupon_result_dto The current instance for method chaining.
     */
    public function set_payable_amount(?float $payableamount): coupon_result_dto {
        $this->payableamount = $payableamount;
        return $this;
    }

    /**
     * Returns the items affected by the coupon.
     *
     * @return array|null The items affected by the coupon.
     */
    public function get_items(): ?array {
        return $this->items;
    }

    /**
     * Sets the items affected by the coupon.
     *
     * @param array|null $items The items affected by the coupon.
     * @return coupon_result_dto The current instance for method chaining.
     */
    public function set_items(?array $items): coupon_result_dto {
        $this->items = $items;
        return $this;
    }

    /**
     * Returns the usage ID of the coupon.
     *
     * @return int|null The coupon usage ID.
     */
    public function get_coupon_usage_id(): ?int {
        return $this->couponusageid;
    }

    /**
     * Sets the usage ID of the coupon.
     *
     * @param int|null $couponusageid The coupon usage ID.
     * @return coupon_result_dto The current instance for method chaining.
     */
    public function set_coupon_usage_id(?int $couponusageid): coupon_result_dto {
        $this->couponusageid = $couponusageid;
        return $this;
    }
}
