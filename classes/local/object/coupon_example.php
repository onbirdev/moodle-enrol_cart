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
 * Class coupon_example
 *
 * This class provides functionalities to handle coupons within a cart system. It includes methods for finding,
 * validating, and applying coupons. The class is designed to ensure proper validation rules are enforced before a
 * coupon is applied to a cart, including checking user eligibility, cart items, and usage limits.
 */
class coupon_example implements coupon_interface {
    /**
     * Find a coupon by its code and return the coupon ID.
     *
     *  In the cart system, we store and work with the **coupon ID**, not the coupon code.
     *  All operations such as **validation**, **applying**, and **canceling** a coupon are done using the coupon ID.
     *  Therefore, we need to implement this method to convert a user-entered code (like `"OFF30"`) into the corresponding coupon
     * ID (like `121`).
     *
     *  This method looks for a record in the 'local_coupon' table using the provided coupon code.
     *  If a matching coupon is found, it returns the coupon's ID.
     *  Otherwise, it returns null.
     *
     *  ### Example implementation (basic logic):
     *  ```
     *  global $DB;
     *  $coupon = $DB->get_record('local_coupon', ['code' => $couponcode]);
     *  return $coupon ? $coupon->id : null;
     *  ```
     *
     *
     * ### Example usage:
     * ```
     * $couponid = coupon_example::get_coupon_id("OFF30");
     * if ($couponid !== null) {
     *     echo "Coupon ID is: $couponid";
     * }
     * ```
     *
     * @param string $couponcode The coupon code entered by the user.
     * @return int|null           The ID of the coupon if found, or null if not found.
     */
    public static function get_coupon_id(string $couponcode): ?int {
        global $DB;

        // Try to find the coupon by its code in the database.
        $coupon = $DB->get_record('local_coupon', ['code' => $couponcode]);

        // Return the coupon ID if found, otherwise return null.
        return $coupon ? $coupon->id : null;
    }

    /**
     * Validates a coupon against the current cart state.
     *
     * This method checks if the coupon is valid based on multiple conditions such as:
     * - Existence and activity status of the coupon
     * - Validity period (valid_from and valid_until)
     * - User permission and usage limits
     * - Applicable items in the cart and minimum order requirements
     *
     * If all validations pass, it calculates the discount and returns the result.
     *
     * @param cart_dto $cart The current cart object.
     * @param int $couponid The ID of the coupon to validate.
     * @return coupon_result_dto The result of validation, including any errors or discount details.
     */
    public static function validate_coupon(cart_dto $cart, int $couponid): coupon_result_dto {
        global $DB, $USER;

        $res = new coupon_result_dto();
        $res->set_ok(false);

        // 1. Retrieve the coupon from the database.
        $coupon = $DB->get_record('local_coupon', ['id' => $couponid]);
        if (!$coupon) {
            return $res->set_error_code('error_coupon_not_found')->set_error_message('Coupon not found.');
        }

        // 2. Check if the coupon is active.
        if (!$coupon->active) {
            return $res->set_error_code('error_coupon_inactive')->set_error_message('Coupon is inactive.');
        }

        // 3. Check if the coupon's start date is in the future.
        if (!empty($coupon->valid_from) && $coupon->valid_from > time()) {
            return $res->set_error_code('error_coupon_not_active')->set_error_message('Coupon is not active yet.');
        }

        // 4. Check if the coupon has expired.
        if (!empty($coupon->valid_until) && $coupon->valid_until < time()) {
            return $res->set_error_code('error_coupon_expired')->set_error_message('Coupon has expired.');
        }

        // 5. Check if the user is allowed to use this coupon.
        if (!in_array($USER->id, $coupon->allowed_users)) {
            return $res->set_error_code('error_user_not_allowed')
                ->set_error_message('This coupon is not available for your user account.');
        }

        // 6. Validate overall usage limit of the coupon.
        if (!empty($coupon->usage_limit)) {
            $totalusage = $DB->count_records('local_coupon_usage', ['coupon_id' => $couponid]);
            if ($totalusage >= $coupon->usage_limit) {
                return $res->set_error_code('error_coupon_usage_limit')->set_error_message('Coupon usage limit has been reached.');
            }
        }

        // 7. Validate per-user usage limit.
        if (!empty($coupon->user_usage_limit)) {
            $userusage = $DB->count_records('local_coupon_usage', [
                'coupon_id' => $couponid,
                'user_id' => $USER->id,
            ]);
            if ($userusage >= $coupon->user_usage_limit) {
                return $res->set_error_code('error_user_usage_limit')
                    ->set_error_message('You have reached your personal usage limit for this coupon.');
            }
        }

        // 8. Calculate total cart amount and eligible amount for discount.
        $allowedcoursestotalamount = 0;
        $totalamount = 0;

        foreach ($cart->get_cart_items() as $item) {
            $payable = $item->get_payable();
            $totalamount += $payable;

            $courseid = $item->get_course_id();
            $isallowed = in_array($courseid, $coupon->allowed_courses);
            $nodiscountapplied = !$item->has_discount();

            // Only include eligible, non-discounted, positive-value items.
            if ($payable > 0 && $isallowed && $nodiscountapplied) {
                $allowedcoursestotalamount += $payable;
            }
        }

        // 9. If no eligible items found in the cart.
        if ($allowedcoursestotalamount == 0) {
            return $res->set_error_code('error_no_eligible_courses')
                ->set_error_message('This coupon does not apply to any eligible items in your cart.');
        }

        // 10. Check if the cart meets the minimum amount required for this coupon.
        if (!empty($coupon->min_order_amount) && $allowedcoursestotalamount < $coupon->min_order_amount) {
            return $res->set_error_code('error_min_order_not_met')
                ->set_error_message('Your cart does not meet the minimum required amount for this coupon.');
        }

        // 11. Calculate discount based on the coupon type.
        $discountamount = 0;
        if ($coupon->type === 'fixed') {
            $discountamount = $coupon->amount;
        } else if ($coupon->type === 'percentage') {
            $discountamount = $allowedcoursestotalamount * ($coupon->amount / 100);
        }

        // 12. Apply the maximum discount amount if defined.
        if (!empty($coupon->max_discount_amount)) {
            $discountamount = min($discountamount, $coupon->max_discount_amount);
        }

        // 13. Ensure discount does not exceed eligible item total.
        $discountamount = min($discountamount, $allowedcoursestotalamount);

        // 14. Calculate the final payable amount after discount.
        $payableamount = $totalamount - $discountamount;

        // 15. All checks passed, return successful result.
        return $res->set_ok(true)
            ->set_coupon_id($coupon->id)
            ->set_coupon_code($coupon->code)
            ->set_discount_amount($discountamount)
            ->set_payable_amount($payableamount);
    }

    /**
     * Applies a validated coupon to the given cart.
     *
     * This method first validates the coupon by checking its eligibility for the current user and cart.
     * If the coupon is valid, it stores the usage record in the database and returns the discount details.
     *
     * @param cart_dto $cart The user's current cart object.
     * @param int $couponid The ID of the coupon to be applied.
     * @return coupon_result_dto The result of the coupon application, including success/failure and discount info.
     */
    public static function apply_coupon(cart_dto $cart, int $couponid): coupon_result_dto {
        global $DB, $USER;

        // 1. Validate the coupon first.
        $res = self::validate_coupon($cart, $couponid);
        if (!$res->is_ok()) {
            return $res;
        }

        // 2. Attempt to log coupon usage in the database.
        $usageid = $DB->insert_record('local_coupon_usage', [
            'coupon_id' => $couponid,
            'user_id' => $USER->id,
            'cart_id' => $cart->get_cart_id(),
            'discount_amount' => $res->get_discount_amount(),
            'payable_amount' => $res->get_payable_amount(),
            'applied_at' => time(),
        ]);

        // 3. If insert succeeded, update result object with usage ID.
        if ($usageid) {
            return $res->set_coupon_usage_id($usageid);
        }

        // 4. If insert failed, return an error result.
        return $res
            ->set_ok(false)
            ->set_error_code('error_applying_coupon')
            ->set_error_message('An error occurred while applying the coupon.');
    }

    /**
     * Cancels an applied coupon from the cart by deleting its usage record.
     *
     * This method checks if a coupon usage ID exists in the cart, and if so,
     * deletes the corresponding record from the `local_coupon_usage` table.
     *
     * @param cart_dto $cart The current user's cart object.
     * @return coupon_result_dto Result of the cancellation process.
     */
    public static function cancel_coupon(cart_dto $cart): coupon_result_dto {
        global $DB;

        $res = new coupon_result_dto();

        // 1. Check if a coupon has been applied to the cart.
        $usageid = $cart->get_coupon_usage_id();
        if (empty($usageid)) {
            return $res
                ->set_ok(false)
                ->set_error_code('error_coupon_not_applied')
                ->set_error_message('No coupon is applied to this cart.');
        }

        // 2. Attempt to delete the coupon usage record.
        $deleted = $DB->delete_records('local_coupon_usage', ['id' => $usageid]);

        // 3. Check if deletion was successful.
        if (!$deleted) {
            return $res
                ->set_ok(false)
                ->set_error_code('error_coupon_cancel_failed')
                ->set_error_message('Failed to cancel the applied coupon.');
        }

        // 4. Success: coupon was cancelled.
        return $res->set_ok(true);
    }
}
