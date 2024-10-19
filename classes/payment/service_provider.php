<?php

/**
 * @package    enrol_cart
 * @brief      Shopping Cart Enrolment Plugin for Moodle
 * @category   Moodle, Enrolment, Shopping Cart
 *
 * @author     MohammadReza PourMohammad <onbirdev@gmail.com>
 * @copyright  2024 MohammadReza PourMohammad
 * @link       https://onbir.dev
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_cart\payment;

defined('MOODLE_INTERNAL') || die();

use core\notification;
use core_payment\local\entities\payable;
use enrol_cart\helper\CartHelper;
use enrol_cart\object\Cart;
use moodle_url;

class service_provider implements \core_payment\local\callback\service_provider
{
    /**
     * @inheritDoc
     * @param string $paymentArea Payment area
     * @param int $itemId An identifier that is known to the plugin
     * @return payable
     */
    public static function get_payable(string $paymentArea, int $itemId): payable
    {
        $cart = Cart::findOne($itemId);

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
     * @inheritdoc
     * @param string $paymentArea Payment area
     * @param int $itemId An identifier that is known to the plugin
     * @return \moodle_url
     */
    public static function get_success_url(string $paymentArea, int $itemId): moodle_url
    {
        return CartHelper::getCartViewUrl($itemId);
    }

    /**
     * Callback function that delivers what the user paid for to them.
     *
     * @inheritdoc
     *
     * @param string $paymentArea Payment area
     * @param int $itemId An identifier that is known to the plugin
     * @param int $paymentId payment id as inserted into the 'payments' table, if needed for reference
     * @param int $userId The userid the order is going to deliver to
     *
     * @return bool Whether successful or not
     */
    public static function deliver_order(string $paymentArea, int $itemId, int $paymentId, int $userId): bool
    {
        $verifyPaymentOnDelivery = CartHelper::getConfig('verify_payment_on_delivery');
        $cart = Cart::findOne($itemId);
        $verified = $cart->user_id == $userId && $cart->isCheckout;

        if ($verifyPaymentOnDelivery) {
            global $DB;
            $payment = $DB->get_record('payments', ['id' => $paymentId], '*', MUST_EXIST);
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
