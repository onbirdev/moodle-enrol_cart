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

namespace enrol_cart\local\availability;

use coding_exception;
use context;
use context_course;
use dml_exception;
use enrol_cart\local\object\cart_enrollment_instance;

/**
 * Availability info class for enrol_cart plugin.
 *
 * This lets enrol_cart consume Moodle's core availability API.
 */
class info extends \core_availability\info {
    /** @var cart_enrollment_instance */
    protected cart_enrollment_instance $instance;

    /**
     * Constructor for info class.
     *
     * @param cart_enrollment_instance $instance
     * @throws coding_exception
     * @throws dml_exception
     */
    public function __construct(cart_enrollment_instance $instance) {
        global $DB;

        $this->instance = $instance;

        $course = $DB->get_record('course', ['id' => $instance->course_id]);
        $visible = $instance->status == 0;

        parent::__construct($course, $visible, $instance->availability_conditions_json);
    }

    /**
     * Get instance context
     *
     * @return bool|context|context_course
     */
    public function get_context() {
        return context_course::instance($this->course->id);
    }

    /**
     * Get thing name
     *
     * @return string
     */
    protected function get_thing_name(): string {
        return $this->instance->name ?? '';
    }

    /**
     * Set availability in database
     *
     * @param string $availability
     * @return void
     * @throws dml_exception
     */
    protected function set_in_database($availability) {
        global $DB;

        $instance = (object) [
            'id' => $this->instance->id,
            'customtext2' => $availability,
            'timemodified' => $this->instance->availability_conditions_json,
        ];

        $DB->update_record('enrol', $instance);
    }

    /**
     * Get the capability required to view hidden content
     *
     * @return string
     */
    protected function get_view_hidden_capability(): string {
        return 'moodle/course:ignoreavailabilityrestrictions';
    }
}
