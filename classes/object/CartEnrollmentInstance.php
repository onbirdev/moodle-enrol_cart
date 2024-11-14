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

use dml_exception;
use enrol_cart\formatter\CurrencyFormatter;
use enrol_cart\helper\CartHelper;
use moodle_url;

/**
 * Class CartEnrollmentInstance
 *
 * Represents an instance of cart enrollment with various attributes and methods to manage enrollment details.
 *
 * @property int $id Unique identifier for the enrollment instance.
 * @property int $status Status of the enrollment instance.
 * @property int $course_id ID of the associated course.
 * @property string $name Name of the enrollment instance.
 * @property string $cost Cost of the enrollment.
 * @property int $discount_type Type of the discount applied (e.g., percentage or fixed amount).
 * @property string $discount_amount Amount of the discount.
 * @property string $currency Currency used for the cost.
 * @property int $enrol_start_date Start date of the enrollment.
 * @property int $enrol_end_date End date of the enrollment.
 *
 * @property float $hasDiscount Whether the enrollment has a discount.
 * @property string $discountPercentage The discount percentage if applicable.
 * @property string $discountPercentageFormatted Formatted discount percentage.
 * @property float $discountAmount Calculated discount amount based on the discount percentage and price.
 * @property string $discountAmountFormatted Formatted discount amount.
 * @property float $price Original price before discount.
 * @property float $payable Final payable amount after applying the discount.
 * @property string $priceFormatted Formatted string of the original price.
 * @property string $payableFormatted Formatted string of the final payable amount.
 * @property string $addToCartUrl The URL to add the current enrolment instance to the cart.
 */
class CartEnrollmentInstance extends BaseModel
{
    use DiscountTypeTrait;

    /**
     * Retrieves the attributes of the cart enrollment instance.
     *
     * @return array An array of enrollment attributes.
     */
    public function attributes(): array
    {
        return [
            'id',
            'status',
            'course_id',
            'name',
            'discount_type',
            'discount_amount',
            'cost',
            'currency',
            'enrol_start_date',
            'enrol_end_date',
        ];
    }

    /**
     * Finds all cart enrollment instances by the given course ID.
     *
     * @param int $courseId The ID of the course to find enrollments for.
     * @return array An array of CartEnrollmentInstance objects for the specified course.
     * @throws dml_exception If there is an error accessing the database.
     */
    public static function findAllByCourseId(int $courseId): array
    {
        global $DB;

        // SQL query to fetch all enrollment instances for the specified course ID.
        $rows = $DB->get_records_sql(
            'SELECT id, enrol, status, courseid as course_id, name, customint1 as discount_type, customchar1 as discount_amount, cost, currency, enrolstartdate as enrol_start_date, enrolenddate as enrol_end_date 
             FROM {enrol} 
             WHERE enrol = :enrol AND status = :status AND courseid = :course_id
             ORDER BY sortorder ASC',
            ['enrol' => 'cart', 'status' => ENROL_INSTANCE_ENABLED, 'course_id' => $courseId],
        );

        return static::populate($rows);
    }

    /**
     * Finds a cart enrollment instance by its ID.
     *
     * @param int $instanceId The ID of the enrollment instance to find.
     * @return self The CartEnrollmentInstance object corresponding to the specified ID.
     * @throws dml_exception If there is an error accessing the database.
     */
    public static function findOneById(int $instanceId): self
    {
        global $DB;

        // SQL query to fetch the enrollment instance for the specified ID.
        $row = $DB->get_record_sql(
            'SELECT id, enrol, status, courseid as course_id, name, customint1 as discount_type, customchar1 as discount_amount, cost, currency, enrolstartdate as enrol_start_date, enrolenddate as enrol_end_date 
             FROM {enrol} 
             WHERE id = :instance_id AND enrol = :enrol AND status = :status',
            ['enrol' => 'cart', 'status' => ENROL_INSTANCE_ENABLED, 'instance_id' => $instanceId],
        );

        return static::populateOne($row);
    }

    /**
     * Post-processing after finding an enrollment instance.
     *
     * Ensures that the currency attribute is set to the default if not already set.
     *
     * @return void
     */
    public function afterFind()
    {
        if (empty($this->currency)) {
            $this->currency = (string) CartHelper::get_config('payment_currency');
        }
    }

    /**
     * Checks if the enrollment has a discount.
     *
     * @return bool True if there is a discount, otherwise false.
     */
    public function getHasDiscount(): bool
    {
        return (bool) $this->discountAmount;
    }

    /**
     * Gets the discount percentage if the discount type is percentage.
     *
     * @return int|null The discount percentage or null if not applicable.
     */
    public function getDiscountPercentage(): ?int
    {
        if ($this->isDiscountTypePercentage) {
            return ceil($this->discount_amount);
        }

        if ($this->isDiscountTypeFixed) {
            $payable = $this->price - $this->discount_amount;
            return 100 - floor(($payable * 100) / $this->price);
        }

        return null;
    }

    /**
     * Gets the formatted discount percentage.
     *
     * @return string|null The formatted discount percentage or null if not applicable.
     */
    public function getDiscountPercentageFormatted(): ?string
    {
        $discountPercentage = $this->discountPercentage;

        if ($discountPercentage) {
            $discountPercentage = '%' . $discountPercentage;
            if (CartHelper::get_config('convert_numbers_to_persian')) {
                return CurrencyFormatter::convert_english_numbers_to_persian($discountPercentage);
            }

            return $discountPercentage;
        }

        return null;
    }

    /**
     * Calculates the discount amount.
     *
     * @return float|null The discount amount or null if not applicable.
     */
    public function getDiscountAmount()
    {
        if ($this->isDiscountTypeFixed && $this->discount_amount <= $this->price) {
            return $this->discount_amount;
        }

        if (
            $this->isDiscountTypePercentage &&
            ctype_digit(strval($this->discount_amount)) &&
            $this->discount_amount >= 0 &&
            $this->discount_amount <= 100
        ) {
            return ($this->discount_amount * $this->price) / 100;
        }

        return null;
    }

    /**
     * Gets the formatted discount amount.
     *
     * @return string|null The formatted discount amount or null if not applicable.
     */
    public function getDiscountAmountFormatted(): ?string
    {
        $discountAmount = $this->discountAmount;

        return $discountAmount ? CurrencyFormatter::get_cost_as_formatted($discountAmount, $this->currency) : null;
    }

    /**
     * Returns the original price amount before discount.
     *
     * @return float The original price amount.
     */
    public function getPrice(): float
    {
        return (float) $this->cost;
    }

    /**
     * Returns the formatted original price.
     *
     * @return string|null The formatted original price string, or 'free' if the price is zero.
     */
    public function getPriceFormatted(): ?string
    {
        if ($this->price !== null && (float) $this->price > 0) {
            return CurrencyFormatter::get_cost_as_formatted($this->price, $this->currency);
        }

        return get_string('free', 'enrol_cart');
    }

    /**
     * Returns the final payable amount after applying the discount.
     *
     * @return float The final payable amount.
     */
    public function getPayable(): float
    {
        $discountAmount = $this->discountAmount;
        return $discountAmount ? $this->price - $discountAmount : $this->price;
    }

    /**
     * Returns the formatted final payable amount.
     *
     * @return string The formatted payable amount string, or 'free' if the payable amount is zero.
     */
    public function getPayableFormatted(): string
    {
        if ($this->payable !== null && (float) $this->payable > 0) {
            return CurrencyFormatter::get_cost_as_formatted($this->payable, $this->currency);
        }

        return get_string('free', 'enrol_cart');
    }

    /**
     * Generates the URL to add the current instance to the shopping cart.
     *
     * This method creates a moodle_url object which points to the enrolment
     * cart script, specifying the action to add the current enrolment instance
     * to the shopping cart.
     *
     * @return moodle_url The URL to add the current enrolment instance to the cart.
     */
    public function getAddToCartUrl(): moodle_url
    {
        return new moodle_url('/enrol/cart/do.php', [
            'action' => 'add', // Specifies the action to be performed: adding an instance to the cart.
            'instance' => $this->id, // The ID of the current enrolment instance.
        ]);
    }
}
