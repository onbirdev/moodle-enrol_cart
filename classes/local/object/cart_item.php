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

use enrol_cart\local\formatter\currency_formatter;
use enrol_cart\local\helper\cart_helper;
use moodle_exception;
use moodle_url;

/**
 * Class cart_item
 *
 * Represents an item in a shopping cart and extends the functionality provided by base_model.
 *
 * @property int $id The unique identifier for the cart item.
 * @property int $cart_id The ID of the cart to which this item belongs.
 * @property int $instance_id The ID of the enrolment instance associated with this item.
 * @property float $price The price of the enrolment associated with this item.
 * @property float $payable The payable amount for the enrolment associated with this item.
 *
 * @property string $price_formatted The human-readable price.
 * @property string $payable_formatted The human-readable payable amount.
 *
 * @property course $course The course object associated with this item.
 * @property cart|cookie_cart $cart The cart object associated with this item.
 *
 * @property moodle_url $view_url The URL for viewing the course associated with this item.
 * @property moodle_url $remove_url The URL for removing this item from the cart.
 *
 * @property bool $has_discount Indicates whether the item has a discount.
 * @property int $discount_percent The discount percentage applied to the item.
 * @property string $discount_percent_formatted The formatted discount percentage.
 */
class cart_item extends base_model {
    /** @var cart|cookie_cart|null The cart object associated with this item. */
    private $_cart;
    /** @var course|null The course object associated with this item. */
    private ?course $_course = null;

    /**
     * Defines the attributes of the cart_item model.
     *
     * @return array The attributes of the cart_item model.
     */
    public function attributes(): array {
        return ['id', 'cart_id', 'instance_id', 'price', 'payable'];
    }

    /**
     * Retrieves all cart items associated with a given cart ID.
     *
     * @param int $cartid The ID of the cart.
     * @return cart_item[] An array of cart_item objects.
     */
    public static function find_all(int $cartid): array {
        global $DB; // Global database object.

        // Fetches all cart items for the specified cart ID.
        $rows = $DB->get_records('enrol_cart_items', ['cart_id' => $cartid], 'id ASC');

        return static::populate($rows);
    }

    /**
     * Deletes the cart item from the database.
     *
     * @return bool True if the item is successfully deleted, false otherwise.
     */
    public function delete(): bool {
        global $DB; // Global database object.

        // Checks if the item exists in the database and deletes it.
        if ($this->id && $this->cart_id) {
            return $DB->delete_records('enrol_cart_items', ['id' => $this->id]);
        }

        return false;
    }

    /**
     * Called after retrieving a cart item from the database.
     * Populates additional attributes and strings for convenient usage.
     *
     * @return void
     */
    public function after_find() {
        // This method can be used to perform any additional tasks after retrieving a cart item.
    }

    /**
     * Adds an item to the cart.
     *
     * This method creates a cart item record in the {enrol_cart_items} table.
     *
     * @param int $cartid The ID of the cart.
     * @param int $instanceid The ID of the enrolment instance to be added to the cart.
     * @return bool True if the item is successfully added, false otherwise.
     */
    public static function add_item_to_cart(int $cartid, int $instanceid): bool {
        global $DB;

        // Check if the item does not already exist in the cart, and check if the instance exists.
        if (
            !$DB->record_exists('enrol_cart_items', ['cart_id' => $cartid, 'instance_id' => $instanceid]) &&
            ($instance = cart_helper::get_instance($instanceid))
        ) {
            // Create a new cart item object.
            $item = (object) [
                'cart_id' => $cartid,
                'instance_id' => $instance->id,
                'price' => $instance->price,
                'payable' => $instance->payable,
            ];

            // Insert the item into the database.
            return $DB->insert_record('enrol_cart_items', $item);
        }

        return false;
    }

    /**
     * Updates the item price and payable value from the instance record.
     *
     * @return void
     */
    public function update_price_and_payable() {
        if (!$this->cart->can_edit_items) {
            return;
        }

        $instance = cart_helper::get_instance($this->instance_id);

        // Updates the price and payable amount if they have changed.
        if ($instance && ($this->price != $instance->price || $this->payable != $instance->payable)) {
            $this->price = $instance->price;
            $this->payable = $instance->payable;

            if ($this->id) {
                global $DB;
                $DB->update_record(
                    'enrol_cart_items',
                    (object) [
                        'id' => $this->id,
                        'price' => $this->price,
                        'payable' => $this->payable,
                    ],
                );
            }
        }
    }

    /**
     * Retrieves the cart model associated with this item.
     *
     * @return cart|cookie_cart|null The cart model associated with this item.
     */
    public function get_cart() {
        if (!$this->_cart) {
            $this->_cart = $this->cart_id ? cart::find_one($this->cart_id) : new cookie_cart();
        }

        return $this->_cart;
    }

    /**
     * Retrieves the course object associated with the item.
     *
     * @return course|null The course object associated with the item.
     */
    public function get_course(): ?course {
        if (!$this->_course) {
            $this->_course = course::find_one_by_instance_id($this->instance_id);
        }

        return $this->_course;
    }

    /**
     * Checks if the item has a discount applied.
     *
     * @return bool True if the item has a discount, false otherwise.
     */
    public function get_has_discount(): bool {
        return $this->price - $this->payable > 0;
    }

    /**
     * Retrieves the discount percentage applied to the item.
     *
     * @return int|null The discount percentage or null if no discount is applied.
     */
    public function get_discount_percent(): ?int {
        if ($this->has_discount) {
            return 100 - floor(($this->payable * 100) / $this->price);
        }

        return null;
    }

    /**
     * Retrieves the formatted discount percentage.
     *
     * @return string|null The formatted discount percentage or null if no discount is applied.
     */
    public function get_discount_percent_formatted(): ?string {
        $discountpercent = $this->discount_percent;

        if ($discountpercent) {
            $discountpercent = $discountpercent . '%';
            if (cart_helper::get_config('convert_numbers_to_persian')) {
                return currency_formatter::convert_english_numbers_to_persian($discountpercent);
            }

            return $discountpercent;
        }

        return null;
    }

    /**
     * Returns the price as a human-readable format.
     *
     * @return string The formatted price string.
     */
    public function get_price_formatted(): string {
        if ($this->price > 0) {
            return currency_formatter::get_cost_as_formatted((float) $this->price, $this->cart->final_currency);
        }

        return get_string('free', 'enrol_cart'); // Return 'free' string if price is zero.
    }

    /**
     * Returns the payable amount as a human-readable format.
     *
     * @return string The formatted payable string.
     */
    public function get_payable_formatted(): string {
        if ($this->payable > 0) {
            return currency_formatter::get_cost_as_formatted((float) $this->payable, $this->cart->final_currency);
        }

        return get_string('free', 'enrol_cart'); // Return 'free' string if payable is zero.
    }

    /**
     * Retrieves the URL for viewing the course associated with this item.
     *
     * @return moodle_url The URL for viewing the course.
     * @throws moodle_exception Thrown when moodle_url instantiation fails.
     */
    public function get_view_url(): moodle_url {
        return new moodle_url('/course/view.php', ['id' => $this->course->id]);
    }

    /**
     * Retrieves the URL for removing this item from the cart.
     *
     * @return moodle_url The URL for removing the item.
     * @throws moodle_exception Thrown when moodle_url instantiation fails.
     */
    public function get_remove_url(): moodle_url {
        return new moodle_url('/enrol/cart/do.php', ['action' => 'remove', 'instance' => $this->instance_id]);
    }
}
