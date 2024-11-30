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

namespace enrol_cart\task;

use context_system;
use core\task\scheduled_task;
use enrol_cart\event\cart_deleted;
use enrol_cart\local\helper\cart_helper;
use enrol_cart\local\helper\coupon_helper;
use enrol_cart\local\object\cart;
use enrol_cart\local\object\cart_dto;
use enrol_cart\local\object\cart_status_interface;

/**
 * Class delete_expired_carts
 * Scheduled task for deleting expired shopping carts in the enrol_cart plugin.
 */
class delete_expired_carts extends scheduled_task {
    /**
     * Get the name of the scheduled task.
     *
     * @return string The localized name of the task.
     */
    public function get_name() {
        return get_string('delete_expired_carts', 'enrol_cart');
    }

    /**
     * Execute the scheduled task.
     * This function deletes both canceled and pending payment carts that have expired.
     */
    public function execute() {
        $this->process_delete_canceled_carts();
        $this->process_delete_pending_payment_carts();
    }

    /**
     * Process deletion of canceled carts that have expired.
     * It deletes carts with a 'canceled' status that have not been updated within the configured lifetime.
     */
    protected function process_delete_canceled_carts() {
        $time = $this->get_time('canceled_cart_lifetime');
        if (!$time) {
            return;
        }

        global $DB;

        $carts = $DB->get_records_sql('SELECT * FROM {enrol_cart} WHERE status = :status AND updated_at < :time', [
            'status' => cart_status_interface::STATUS_CANCELED,
            'time' => $time,
        ]);

        $this->process_delete_carts($carts);
    }

    /**
     * Process deletion of pending payment carts that have expired.
     * It deletes carts with a 'checkout' status that have not been checked out within the configured lifetime.
     */
    protected function process_delete_pending_payment_carts() {
        $time = $this->get_time('pending_payment_cart_lifetime');
        if (!$time) {
            return;
        }

        global $DB;

        $carts = $DB->get_records_sql('SELECT * FROM {enrol_cart} WHERE status = :status AND checkout_at < :time', [
            'status' => cart_status_interface::STATUS_CHECKOUT,
            'time' => $time,
        ]);

        $this->process_delete_carts($carts);
    }

    /**
     * Get the expiration time for a specific cart status.
     *
     * @param string $item The configuration item for the cart lifetime.
     * @return int The timestamp for expiration or 0 if not configured.
     */
    protected function get_time(string $item): int {
        $lifetime = (int) cart_helper::get_config($item);
        if (!$lifetime) {
            return 0;
        }

        return time() - $lifetime;
    }

    /**
     * Check if a cart has associated payment records.
     *
     * @param int $cartid The ID of the cart.
     * @return bool True if the cart has payment records, false otherwise.
     */
    protected function has_payment_record(int $cartid): bool {
        global $DB;
        return $DB->record_exists('payments', [
            'component' => 'enrol_cart',
            'paymentarea' => 'cart',
            'itemid' => $cartid,
        ]);
    }

    /**
     * Delete a cart and its associated items.
     *
     * @param object $cart The object of the cart to delete.
     */
    private function delete_cart(object $cart) {
        global $DB;

        $systemcontext = context_system::instance();
        $cart = cart::populate_one($cart);

        if ($cart->coupon_id && $cart->coupon_usage_id) {
            coupon_helper::coupon_cancel(new cart_dto($cart));
        }

        $DB->delete_records('enrol_cart_items', ['cart_id' => $cart->id]);
        $DB->delete_records('enrol_cart', ['id' => $cart->id]);

        // Trigger cart deleted event.
        $event = cart_deleted::create([
            'context' => $systemcontext,
            'objectid' => $cart->id,
            'other' => (array) $cart->get_attributes(),
        ]);
        $event->trigger();
    }

    /**
     * Process deletion of carts.
     * It deletes each cart in the provided list if it has no associated payment records.
     *
     * @param array $carts The list of carts to process.
     */
    private function process_delete_carts(array $carts) {
        foreach ($carts as $cart) {
            if (cart_helper::get_config('not_delete_cart_with_payment_record') && $this->has_payment_record($cart->id)) {
                continue;
            }
            $this->delete_cart($cart);
        }
    }
}
