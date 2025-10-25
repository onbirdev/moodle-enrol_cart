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

namespace enrol_cart\privacy;

use context;
use context_course;
use core_privacy\local\metadata\collection;
use core_privacy\local\metadata\null_provider;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\core_userlist_provider;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;
use Exception;

/**
 * Privacy provider for the enrol_cart plugin.
 *
 * Implements Privacy API to handle user data related to the shopping cart.
 */
class provider implements core_userlist_provider, null_provider, \core_privacy\local\metadata\provider, \core_privacy\local\request\plugin\provider {
    /**
     * Provides the reason why no user data is stored.
     *
     * @return string Reason message.
     */
    public static function get_reason(): string {
        return 'privacy:metadata:reason';
    }

    /**
     * Returns metadata about the data stored by the enrol_cart plugin.
     *
     * @param collection $collection The metadata collection to add items to.
     * @return collection Updated metadata collection.
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_database_table(
            'enrol_cart',
            [
                'user_id' => 'privacy:metadata:enrol_cart:user_id',
                'status' => 'privacy:metadata:enrol_cart:status',
                'currency' => 'privacy:metadata:enrol_cart:currency',
                'price' => 'privacy:metadata:enrol_cart:price',
                'payable' => 'privacy:metadata:enrol_cart:payable',
                'coupon_id' => 'privacy:metadata:enrol_cart:coupon_id',
                'coupon_code' => 'privacy:metadata:enrol_cart:coupon_code',
                'checkout_at' => 'privacy:metadata:enrol_cart:checkout_at',
                'created_at' => 'privacy:metadata:enrol_cart:created_at',
            ],
            'privacy:metadata:enrol_cart',
        );

        $collection->add_database_table(
            'enrol_cart_items',
            [
                'cart_id' => 'privacy:metadata:enrol_cart_items:cart_id',
                'instance_id' => 'privacy:metadata:enrol_cart_items:instance_id',
                'price' => 'privacy:metadata:enrol_cart_items:price',
                'payable' => 'privacy:metadata:enrol_cart_items:payable',
            ],
            'privacy:metadata:enrol_cart_items',
        );

        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for a specific user.
     *
     * @param int $userid The ID of the user.
     * @return contextlist The list of contexts containing the user's data.
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        $contextlist = new contextlist();

        $sql = "SELECT ctx.id
                  FROM {context} ctx
                  JOIN {enrol} e ON e.courseid = ctx.instanceid
                  JOIN {enrol_cart_item} eci ON eci.instance_id = e.id
                  JOIN {enrol_cart} ec ON ec.id = eci.cart_id
                 WHERE ec.user_id = :userid AND ctx.contextlevel = :contextlevel";

        $params = [
            'userid' => $userid,
            'contextlevel' => CONTEXT_COURSE,
        ];

        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Get the list of users with data in the given context.
     *
     * @param userlist $userlist The userlist to add users to.
     */
    public static function get_users_in_context(userlist $userlist) {
        $context = $userlist->get_context();

        if ($context instanceof context_course) {
            $sql = "SELECT ec.user_id
                      FROM {enrol_cart} ec
                      JOIN {enrol_cart_item} eci ON eci.cart_id = ec.id
                      JOIN {enrol} e ON e.id = eci.instance_id
                     WHERE e.courseid = :instanceid";

            $params = [
                'instanceid' => $context->instanceid,
            ];

            $userlist->add_from_sql('user_id', $sql, $params);
        }
    }

    /**
     * Export all user data for approved contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export data for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;

        $userid = $contextlist->get_user()->id;

        [$contextsql, $contextparams] = $DB->get_in_or_equal($contextlist->get_contextids(), SQL_PARAMS_NAMED);

        $sql = "SELECT ec.*, e.courseid as course_id, e.id as enrol_id
              FROM {enrol_cart} ec
              JOIN {enrol_cart_items} eci ON eci.cart_id = ec.id
              JOIN {enrol} e ON eci.instance_id = e.id
              JOIN {context} ctx ON e.courseid = ctx.instanceid AND ctx.contextlevel = :context_course
             WHERE ctx.id {$contextsql} AND ec.user_id = :user_id
          ORDER BY e.courseid";
        $params = [
            'context_course' => CONTEXT_COURSE,
            'user_id' => $userid,
        ];
        $params += $contextparams;

        // Retrieve all carts for the user.
        $carts = $DB->get_records_sql($sql, $params);
        $data = [];
        $lastcourseid = null;

        try {
            foreach ($carts as $cart) {
                if ($lastcourseid != $cart->course_id) {
                    if (!empty($data)) {
                        $coursecontext = context_course::instance($lastcourseid);
                        writer::with_context($coursecontext)->export_data([], (object) ['carts' => $data]);
                    }
                    $data = [];
                }

                // Prepare data for export.
                $cartdata = (object) [
                    'status' => $cart->status,
                    'currency' => $cart->currency,
                    'price' => $cart->price,
                    'payable' => $cart->payable,
                    'coupon_code' => $cart->coupon_code,
                    'checkout_at' => userdate($cart->checkout_at),
                    'created_at' => userdate($cart->created_at),
                ];

                // Retrieve and attach cart items.
                $items = $DB->get_records('enrol_cart_items', [
                    'cart_id' => $cart->id,
                    'instance_id' => $cart->enrol_id,
                ]);
                $cartdata->items = [];
                foreach ($items as $item) {
                    $cartdata->items[] = (object) [
                        'instance_id' => $item->instance_id,
                        'price' => $item->price,
                        'payable' => $item->payable,
                    ];
                }

                $data[] = $cartdata;
                $lastcourseid = $cart->course_id;
            }

            // Export the remaining data for the last course.
            if (!empty($data)) {
                $coursecontext = context_course::instance($lastcourseid);
                writer::with_context($coursecontext)->export_data([], (object) ['carts' => $data]);
            }
        } catch (Exception $e) {
            debugging('Error exporting user data: ' . $e->getMessage(), DEBUG_DEVELOPER);
        }
    }

    /**
     * Delete all data for all users in a given context.
     *
     * @param context $context The context to delete data from.
     */
    public static function delete_data_for_all_users_in_context(context $context) {
        global $DB;

        if (!($context instanceof context_course)) {
            return; // Skip non-course contexts.
        }

        $courseid = $context->instanceid;

        // Get all enrol instances of type 'cart' for the course.
        $enrols = $DB->get_records('enrol', ['enrol' => 'cart', 'courseid' => $courseid]);

        if (empty($enrols)) {
            return; // No enrolments of type 'cart' found for this course.
        }

        foreach ($enrols as $enrol) {
            try {
                // Start a transaction for safe deletion.
                $transaction = $DB->start_delegated_transaction();

                // Delete all cart items linked to the enrol instance.
                $DB->delete_records_select('enrol_cart_items', 'instance_id = :instance_id', [
                    'instance_id' => $enrol->id,
                ]);

                // Get and delete empty carts.
                $emptycartids = $DB->get_fieldset_select(
                    'enrol_cart',
                    'id',
                    'NOT EXISTS (SELECT 1 FROM {enrol_cart_items} WHERE cart_id = {enrol_cart}.id)',
                );

                if (!empty($emptycartids)) {
                    $DB->delete_records_list('enrol_cart', 'id', $emptycartids);
                }

                $transaction->allow_commit();
            } catch (Exception $e) {
                $transaction->rollback($e);
                throw $e; // Rethrow exception for logging or further handling.
            }
        }
    }

    /**
     * Delete all data for specific users in a context.
     *
     * @param approved_userlist $userlist The approved userlist containing users to delete data for.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        $context = $userlist->get_context();

        if (!($context instanceof context_course)) {
            return; // Skip non-course contexts.
        }

        $courseid = $context->instanceid;

        // Get all enrol instances of type 'cart' for the course.
        $enrols = $DB->get_records('enrol', ['enrol' => 'cart', 'courseid' => $courseid]);

        if (empty($enrols)) {
            return; // No enrolments of type 'cart' found for this course.
        }

        $enrolids = array_column($enrols, 'id');
        [$insql, $inparams] = $DB->get_in_or_equal($enrolids, SQL_PARAMS_NAMED);

        foreach ($userlist->get_users() as $user) {
            // Start a transaction for safe deletion.
            $transaction = $DB->start_delegated_transaction();

            // Delete all cart items linked to the enrol instances and user.
            $DB->delete_records_select(
                'enrol_cart_items',
                "instance_id {$insql} AND cart_id IN (SELECT id FROM {enrol_cart} WHERE user_id = :userid)",
                $inparams + ['userid' => $user->id],
            );

            // Delete any empty carts for the user.
            $DB->delete_records_select(
                'enrol_cart',
                'user_id = :userid AND NOT EXISTS (SELECT 1 FROM {enrol_cart_items} WHERE cart_id = {enrol_cart}.id)',
                ['userid' => $user->id],
            );

            $transaction->allow_commit();
        }
    }

    /**
     * Delete all user data for a specific user in approved contexts.
     *
     * @param approved_contextlist $contextlist The list of approved contexts.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;

        $userid = $contextlist->get_user()->id;

        foreach ($contextlist->get_contexts() as $context) {
            if (!($context instanceof context_course)) {
                continue; // Skip non-course contexts.
            }

            $courseid = $context->instanceid;

            // Get all enrol instances of type 'cart' for the course.
            $enrols = $DB->get_records('enrol', ['enrol' => 'cart', 'courseid' => $courseid]);

            foreach ($enrols as $enrol) {
                // Start a transaction for safe deletion.
                $transaction = $DB->start_delegated_transaction();

                // Delete all cart items linked to the enrol instance and user.
                $DB->delete_records_select(
                    'enrol_cart_items',
                    'instance_id = :instance_id AND cart_id IN (SELECT id FROM {enrol_cart} WHERE user_id = :userid)',
                    ['instance_id' => $enrol->id, 'userid' => $userid],
                );

                // Delete any empty carts for the user.
                $DB->delete_records_select(
                    'enrol_cart',
                    'user_id = :userid AND NOT EXISTS (SELECT 1 FROM {enrol_cart_items} WHERE cart_id = {enrol_cart}.id)',
                    ['userid' => $userid],
                );

                $transaction->allow_commit();
            }
        }
    }
}
