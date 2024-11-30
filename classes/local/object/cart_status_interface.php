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

namespace enrol_cart\local\object;

/**
 * Interface cart_status_interface
 * Defines constants for cart status.
 */
interface cart_status_interface {
    /** @var int The current status of the cart */
    public const STATUS_CURRENT = 0;
    /** @var int The status when user is in the process of checkout */
    public const STATUS_CHECKOUT = 10;
    /** @var int The status when the cart has been canceled by the user */
    public const STATUS_CANCELED = 70;
    /** @var int The status when items in the cart have been delivered to the user */
    public const STATUS_DELIVERED = 90;
}
