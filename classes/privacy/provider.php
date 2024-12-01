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
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;

/**
 * Privacy provider for the enrol_cart plugin.
 *
 * Implements Privacy API to handle user data related to the shopping cart.
 */
class provider implements null_provider, \core_privacy\local\request\plugin\provider {
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
                  JOIN {enrol_cart} ec ON ec.id = ctx.instanceid
                 WHERE ec.user_id = :userid AND ctx.contextlevel = :contextlevel";

        $params = [
            'userid' => $userid,
            'contextlevel' => CONTEXT_COURSE,
        ];

        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Export all user data for approved contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export data for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;

        $userid = $contextlist->get_user()->id;

        // Retrieve all carts for the user.
        $carts = $DB->get_records('enrol_cart', ['user_id' => $userid]);

        foreach ($carts as $cart) {
            $context = context_course::instance($cart->id);

            // Prepare data for export.
            $data = (object) [
                'status' => $cart->status,
                'currency' => $cart->currency,
                'price' => $cart->price,
                'payable' => $cart->payable,
                'coupon_code' => $cart->coupon_code,
                'checkout_at' => userdate($cart->checkout_at),
                'created_at' => userdate($cart->created_at),
            ];

            // Retrieve and attach cart items.
            $items = $DB->get_records('enrol_cart_items', ['cart_id' => $cart->id]);
            $data->items = [];
            foreach ($items as $item) {
                $data->items[] = (object) [
                    'instance_id' => $item->instance_id,
                    'price' => $item->price,
                    'payable' => $item->payable,
                ];
            }

            // Write data to the context.
            writer::with_context($context)->export_data([], $data);
        }
    }

    /**
     * Delete all data for all users in a given context.
     *
     * @param context $context The context to delete data from.
     */
    public static function delete_data_for_all_users_in_context(context $context) {
        global $DB;

        $DB->delete_records_select('enrol_cart_items', 'cart_id IN (SELECT id FROM {enrol_cart} WHERE id = :cartid)', [
            'cartid' => $context->instanceid,
        ]);
        $DB->delete_records('enrol_cart', ['id' => $context->instanceid]);
    }

    /**
     * Delete all data for specific users in a context.
     *
     * @param approved_userlist $userlist The approved userlist containing users to delete data for.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        foreach ($userlist->get_users() as $user) {
            $DB->delete_records_select(
                'enrol_cart_items',
                'cart_id IN (SELECT id FROM {enrol_cart} WHERE user_id = :userid)',
                [
                    'userid' => $user->id,
                ],
            );
            $DB->delete_records('enrol_cart', ['user_id' => $user->id]);
        }
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
                     WHERE ec.id = :instanceid";

            $params = [
                'instanceid' => $context->instanceid,
            ];

            $userlist->add_from_sql('user_id', $sql, $params);
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

        foreach ($contextlist as $context) {
            if ($context instanceof context_course) {
                $DB->delete_records_select(
                    'enrol_cart_items',
                    'cart_id IN (SELECT id FROM {enrol_cart} WHERE user_id = :userid)',
                    ['userid' => $userid],
                );

                $DB->delete_records('enrol_cart', ['user_id' => $userid]);
            }
        }
    }
}
