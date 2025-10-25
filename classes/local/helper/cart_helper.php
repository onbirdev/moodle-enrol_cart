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

namespace enrol_cart\local\helper;

use context_course;
use enrol_cart\local\availability\info;
use enrol_cart\local\object\cart;
use enrol_cart\local\object\cart_enrollment_instance;
use enrol_cart\local\object\cookie_cart;
use moodle_url;

/**
 * Class cart_helper
 * Provides utility functions for managing shopping cart-related operations.
 */
class cart_helper {
    /**
     * Retrieve the configuration setting for enrol_cart.
     *
     * @param string|null $name The name of the configuration setting to retrieve.
     * @return mixed The configuration value or null if not found.
     */
    public static function get_config($name = null) {
        static $config;

        if (!isset($config)) {
            $config = get_config('enrol_cart');
        }

        if ($name) {
            return $config->$name ?? null;
        }

        return $config;
    }

    /**
     * Return the first cart enrolment instance ID of a course.
     *
     * @param int $courseid The ID of the course.
     * @return int The cart enrolment instance ID of the course.
     */
    public static function get_course_instance_id(int $courseid): int {
        global $DB;
        $instances = $DB->get_records(
            'enrol',
            [
                'courseid' => $courseid,
                'enrol' => 'cart',
                'status' => ENROL_INSTANCE_ENABLED,
            ],
            'sortorder ASC',
            'id',
        );
        foreach ($instances as $instance) {
            return $instance->id;
        }
        return 0;
    }

    /**
     * Return an active cart enrol record.
     *
     * @param int $instanceid The ID of the enrolment instance.
     * @return false|cart_enrollment_instance The cart enrolment record or false if not found.
     */
    public static function get_instance(int $instanceid) {
        static $cache = [];
        if (!isset($cache[$instanceid])) {
            $instance = cart_enrollment_instance::find_one_by_id($instanceid);
            if (
                (!$instance->enrol_start_date || $instance->enrol_start_date < time()) &&
                (!$instance->enrol_end_date || $instance->enrol_end_date > time())
            ) {
                $cache[$instanceid] = $instance;
            }
        }
        return $cache[$instanceid];
    }

    /**
     * Return true if the enrol method exists.
     *
     * @param int $instanceid The ID of the enrolment instance.
     * @return bool Returns true if the enrol method exists, false otherwise.
     */
    public static function has_instance(int $instanceid): bool {
        return !!self::get_instance($instanceid);
    }

    /**
     * Check if a user is enrolled in a specified instance.
     *
     * @param int $instanceid The ID of the enrolment instance.
     * @param int $userid The ID of the user.
     * @param bool $anyinstance (Optional) Whether to check enrollment in any instance of the course.
     * @param bool $onlyactive (Optional) Whether to check only active enrollments.
     * @return bool Returns true if the user is enrolled, otherwise false.
     */
    public static function is_user_enrolled(
        int $instanceid,
        int $userid,
        bool $anyinstance = false,
        bool $onlyactive = false
    ): bool {
        global $DB;

        // If anyInstance flag is set and the instance exists, check enrollment in the course.
        if ($anyinstance && self::has_instance($instanceid)) {
            $instance = self::get_instance($instanceid);
            $course = $DB->get_record('course', ['id' => $instance->course_id], '*', MUST_EXIST);
            $context = context_course::instance($course->id);
            return is_enrolled($context, $userid, '', $onlyactive); // Check enrollment in the course context.
        }

        // Otherwise, check enrollment in the specified instance.
        return $DB->record_exists('user_enrolments', [
            'enrolid' => $instanceid,
            'userid' => $userid,
        ]);
    }

    /**
     * Determines if the user can enrol in the specified instance.
     *
     * @param int $instanceid The ID of the enrolment instance.
     * @param int $userid The ID of the user to check enrolment eligibility for.
     * @param null|string $information Output parameter to store additional information about the enrolment status.
     * @return bool Returns true if the user can enrol, otherwise false.
     */
    public static function can_user_enrol(int $instanceid, int $userid, ?string &$information = ''): bool {
        $instance = self::get_instance($instanceid);

        if (!empty($instance->availability_conditions_json)) {
            $info = new info($instance);
            return $info->is_available($information, false, $userid);
        }

        return true;
    }

    /**
     * Move the not-authenticated user cookie cart to the database when the user logs in.
     *
     * @return void
     * @see user_observer::user_logged_in()
     */
    public static function move_cookie_cart_to_db() {
        global $USER;

        $cookiecart = new cookie_cart();

        if (empty($cookiecart->items) || !$USER->id || isguestuser()) {
            return;
        }

        $cart = cart::find_current(true);
        foreach ($cookiecart->items as $item) {
            $cart->add_item($item->instance_id);
        }

        $cookiecart->flush();
    }

    /**
     * Return the cart object.
     *
     * @param bool $forcenew Create an active cart on the database for the current user.
     * @return cart|cookie_cart|null The shopping cart object.
     */
    public static function get_current(bool $forcenew = false) {
        global $USER;

        static $current = null;

        if (!$current) {
            if (!$USER->id || isguestuser()) {
                $current = new cookie_cart();
            } else {
                $current = cart::find_current($forcenew);
            }
        }

        return $current;
    }

    /**
     * Add a course to the current cart.
     *
     * @param int $courseid The ID of the course to add.
     * @return bool Returns true if the course was added successfully, otherwise false.
     */
    public static function add_course_to_cart(int $courseid): bool {
        $cart = self::get_current(true);
        return $cart->add_course($courseid);
    }

    /**
     * Add an enrolment instance to the current cart.
     *
     * @param int $instanceid The ID of the enrolment instance to add.
     * @return bool Returns true if the instance was added successfully, otherwise false.
     */
    public static function add_instance_to_cart(int $instanceid): bool {
        $cart = self::get_current(true);
        return $cart->add_item($instanceid);
    }

    /**
     * Remove a course from the current cart.
     *
     * @param int $courseid The ID of the course to remove.
     * @return bool Returns true if the course was removed successfully, otherwise false.
     */
    public static function remove_course_from_cart(int $courseid): bool {
        $cart = self::get_current(true);
        return $cart->remove_course($courseid);
    }

    /**
     * Remove an enrolment instance from the current cart.
     *
     * @param int $instanceid The ID of the enrolment instance to remove.
     * @return bool Returns true if the instance was removed successfully, otherwise false.
     */
    public static function remove_instance_from_cart(int $instanceid): bool {
        $cart = self::get_current(true);
        return $cart->remove_item($instanceid);
    }

    /**
     * Get the URL for the cart view page.
     *
     * @param int|null $id The ID of the cart to view, or null for the current cart.
     * @return moodle_url The URL of the cart view page.
     */
    public static function get_cart_view_url(?int $id = null): moodle_url {
        $params = $id ? ['id' => $id] : null;
        return new moodle_url('/enrol/cart/view.php', $params);
    }

    /**
     * Get the URL for the cart checkout page.
     *
     * @param int|null $id The ID of the cart for checkout, or null for the current cart.
     * @return moodle_url The URL of the cart checkout page.
     */
    public static function get_cart_checkout_url(?int $id = null): moodle_url {
        $params = $id ? ['id' => $id] : null;
        return new moodle_url('/enrol/cart/checkout.php', $params);
    }
}
