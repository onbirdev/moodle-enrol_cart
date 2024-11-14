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

use enrol_cart\helper\CouponHelper;

/**
 * Class CouponResultDto
 * @brief Represents the result of a coupon process.
 *
 * This class is used to encapsulate the result of coupon operations, including validation, application,
 * and cancellation, providing detailed information about the status and effects of the coupon.
 */
class CouponResultDto
{
    /**
     * @var bool Indicates if the coupon process is successful.
     */
    private bool $ok = false;

    /**
     * @var int|null The ID of the coupon.
     */
    private ?int $couponId = null;

    /**
     * @var string|null The code of the coupon.
     */
    private ?string $couponCode = null;

    /**
     * @var string|null The error code if the coupon is invalid.
     */
    private ?string $errorCode = null;

    /**
     * @var string|null The error message if the coupon is invalid.
     */
    private ?string $errorMessage = null;

    /**
     * @var float|null The discount amount provided by the coupon.
     */
    private ?float $discountAmount = null;

    /**
     * @var float|null The payable amount after applying the coupon.
     */
    private ?float $payableAmount = null;

    /**
     * @var array|null The items affected by the coupon.
     */
    private ?array $items = [];

    /**
     * @var int|null The usage ID of the coupon.
     */
    private ?int $couponUsageId = null;

    /**
     * CouponResult constructor.
     * Initializes the CouponResult object and checks if the coupon functionality is enabled.
     */
    public function __construct()
    {
        if (!CouponHelper::is_coupon_enable()) {
            $this->setOk(false);
            $this->setErrorMessage(get_string('error_coupon_disabled', 'enrol_cart'));
        }
    }

    /**
     * Returns whether the coupon process is successful.
     *
     * @return bool True if the coupon process is successful, false otherwise.
     */
    public function isOk(): bool
    {
        return $this->ok;
    }

    /**
     * Sets the status of the coupon process.
     *
     * @param bool $ok The process status.
     * @return CouponResultDto The current instance for method chaining.
     */
    public function setOk(bool $ok): CouponResultDto
    {
        $this->ok = $ok;
        return $this;
    }

    /**
     * Returns the coupon ID.
     *
     * @return int|null The coupon ID.
     */
    public function get_coupon_id(): ?int
    {
        return $this->couponId;
    }

    /**
     * Sets the coupon ID.
     *
     * @param int|null $couponId The coupon ID.
     * @return CouponResultDto The current instance for method chaining.
     */
    public function setCouponId(?int $couponId): CouponResultDto
    {
        $this->couponId = $couponId;
        return $this;
    }

    /**
     * Returns the coupon code.
     *
     * @return string|null The coupon code.
     */
    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    /**
     * Sets the coupon code.
     *
     * @param string|null $couponCode The coupon code.
     * @return CouponResultDto The current instance for method chaining.
     */
    public function setCouponCode(?string $couponCode): CouponResultDto
    {
        $this->couponCode = $couponCode;
        return $this;
    }

    /**
     * Returns the error code if the coupon is invalid.
     *
     * @return string|null The error code.
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * Sets the error code.
     *
     * @param string|null $errorCode The error code.
     * @return CouponResultDto The current instance for method chaining.
     */
    public function setErrorCode(?string $errorCode): CouponResultDto
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * Returns the error message if the coupon is invalid.
     *
     * @return string|null The error message.
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * Sets the error message.
     *
     * @param string|null $errorMessage The error message.
     * @return CouponResultDto The current instance for method chaining.
     */
    public function setErrorMessage(?string $errorMessage): CouponResultDto
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * Returns the discount amount.
     *
     * @return float|null The discount amount.
     */
    public function getDiscountAmount(): ?float
    {
        return $this->discountAmount;
    }

    /**
     * Sets the discount amount.
     *
     * @param float|null $discountAmount The discount amount.
     * @return CouponResultDto The current instance for method chaining.
     */
    public function setDiscountAmount(?float $discountAmount): CouponResultDto
    {
        $this->discountAmount = $discountAmount;
        return $this;
    }

    /**
     * Returns the payable amount after applying the coupon.
     *
     * @return float|null The payable amount.
     */
    public function getPayableAmount(): ?float
    {
        return $this->payableAmount;
    }

    /**
     * Sets the payable amount.
     *
     * @param float|null $payableAmount The payable amount.
     * @return CouponResultDto The current instance for method chaining.
     */
    public function setPayableAmount(?float $payableAmount): CouponResultDto
    {
        $this->payableAmount = $payableAmount;
        return $this;
    }

    /**
     * Returns the items affected by the coupon.
     *
     * @return array|null The items affected by the coupon.
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * Sets the items affected by the coupon.
     *
     * @param array|null $items The items affected by the coupon.
     * @return CouponResultDto The current instance for method chaining.
     */
    public function setItems(?array $items): CouponResultDto
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Returns the usage ID of the coupon.
     *
     * @return int|null The coupon usage ID.
     */
    public function getCouponUsageId(): ?int
    {
        return $this->couponUsageId;
    }

    /**
     * Sets the usage ID of the coupon.
     *
     * @param int|null $couponUsageId The coupon usage ID.
     * @return CouponResultDto The current instance for method chaining.
     */
    public function setCouponUsageId(?int $couponUsageId): CouponResultDto
    {
        $this->couponUsageId = $couponUsageId;
        return $this;
    }
}
