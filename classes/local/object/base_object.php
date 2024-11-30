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

use Exception;

/**
 * Base class for general object functionality.
 */
class base_object {
    /**
     * Constructor.
     *
     * - Initializes the object with the given configuration `$config`.
     * - Call [[init()]].
     *
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct(array $config = []) {
        if (!empty($config)) {
            foreach ($config as $name => $value) {
                $this->$name = $value;
            }
        }
        $this->init();
    }

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init() {
    }

    /**
     * Returns the value of an object property.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `$value = $object->property;`.
     *
     * @param string $name the property name
     * @return mixed the property value
     * @throws Exception if the property is not defined
     * @see __set()
     */
    public function __get(string $name) {
        $getter = 'get_' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
        throw new Exception('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    /**
     * Sets value of an object property.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `$object->property = $value;`.
     *
     * @param string $name the property name or the event name
     * @param mixed $value the property value
     * @throws Exception if the property is not defined
     * @see __get()
     */
    public function __set(string $name, $value) {
        $setter = 'set_' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        }
        throw new Exception('Setting unknown property: ' . get_class($this) . '::' . $name);
    }

    /**
     * Checks if a property is set, i.e. defined and not null.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `isset($object->property)`.
     *
     * Note that if the property is not defined, false will be returned.
     *
     * @param string $name the property name or the event name
     * @return bool whether the named property is set (not null).
     * @see https://www.php.net/manual/en/function.isset.php
     */
    public function __isset(string $name) {
        $getter = 'get_' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        }
        return false;
    }

    /**
     * Sets an object property to null.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `unset($object->property)`.
     *
     * Note that if the property is not defined, this method will do nothing.
     * If the property is read-only, it will throw an exception.
     *
     * @param string $name the property name
     */
    public function __unset(string $name) {
        $setter = 'set_' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter(null);
        }
    }

    /**
     * Returns a value indicating whether a property is defined.
     *
     * A property is defined if:
     *
     * - the class has a getter or setter method associated with the specified name
     *   (in this case, property name is case-insensitive);
     * - the class has a member variable with the specified name (when `$checkvars` is true);
     *
     * @param string $name the property name
     * @param bool $checkvars whether to treat member variables as properties
     * @return bool whether the property is defined
     * @see can_get_property()
     * @see can_set_property()
     */
    public function has_property(string $name, bool $checkvars = true): bool {
        return $this->can_get_property($name, $checkvars) || $this->can_set_property($name, false);
    }

    /**
     * Returns a value indicating whether a property can be read.
     *
     * A property is readable if:
     *
     * - the class has a getter method associated with the specified name
     *   (in this case, property name is case-insensitive);
     * - the class has a member variable with the specified name (when `$checkvars` is true);
     *
     * @param string $name the property name
     * @param bool $checkvars whether to treat member variables as properties
     * @return bool whether the property can be read
     * @see can_set_property()
     */
    public function can_get_property(string $name, bool $checkvars = true): bool {
        return method_exists($this, 'get_' . $name) || ($checkvars && property_exists($this, $name));
    }

    /**
     * Returns a value indicating whether a property can be set.
     *
     * A property is writable if:
     *
     * - the class has a setter method associated with the specified name
     *   (in this case, property name is case-insensitive);
     * - the class has a member variable with the specified name (when `$checkvars` is true);
     *
     * @param string $name the property name
     * @param bool $checkvars whether to treat member variables as properties
     * @return bool whether the property can be written
     * @see can_get_property()
     */
    public function can_set_property(string $name, bool $checkvars = true): bool {
        return method_exists($this, 'set_' . $name) || ($checkvars && property_exists($this, $name));
    }

    /**
     * Returns a value indicating whether a method is defined.
     *
     * @param string $name the method name
     * @return bool whether the method is defined
     */
    public function has_method(string $name): bool {
        return method_exists($this, $name);
    }
}
