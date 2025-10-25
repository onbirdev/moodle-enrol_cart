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
use moodle_url;

/**
 * The base_cart class provides a foundation for shopping cart functionality.
 *
 * @property cart_item[] $items An array of cart items.
 * @property int $count The total count of items in the cart.
 * @property bool $is_empty Returns true if there are no items in the cart.
 * @property bool $is_current_user_owner Returns true if the current user ID matches the cart owner's user ID, false otherwise.
 * @property bool $can_edit_items Whether items in the cart can be edited (true/false).
 * @property int $payment_account_id The cart payment account ID.
 *
 * @property string $final_currency The final currency code used in the cart.
 * @property float|int $final_price The total price of items in the cart.
 * @property float|int $final_payable The total amount payable after discounts.
 * @property float|int $items_discount_amount The items discount amount.
 * @property float|int $final_discount_amount The total discount amount applied.
 * @property string $final_price_formatted The formatted total price.
 * @property string $final_payable_formatted The formatted total payable amount.
 * @property string $items_discount_amount_formatted The formatted items discount amount.
 * @property string $final_discount_amount_formatted The formatted discount amount.
 *
 * @property moodle_url $view_url The URL for viewing the cart.
 * @property moodle_url $checkout_url The URL for checkout the cart.
 */
abstract class base_cart extends base_model {
    use cart_status_trait;

    /** @var array An array of the cart items */
    protected array $_items = [];

    /**
     * {@inheritdoc}
     */
    public function init() {
        $this->set_attribute('id', 0);
        $this->set_attribute('user_id', 0);
        $this->set_attribute('status', cart_status_interface::STATUS_CURRENT);
    }

    /**
     * {@inheritdoc}
     * @return string[]
     */
    public function attributes(): array {
        return ['id', 'user_id', 'status'];
    }

    /**
     * Retrieve the currency used in the cart.
     *
     * @return string The currency code.
     */
    public function get_final_currency(): string {
        return (string) cart_helper::get_config('payment_currency');
    }

    /**
     * Returns the total price of items in the cart.
     *
     * @return float|int The total price amount.
     */
    public function get_final_price() {
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item->price;
        }

        return $price;
    }

    /**
     * Returns the formatted total price of items in the cart.
     *
     * @return string The formatted price string.
     */
    public function get_final_price_formatted(): string {
        if ($this->final_price > 0) {
            return currency_formatter::get_cost_as_formatted($this->final_price, $this->final_currency);
        }

        return get_string('free', 'enrol_cart');
    }

    /**
     * Returns the total payable amount after discounts.
     *
     * @return float|int The total payable amount.
     */
    public function get_final_payable() {
        $payable = 0;
        foreach ($this->items as $item) {
            $payable += $item->payable;
        }

        return $payable;
    }

    /**
     * Returns the formatted total payable amount after discounts.
     *
     * @return string The formatted payable string.
     */
    public function get_final_payable_formatted(): string {
        if ($this->final_payable > 0) {
            return currency_formatter::get_cost_as_formatted($this->final_payable, $this->final_currency);
        }

        return get_string('free', 'enrol_cart');
    }

    /**
     * Returns the items discount amount applied.
     *
     * @return float|int The discount amount.
     */
    public function get_items_discount_amount() {
        $payable = 0;
        $price = 0;
        foreach ($this->items as $item) {
            $payable += $item->payable;
            $price += $item->price;
        }
        return $price - $payable;
    }

    /**
     * Returns the formatted items discount amount.
     *
     * @return string|null The formatted discount amount string.
     */
    public function get_items_discount_amount_formatted(): ?string {
        if ($this->items_discount_amount) {
            return currency_formatter::get_cost_as_formatted((float) $this->items_discount_amount, $this->final_currency);
        }

        return null;
    }

    /**
     * Returns the total discount amount applied.
     *
     * @return float|int The discount amount.
     */
    public function get_final_discount_amount() {
        return $this->final_price - $this->final_payable;
    }

    /**
     * Returns the formatted discount amount.
     *
     * @return string|null The formatted discount amount string.
     */
    public function get_final_discount_amount_formatted(): ?string {
        if ($this->final_discount_amount) {
            return currency_formatter::get_cost_as_formatted((float) $this->final_discount_amount, $this->final_currency);
        }

        return null;
    }

    /**
     * Returns the total count of items in the cart.
     *
     * @return int The total count of items.
     */
    public function get_count(): int {
        return count($this->items);
    }

    /**
     * Checks if the cart is empty.
     *
     * @return bool True if the cart is empty, false otherwise.
     */
    public function get_is_empty(): bool {
        return empty($this->items);
    }

    /**
     * Check if the current user is the owner of the cart.
     *
     * @return bool Returns true if the current user ID matches the cart owner's user ID, false otherwise.
     */
    public function get_is_current_user_owner(): bool {
        global $USER;
        return !$USER->id || (isset($this->user_id) && $USER->id == $this->user_id);
    }

    /**
     * Check if items in the shopping cart can be edited.
     *
     * @return bool Returns true if the cart is currently active and items can be edited, false otherwise.
     */
    public function get_can_edit_items(): bool {
        return $this->is_current && $this->is_current_user_owner;
    }

    /**
     * Retrieves the cart payment account ID.
     *
     * @return int The cart payment account ID.
     */
    public function get_payment_account_id(): int {
        return (int) cart_helper::get_config('payment_account');
    }

    /**
     * Adds a course to the cart.
     *
     * @param int $courseid The ID of the course to be added to the cart.
     * @return bool True if the course is successfully added, false otherwise.
     */
    public function add_course(int $courseid): bool {
        $instanceid = cart_helper::get_course_instance_id($courseid);
        if ($instanceid) {
            return $this->add_item($instanceid);
        }

        return false;
    }

    /**
     * Removes a course from the cart.
     *
     * @param int $courseid The ID of the course to be removed from the cart.
     * @return bool True if the course is successfully removed, false otherwise.
     */
    public function remove_course(int $courseid): bool {
        $instanceid = cart_helper::get_course_instance_id($courseid);
        if ($instanceid) {
            return $this->remove_item($instanceid);
        }

        return false;
    }

    /**
     * Checks if the cart contains an item with the specified enrolment instance ID.
     *
     * @param int $instanceid The enrolment instance ID to check.
     * @return bool True if the item is in the cart, false otherwise.
     */
    public function has_item(int $instanceid): bool {
        foreach ($this->items as $item) {
            if ($item->instance_id == $instanceid) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determines if the user can add an item to the cart.
     *
     * @param int $instanceid The enrolment instance ID to check.
     * @param null|string $information Output parameter to store additional information about the enrolment status.
     * @return bool True if the user can add the item, false otherwise.
     */
    public function can_add_item(int $instanceid, ?string &$information = ''): bool {
        // If the user is not logged in, then it can be added. (cookie cart).
        if (empty($this->user_id)) {
            return true;
        }

        return cart_helper::can_user_enrol($instanceid, $this->user_id, $information);
    }

    /**
     * Refreshes the cart items.
     *
     * @return bool
     */
    public function refresh(): bool {
        $this->_items = [];

        return true;
    }

    /**
     * Retrieves the URL for viewing the cart associated with this item.
     *
     * @return moodle_url The URL for viewing the cart.
     */
    public function get_view_url(): moodle_url {
        return cart_helper::get_cart_view_url($this->id ?? null);
    }

    /**
     * Retrieves the URL for checkout the cart associated with this item.
     *
     * @return moodle_url The URL for viewing the cart.
     */
    public function get_checkout_url(): moodle_url {
        return cart_helper::get_cart_checkout_url($this->id ?? null);
    }

    /**
     * Adds an enrol item to the cart.
     *
     * @param int $instanceid The enrolment instance ID to be added to the cart.
     * @return bool True if the item is successfully added, false otherwise.
     */
    abstract public function add_item(int $instanceid): bool;

    /**
     * Removes an enrol item from the cart.
     *
     * @param int $instanceid The enrolment instance ID to be removed from the cart.
     * @return bool True if the item is successfully removed, false otherwise.
     */
    abstract public function remove_item(int $instanceid): bool;

    /**
     * Returns an array of cart items.
     *
     * @return cart_item[] An array of cart_item objects representing the cart items.
     */
    abstract public function get_items(): array;

    /**
     * Initiates the checkout process for the cart.
     *
     * This method typically handles the necessary steps to finalize a purchase,
     * such as payment processing and order confirmation.
     *
     * @return bool True if the checkout process is successful, false otherwise.
     */
    abstract public function checkout(): bool;

    /**
     * Cancels the cart and removes associated items.
     *
     * This method is used to cancel the current cart, removing any items
     * that were added to it during the shopping session.
     *
     * @return bool True if the cart cancellation is successful, false otherwise.
     */
    abstract public function cancel(): bool;

    /**
     * Delivers the items in the cart to the user.
     *
     * This method is responsible for processing and delivering the selected items
     * to the user, typically by enrolling them in courses or finalizing any other
     * relevant transactions associated with the cart items.
     *
     * @return bool True if the delivery process is successful, false otherwise.
     */
    abstract public function deliver(): bool;
}
