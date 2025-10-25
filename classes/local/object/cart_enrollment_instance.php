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

use dml_exception;
use enrol_cart\local\availability\info;
use enrol_cart\local\formatter\currency_formatter;
use enrol_cart\local\helper\cart_helper;
use moodle_url;

/**
 * Class cart_enrollment_instance
 *
 * Represents an instance of cart enrollment with various attributes and methods to manage enrollment details.
 *
 * @property int $id Unique identifier for the enrollment instance.
 * @property int $status Status of the enrollment instance.
 * @property int $course_id ID of the associated course.
 * @property string $name Name of the enrollment instance.
 * @property string $cost Cost of the enrollment.
 * @property int $discount_type Type of the discount applied (e.g., percentage or fixed amount).
 * @property string $discount_amount Amount of the discount.
 * @property string $currency Currency used for the cost.
 * @property int $enrol_start_date Start date of the enrollment.
 * @property int $enrol_end_date End date of the enrollment.
 * @property string $instructions Enrollment instructions text.
 * @property string $enrol_groups Groups the user will be added to after enrollment.
 * @property string $availability_conditions_json JSON string containing availability conditions.
 *
 * @property float $has_discount Whether the enrollment has a discount.
 * @property string $discount_percentage The discount percentage if applicable.
 * @property string $discount_percentage_formatted Formatted discount percentage.
 * @property float $applied_discount Calculated discount amount based on the discount percentage and price.
 * @property string $applied_discount_formatted Formatted discount amount.
 * @property float $price Original price before discount.
 * @property float $payable Final payable amount after applying the discount.
 * @property string $price_formatted Formatted string of the original price.
 * @property string $payable_formatted Formatted string of the final payable amount.
 * @property string $add_to_cart_url The URL to add the current enrolment instance to the cart.
 */
class cart_enrollment_instance extends base_model {
    use discount_type_trait;

    /**
     * Retrieves the attributes of the cart enrollment instance.
     *
     * @return array An array of enrollment attributes.
     */
    public function attributes(): array {
        return [
            'id',
            'status',
            'course_id',
            'name',
            'discount_type',
            'discount_amount',
            'cost',
            'currency',
            'enrol_start_date',
            'enrol_end_date',
            'instructions',
            'enrol_groups',
            'availability_conditions_json',
        ];
    }

    /**
     * Finds all cart enrollment instances by the given course ID.
     *
     * @param int $courseid The ID of the course to find enrollments for.
     * @return array An array of cart_enrollment_instance objects for the specified course.
     * @throws dml_exception If there is an error accessing the database.
     */
    public static function find_all_by_course_id(int $courseid): array {
        global $DB;

        // SQL query to fetch all enrollment instances for the specified course ID.
        $rows = $DB->get_records_sql(
            'SELECT id, enrol, status, courseid as course_id, name, customint1 as discount_type, customchar1 as discount_amount,
       cost, currency, enrolstartdate as enrol_start_date, enrolenddate as enrol_end_date, customtext1 as instructions,
       customchar2 as enrol_groups, customtext2 as availability_conditions_json
             FROM {enrol}
             WHERE enrol = :enrol AND status = :status AND courseid = :course_id
             ORDER BY sortorder ASC',
            ['enrol' => 'cart', 'status' => ENROL_INSTANCE_ENABLED, 'course_id' => $courseid],
        );

        return static::populate($rows);
    }

    /**
     * Finds a cart enrollment instance by its ID.
     *
     * @param int $instanceid The ID of the enrollment instance to find.
     * @return self The cart_enrollment_instance object corresponding to the specified ID.
     * @throws dml_exception If there is an error accessing the database.
     */
    public static function find_one_by_id(int $instanceid): self {
        global $DB;

        // SQL query to fetch the enrollment instance for the specified ID.
        $row = $DB->get_record_sql(
            'SELECT id, enrol, status, courseid as course_id, name, customint1 as discount_type, customchar1 as discount_amount,
       cost, currency, enrolstartdate as enrol_start_date, enrolenddate as enrol_end_date, customtext1 as instructions,
       customchar2 as enrol_groups, customtext2 as availability_conditions_json
             FROM {enrol}
             WHERE id = :instance_id AND enrol = :enrol AND status = :status',
            ['enrol' => 'cart', 'status' => ENROL_INSTANCE_ENABLED, 'instance_id' => $instanceid],
        );

        return static::populate_one($row);
    }

    /**
     * Post-processing after finding an enrollment instance.
     *
     * Ensures that the currency attribute is set to the default if not already set.
     *
     * @return void
     */
    public function after_find() {
        if (empty($this->currency)) {
            $this->currency = (string)cart_helper::get_config('payment_currency');
        }
    }

    /**
     * Retrieves the groups associated with the enrollment.
     *
     * @return array An array of group IDs split by commas.
     */
    public function get_enrol_groups(): array {
        return explode(',', $this->enrol_groups);
    }

    /**
     * Checks if the enrollment has a discount.
     *
     * @return bool True if there is a discount, otherwise false.
     */
    public function get_has_discount(): bool {
        return (bool)$this->applied_discount;
    }

    /**
     * Gets the discount percentage if the discount type is percentage.
     *
     * @return int|null The discount percentage or null if not applicable.
     */
    public function get_discount_percentage(): ?int {
        if ($this->is_discount_type_percentage) {
            return ceil($this->discount_amount);
        }

        if ($this->is_discount_type_fixed) {
            $payable = $this->price - $this->discount_amount;
            return 100 - floor(($payable * 100) / $this->price);
        }

        return null;
    }

    /**
     * Gets the formatted discount percentage.
     *
     * @return string|null The formatted discount percentage or null if not applicable.
     */
    public function get_discount_percentage_formatted(): ?string {
        $discountpercentage = $this->discount_percentage;

        if ($discountpercentage) {
            $discountpercentage = '%' . $discountpercentage;
            if (cart_helper::get_config('convert_numbers_to_persian')) {
                return currency_formatter::convert_english_numbers_to_persian($discountpercentage);
            }

            return $discountpercentage;
        }

        return null;
    }

    /**
     * Calculates the discount amount.
     *
     * @return float|null The discount amount or null if not applicable.
     */
    public function get_applied_discount() {
        if ($this->is_discount_type_fixed && $this->discount_amount <= $this->price) {
            return $this->discount_amount;
        }

        if (
            $this->is_discount_type_percentage &&
            ctype_digit(strval($this->discount_amount)) &&
            $this->discount_amount >= 0 &&
            $this->discount_amount <= 100
        ) {
            return ($this->discount_amount * $this->price) / 100;
        }

        return null;
    }

    /**
     * Gets the formatted discount amount.
     *
     * @return string|null The formatted discount amount or null if not applicable.
     */
    public function get_applied_discount_formatted(): ?string {
        $discountamount = $this->applied_discount;

        return $discountamount ? currency_formatter::get_cost_as_formatted($discountamount, $this->currency) : null;
    }

    /**
     * Returns the original price amount before discount.
     *
     * @return float The original price amount.
     */
    public function get_price(): float {
        return (float)$this->cost;
    }

    /**
     * Returns the formatted original price.
     *
     * @return string|null The formatted original price string, or 'free' if the price is zero.
     */
    public function get_price_formatted(): ?string {
        if ($this->price !== null && (float)$this->price > 0) {
            return currency_formatter::get_cost_as_formatted($this->price, $this->currency);
        }

        return get_string('free', 'enrol_cart');
    }

    /**
     * Returns the final payable amount after applying the discount.
     *
     * @return float The final payable amount.
     */
    public function get_payable(): float {
        $applieddiscount = $this->applied_discount;
        return $applieddiscount ? $this->price - $applieddiscount : $this->price;
    }

    /**
     * Returns the formatted final payable amount.
     *
     * @return string The formatted payable amount string, or 'free' if the payable amount is zero.
     */
    public function get_payable_formatted(): string {
        if ($this->payable !== null && (float)$this->payable > 0) {
            return currency_formatter::get_cost_as_formatted($this->payable, $this->currency);
        }

        return get_string('free', 'enrol_cart');
    }

    /**
     * Generates the URL to add the current instance to the shopping cart.
     *
     * This method creates a moodle_url object which points to the enrolment
     * cart script, specifying the action to add the current enrolment instance
     * to the shopping cart.
     *
     * @return moodle_url The URL to add the current enrolment instance to the cart.
     */
    public function get_add_to_cart_url(): moodle_url {
        return new moodle_url('/enrol/cart/do.php', [
            'action' => 'add', // Specifies the action to be performed: adding an instance to the cart.
            'instance' => $this->id, // The ID of the current enrolment instance.
        ]);
    }

    /**
     * Determines whether a user can enroll based on availability conditions.
     *
     * @param int|null $userid The ID of the user to check enrollment for. Defaults to the current user's ID if not provided.
     * @param string|null $information Additional information regarding availability, passed by reference.
     * @return bool True if the user can enroll, otherwise false.
     */
    public function can_enrol_user(?int $userid = null, ?string &$information = ''): bool {
        global $USER;
        if (empty($userid)) {
            $userid = $USER->id;
        }

        if (!empty($userid) && !empty($this->availability_conditions_json)) {
            $info = new info($this);
            return $info->is_available($information, false, $userid);
        }

        return true;
    }
}
