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

use core_course_list_element;
use moodle_url;

/**
 * Class course
 *
 * Represents a course in the system and extends functionality from base_model.
 *
 * @property int $id The ID of the course.
 * @property string $name The shortname of the course.
 * @property string $title The fullname of the course.
 * @property string $image_url The URL of the course image.
 */
class course extends base_model {
    /**
     * @var string|null Private property to store the course image URL.
     */
    private ?string $_image_url = null;

    /**
     * Retrieves the attributes of the course.
     *
     * @return array An array of course attributes including id, name, and title.
     */
    public function attributes(): array {
        return ['id', 'name', 'title'];
    }

    /**
     * Finds a course by its instance ID.
     *
     * @param int $instanceid The instance ID of the course.
     * @return null|self The course object corresponding to the instance ID.
     */
    public static function find_one_by_instance_id(int $instanceid): ?self {
        global $DB; // Global database object.

        // SQL query to retrieve course details based on instance ID.
        $row = $DB->get_record_sql(
            'SELECT c.id, c.shortname as name, c.fullname as title
                 FROM {course} c
                 INNER JOIN {enrol} e ON e.courseid = c.id
                 WHERE e.id = :instance_id',
            ['instance_id' => $instanceid],
        );

        return $row ? static::populate_one($row) : null; // Returns a populated course object.
    }

    /**
     * Retrieves the URL of the course image.
     *
     * @return string The URL of the course image.
     */
    public function get_image_url(): string {
        if ($this->_image_url === null) {
            $this->_image_url = ''; // Initialize image URL to an empty string.

            // Create a new core_course_list_element object for the course.
            $courselistelement = new core_course_list_element(
                (object) [
                    'id' => $this->id,
                    'shortname' => $this->name,
                    'fullname' => $this->title,
                ],
            );

            // Iterate through course overview files to find valid images.
            foreach ($courselistelement->get_course_overviewfiles() as $file) {
                if ($file->is_valid_image()) {
                    // Check if the file is a valid image.
                    // Construct the path for the image URL.
                    $path = implode('/', [
                        '/pluginfile.php',
                        $file->get_contextid(),
                        $file->get_component(),
                        $file->get_filearea() . $file->get_filepath() . $file->get_filename(),
                    ]);

                    // Generate and set the image URL using moodle_url class.
                    $this->_image_url = (new moodle_url($path))->out();
                }
            }
        }

        return $this->_image_url; // Return the URL of the course image.
    }
}
