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

use core\notification;
use dml_exception;
use enrol_cart\local\formatter\currency_formatter;
use enrol_cart\local\helper\cart_helper;
use enrol_cart\local\helper\coupon_helper;
use Exception;

/**
 * Class cart
 *
 * Represents a shopping cart and extends functionality from base_cart.
 * Provides methods to manage cart items, handle coupon discounts, and process enrolments.
 *
 * @property int $id The unique identifier for the cart.
 * @property int $user_id The user ID associated with the cart.
 * @property int $status The status of the cart (e.g., active, checkout, delivered).
 * @property string|null $currency The currency code for the cart (e.g., USD, EUR).
 * @property float|null $price The total price of items in the cart.
 * @property float|null $payable The total payable amount after apply discount, tax, ....
 * @property int|null $coupon_id The ID of the applied coupon, if any.
 * @property int|null $coupon_usage_id The ID of the coupon user usage record.
 * @property array|null $data Additional data related to the cart.
 * @property int|null $checkout_at The timestamp when the cart status changed for checkout.
 * @property int $created_at The timestamp when the cart was created.
 * @property int $created_by The user ID who created the cart.
 * @property int|null $updated_at The timestamp when the cart was last updated.
 * @property int|null $updated_by The user ID who last updated the cart.
 *
 * @property bool $has_changed Returns true if the cart has changed, false otherwise.
 * @property bool $is_checkout_expired Returns true if the checkout session has expired, false otherwise.
 * @property bool $is_final_payable_zero Check if the cart's payable amount is zero
 *
 * @property user $user The user object associated with this cart.
 * @property cart_item[] $items An array of cart_item objects representing the items in the cart.
 *
 * @property bool $has_coupon Checks if a coupon is applied to the cart.
 * @property bool $can_use_coupon Determines if a coupon can be used with the cart.
 * @property string|null $coupon_code The code of the last applied coupon, if any.
 * @property string|null $coupon_error_code The error code from the last applied coupon, if any.
 * @property string|null $coupon_error_message The error message from the last applied coupon, if any.
 * @property float|null $coupon_discount_amount The discount amount from the applied coupon.
 * @property string|null $coupon_discount_amount_formatted The formatted coupon discount amount.
 *
 */
class cart extends base_cart {
    /**
     * @var bool Indicates if the cart has been changed since last save.
     */
    private bool $_changed = false;

    /**
     * @var coupon_result_dto Holds the result details of the last applied coupon.
     */
    private coupon_result_dto $_coupon_result;

    /**
     * @var user|null The user associated with this cart, or null if not set.
     */
    private ?user $_user = null;

    /**
     * {@inheritDoc}
     */
    public function init() {
        $this->_coupon_result = new coupon_result_dto();
    }

    /**
     * {@inheritDoc}
     * @return string[]
     */
    public function attributes(): array {
        return [
            'id',
            'user_id',
            'status',
            'currency',
            'price',
            'payable',
            'coupon_id',
            'coupon_code',
            'coupon_usage_id',
            'coupon_discount_amount',
            'data',
            'checkout_at',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ];
    }

    /**
     * Retrieve the cart currency.
     *
     * @return string The currency code of the cart.
     */
    public function get_final_currency(): string {
        return $this->currency ?: parent::get_final_currency();
    }

    /**
     * Retrieve the cart price.
     *
     * @return float|int|null The total price of items in the cart.
     */
    public function get_final_price() {
        if ($this->is_delivered) {
            return $this->price;
        }

        return parent::get_final_price();
    }

    /**
     * Retrieve the cart payable.
     *
     * @return float|int|null The total payable amount of items in the cart.
     */
    public function get_final_payable() {
        if (!$this->can_edit_items) {
            return $this->payable;
        }

        $finalpayable = parent::get_final_payable();

        if ($this->has_coupon) {
            $finalpayable -= $this->coupon_discount_amount;
        }

        return $finalpayable;
    }

    /**
     * Retrieve the cart total payable.
     *
     * @return float|int|null The total payable amount of items in the cart.
     */
    public function get_final_total_payable() {
        if ($this->is_delivered) {
            return $this->payable;
        }

        $finaltotalpayable = parent::get_final_payable();

        if ($this->has_coupon) {
            $finaltotalpayable -= $this->coupon_discount_amount;
        }

        return $finaltotalpayable;
    }

    /**
     * Return the cart object.
     *
     * @param bool $forcenew Create an active cart on the database for the current user.
     * @return cart|null
     */
    public static function find_current(bool $forcenew = false): ?cart {
        global $DB, $USER;

        static $current = null;

        if (!$current) {
            $cart = $DB->get_record('enrol_cart', [
                'user_id' => $USER->id,
                'status' => cart_status_interface::STATUS_CURRENT,
            ]);
            if (!$cart && $forcenew) {
                $cart = (object)[
                    'user_id' => $USER->id,
                    'status' => cart_status_interface::STATUS_CURRENT,
                    'created_at' => time(),
                    'created_by' => $USER->id,
                ];
                $cart->id = $DB->insert_record('enrol_cart', $cart);
            }
            $current = $cart ? static::populate_one($cart) : null;
        }

        return $current;
    }

    /**
     * Return the cart object.
     *
     * @param int $id The ID of the cart to retrieve.
     * @return cart|null
     */
    public static function find_one(int $id): ?cart {
        global $DB;

        $cart = $DB->get_record('enrol_cart', [
            'id' => $id,
        ]);

        if ($cart) {
            return static::populate_one($cart);
        }

        return null;
    }

    /**
     * Retrieves an array of carts for a specific user, paginated by page number and limit.
     *
     * This method queries the database to get a list of user carts and paginates the results
     * based on the given page number and limit per page.
     *
     * @param int $userid The ID of the user whose carts are being retrieved.
     * @param int $page The current page number for pagination (starting from 0).
     * @param int $limit The number of records to return per page.
     * @return array An array of user carts. If no carts are found, returns an empty array.
     */
    public static function find_all_by_user_id(int $userid, int $page, int $limit): array {
        global $DB;

        $rows = $DB->get_records_sql(
            'SELECT * FROM {enrol_cart} WHERE user_id = :user_id ORDER BY id DESC',
            [
                'user_id' => $userid,
            ],
            $page * $limit,
            $limit,
        );

        if ($rows) {
            return static::populate($rows);
        }

        return [];
    }

    /**
     * Returns the total count of carts for a specific user.
     *
     * This method counts the number of cart records in the database for a given user.
     *
     * @param int $userid The ID of the user whose cart count is being retrieved.
     * @return int The total number of carts associated with the user.
     */
    public static function count_all_by_user_id(int $userid): int {
        global $DB;

        // Return the count of cart records associated with the user.
        return $DB->count_records('enrol_cart', [
            'user_id' => $userid,
        ]);
    }

    /**
     * Save cart to DB.
     *
     * @return bool
     * @throws dml_exception
     */
    public function save(): bool {
        global $DB, $USER;

        $data = [];
        foreach ($this->attributes() as $attribute) {
            $data[$attribute] = $this->$attribute;
        }

        // Create new record.
        if (empty($data['id'])) {
            $data['created_at'] = time();
            $data['created_by'] = $USER->id;
            $this->id = $DB->insert_record('enrol_cart', (object)$data);
            if (!$this->id) {
                return false;
            }
            return true;
        }

        // Update.
        $data['updated_at'] = time();
        $data['updated_by'] = $USER->id;

        return $DB->update_record('enrol_cart', (object)$data);
    }

    /**
     * Add an item to the cart.
     *
     * This method adds an enrolment instance to the shopping cart.
     *
     * @param int $instanceid The ID of the enrolment instance to be added to the cart.
     * @return bool True if the item is successfully added, false otherwise.
     */
    public function add_item(int $instanceid): bool {
        // Check if the user has permission to add items to the cart.
        if (!$this->can_add_item($instanceid, $information)) {
            if (!empty($information)) {
                notification::info($information);
            }
            return false;
        }

        // Check if the user has permission to edit items in the cart, and the item does not already exist in the cart.
        if ($this->can_edit_items && !$this->has_item($instanceid)) {
            // Ensure the user is not already enrolled in the instance, and add item to cart.
            if (
                !cart_helper::is_user_enrolled($instanceid, $this->user_id) &&
                cart_item::add_item_to_cart($this->id, $instanceid)
            ) {
                return $this->refresh();
            } else {
                $course = course::find_one_by_instance_id($instanceid);
                // User already enrolled.
                notification::info(
                    get_string('msg_enrolment_already', 'enrol_cart', [
                        'title' => $course ? $course->title : '',
                    ]),
                );
            }
        }

        return false;
    }

    /**
     * Remove an item from the cart.
     *
     * @param int $instanceid The ID of the enrolment instance to be removed from the cart.
     * @return bool True if the item is successfully removed, false otherwise.
     */
    public function remove_item(int $instanceid): bool {
        if ($this->can_edit_items) {
            foreach ($this->items as $item) {
                if ($item->instance_id == $instanceid && $item->delete()) {
                    return $this->refresh();
                }
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     * @return cart_item[] An array of cart_item objects representing the cart items.
     */
    public function get_items(): array {
        if (empty($this->_items)) {
            $this->_items = cart_item::find_all($this->id);
        }

        return $this->_items;
    }

    /**
     * Retrieves the user object associated with the cart.
     *
     * @return user|null The user object associated with the cart.
     */
    public function get_user(): ?user {
        if (!$this->_user) {
            $this->_user = user::find_one_id($this->user_id);
        }

        return $this->_user;
    }

    /**
     * Refresh the cart items.
     * Calculate the price and payable.
     * Remove disabled or invalid enrol items.
     *
     * @param bool $force
     * @return bool
     */
    public function refresh(bool $force = false): bool {
        if (!$this->can_edit_items && !$force) {
            return false;
        }

        $this->_changed = false;
        $this->_items = [];

        // Remove disabled or invalid enrol from the cart.
        $items = cart_item::find_all($this->id);
        foreach ($items as $item) {
            if (!cart_helper::has_instance($item->instance_id)) {
                $this->_changed = true;
                $item->delete();
                notification::info(get_string('msg_enrolment_deleted', 'enrol_cart'));
                continue;
            }

            if (cart_helper::is_user_enrolled($item->instance_id, $this->user_id)) {
                $this->_changed = true;
                $item->delete();
                notification::info(
                    get_string('msg_enrolment_already', 'enrol_cart', [
                        'title' => $item->course ? $item->course->title : '',
                    ]),
                );
                continue;
            }

            if (!cart_helper::can_user_enrol($item->instance_id, $this->user_id, $information)) {
                $this->_changed = true;
                $item->delete();
                if (!empty($information)) {
                    notification::info($information);
                }
                continue;
            }

            $item->update_price_and_payable();
        }

        // Set calculated price and payable.
        if ($this->price != $this->final_price || $this->payable != $this->final_payable) {
            $this->_changed = true;
            $this->price = $this->final_price;
            $this->payable = $this->final_payable;

            // Save changes.
            return $this->save();
        }

        return true;
    }

    /**
     * Check if the cart has changed after a refresh.
     *
     * This method checks whether the items or the total price in the cart have been modified
     * since the last refresh operation. It can be used to ensure that any subsequent operations
     * are based on the most up-to-date cart state.
     *
     * @return bool Returns true if the cart has changed, false otherwise.
     */
    public function get_has_changed(): bool {
        return $this->_changed;
    }

    /**
     * Check if the checkout session has expired based on the configured payment completion time.
     *
     * @return bool Returns true if the checkout session has expired, false otherwise.
     */
    public function get_is_checkout_expired(): bool {
        if (!$this->is_checkout) {
            return false;
        }

        $timelimit = cart_helper::get_config('payment_completion_time');

        return time() - $this->checkout_at > $timelimit;
    }

    /**
     * Determine if items in the cart can still be edited.
     *
     * @return bool Returns true if items can be edited (either the cart is current or it is checked out but not expired), false
     *     otherwise.
     */
    public function get_can_edit_items(): bool {
        return $this->is_current_user_owner && ($this->is_current || ($this->is_checkout && $this->is_checkout_expired));
    }

    /**
     * Check if the cart's payable amount is zero.
     *
     * This method determines whether the total payable amount for the items in the cart is zero.
     *
     * @return bool True if the payable amount is zero, false otherwise.
     */
    public function get_is_final_payable_zero(): bool {
        return $this->final_payable <= 0;
    }

    /**
     * Process cart items with a payable amount of 0.
     *
     * This method handles the case where the cart's payable amount is zero,
     * allowing users to complete the enrolment process without requiring payment.
     *
     * @return bool True if the processing of free items is successful, false otherwise.
     */
    public function process_free_items(): bool {
        if ($this->get_final_payable() <= 0) {
            if ($this->checkout() && $this->deliver()) {
                notification::success(get_string('msg_enrolment_success', 'enrol_cart'));

                return true;
            }
            notification::error(get_string('msg_enrolment_failed', 'enrol_cart'));
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function checkout(): bool {
        $this->currency = $this->final_currency;
        $this->status = cart_status_interface::STATUS_CHECKOUT;
        $this->checkout_at = time();

        return $this->save();
    }

    /**
     * {@inheritDoc}
     */
    public function cancel(): bool {
        global $DB;

        $transaction = $DB->start_delegated_transaction();

        try {
            $this->status = cart_status_interface::STATUS_CANCELED;
            $this->coupon_cancel();
            $this->save();

            $transaction->allow_commit();

            notification::info(get_string('msg_cart_cancel_success', 'enrol_cart'));

            return true;
        } catch (Exception $e) {
            // Rollback the transaction in case of an exception.
            $transaction->rollback($e);

            notification::warning(get_string('msg_cart_cancel_failed', 'enrol_cart'));

            return false;
        }
    }

    /**
     * Deliver method processes the user course enrolments.
     *
     * @return bool True if the delivery is successful, false otherwise.
     */
    public function deliver(): bool {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/group/lib.php');

        if (!$this->is_checkout) {
            return false;
        }

        // Start a delegated transaction to ensure atomicity.
        $transaction = $DB->start_delegated_transaction();

        try {
            // Get the cart enrolment plugin.
            $plugin = enrol_get_plugin('cart');

            // Loop through each item in the cart for delivery.
            foreach ($this->items as $item) {
                // Retrieve enrolment instance details from the database.
                $instance = $DB->get_record(
                    'enrol',
                    [
                        'id' => $item->instance_id,
                        'enrol' => 'cart',
                    ],
                    '*',
                    MUST_EXIST,
                );

                // Set the enrolment period (if applicable).
                $timestart = 0;
                $timeend = 0;
                if ($instance->enrolperiod) {
                    $timestart = time();
                    $timeend = $timestart + $instance->enrolperiod;
                }

                // Enrol the user in the course using the cart plugin.
                $plugin->enrol_user($instance, $this->user_id, $instance->roleid, $timestart, $timeend);

                // Add user to the groups.
                $groups = explode(',', $instance->customchar2);
                foreach ($groups as $groupid) {
                    if (!empty($groupid)) {
                        groups_add_member($groupid, $this->user_id);
                    }
                }
            }

            // Update the cart status to indicate successful delivery.
            $this->status = cart_status_interface::STATUS_DELIVERED;
            $this->save();

            // Allow the transaction to commit.
            $transaction->allow_commit();

            // Return true to indicate successful delivery.
            return true;
        } catch (Exception $e) {
            // Rollback the transaction in case of an exception.
            $transaction->rollback($e);

            // Return false to indicate delivery failure.
            return false;
        }
    }

    /**
     * Checks if a coupon is applied to the cart.
     *
     * @return bool True if a coupon is applied, false otherwise.
     */
    public function get_has_coupon(): bool {
        return ($this->coupon_id && $this->coupon_usage_id) || !empty($this->_coupon_result->get_discount_amount());
    }

    /**
     * Determines if a coupon can be used with the cart.
     *
     * @return bool True if a coupon can be used, false otherwise.
     */
    public function get_can_use_coupon(): bool {
        if (!$this->can_edit_items) {
            $this->_coupon_result->set_ok(false);
            $this->_coupon_result->set_error_message(get_string('msg_cart_edit_blocked', 'enrol_cart'));
            return false;
        }

        if (!coupon_helper::is_coupon_enable()) {
            $this->_coupon_result->set_ok(false);
            $this->_coupon_result->set_error_message(get_string('error_coupon_disabled', 'enrol_cart'));
            return false;
        }

        return true;
    }

    /**
     * Validates a coupon code against the cart items.
     *
     * @param string $couponcode The coupon code to validate.
     * @return bool True if the coupon code is valid, false otherwise.
     */
    public function coupon_validate(string $couponcode): bool {
        $couponid = coupon_helper::get_coupon_id($couponcode);

        if (!$couponid) {
            $this->_coupon_result->set_ok(false);
            $this->_coupon_result->set_error_message(get_string('error_coupon_is_invalid', 'enrol_cart'));
            return false;
        }

        $this->_coupon_result = coupon_helper::coupon_validate(new cart_dto($this), $couponid);

        return $this->_coupon_result->is_ok();
    }

    /**
     * Checks if a coupon is available for the cart.
     *
     * This method validates if the coupon has been purchased in this cart and returns false if the coupon is not valid.
     * If the coupon has already been applied, this function is executed before connecting to the payment gateway to validate the
     * coupon.
     *
     * @return bool False if the coupon is used and it is not valid, true otherwise.
     */
    public function coupon_check_availability(): bool {
        if (!$this->coupon_id) {
            return true;
        }

        $this->_coupon_result = coupon_helper::coupon_validate(new cart_dto($this), $this->coupon_id);

        return $this->_coupon_result->is_ok() &&
            $this->_coupon_result->get_discount_amount() == $this->coupon_discount_amount;
    }

    /**
     * Applies a coupon code to the cart.
     *
     * Validates the coupon code against the cart items and calculates the discount amount.
     * Updates the cart properties accordingly.
     *
     * @param string $couponcode The coupon code to apply.
     * @return bool True if the coupon is successfully applied, false otherwise.
     */
    public function coupon_apply(string $couponcode): bool {
        if (!$this->coupon_id && $this->coupon_validate($couponcode)) {
            $this->_coupon_result = coupon_helper::coupon_apply(
                new cart_dto($this),
                coupon_helper::get_coupon_id($couponcode),
            );

            if ($this->_coupon_result->is_ok()) {
                $this->coupon_id = $this->_coupon_result->get_coupon_id();
                $this->coupon_code = $this->_coupon_result->get_coupon_code();
                $this->coupon_usage_id = $this->_coupon_result->get_coupon_usage_id();
                $this->coupon_discount_amount = $this->_coupon_result->get_discount_amount();
                $this->payable = $this->final_payable;

                return $this->save();
            }
        }

        return false;
    }

    /**
     * Cancels the usage of a coupon when the cart is canceled.
     *
     * @return bool True if the coupon is successfully canceled, false otherwise.
     */
    public function coupon_cancel(): bool {
        if ($this->coupon_usage_id && $this->coupon_id) {
            if ($this->can_edit_items) {
                $this->_coupon_result = coupon_helper::coupon_cancel(new cart_dto($this));

                if ($this->_coupon_result->is_ok()) {
                    $this->_coupon_result = new coupon_result_dto();
                    $this->coupon_id = null;
                    $this->coupon_code = null;
                    $this->coupon_usage_id = null;
                    $this->coupon_discount_amount = null;

                    return $this->save() && $this->refresh(true);
                }
            } else {
                notification::error(get_string('msg_cart_edit_blocked', 'enrol_cart'));
            }
        }

        return false;
    }

    /**
     * Retrieves the error code from the last applied coupon.
     *
     * @return string|null The error code, or null if no error occurred.
     */
    public function get_coupon_error_code(): ?string {
        return $this->_coupon_result->get_error_code();
    }

    /**
     * Retrieves the error message from the last applied coupon.
     *
     * @return string|null The error message, or null if no error occurred.
     */
    public function get_coupon_error_message(): ?string {
        return $this->_coupon_result->get_error_message();
    }

    /**
     * Retrieves the code of the last applied coupon.
     *
     * @return string|null The coupon code, or null if no coupon is applied.
     */
    public function get_coupon_code(): ?string {
        $couponcode = $this->get_attribute('coupon_code');
        if (!empty($couponcode)) {
            return $couponcode;
        }

        return $this->_coupon_result->get_coupon_code();
    }

    /**
     * Retrieves the discount amount from the applied coupon.
     *
     * @return float|null The discount amount, or null if no coupon is applied.
     */
    public function get_coupon_discount_amount(): ?float {
        $coupondiscountamount = $this->get_attribute('coupon_discount_amount');
        if (!empty($coupondiscountamount)) {
            return $coupondiscountamount;
        }

        return $this->_coupon_result->get_discount_amount();
    }

    /**
     * Retrieves the formatted discount amount from the applied coupon.
     *
     * @return string|null The formatted discount amount, or null if no coupon is applied.
     */
    public function get_coupon_discount_amount_formatted(): ?string {
        if ($this->coupon_discount_amount) {
            return currency_formatter::get_cost_as_formatted(
                (float)$this->coupon_discount_amount,
                $this->final_currency
            );
        }

        return null;
    }
}
