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

namespace enrol_cart\payment;

use core\notification;
use core_payment\local\entities\payable;
use enrol_cart\local\helper\cart_helper;
use enrol_cart\local\object\cart;
use moodle_url;

/**
 * Service provider class for handling payment callback operations in Moodle.
 *
 * This class implements the service_provider interface for processing payment
 * callback requests and interacting with the Moodle payment system.
 */
class service_provider implements \core_payment\local\callback\service_provider {
    /**
     * {@inheritdoc}
     * @param string $paymentarea Payment area
     * @param int $itemid An identifier that is known to the plugin
     * @return payable
     */
    public static function get_payable(string $paymentarea, int $itemid): payable {
        $cart = cart::find_one($itemid);

        if (
            $cart &&
            $cart->is_current_user_owner &&
            $cart->final_payable > 0 &&
            ($cart->is_current || $cart->is_checkout) &&
            !$cart->can_edit_items
        ) {
            if (!$cart->is_checkout) {
                $cart->checkout();
            }

            return new payable($cart->final_payable, $cart->final_currency, $cart->payment_account_id);
        }

        return new payable(-1, '', -1);
    }

    /**
     * {@inheritdoc}
     * @param string $paymentarea Payment area
     * @param int $itemid An identifier that is known to the plugin
     * @return moodle_url
     */
    public static function get_success_url(string $paymentarea, int $itemid): moodle_url {
        return cart_helper::get_cart_view_url($itemid);
    }

    /**
     * Callback function that delivers what the user paid for to them.
     *
     * {@inheritdoc}
     *
     * @param string $paymentarea Payment area
     * @param int $itemid An identifier that is known to the plugin
     * @param int $paymentid payment id as inserted into the 'payments' table, if needed for reference
     * @param int $userid The userid the order is going to deliver to
     *
     * @return bool Whether successful or not
     */
    public static function deliver_order(string $paymentarea, int $itemid, int $paymentid, int $userid): bool {
        $verifypaymentondelivery = cart_helper::get_config('verify_payment_on_delivery');
        $cart = cart::find_one($itemid);
        $verified = $cart->user_id == $userid && $cart->is_checkout;

        if ($verified && $verifypaymentondelivery) {
            global $DB;
            $payment = $DB->get_record('payments', ['id' => $paymentid], '*', MUST_EXIST);
            $verified = $payment->amount == $cart->final_payable;
        }

        if ($verified && $cart->deliver()) {
            notification::success(get_string('msg_enrolment_success', 'enrol_cart'));
            return true;
        }

        notification::error(get_string('msg_enrolment_failed', 'enrol_cart'));
        return false;
    }
}
