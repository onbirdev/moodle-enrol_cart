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
 * Base model class providing common data model functionality.
 *
 * This class extends base_object and serves as a foundation for data models in the system.
 * It includes shared properties and methods for handling data, which can be utilized
 * by derived model classes to ensure consistency and reusability across different models.
 */
class base_model extends base_object {
    /**
     * @var array dynamic attribute values (name => value).
     */
    private array $_attributes = [];

    /**
     * Constructor.
     *
     * @param array $attributes the attributes (name-value pairs, or names) being defined.
     * @param array $config the configuration array to be applied to this object.
     */
    public function __construct(array $attributes = [], array $config = []) {
        foreach ($attributes as $name => $value) {
            if (is_int($name)) {
                $this->_attributes[$value] = null;
            } else {
                $this->_attributes[$name] = $value;
            }
        }
        parent::__construct($config);
    }

    /**
     * PHP getter magic method.
     * This method is overridden so that attributes and related objects can be accessed like properties.
     *
     * @param string $name property name
     * @return mixed property value
     * @throws Exception
     * @see get_attribute()
     */
    public function __get(string $name) {
        $getter = 'get_' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        if (array_key_exists($name, $this->_attributes)) {
            return $this->_attributes[$name];
        }

        if ($this->has_attribute($name)) {
            return null;
        }

        throw new Exception('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    /**
     * PHP setter magic method.
     *
     * @param string $name property name
     * @param mixed $value property value
     * @throws Exception
     */
    public function __set(string $name, $value) {
        if ($this->has_attribute($name)) {
            $this->_attributes[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * Checks if a property value is null.
     *
     * @param string $name the property name or the event name
     * @return bool whether the property value is null
     */
    public function __isset(string $name) {
        try {
            return $this->__get($name) !== null;
        } catch (Exception $t) {
            return false;
        }
    }

    /**
     * Sets a component property to be null.
     *
     * @param string $name the property name or the event name
     */
    public function __unset(string $name) {
        if ($this->has_attribute($name)) {
            unset($this->_attributes[$name]);
        }
    }

    /**
     * {@inheritDoc}
     * @param string $name the property name
     * @param bool $checkvars whether to treat member variables as properties
     * @return bool whether the property can be read
     */
    public function can_get_property(string $name, bool $checkvars = true): bool {
        if (parent::can_get_property($name, $checkvars)) {
            return true;
        }
        try {
            return $this->has_attribute($name);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     * @param string $name the property name
     * @param bool $checkvars whether to treat member variables as properties
     * @return bool whether the property can be written
     */
    public function can_set_property(string $name, bool $checkvars = true): bool {
        if (parent::can_set_property($name, $checkvars)) {
            return true;
        }
        try {
            return $this->has_attribute($name);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Defines an attribute.
     *
     * @param string $name the attribute name.
     * @param mixed $value the attribute value.
     */
    public function define_attribute(string $name, $value = null) {
        $this->_attributes[$name] = $value;
    }

    /**
     * Returns the list of attribute names.
     *
     * @return string[] list of attribute names.
     */
    public function attributes(): array {
        return array_keys($this->_attributes);
    }

    /**
     * Returns a value indicating whether the model has an attribute with the specified name.
     *
     * @param string $name the name of the attribute
     * @return bool whether the model has an attribute with the specified name.
     */
    public function has_attribute(string $name): bool {
        return isset($this->_attributes[$name]) || in_array($name, $this->attributes(), true);
    }

    /**
     * Returns the named attribute value.
     *
     * @param string $name the attribute name
     * @return mixed the attribute value. `null` if the attribute is not set or does not exist.
     * @see has_attribute()
     */
    public function get_attribute(string $name) {
        return $this->_attributes[$name] ?? null;
    }

    /**
     * Sets the named attribute value.
     *
     * @param string $name the attribute name
     * @param mixed $value the attribute value.
     * @throws Exception if the named attribute does not exist.
     * @see has_attribute()
     */
    public function set_attribute(string $name, $value) {
        if ($this->has_attribute($name)) {
            $this->_attributes[$name] = $value;
        } else {
            throw new Exception(get_class($this) . ' has no attribute named "' . $name . '".');
        }
    }

    /**
     * Returns attribute values.
     *
     * @param array|null $names list of attributes whose value needs to be returned.
     * @return array attribute values (name => value).
     */
    public function get_attributes(?array $names = null): array {
        $values = [];
        if ($names === null) {
            $names = $this->attributes();
        }
        foreach ($names as $name) {
            $values[$name] = $this->$name;
        }
        return $values;
    }

    /**
     * Sets the attribute values in a massive way.
     *
     * @param array $values attribute values (name => value) to be assigned to the model.
     * A safe attribute is one that is associated with a validation rule in the current [[scenario]].
     */
    public function set_attributes(array $values) {
        $attributes = array_flip($this->attributes());
        foreach ($values as $name => $value) {
            if (isset($attributes[$name])) {
                $this->$name = $value;
            }
        }
    }

    /**
     * Creates a model instance.
     *
     * @param array $row row data to be populated into the record.
     * @return static the newly created model
     */
    public static function instantiate(array $row): base_model {
        return new static();
    }

    /**
     * Populates an active record object using a row of data from the database.
     *
     * @param base_model $record the record to be populated.
     * @param array $row attribute values (name => value)
     */
    public static function populate_record(base_model $record, array $row) {
        $columns = array_flip($record->attributes());
        foreach ($row as $name => $value) {
            if (isset($columns[$name])) {
                $record->_attributes[$name] = $value;
            } else if ($record->can_set_property($name)) {
                $record->$name = $value;
            }
        }
    }

    /**
     * Converts found rows into model instances.
     *
     * @param array $rows
     * @return array|static[]
     */
    protected static function create_models(array $rows): array {
        $models = [];
        /** @var base_model $class */
        $class = get_called_class();
        foreach ($rows as $row) {
            $row = (array) $row;
            $model = $class::instantiate($row);
            $modelclass = get_class($model);
            $modelclass::populate_record($model, $row);
            $models[] = $model;
        }
        return $models;
    }

    /**
     * Converts the raw query results.
     *
     * @param array $rows the raw query result from database
     * @return array the converted query result
     */
    public static function populate(array $rows): array {
        if (empty($rows)) {
            return [];
        }
        $models = static::create_models($rows);
        foreach ($models as $model) {
            $model->after_find();
        }
        return $models;
    }

    /**
     * Converts the raw query results.
     *
     * @param object|array $row the raw query result from database
     * @return static the converted query result
     */
    public static function populate_one($row): self {
        $models = static::create_models([$row]);
        $model = $models[0];
        $model->after_find();
        return $model;
    }

    /**
     * This method is called when the Model object is created and populated with the query result.
     *
     * @return void
     */
    public function after_find() {
    }
}
