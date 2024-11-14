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
use enrol_cart\helper\CartHelper;
use enrol_cart\object\Cart;
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
        $cart = Cart::findOne($itemid);

        if (
            $cart &&
            $cart->isCurrentUserOwner &&
            $cart->finalPayable > 0 &&
            ($cart->isCurrent || $cart->isCheckout) &&
            !$cart->canEditItems
        ) {
            if (!$cart->isCheckout) {
                $cart->checkout();
            }

            return new payable($cart->finalPayable, $cart->finalCurrency, $cart->paymentAccountId);
        }

        return new payable(-1, '', -1);
    }

    /**
     * {@inheritdoc}
     * @param string $paymentarea Payment area
     * @param int $itemid An identifier that is known to the plugin
     * @return \moodle_url
     */
    public static function get_success_url(string $paymentarea, int $itemid): moodle_url {
        return CartHelper::get_cart_view_url($itemid);
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
        $verifypaymentondelivery = CartHelper::get_config('verify_payment_on_delivery');
        $cart = Cart::findOne($itemid);
        $verified = $cart->user_id == $userid && $cart->isCheckout;

        if ($verifypaymentondelivery) {
            global $DB;
            $payment = $DB->get_record('payments', ['id' => $paymentid], '*', MUST_EXIST);
            $verified = $payment->amount == $cart->finalPayable;
        }

        if ($verified && $cart->deliver()) {
            notification::success(get_string('msg_delivery_successful', 'enrol_cart'));
            return true;
        }

        notification::error(get_string('msg_delivery_filed', 'enrol_cart'));
        return false;
    }
}
