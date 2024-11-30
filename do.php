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

require_once('../../config.php');

use enrol_cart\local\helper\cart_helper;

$action = required_param('action', PARAM_ALPHANUMEXT);

// The cart enrolment disabled.
if (!enrol_is_enabled('cart')) {
    throw new moodle_exception('error_disabled', 'enrol_cart');
}

// If guest cart access is disabled, require user login.
$enableguestcart = cart_helper::get_config('enable_guest_cart');
if (!$enableguestcart) {
    require_login();
}

// Add or remove an item or a course.
if ($action == 'add' || $action == 'remove') {
    $instanceid = optional_param('instance', null, PARAM_INT);
    $courseid = optional_param('course', null, PARAM_INT);

    if (!$instanceid && !$courseid) {
        throw new moodle_exception('CourseID or InstanceID is required.');
    }

    if ($action == 'add') {
        if ($instanceid) {
            cart_helper::add_instance_to_cart($instanceid);
        } else if ($courseid) {
            cart_helper::add_course_to_cart($courseid);
        }
    } else if ($action == 'remove') {
        if ($instanceid) {
            cart_helper::remove_instance_from_cart($instanceid);
        } else if ($courseid) {
            cart_helper::remove_course_from_cart($courseid);
        }
    }
}

redirect(cart_helper::get_cart_view_url());
