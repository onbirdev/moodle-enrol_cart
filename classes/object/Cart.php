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

use core\notification;
use dml_exception;
use enrol_cart\formatter\CurrencyFormatter;
use enrol_cart\helper\CartHelper;
use enrol_cart\helper\CouponHelper;
use Exception;

/**
 * Class Cart
 *
 * Represents a shopping cart and extends functionality from BaseCart.
 * Provides methods to manage cart items, handle coupon discounts, and process enrolments.
 *
 * @property int $id The unique identifier for the cart.
 * @property int $user_id The user ID associated with the cart.
 * @property int $status The status of the cart (e.g., active, checkout, delivered).
 * @property string|null $currency The currency code for the cart (e.g., USD, EUR).
 * @property float|null $price The total price of items in the cart.
 * @property float|null $payable The total payable amount after apply discount, tax, ....
 * @property int|null $coupon_id The ID of the applied coupon, if any.
 * @property string|null $coupon_code The code of the applied coupon.
 * @property int|null $coupon_usage_id The ID of the coupon user usage record.
 * @property float|null $coupon_discount_amount The discount amount from the applied coupon.
 * @property array|null $data Additional data related to the cart.
 * @property int|null $checkout_at The timestamp when the cart status changed for checkout.
 * @property int $created_at The timestamp when the cart was created.
 * @property int $created_by The user ID who created the cart.
 * @property int|null $updated_at The timestamp when the cart was last updated.
 * @property int|null $updated_by The user ID who last updated the cart.
 *
 * @property bool $hasChanged Returns true if the cart has changed, false otherwise.
 * @property bool $isCheckoutExpired Returns true if the checkout session has expired, false otherwise.
 * @property bool $isFinalPayableZero Check if the cart's payable amount is zero
 *
 * @property User $user The user object associated with this cart.
 * @property CartItem[] $items An array of CartItem objects representing the items in the cart.
 *
 * @property bool $hasCoupon Checks if a coupon is applied to the cart.
 * @property bool $canUseCoupon Determines if a coupon can be used with the cart.
 * @property string|null $couponCode The code of the last applied coupon, if any.
 * @property string|null $couponErrorCode The error code from the last applied coupon, if any.
 * @property string|null $couponErrorMessage The error message from the last applied coupon, if any.
 * @property float|null $couponDiscountAmount The discount amount from the applied coupon.
 * @property string|null $couponDiscountAmountFormatted The formatted coupon discount amount.
 *
 */
class Cart extends BaseCart
{
    private bool $_changed = false;
    private CouponResultDto $_couponResult;
    private ?User $_user = null;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->_couponResult = new CouponResultDto();
    }

    /**
     * @inheritdoc
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'id',
            'user_id',
            'status',
            'currency',
            'price',
            'payable',
            'coupon_id',
            'coupon_code',
            'coupon_usage_id',
            'coupon_discount_amount',
            'data',
            'checkout_at',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ];
    }

    /**
     * Retrieve the cart currency.
     * @return string The currency code of the cart.
     */
    public function getFinalCurrency(): string
    {
        return $this->currency ?: parent::getFinalCurrency();
    }

    /**
     * Retrieve the cart price.
     * @return int|string The total price of items in the cart.
     */
    public function getFinalPrice()
    {
        if ($this->isDelivered) {
            return $this->price;
        }

        return parent::getFinalPrice();
    }

    /**
     * Retrieve the cart payable.
     * @return float|int|null The total payable amount of items in the cart.
     */
    public function getFinalPayable()
    {
        if (!$this->canEditItems) {
            return $this->payable;
        }

        $finalPayable = parent::getFinalPayable();

        if ($this->hasCoupon) {
            $finalPayable -= $this->couponDiscountAmount;
        }

        return $finalPayable;
    }

    /**
     * Retrieve the cart total payable.
     * @return float|int|null The total payable amount of items in the cart.
     */
    public function getFinalTotalPayable()
    {
        if ($this->isDelivered) {
            return $this->payable;
        }

        $finalTotalPayable = parent::getFinalPayable();

        if ($this->hasCoupon) {
            $finalTotalPayable -= $this->couponDiscountAmount;
        }

        return $finalTotalPayable;
    }

    /**
     * Return the cart object.
     * @param bool $forceNew Create an active cart on the database for the current user.
     * @return Cart|null
     */
    public static function findCurrent(bool $forceNew = false): ?Cart
    {
        global $DB, $USER;

        static $current = null;

        if (!$current) {
            $cart = $DB->get_record('enrol_cart', [
                'user_id' => $USER->id,
                'status' => CartStatusInterface::STATUS_CURRENT,
            ]);
            if (!$cart && $forceNew) {
                $cart = (object) [
                    'user_id' => $USER->id,
                    'status' => CartStatusInterface::STATUS_CURRENT,
                    'created_at' => time(),
                    'created_by' => $USER->id,
                ];
                $cart->id = $DB->insert_record('enrol_cart', $cart);
            }
            $current = $cart ? static::populateOne($cart) : null;
        }

        return $current;
    }

    /**
     * @param int $id The ID of the cart to retrieve.
     * @return Cart|null
     * @throws dml_exception
     */
    public static function findOne(int $id): ?Cart
    {
        global $DB;
        $cart = $DB->get_record('enrol_cart', [
            'id' => $id,
        ]);
        if ($cart) {
            return static::populateOne($cart);
        }
        return null;
    }

    /**
     * Retrieves an array of carts for a specific user, paginated by page number and limit.
     *
     * This method queries the database to get a list of user carts and paginates the results
     * based on the given page number and limit per page.
     *
     * @param int $userId The ID of the user whose carts are being retrieved.
     * @param int $page The current page number for pagination (starting from 0).
     * @param int $limit The number of records to return per page.
     * @return array An array of user carts. If no carts are found, returns an empty array.
     */
    public static function findAllByUserId(int $userId, int $page, int $limit): array
    {
        global $DB;

        $rows = $DB->get_records_sql(
            'SELECT * FROM {enrol_cart} WHERE user_id = :user_id ORDER BY id DESC',
            [
                'user_id' => $userId,
            ],
            $page * $limit,
            $limit,
        );

        if ($rows) {
            return static::populate($rows);
        }

        return [];
    }

    /**
     * Returns the total count of carts for a specific user.
     *
     * This method counts the number of cart records in the database for a given user.
     *
     * @param int $userId The ID of the user whose cart count is being retrieved.
     * @return int The total number of carts associated with the user.
     */
    public static function countAllByUserId(int $userId): int
    {
        global $DB;

        // Return the count of cart records associated with the user.
        return $DB->count_records('enrol_cart', [
            'user_id' => $userId,
        ]);
    }

    /**
     * Save cart to DB.
     * @return bool
     * @throws dml_exception
     */
    public function save(): bool
    {
        global $DB, $USER;

        $data = [];
        foreach ($this->attributes() as $attribute) {
            $data[$attribute] = $this->$attribute;
        }

        // create new record
        if (empty($data['id'])) {
            $data['created_at'] = time();
            $data['created_by'] = $USER->id;
            $this->id = $DB->insert_record('enrol_cart', (object) $data);
            if (!$this->id) {
                return false;
            }
            return true;
        }

        // update
        $data['updated_at'] = time();
        $data['updated_by'] = $USER->id;

        return $DB->update_record('enrol_cart', (object) $data);
    }

    /**
     * Add an item to the cart.
     *
     * This method adds an enrolment instance to the shopping cart.
     *
     * @param int $instanceId The ID of the enrolment instance to be added to the cart.
     * @return bool True if the item is successfully added, false otherwise.
     */
    public function addItem(int $instanceId): bool
    {
        // Check if the user has permission to edit items in the cart, and the item does not already exist in the cart
        if ($this->canEditItems && !$this->hasItem($instanceId)) {
            // Ensure the user is not already enrolled in the instance, and add item to cart
            if (
                !CartHelper::isUserEnrolled($instanceId, $this->user_id) &&
                CartItem::addItemToCart($this->id, $instanceId)
            ) {
                return $this->refresh();
            } else {
                $course = Course::findOneByInstanceId($instanceId);
                // User already enrolled
                notification::info(
                    get_string('msg_already_enrolled', 'enrol_cart', [
                        'title' => $course ? $course->title : '',
                    ]),
                );
            }
        }

        return false; // Item not added
    }

    /**
     * Remove an item from the cart.
     *
     * @param int $instanceId The ID of the enrolment instance to be removed from the cart.
     * @return bool True if the item is successfully removed, false otherwise.
     */
    public function removeItem(int $instanceId): bool
    {
        if ($this->canEditItems) {
            foreach ($this->items as $item) {
                if ($item->instance_id == $instanceId && $item->delete()) {
                    return $this->refresh();
                }
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     * @return CartItem[] An array of CartItem objects representing the cart items.
     */
    public function getItems(): array
    {
        if (empty($this->_items)) {
            $this->_items = CartItem::findAll($this->id);
        }

        return $this->_items;
    }

    /**
     * Retrieves the user object associated with the cart.
     *
     * @return User|null The user object associated with the cart.
     */
    public function getUser(): ?User
    {
        if (!$this->_user) {
            $this->_user = User::findOneId($this->user_id);
        }

        return $this->_user;
    }

    /**
     * Refresh the cart items.
     * Calculate the price and payable.
     * Remove disabled or invalid enrol items.
     * @param bool $force
     * @return bool
     */
    public function refresh(bool $force = false): bool
    {
        if (!$this->canEditItems && !$force) {
            return false;
        }

        $this->_changed = false;
        $this->_items = [];

        // remove disabled or invalid enrol from the cart
        $items = CartItem::findAll($this->id);
        foreach ($items as $item) {
            if (!CartHelper::hasInstance($item->instance_id)) {
                $this->_changed = true;
                $item->delete();
                notification::info(get_string('msg_instance_deleted', 'enrol_cart'));
                continue;
            }

            if (CartHelper::isUserEnrolled($item->instance_id, $this->user_id)) {
                $this->_changed = true;
                $item->delete();
                notification::info(
                    get_string('msg_already_enrolled', 'enrol_cart', [
                        'title' => $item->course ? $item->course->title : '',
                    ]),
                );
                continue;
            }

            $item->updatePriceAndPayable();
        }

        // set calculated price and payable
        if ($this->price != $this->finalPrice || $this->payable != $this->finalPayable) {
            $this->_changed = true;
            $this->price = $this->finalPrice;
            $this->payable = $this->finalPayable;

            // save changes
            return $this->save();
        }

        return true;
    }

    /**
     * Check if the cart has changed after a refresh.
     *
     * This method checks whether the items or the total price in the cart have been modified
     * since the last refresh operation. It can be used to ensure that any subsequent operations
     * are based on the most up-to-date cart state.
     *
     * @return bool Returns true if the cart has changed, false otherwise.
     */
    public function getHasChanged(): bool
    {
        return $this->_changed;
    }

    /**
     * Check if the checkout session has expired based on the configured payment completion time.
     *
     * @return bool Returns true if the checkout session has expired, false otherwise.
     */
    public function getIsCheckoutExpired(): bool
    {
        if (!$this->isCheckout) {
            return false;
        }

        $timeLimit = CartHelper::getConfig('payment_completion_time');

        return time() - $this->checkout_at > $timeLimit;
    }

    /**
     * Determine if items in the cart can still be edited.
     *
     * @return bool Returns true if items can be edited (either the cart is current or it is checked out but not expired), false otherwise.
     */
    public function getCanEditItems(): bool
    {
        return $this->isCurrentUserOwner && ($this->isCurrent || ($this->isCheckout && $this->isCheckoutExpired));
    }

    /**
     * Check if the cart's payable amount is zero.
     *
     * This method determines whether the total payable amount for the items in the cart is zero.
     *
     * @return bool True if the payable amount is zero, false otherwise.
     */
    public function getIsFinalPayableZero(): bool
    {
        return $this->finalPayable <= 0;
    }

    /**
     * Process cart items with a payable amount of 0.
     *
     * This method handles the case where the cart's payable amount is zero,
     * allowing users to complete the enrolment process without requiring payment.
     *
     * @return bool True if the processing of free items is successful, false otherwise.
     */
    public function processFreeItems(): bool
    {
        if ($this->getFinalPayable() <= 0) {
            if ($this->checkout() && $this->deliver()) {
                notification::success(get_string('msg_delivery_successful', 'enrol_cart'));

                return true;
            }
            notification::error(get_string('msg_delivery_filed', 'enrol_cart'));
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function checkout(): bool
    {
        $this->currency = $this->finalCurrency;
        $this->status = CartStatusInterface::STATUS_CHECKOUT;
        $this->checkout_at = time();

        return $this->save();
    }

    /**
     * @inheritDoc
     */
    public function cancel(): bool
    {
        global $DB;

        $transaction = $DB->start_delegated_transaction();

        try {
            $this->status = CartStatusInterface::STATUS_CANCELED;
            $this->couponCancel();
            $this->save();

            $transaction->allow_commit();

            notification::info(get_string('msg_cancel_successful', 'enrol_cart'));

            return true;
        } catch (Exception $e) {
            // Rollback the transaction in case of an exception.
            $transaction->rollback($e);

            notification::warning(get_string('msg_cancel_filed', 'enrol_cart'));

            return false;
        }
    }

    /**
     * Deliver method processes the user course enrolments.
     *
     * @return bool True if the delivery is successful, false otherwise.
     */
    public function deliver(): bool
    {
        global $DB;

        if (!$this->isCheckout) {
            return false;
        }

        // Start a delegated transaction to ensure atomicity.
        $transaction = $DB->start_delegated_transaction();

        try {
            // Get the cart enrolment plugin.
            $plugin = enrol_get_plugin('cart');

            // Loop through each item in the cart for delivery.
            foreach ($this->items as $item) {
                // Retrieve enrolment instance details from the database.
                $instance = $DB->get_record(
                    'enrol',
                    [
                        'id' => $item->instance_id,
                        'enrol' => 'cart',
                    ],
                    '*',
                    MUST_EXIST,
                );

                // Set the enrolment period (if applicable).
                $timeStart = 0;
                $timeEnd = 0;
                if ($instance->enrolperiod) {
                    $timeStart = time();
                    $timeEnd = $timeStart + $instance->enrolperiod;
                }

                // Enrol the user in the course using the cart plugin.
                $plugin->enrol_user($instance, $this->user_id, $instance->roleid, $timeStart, $timeEnd);
            }

            // Update the cart status to indicate successful delivery.
            $this->status = CartStatusInterface::STATUS_DELIVERED;
            $this->save();

            // Allow the transaction to commit.
            $transaction->allow_commit();

            // Return true to indicate successful delivery.
            return true;
        } catch (Exception $e) {
            // Rollback the transaction in case of an exception.
            $transaction->rollback($e);

            // Return false to indicate delivery failure.
            return false;
        }
    }

    /**
     * Checks if a coupon is applied to the cart.
     *
     * @return bool True if a coupon is applied, false otherwise.
     */
    public function getHasCoupon(): bool
    {
        return ($this->coupon_id && $this->coupon_usage_id) || !empty($this->_couponResult->getDiscountAmount());
    }

    /**
     * Determines if a coupon can be used with the cart.
     *
     * @return bool True if a coupon can be used, false otherwise.
     */
    public function getCanUseCoupon(): bool
    {
        if (!$this->canEditItems) {
            $this->_couponResult->setOk(false);
            $this->_couponResult->setErrorMessage(get_string('msg_cart_cannot_be_edited', 'enrol_cart'));
            return false;
        }

        if (!CouponHelper::isCouponEnable()) {
            $this->_couponResult->setOk(false);
            $this->_couponResult->setErrorMessage(get_string('error_coupon_disabled', 'enrol_cart'));
            return false;
        }

        return true;
    }

    /**
     * Validates a coupon code against the cart items.
     *
     * @param string $couponCode The coupon code to validate.
     * @return bool True if the coupon code is valid, false otherwise.
     */
    public function couponValidate(string $couponCode): bool
    {
        $couponId = CouponHelper::getCouponId($couponCode);

        if (!$couponId) {
            $this->_couponResult->setOk(false);
            $this->_couponResult->setErrorMessage(get_string('error_coupon_is_invalid', 'enrol_cart'));
            return false;
        }

        $this->_couponResult = CouponHelper::couponValidate(new CartDto($this), $couponId);

        return $this->_couponResult->isOk();
    }

    /**
     * Checks if a coupon is available for the cart.
     *
     * This method validates if the coupon has been purchased in this cart and returns false if the coupon is not valid.
     * If the coupon has already been applied, this function is executed before connecting to the payment gateway to validate the coupon.
     *
     * @return bool False if the coupon is used and it is not valid, true otherwise.
     */
    public function couponCheckAvailability(): bool
    {
        if (!$this->coupon_id) {
            return true;
        }

        $this->_couponResult = CouponHelper::couponValidate(new CartDto($this), $this->coupon_id);

        return $this->_couponResult->isOk() &&
            $this->_couponResult->getDiscountAmount() == $this->coupon_discount_amount;
    }

    /**
     * Applies a coupon code to the cart.
     *
     * Validates the coupon code against the cart items and calculates the discount amount.
     * Updates the cart properties accordingly.
     *
     * @param string $couponCode The coupon code to apply.
     * @return bool True if the coupon is successfully applied, false otherwise.
     */
    public function couponApply(string $couponCode): bool
    {
        if (!$this->coupon_id && $this->couponValidate($couponCode)) {
            $this->_couponResult = CouponHelper::couponApply(
                new CartDto($this),
                CouponHelper::getCouponId($couponCode),
            );

            if ($this->_couponResult->isOk()) {
                $this->coupon_id = $this->_couponResult->getCouponId();
                $this->coupon_code = $this->_couponResult->getCouponCode();
                $this->coupon_usage_id = $this->_couponResult->getCouponUsageId();
                $this->coupon_discount_amount = $this->_couponResult->getDiscountAmount();
                $this->payable = $this->finalPayable;

                return $this->save();
            }
        }

        return false;
    }

    /**
     * Cancels the usage of a coupon when the cart is canceled.
     *
     * @return bool True if the coupon is successfully canceled, false otherwise.
     */
    public function couponCancel(): bool
    {
        if ($this->coupon_usage_id && $this->coupon_id) {
            if ($this->canEditItems) {
                $this->_couponResult = CouponHelper::couponCancel(new CartDto($this));

                if ($this->_couponResult->isOk()) {
                    $this->_couponResult = new CouponResultDto();
                    $this->coupon_id = null;
                    $this->coupon_code = null;
                    $this->coupon_usage_id = null;
                    $this->coupon_discount_amount = null;

                    return $this->save() && $this->refresh(true);
                }
            } else {
                notification::error(get_string('msg_cart_cannot_be_edited', 'enrol_cart'));
            }
        }

        return false;
    }

    /**
     * Retrieves the error code from the last applied coupon.
     *
     * @return string|null The error code, or null if no error occurred.
     */
    public function getCouponErrorCode(): ?string
    {
        return $this->_couponResult->getErrorCode();
    }

    /**
     * Retrieves the error message from the last applied coupon.
     *
     * @return string|null The error message, or null if no error occurred.
     */
    public function getCouponErrorMessage(): ?string
    {
        return $this->_couponResult->getErrorMessage();
    }

    /**
     * Retrieves the code of the last applied coupon.
     *
     * @return string|null The coupon code, or null if no coupon is applied.
     */
    public function getCouponCode(): ?string
    {
        if (!empty($this->coupon_code)) {
            return $this->coupon_code;
        }

        return $this->_couponResult->getCouponCode();
    }

    /**
     * Retrieves the discount amount from the applied coupon.
     *
     * @return float|null The discount amount, or null if no coupon is applied.
     */
    public function getCouponDiscountAmount(): ?float
    {
        if (!empty($this->coupon_discount_amount)) {
            return $this->coupon_discount_amount;
        }

        return $this->_couponResult->getDiscountAmount();
    }

    /**
     * Retrieves the formatted discount amount from the applied coupon.
     *
     * @return string|null The formatted discount amount, or null if no coupon is applied.
     */
    public function getCouponDiscountAmountFormatted(): ?string
    {
        if ($this->couponDiscountAmount) {
            return CurrencyFormatter::getCostAsFormatted((float) $this->couponDiscountAmount, $this->finalCurrency);
        }

        return null;
    }
}
