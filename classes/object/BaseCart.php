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
use moodle_url;

/**
 * The BaseCart class provides a foundation for shopping cart functionality.
 *
 * @property CartItem[] $items An array of cart items.
 * @property int $count The total count of items in the cart.
 * @property bool $isEmpty Returns true if there are no items in the cart.
 * @property bool $isCurrentUserOwner Returns true if the current user ID matches the cart owner's user ID, false otherwise.
 * @property bool $canEditItems Whether items in the cart can be edited (true/false).
 * @property int $paymentAccountId The cart payment account ID.
 *
 * @property string $finalCurrency The final currency code used in the cart.
 * @property float|int $finalPrice The total price of items in the cart.
 * @property float|int $finalPayable The total amount payable after discounts.
 * @property float|int $itemsDiscountAmount The items discount amount.
 * @property float|int $finalDiscountAmount The total discount amount applied.
 * @property string $finalPriceFormatted The formatted total price.
 * @property string $finalPayableFormatted The formatted total payable amount.
 * @property string $itemsDiscountAmountFormatted The formatted items discount amount.
 * @property string $finalDiscountAmountFormatted The formatted discount amount.
 *
 * @property moodle_url $viewUrl The URL for viewing the cart.
 * @property moodle_url $checkoutUrl The URL for checkout the cart.
 */
abstract class BaseCart extends BaseModel
{
    use CartStatusTrait;

    /** @var array An array of the cart items */
    protected array $_items = [];

    public function init()
    {
        $this->setAttribute('id', 0);
        $this->setAttribute('user_id', 0);
        $this->setAttribute('status', CartStatusInterface::STATUS_CURRENT);
    }

    /**
     * @inheritdoc
     * @return string[]
     */
    public function attributes(): array
    {
        return ['id', 'user_id', 'status'];
    }

    /**
     * Retrieve the currency used in the cart.
     * @return string The currency code.
     */
    public function getFinalCurrency(): string
    {
        return (string) CartHelper::get_config('payment_currency');
    }

    /**
     * Returns the total price of items in the cart.
     * @return float|int The total price amount.
     */
    public function getFinalPrice()
    {
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item->price;
        }

        return $price;
    }

    /**
     * Returns the formatted total price of items in the cart.
     * @return string The formatted price string.
     */
    public function getFinalPriceFormatted(): string
    {
        if ($this->finalPrice > 0) {
            return CurrencyFormatter::get_cost_as_formatted($this->finalPrice, $this->finalCurrency);
        }

        return get_string('free', 'enrol_cart');
    }

    /**
     * Returns the total payable amount after discounts.
     * @return float|int The total payable amount.
     */
    public function getFinalPayable()
    {
        $payable = 0;
        foreach ($this->items as $item) {
            $payable += $item->payable;
        }

        return $payable;
    }

    /**
     * Returns the formatted total payable amount after discounts.
     * @return string The formatted payable string.
     */
    public function getFinalPayableFormatted(): string
    {
        if ($this->finalPayable > 0) {
            return CurrencyFormatter::get_cost_as_formatted($this->finalPayable, $this->finalCurrency);
        }

        return get_string('free', 'enrol_cart');
    }

    /**
     * Returns the items discount amount applied.
     * @return float|int The discount amount.
     */
    public function getItemsDiscountAmount()
    {
        $payable = 0;
        $price = 0;
        foreach ($this->items as $item) {
            $payable += $item->payable;
            $price += $item->price;
        }
        return $price - $payable;
    }

    /**
     * Returns the formatted items discount amount.
     * @return string|null The formatted discount amount string.
     */
    public function getItemsDiscountAmountFormatted(): ?string
    {
        if ($this->itemsDiscountAmount) {
            return CurrencyFormatter::get_cost_as_formatted((float) $this->itemsDiscountAmount, $this->finalCurrency);
        }

        return null;
    }

    /**
     * Returns the total discount amount applied.
     * @return float|int The discount amount.
     */
    public function getFinalDiscountAmount()
    {
        return $this->finalPrice - $this->finalPayable;
    }

    /**
     * Returns the formatted discount amount.
     * @return string|null The formatted discount amount string.
     */
    public function getFinalDiscountAmountFormatted(): ?string
    {
        if ($this->finalDiscountAmount) {
            return CurrencyFormatter::get_cost_as_formatted((float) $this->finalDiscountAmount, $this->finalCurrency);
        }

        return null;
    }

    /**
     * Returns the total count of items in the cart.
     * @return int The total count of items.
     */
    public function getCount(): int
    {
        return count($this->items);
    }

    /**
     * Checks if the cart is empty.
     * @return bool True if the cart is empty, false otherwise.
     */
    public function getIsEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * Check if the current user is the owner of the cart.
     *
     * @return bool Returns true if the current user ID matches the cart owner's user ID, false otherwise.
     */
    public function getIsCurrentUserOwner(): bool
    {
        global $USER;
        return !$USER->id || (isset($this->user_id) && $USER->id == $this->user_id);
    }

    /**
     * Check if items in the shopping cart can be edited.
     *
     * @return bool Returns true if the cart is currently active and items can be edited, false otherwise.
     */
    public function getCanEditItems(): bool
    {
        return $this->isCurrent && $this->isCurrentUserOwner;
    }

    /**
     * Retrieves the cart payment account ID.
     * @return int The cart payment account ID.
     */
    public function getPaymentAccountId(): int
    {
        return (int) CartHelper::get_config('payment_account');
    }

    /**
     * Adds a course to the cart.
     * @param int $courseId The ID of the course to be added to the cart.
     * @return bool True if the course is successfully added, false otherwise.
     */
    public function addCourse(int $courseId): bool
    {
        $instanceId = CartHelper::get_course_instance_id($courseId);
        if ($instanceId) {
            return $this->addItem($instanceId);
        }

        return false;
    }

    /**
     * Removes a course from the cart.
     * @param int $courseId The ID of the course to be removed from the cart.
     * @return bool True if the course is successfully removed, false otherwise.
     */
    public function removeCourse(int $courseId): bool
    {
        $instanceId = CartHelper::get_course_instance_id($courseId);
        if ($instanceId) {
            return $this->removeItem($instanceId);
        }

        return false;
    }

    /**
     * Checks if the cart contains an item with the specified enrolment instance ID.
     * @param int $instanceId The enrolment instance ID to check.
     * @return bool True if the item is in the cart, false otherwise.
     */
    public function hasItem(int $instanceId): bool
    {
        foreach ($this->items as $item) {
            if ($item->instance_id == $instanceId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Refreshes the cart items.
     * @return bool
     */
    public function refresh(): bool
    {
        $this->_items = [];

        return true;
    }

    /**
     * Retrieves the URL for viewing the cart associated with this item.
     *
     * @return moodle_url The URL for viewing the cart.
     */
    public function getViewUrl(): moodle_url
    {
        return CartHelper::get_cart_view_url($this->id ?? null);
    }

    /**
     * Retrieves the URL for checkout the cart associated with this item.
     *
     * @return moodle_url The URL for viewing the cart.
     */
    public function getCheckoutUrl(): moodle_url
    {
        return CartHelper::get_cart_checkout_url($this->id ?? null);
    }

    /**
     * Adds an enrol item to the cart.
     * @param int $instanceId The enrolment instance ID to be added to the cart.
     * @return bool True if the item is successfully added, false otherwise.
     */
    abstract public function addItem(int $instanceId): bool;

    /**
     * Removes an enrol item from the cart.
     * @param int $instanceId The enrolment instance ID to be removed from the cart.
     * @return bool True if the item is successfully removed, false otherwise.
     */
    abstract public function removeItem(int $instanceId): bool;

    /**
     * Returns an array of cart items.
     * @return CartItem[] An array of CartItem objects representing the cart items.
     */
    abstract public function getItems(): array;

    /**
     * Initiates the checkout process for the cart.
     *
     * This method typically handles the necessary steps to finalize a purchase,
     * such as payment processing and order confirmation.
     *
     * @return bool True if the checkout process is successful, false otherwise.
     */
    abstract public function checkout(): bool;

    /**
     * Cancels the cart and removes associated items.
     *
     * This method is used to cancel the current cart, removing any items
     * that were added to it during the shopping session.
     *
     * @return bool True if the cart cancellation is successful, false otherwise.
     */
    abstract public function cancel(): bool;

    /**
     * Delivers the items in the cart to the user.
     *
     * This method is responsible for processing and delivering the selected items
     * to the user, typically by enrolling them in courses or finalizing any other
     * relevant transactions associated with the cart items.
     *
     * @return bool True if the delivery process is successful, false otherwise.
     */
    abstract public function deliver(): bool;
}
