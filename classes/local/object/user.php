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

use moodle_url;

/**
 * Class user
 *
 * Represents a user in the system and extends functionality from base_model.
 *
 * @property int $id The ID of the user.
 * @property string $username The username of the user.
 * @property string $email The email of the user.
 * @property string $first_name The first name of the user.
 * @property string $last_name The last name of the user.
 * @property string $first_name_phonetic
 * @property string $last_name_phonetic
 * @property string $middle_name
 * @property string $alternate_name
 *
 * @property string $full_name The full name of the user.
 * @property string $profile_url The url of the user profile.
 */
class user extends base_model {
    /**
     * Stores the full name of the user as a private string property.
     *
     * @var string
     */
    private string $_full_name = '';

    /**
     * Retrieves the attributes of the course.
     *
     * @return array An array of course attributes including id, name, and title.
     */
    public function attributes(): array {
        return [
            'id',
            'username',
            'email',
            'first_name',
            'last_name',
            'first_name_phonetic',
            'last_name_phonetic',
            'middle_name',
            'alternate_name',
        ];
    }

    /**
     * Finds a user by its user ID.
     *
     * @param int $userid The user ID of the user.
     * @return null|self The User object corresponding to the user ID.
     */
    public static function find_one_id(int $userid): ?self {
        global $DB;

        // SQL query to retrieve user details based on user ID.
        $row = $DB->get_record_sql(
            'SELECT id, username, email, firstname as first_name, lastname as last_name,
       firstnamephonetic as first_name_phonetic, lastnamephonetic as last_name_phonetic,
       middlename as middle_name, alternatename as alternate_name
                 FROM {user} u
                 WHERE id = :id',
            ['id' => $userid],
        );

        return $row ? static::populate_one($row) : null;
    }

    /**
     * Gets the full name of the user by combining first and last names.
     *
     * @return string The full name of the user.
     */
    public function get_full_name(): string {
        if (empty($this->_full_name)) {
            $user = (object) [
                'firstname' => $this->first_name,
                'lastname' => $this->last_name,
                'firstnamephonetic' => $this->first_name_phonetic,
                'lastnamephonetic' => $this->last_name_phonetic,
                'middlename' => $this->middle_name,
                'alternatename' => $this->alternate_name,
            ];
            $this->_full_name = fullname($user);
        }

        return $this->_full_name;
    }

    /**
     * Generates the URL to the user's profile page.
     *
     * @return moodle_url The URL for the user's profile page.
     */
    public function get_profile_url(): moodle_url {
        return new moodle_url('/user/profile.php', ['id' => $this->id]);
    }
}
