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

/**
 * Data Transfer Object for Cart.
 *
 * This class is used to transfer data related to a shopping cart in the enrolment system.
 */
class CartDto
{
    private Cart $cart;

    /**
     * Constructor for CartDto.
     *
     * @param Cart $cart The cart object to be used for data transfer.
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Get the cart ID.
     *
     * @return int The ID of the cart.
     */
    public function getCartId(): int
    {
        return $this->cart->id;
    }

    /**
     * Get the user ID associated with the cart.
     *
     * @return int The ID of the user.
     */
    public function getUserId(): int
    {
        return $this->cart->user_id;
    }

    /**
     * Get the coupon ID applied to the cart.
     *
     * @return int|null The ID of the coupon, or null if no coupon is applied.
     */
    public function get_coupon_id(): ?int
    {
        return $this->cart->coupon_id;
    }

    /**
     * Get the coupon code applied to the cart.
     *
     * @return string|null The coupon code, or null if no coupon is applied.
     */
    public function getCouponCode(): ?string
    {
        return $this->cart->coupon_code;
    }

    /**
     * Get the coupon usage ID.
     *
     * @return int|null The ID of the coupon usage, or null if no coupon is used.
     */
    public function getCouponUsageId(): ?int
    {
        return $this->cart->coupon_usage_id;
    }

    /**
     * Get the discount amount provided by the coupon.
     *
     * @return string|null The discount amount, or null if no coupon is applied.
     */
    public function getCouponDiscountAmount(): ?string
    {
        return $this->cart->coupon_discount_amount;
    }

    /**
     * Get the final price of the cart before any discounts.
     *
     * @return float The final price of the cart.
     */
    public function getFinalPrice(): float
    {
        return $this->cart->finalPrice;
    }

    /**
     * Get the final payable amount of the cart after applying discounts.
     *
     * @return float The final payable amount.
     */
    public function getFinalPayable(): float
    {
        return $this->cart->finalPayable;
    }

    /**
     * Get the items in the cart.
     *
     * @return CartItemDto[] An array of CartItemDto objects representing the items in the cart.
     */
    public function getCartItems(): array
    {
        $items = [];
        foreach ($this->cart->items as $cartItem) {
            $items[] = new CartItemDto($cartItem);
        }

        return $items;
    }
}
