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

namespace enrol_cart\object;

use html_writer;

/**
 * Trait CartStatusTrait
 * Provides methods related to cart status.
 *
 * @property int $status The status of the cart (e.g., active, checkout, delivered).
 * @property string $statusName
 * @property string $statusNameFormattedHtml
 * @property bool $isCurrent
 * @property bool $isCheckout
 * @property bool $isCanceled
 * @property bool $isDelivered
 */
trait CartStatusTrait {
    /**
     * Returns an array of possible status values for the cart.
     * @return string[] An associative array of status values with their corresponding labels.
     */
    public static function getStatusOptions(): array {
        return [
            CartStatusInterface::STATUS_CURRENT => get_string('status_current', 'enrol_cart'),
            CartStatusInterface::STATUS_CHECKOUT => get_string('status_checkout', 'enrol_cart'),
            CartStatusInterface::STATUS_CANCELED => get_string('status_canceled', 'enrol_cart'),
            CartStatusInterface::STATUS_DELIVERED => get_string('status_delivered', 'enrol_cart'),
        ];
    }

    /**
     * Retrieve the name of the status.
     *
     * @return string The name of the status.
     */
    public function getStatusName(): string {
        $options = static::getStatusOptions();
        return $options[$this->status] ?? get_string('unknown', 'enrol_cart');
    }

    /**
     * Return the status name.
     * @return string Return `<span class="badge badge-success">Delivered</span>` or `<span class="badge badge-dark">Current</span>`
     */
    public function getStatusNameFormattedHtml(): string {
        $class = 'badge badge-dark';
        switch ($this->status) {
            case CartStatusInterface::STATUS_CHECKOUT:
                $class = 'badge badge-warning';
                break;
            case CartStatusInterface::STATUS_DELIVERED:
                $class = 'badge badge-success';
                break;
            case CartStatusInterface::STATUS_CANCELED:
                $class = 'badge badge-danger';
                break;
        }
        return html_writer::tag('span', $this->statusName, [
            'class' => $class,
        ]);
    }

    /**
     * Checks if the cart is in the "current" status.
     * @return bool True if the cart is in the "current" status, false otherwise.
     */
    public function getIsCurrent(): bool {
        return $this->status == CartStatusInterface::STATUS_CURRENT;
    }

    /**
     * Checks if the cart is in the "checkout" status.
     * @return bool True if the cart is in the "checkout" status, false otherwise.
     */
    public function getIsCheckout(): bool {
        return $this->status == CartStatusInterface::STATUS_CHECKOUT;
    }

    /**
     * Checks if the cart is in the "canceled" status.
     * @return bool True if the cart is in the "canceled" status, false otherwise.
     */
    public function getIsCanceled(): bool {
        return $this->status == CartStatusInterface::STATUS_CANCELED;
    }

    /**
     * Checks if the cart is in the "delivered" status.
     * @return bool True if the cart is in the "delivered" status, false otherwise.
     */
    public function getIsDelivered(): bool {
        return $this->status == CartStatusInterface::STATUS_DELIVERED;
    }
}
