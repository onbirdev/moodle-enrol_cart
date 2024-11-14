<?php

/**
 * @package    enrol_cart
 * @brief      Shopping Cart Enrolment Plugin for Moodle
 * @category   Moodle, Enrolment, Shopping Cart
 *
 * @author     MohammadReza PourMohammad <onbirdev@gmail.com>
 * @copyright  2024 MohammadReza PourMohammad
 * @link       https://onbir.dev
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_cart\object;

defined('MOODLE_INTERNAL') || die();

use enrol_cart\formatter\CurrencyFormatter;
use enrol_cart\helper\CartHelper;
use moodle_exception;
use moodle_url;

/**
 * Class CartItem
 *
 * Represents an item in a shopping cart and extends the functionality provided by BaseModel.
 *
 * @property int $id The unique identifier for the cart item.
 * @property int $cart_id The ID of the cart to which this item belongs.
 * @property int $instance_id The ID of the enrolment instance associated with this item.
 * @property float $price The price of the enrolment associated with this item.
 * @property float $payable The payable amount for the enrolment associated with this item.
 *
 * @property string $priceFormatted The human-readable price.
 * @property string $payableFormatted The human-readable payable amount.
 *
 * @property Course $course The course object associated with this item.
 * @property Cart|CookieCart $cart The cart object associated with this item.
 *
 * @property moodle_url $viewUrl The URL for viewing the course associated with this item.
 * @property moodle_url $removeUrl The URL for removing this item from the cart.
 *
 * @property bool $hasDiscount Indicates whether the item has a discount.
 * @property int $discountPercent The discount percentage applied to the item.
 * @property string $discountPercentFormatted The formatted discount percentage.
 */
class CartItem extends BaseModel
{
    /** @var Cart|CookieCart|null The cart object associated with this item. */
    private $_cart;
    /** @var Course|null The course object associated with this item. */
    private ?Course $_course = null;

    /**
     * Defines the attributes of the CartItem model.
     *
     * @inheritdoc
     * @return array The attributes of the CartItem model.
     */
    public function attributes(): array
    {
        return ['id', 'cart_id', 'instance_id', 'price', 'payable'];
    }

    /**
     * Retrieves all cart items associated with a given cart ID.
     *
     * @param int $cartId The ID of the cart.
     * @return CartItem[] An array of CartItem objects.
     */
    public static function findAll(int $cartId): array
    {
        global $DB; // Global database object.

        // Fetches all cart items for the specified cart ID.
        $rows = $DB->get_records('enrol_cart_items', ['cart_id' => $cartId], 'id ASC');

        return static::populate($rows);
    }

    /**
     * Deletes the cart item from the database.
     *
     * @return bool True if the item is successfully deleted, false otherwise.
     */
    public function delete(): bool
    {
        global $DB; // Global database object.

        // Checks if the item exists in the database and deletes it.
        if ($this->id && $this->cart_id) {
            return $DB->delete_records('enrol_cart_items', ['id' => $this->id]);
        }

        return false;
    }

    /**
     * Called after retrieving a cart item from the database.
     * Populates additional attributes and strings for convenient usage.
     *
     * @return void
     */
    public function afterFind()
    {
        // This method can be used to perform any additional tasks after retrieving a cart item.
    }

    /**
     * Adds an item to the cart.
     *
     * This method creates a cart item record in the {enrol_cart_items} table.
     *
     * @param int $cartId The ID of the cart.
     * @param int $instanceId The ID of the enrolment instance to be added to the cart.
     * @return bool True if the item is successfully added, false otherwise.
     */
    public static function addItemToCart(int $cartId, int $instanceId): bool
    {
        global $DB;

        // Check if the item does not already exist in the cart, and check if the instance exists.
        if (
            !$DB->record_exists('enrol_cart_items', ['cart_id' => $cartId, 'instance_id' => $instanceId]) &&
            ($instance = CartHelper::get_instance($instanceId))
        ) {
            // Create a new cart item object.
            $item = (object) [
                'cart_id' => $cartId,
                'instance_id' => $instance->id,
                'price' => $instance->price,
                'payable' => $instance->payable,
            ];

            // Insert the item into the database.
            return $DB->insert_record('enrol_cart_items', $item);
        }

        return false;
    }

    /**
     * Updates the item price and payable value from the instance record.
     *
     * @return void
     */
    public function updatePriceAndPayable()
    {
        if (!$this->cart->canEditItems) {
            return;
        }

        $instance = CartHelper::get_instance($this->instance_id);

        // Updates the price and payable amount if they have changed.
        if ($instance && ($this->price != $instance->price || $this->payable != $instance->payable)) {
            $this->price = $instance->price;
            $this->payable = $instance->payable;

            if ($this->id) {
                global $DB;
                $DB->update_record(
                    'enrol_cart_items',
                    (object) [
                        'id' => $this->id,
                        'price' => $this->price,
                        'payable' => $this->payable,
                    ],
                );
            }
        }
    }

    /**
     * Retrieves the cart model associated with this item.
     *
     * @return Cart|CookieCart|null The cart model associated with this item.
     */
    public function getCart()
    {
        if (!$this->_cart) {
            $this->_cart = $this->cart_id ? Cart::findOne($this->cart_id) : new CookieCart();
        }

        return $this->_cart;
    }

    /**
     * Retrieves the course object associated with the item.
     *
     * @return Course|null The course object associated with the item.
     */
    public function getCourse(): ?Course
    {
        if (!$this->_course) {
            $this->_course = Course::findOneByInstanceId($this->instance_id);
        }

        return $this->_course;
    }

    /**
     * Checks if the item has a discount applied.
     *
     * @return bool True if the item has a discount, false otherwise.
     */
    public function getHasDiscount(): bool
    {
        return $this->price - $this->payable > 0;
    }

    /**
     * Retrieves the discount percentage applied to the item.
     *
     * @return int|null The discount percentage or null if no discount is applied.
     */
    public function getDiscountPercent(): ?int
    {
        if ($this->hasDiscount) {
            return 100 - floor(($this->payable * 100) / $this->price);
        }

        return null;
    }

    /**
     * Retrieves the formatted discount percentage.
     *
     * @return string|null The formatted discount percentage or null if no discount is applied.
     */
    public function getDiscountPercentFormatted(): ?string
    {
        $discountPercent = $this->discountPercent;

        if ($discountPercent) {
            $discountPercent = $discountPercent . '%';
            if (CartHelper::get_config('convert_numbers_to_persian')) {
                return CurrencyFormatter::convert_english_numbers_to_persian($discountPercent);
            }

            return $discountPercent;
        }

        return null;
    }

    /**
     * Returns the price as a human-readable format.
     *
     * @return string The formatted price string.
     */
    public function getPriceFormatted(): string
    {
        if ($this->price > 0) {
            return CurrencyFormatter::get_cost_as_formatted((float) $this->price, $this->cart->finalCurrency);
        }

        return get_string('free', 'enrol_cart'); // Return 'free' string if price is zero.
    }

    /**
     * Returns the payable amount as a human-readable format.
     *
     * @return string The formatted payable string.
     */
    public function getPayableFormatted(): string
    {
        if ($this->payable > 0) {
            return CurrencyFormatter::get_cost_as_formatted((float) $this->payable, $this->cart->finalCurrency);
        }

        return get_string('free', 'enrol_cart'); // Return 'free' string if payable is zero.
    }

    /**
     * Retrieves the URL for viewing the course associated with this item.
     *
     * @return moodle_url The URL for viewing the course.
     * @throws moodle_exception Thrown when moodle_url instantiation fails.
     */
    public function getViewUrl(): moodle_url
    {
        return new moodle_url('/course/view.php', ['id' => $this->course->id]);
    }

    /**
     * Retrieves the URL for removing this item from the cart.
     *
     * @return moodle_url The URL for removing the item.
     * @throws moodle_exception Thrown when moodle_url instantiation fails.
     */
    public function getRemoveUrl(): moodle_url
    {
        return new moodle_url('/enrol/cart/do.php', ['action' => 'remove', 'instance' => $this->instance_id]);
    }
}
