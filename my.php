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

require_once('../../config.php');

use enrol_cart\local\object\cart;

global $PAGE, $OUTPUT, $CFG, $USER;

$page = optional_param('page', 0, PARAM_INT);
$perpage = optional_param('perpage', 20, PARAM_INT);
$userid = $USER->id;

require_login();

$title = get_string('my_purchases', 'enrol_cart');
$url = new moodle_url('/enrol/cart/my.php');
$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagetype('cart');
$PAGE->set_url($url);

$PAGE->navigation->add($title, $url, navigation_node::TYPE_CONTAINER);

/** @var cart[] $carts */
$carts = cart::find_all_by_user_id($userid, $page, $perpage);
$total = cart::count_all_by_user_id($userid);

$table = new html_table();
$table->head = [
    '#',
    get_string('order_id', 'enrol_cart'),
    get_string('date', 'enrol_cart'),
    get_string('discount', 'enrol_cart'),
    get_string('payable', 'enrol_cart'),
    get_string('cart_status', 'enrol_cart'),
    '',
];
$table->attributes = ['class' => 'generaltable'];
$table->data = [];

$i = 0;
foreach ($carts as $cart) {
    $i++;
    $actions = [
        html_writer::tag('a', get_string('view', 'enrol_cart'), [
            'href' => $cart->view_url,
        ]),
    ];
    if ($cart->is_checkout) {
        $actions[] = html_writer::tag('a', get_string('pay', 'enrol_cart'), [
            'href' => $cart->checkout_url,
        ]);
    }
    $table->data[] = [
        $i,
        $cart->id,
        userdate($cart->checkout_at ?: $cart->created_at),
        $cart->final_discount_amount
            ? html_writer::tag('span', $cart->final_discount_amount_formatted, [
                'class' => 'currency text-danger',
            ])
            : '-',
        html_writer::tag('span', $cart->final_payable_formatted, [
            'class' => 'currency',
        ]),
        $cart->status_name_formatted_html,
        implode(' | ', $actions),
    ];
}

if (empty($table->data)) {
    $cell = new html_table_cell(
        html_writer::tag('div', get_string('no_items', 'enrol_cart'), [
            'class' => 'text-center',
        ]),
    );
    $cell->colspan = 7;
    $table->data[] = new html_table_row([$cell]);
}

echo $OUTPUT->header();
echo html_writer::table($table);
echo $OUTPUT->paging_bar($total, $page, $perpage, $url);
echo $OUTPUT->footer();
