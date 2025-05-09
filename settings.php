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

use core\output\notification;
use enrol_cart\local\helper\cart_helper;
use enrol_cart\local\helper\coupon_helper;
use enrol_cart\local\helper\payment_helper;

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading('enrol_cart_settings', '', get_string('pluginname_desc', 'enrol_cart')));

    // Available payment accounts.
    $availableaccounts = payment_helper::get_available_payment_accounts();
    // No payment account warning.
    $nopaymentaccountwarning = '';
    if (empty($availableaccounts)) {
        $nopaymentaccountwarning = html_writer::tag('p', get_string('error_no_payment_accounts_available', 'enrol_cart'), [
            'class' => 'alert alert-warning',
        ]);
    }
    // Payment account.
    $settings->add(
        new admin_setting_configselect(
            'enrol_cart/payment_account',
            get_string('payment_account', 'enrol_cart'),
            $nopaymentaccountwarning,
            '',
            ['' => ''] + $availableaccounts,
        ),
    );

    // Available currencies.
    $availablecurrencies = payment_helper::get_available_currencies();
    // No payment currency warning.
    $nopaymentcurrencywarning = '';
    if (empty($availablecurrencies)) {
        $nopaymentcurrencywarning = html_writer::tag('p', get_string('error_no_payment_currency_available', 'enrol_cart'), [
            'class' => 'alert alert-warning',
        ]);
    }
    // Payment currency.
    $settings->add(
        new admin_setting_configselect(
            'enrol_cart/payment_currency',
            get_string('payment_currency', 'enrol_cart'),
            $nopaymentcurrencywarning,
            '',
            ['' => ''] + $availablecurrencies,
        ),
    );

    // Guest cart.
    $settings->add(
        new admin_setting_configcheckbox(
            'enrol_cart/enable_guest_cart',
            get_string('enable_guest_cart', 'enrol_cart'),
            get_string('enable_guest_cart_desc', 'enrol_cart'),
            1,
        ),
    );

    // Coupon enable.
    $settings->add(
        new admin_setting_configcheckbox(
            'enrol_cart/coupon_enable',
            get_string('coupon_enable', 'enrol_cart'),
            get_string('coupon_enable_desc', 'enrol_cart'),
            0,
        ),
    );

    // Coupon class.
    $settings->add(
        new admin_setting_configtext(
            'enrol_cart/coupon_class',
            get_string('coupon_class', 'enrol_cart'),
            get_string('coupon_class_desc', 'enrol_cart'),
            '',
        ),
    );

    $couponclass = coupon_helper::get_coupon_class_name();
    $couponclasserror = null;
    if (!empty($couponclass)) {
        if (!class_exists($couponclass)) {
            $couponclasserror = get_string('error_coupon_class_not_found', 'enrol_cart');
        } else if (!in_array('enrol_cart\local\object\coupon_interface', class_implements($couponclass))) {
            $couponclasserror = get_string('error_coupon_class_not_implemented', 'enrol_cart');
        }
    }

    if (!empty($couponclasserror)) {
        $notify = new notification($couponclasserror, notification::NOTIFY_WARNING);
        $settings->add(new admin_setting_heading('error_coupon_class_error', '', $OUTPUT->render($notify)));
    }

    // Payment completion window.
    $settings->add(
        new admin_setting_configduration(
            'enrol_cart/payment_completion_time',
            get_string('payment_completion_time', 'enrol_cart'),
            get_string('payment_completion_time_desc', 'enrol_cart'),
            60 * 15,
        ),
    );

    // Canceled cart lifetime.
    $settings->add(
        new admin_setting_configduration(
            'enrol_cart/canceled_cart_lifetime',
            get_string('canceled_cart_lifetime', 'enrol_cart'),
            get_string('canceled_cart_lifetime_desc', 'enrol_cart'),
            0,
        ),
    );

    // Pending payment cart lifetime.
    $settings->add(
        new admin_setting_configduration(
            'enrol_cart/pending_payment_cart_lifetime',
            get_string('pending_payment_cart_lifetime', 'enrol_cart'),
            get_string('pending_payment_cart_lifetime_desc', 'enrol_cart'),
            0,
        ),
    );

    // Not delete cart with payment record.
    $settings->add(
        new admin_setting_configcheckbox(
            'enrol_cart/not_delete_cart_with_payment_record',
            get_string('not_delete_cart_with_payment_record', 'enrol_cart'),
            get_string('not_delete_cart_with_payment_record_desc', 'enrol_cart'),
            true,
        ),
    );

    // Verify payment on delivery.
    $settings->add(
        new admin_setting_configcheckbox(
            'enrol_cart/verify_payment_on_delivery',
            get_string('verify_payment_on_delivery', 'enrol_cart'),
            get_string('verify_payment_on_delivery_desc', 'enrol_cart'),
            true,
        ),
    );

    // Convert IRR to IRT.
    $settings->add(
        new admin_setting_configcheckbox(
            'enrol_cart/convert_irr_to_irt',
            get_string('convert_irr_to_irt', 'enrol_cart'),
            get_string('convert_irr_to_irt_desc', 'enrol_cart'),
            false,
        ),
    );

    // Convert numbers to persian.
    $settings->add(
        new admin_setting_configcheckbox(
            'enrol_cart/convert_numbers_to_persian',
            get_string('convert_numbers_to_persian', 'enrol_cart'),
            get_string('convert_numbers_to_persian_desc', 'enrol_cart'),
            false,
        ),
    );

    $settings->add(
        new admin_setting_heading(
            'enrol_cart_defaults',
            get_string('enrol_instance_defaults', 'enrol_cart'),
            get_string('enrol_instance_defaults_desc', 'enrol_cart'),
        ),
    );

    // Default status.
    $settings->add(
        new admin_setting_configselect(
            'enrol_cart/status',
            get_string('status', 'enrol_cart'),
            get_string('status_desc', 'enrol_cart'),
            ENROL_INSTANCE_DISABLED,
            enrol_get_plugin('cart')->get_status_options(),
        ),
    );

    // Default role.
    if (!during_initial_install()) {
        $options = get_default_enrol_roles(context_system::instance());
        $student = get_archetype_roles('student');
        $student = reset($student);
        $settings->add(
            new admin_setting_configselect(
                'enrol_cart/assign_role',
                get_string('assign_role', 'enrol_cart'),
                get_string('assign_role_desc', 'enrol_cart'),
                $student->id,
                $options,
            ),
        );
    }

    // Enrol period.
    $settings->add(
        new admin_setting_configduration(
            'enrol_cart/enrol_period',
            get_string('enrol_period', 'enrol_cart'),
            get_string('enrol_period_desc', 'enrol_cart'),
            0,
        ),
    );
}
