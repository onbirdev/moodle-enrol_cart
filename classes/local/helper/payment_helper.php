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

use context_system;
use core_payment\account;
use core_payment\gateway;
use core_payment\helper;
use lang_string;
use moodle_url;

/**
 * Class payment_helper
 * Provides utility functions for managing payment gateways.
 */
class payment_helper {
    /**
     * Retrieve the list of available currencies with language strings that the payment system supports.
     *
     * @return array An associative array of currency codes to language strings.
     */
    public static function get_available_currencies(): array {
        $currencycodes = helper::get_supported_currencies();

        $currencies = [];
        foreach ($currencycodes as $code) {
            $currencies[$code] = new lang_string($code, 'core_currencies');
        }

        uasort($currencies, 'strcmp');

        return $currencies;
    }

    /**
     * Retrieve the list of available payment accounts.
     *
     * @return array An array of available payment accounts.
     */
    public static function get_available_payment_accounts(): array {
        $context = context_system::instance();
        return helper::get_payment_accounts_menu($context);
    }

    /**
     * Retrieve the list of available payment gateways for a specific account and currency.
     *
     * @param int $accountid The ID of the payment account.
     * @param string $currency The currency code.
     * @return array An array of available payment gateways.
     */
    public static function get_available_payment_gateways(int $accountid, string $currency): array {
        $gateways = [];

        $account = new account($accountid);

        if (!$account->get('id') || !$account->get('enabled')) {
            return $gateways;
        }

        foreach ($account->get_gateways() as $plugin => $gateway) {
            if (!$gateway->get('enabled')) {
                continue;
            }
            /** @var gateway $classname */
            $classname = '\paygw_' . $plugin . '\gateway';

            $currencies = component_class_callback($classname, 'get_supported_currencies', [], []);
            $pluginname = get_string('pluginname', 'paygw_' . $plugin);
            if (in_array($currency, $currencies)) {
                $gateways[$plugin] = $pluginname;
            }
        }

        return $gateways;
    }

    /**
     * Retrieve the list of allowed payment gateways.
     *
     * @return array An array of allowed payment gateways.
     */
    public static function get_allowed_payment_gateways(): array {
        global $CFG;
        $accountid = cart_helper::get_config('payment_account');
        $currency = cart_helper::get_config('payment_currency');
        $availablegateways = self::get_available_payment_gateways($accountid, $currency);

        $gateways = [];

        foreach ($availablegateways as $plugin => $title) {
            $gateways[] = (object)[
                'name' => $plugin,
                'title' => $title,
                'icon_url' => (new moodle_url('/theme/image.php', [
                    'theme' => $CFG->theme,
                    'component' => 'paygw_' . $plugin,
                    'image' => 'img',
                ]))->out(),
                'selected' => false,
            ];
        }

        if (isset($gateways[0])) {
            $gateways[0]->selected = true;
        }

        return $gateways;
    }

    /**
     * Check if a given payment gateway is valid.
     *
     * This method verifies if the provided payment gateway name is within the list
     * of allowed payment gateways.
     *
     * @param string $gatewayname The name of the payment gateway to check.
     * @return bool Returns true if the payment gateway is valid, otherwise false.
     */
    public static function is_payment_gateway_valid(string $gatewayname): bool {
        foreach (self::get_allowed_payment_gateways() as $gateway) {
            if ($gateway->name === $gatewayname) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a random payment gateway from the list of allowed gateways.
     *
     * This method returns the name of a randomly selected payment gateway from
     * the list of allowed payment gateways. If no gateways are available, it returns null.
     *
     * @return string|null The name of the random payment gateway, or null if no gateways are available.
     */
    public static function get_rand_payment_gateway(): ?string {
        $allowedgateways = self::get_allowed_payment_gateways();

        if (!empty($allowedgateways)) {
            $randomindex = rand(0, count($allowedgateways) - 1);
            return $allowedgateways[$randomindex]->name;
        }

        return null;
    }
}
