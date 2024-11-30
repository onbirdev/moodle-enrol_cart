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

namespace enrol_cart\local\form;

defined('MOODLE_INTERNAL') || die();

use enrol_cart\local\object\cart;
use moodle_exception;
use moodleform;

require_once("$CFG->libdir/formslib.php");

/**
 * Form class for handling coupon code submission in Moodle.
 *
 * This class extends the moodleform class to provide the form structure and
 * validation logic for users to submit coupon codes in Moodle.
 */
class coupon_code_form extends moodleform {
    /**
     * {@inheritdoc}
     */
    protected function definition() {
        $form = $this->_form;

        $cart = $this->_customdata['cart'];
        if (!$cart instanceof cart) {
            throw new moodle_exception('error_invalid_cart', 'enrol_cart');
        }
        $this->set_data(['coupon_code' => $cart->get_coupon_code()]);

        $form->addElement('hidden', 'id', $cart->id);
        $form->setType('id', PARAM_INT);

        $form->addElement('text', 'coupon_code', '', [
            'placeholder' => get_string('coupon_code', 'enrol_cart'),
        ]);
        $form->setType('coupon_code', PARAM_ALPHANUMEXT);

        $this->add_action_buttons(true, get_string('apply', 'enrol_cart'));
    }
}
