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

namespace enrol_cart\local\formatter;

use core_payment\helper;
use enrol_cart\local\helper\cart_helper;

/**
 * Class CurrencyHelper
 * Provides utility functions for managing payment currency.
 */
class currency_formatter {
    /**
     * Get the mapping of currency codes to human-readable names.
     *
     * @return array An associative array mapping currency codes to human-readable names.
     */
    protected static function get_currency_name_convert(): array {
        return [
            'IRR' => get_string('IRR', 'enrol_cart'),
            'IRT' => get_string('IRT', 'enrol_cart'),
        ];
    }

    /**
     * Retrieves the current language in use, with caching for performance optimization.
     *
     * This method uses a static cache to avoid repeated calls to the `current_language()` function,
     * ensuring that the current language is only fetched once per request.
     *
     * @return string The current language code (e.g., 'en', 'fa', 'es').
     */
    protected static function get_current_language(): string {
        static $cache = null;

        if (is_null($cache)) {
            $cache = current_language();
        }

        return $cache;
    }

    /**
     * Convert English numbers in a given text to Farsi numbers.
     *
     * @param string $text The text containing English numbers.
     * @return string The text with English numbers converted to Farsi.
     */
    public static function convert_english_numbers_to_persian(string $text): string {
        $englishnumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '%'];
        $farsinumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٪'];

        return str_replace($englishnumbers, $farsinumbers, $text);
    }

    /**
     * Returns a human-readable amount with the correct number of fractional digits and currency indicator,
     * and can also apply a surcharge or convert IRR to IRT based on configuration.
     *
     * @param float $amount Amount in the currency units.
     * @param string $currency The currency code.
     * @return string The formatted cost string.
     */
    public static function get_cost_as_formatted(float $amount, string $currency): string {
        // Convert IRR to IRT if configured.
        if ($currency == 'IRR' && cart_helper::get_config('convert_irr_to_irt')) {
            $amount = $amount / 10;
        }
        $cost = helper::get_cost_as_string($amount, $currency);

        // Replace IRR with IRT in the cost string if configured.
        if ($currency == 'IRR' && cart_helper::get_config('convert_irr_to_irt')) {
            $cost = str_replace('IRR', 'IRT', $cost);
        }

        // Convert currency codes to human-readable format.
        foreach (self::get_currency_name_convert() as $item => $value) {
            $cost = str_replace($item, '<span>' . $value . '</span>', $cost);
        }

        // Convert numbers to Persian if configured.
        if (cart_helper::get_config('convert_numbers_to_persian') && self::get_current_language() == 'fa') {
            $cost = self::convert_english_numbers_to_persian($cost);
        }

        return $cost;
    }
}
