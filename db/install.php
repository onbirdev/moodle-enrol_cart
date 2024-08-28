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

function xmldb_enrol_cart_install()
{
    global $CFG;
    $myPurchasesItem = 'my_purchases,enrol_cart|/enrol/cart/my.php';
    set_config('customusermenuitems', $myPurchasesItem . "\r\n" . $CFG->customusermenuitems);
}