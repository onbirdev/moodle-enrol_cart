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

use core_payment\helper;
use enrol_cart\local\helper\cart_helper;
use enrol_cart\local\helper\payment_helper;
use enrol_cart\local\object\cart_enrollment_instance;
use enrol_cart\local\object\discount_type_interface;

/**
 * enrol_cart_plugin class for handling cart-based enrolment in Moodle.
 *
 * This class provides the core functionality for enrolling users through the
 * shopping cart in Moodle. It extends the base enrol_plugin class to integrate
 * with Moodle's enrolment system and manage course enrolments using the cart.
 */
class enrol_cart_plugin extends enrol_plugin {
    /**
     * Return an array of valid options for the status.
     *
     * @return array
     */
    public function get_status_options(): array {
        return [
            ENROL_INSTANCE_ENABLED => get_string('yes'),
            ENROL_INSTANCE_DISABLED => get_string('no'),
        ];
    }

    /**
     * Return an array of valid options for the role_id.
     *
     * @param stdClass $instance
     * @param context $context
     * @return array
     */
    public function get_role_id_options(stdClass $instance, context $context): array {
        if ($instance->id) {
            $roles = get_default_enrol_roles($context, $instance->roleid);
        } else {
            $roles = get_default_enrol_roles($context, cart_helper::get_config('assign_role'));
        }

        return $roles;
    }

    /**
     * Retrieves an array of group options for a given course context.
     *
     * @param context $coursecontext The course context for which the group options are retrieved.
     * @return array An associative array of group options, where the keys are group IDs and the values are the formatted group
     *     names.
     */
    protected function get_group_options(context $coursecontext): array {
        $groups = [];

        foreach (groups_get_all_groups($coursecontext->instanceid) as $group) {
            $groups[$group->id] = format_string($group->name, true, ['context' => $coursecontext]);
        }

        return $groups;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $instances all enrol instances of this type in one course
     * @return array of pix_icon
     */
    public function get_info_icons(array $instances): array {
        $found = false;

        foreach ($instances as $instance) {
            if ($instance->enrolstartdate != 0 && $instance->enrolstartdate > time()) {
                continue;
            }
            if ($instance->enrolenddate != 0 && $instance->enrolenddate < time()) {
                continue;
            }
            $found = true;
            break;
        }

        if ($found) {
            return [new pix_icon('icon', get_string('pluginname', 'enrol_cart'), 'enrol_cart')];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function roles_protected(): bool {
        // Users with role assign cap may tweak the roles later.
        return false;
    }

    /**
     * {@inheritdoc}
     * @param stdClass $instance course enrol instance
     * @return bool
     */
    public function allow_unenrol(stdClass $instance): bool {
        // Users with unenrol cap may unenrol other users manually - requires enrol/cart:unenrol.
        return true;
    }

    /**
     * {@inheritdoc}
     * @param stdClass $instance course enrol instance
     * @return bool - true means it is possible to change enrol period and status in user_enrolments table
     */
    public function allow_manage(stdClass $instance): bool {
        // Users with manage cap may tweak period and status - requires enrol/cart:manage.
        return true;
    }

    /**
     * {@inheritdoc}
     * @param stdClass $instance course enrol instance
     * @return bool - true means show "Enrol me in this course" link in course UI
     */
    public function show_enrolme_link(stdClass $instance): bool {
        return $instance->status == ENROL_INSTANCE_ENABLED;
    }

    /**
     * Returns true if the user can add a new instance in this course.
     *
     * @param int $courseid
     * @return boolean
     * @throws coding_exception
     */
    public function can_add_instance($courseid): bool {
        $context = context_course::instance($courseid, MUST_EXIST);

        if (empty(helper::get_supported_currencies())) {
            return false;
        }

        if (!has_capability('moodle/course:enrolconfig', $context) || !has_capability('enrol/cart:config', $context)) {
            return false;
        }

        // Multiple instances supported - different cost for different roles.
        return true;
    }

    /**
     * The enrol_cart plugin support standard UI.
     *
     * @return boolean
     */
    public function use_standard_editing_ui(): bool {
        return true;
    }

    /**
     * Add new instance of enrol plugin.
     *
     * @param object $course
     * @param array|null $fields instance fields
     * @return int|null id of new instance, null when can not be created
     * @throws coding_exception
     */
    public function add_instance($course, ?array $fields = null): ?int {
        if (!empty($fields)) {
            if (!empty($fields['cost'])) {
                $fields['cost'] = unformat_float($fields['cost']);
                $fields['customint1'] = unformat_float($fields['customint1']);
                $fields['customchar1'] = unformat_float($fields['customchar1'] ?? '');
                $fields['customtext1'] = $fields['customtext1']['text'];
                $fields['customchar2'] = implode(',', $fields['customchar2']);
                unset($fields['currency']);
            }

            // Store availability conditions in customtext2.
            if (!empty($fields['availabilityconditionsjson'])) {
                $fields['customtext2'] = $fields['availabilityconditionsjson'];
                unset($fields['availabilityconditionsjson']);
            }
        }

        return parent::add_instance($course, $fields);
    }

    /**
     * Update instance of enrol plugin.
     *
     * @param stdClass $instance
     * @param stdClass $data modified instance fields
     * @return boolean
     */
    public function update_instance($instance, $data): bool {
        if ($data) {
            $data->cost = unformat_float($data->cost);
            $data->customint1 = unformat_float($data->customint1);
            $data->customchar1 = unformat_float($data->customchar1 ?? '');
            $data->customtext1 = $data->customtext1['text'];
            $data->customchar2 = implode(',', $data->customchar2);
            $instance->currency = null;
            unset($data->currency);
        }

        // Store availability conditions in customtext2.
        if (!empty($data->availabilityconditionsjson)) {
            $data->customtext2 = $data->availabilityconditionsjson;
            unset($data->availabilityconditionsjson);
        }

        return parent::update_instance($instance, $data);
    }

    /**
     * Creates course enrol form, checks if form submitted
     * and enrols user if necessary. It can also redirect.
     *
     * @param stdClass $instance
     * @return string html text, usually a form in a text box
     */
    public function enrol_page_hook(stdClass $instance): string {
        global $USER, $OUTPUT, $DB;

        // User enrolled.
        if (
            $DB->record_exists('user_enrolments', [
                'userid' => $USER->id,
                'enrolid' => $instance->id,
            ])
        ) {
            return '';
        }

        // Enrol not started.
        if ($instance->enrolstartdate != 0 && $instance->enrolstartdate > time()) {
            return '';
        }

        // Enrol ended.
        if ($instance->enrolenddate != 0 && $instance->enrolenddate < time()) {
            return '';
        }

        $information = '';
        $canenrol = cart_helper::can_user_enrol($instance->id, $USER->id, $information);
        if (!$canenrol && empty($information)) {
            return '';
        }

        $instanceobject = cart_enrollment_instance::find_one_by_id($instance->id);

        return $OUTPUT->box(
            $OUTPUT->render_from_template('enrol_cart/enrol_page', [
                'instance' => $instanceobject,
                'can_enrol' => $canenrol,
                'information' => $information,
            ]),
        );
    }

    /**
     * Restore instance and map settings.
     *
     * @param restore_enrolments_structure_step $step
     * @param stdClass $data
     * @param stdClass $course
     * @param int $oldid
     * @throws dml_exception
     * @throws coding_exception
     * @throws restore_step_exception
     */
    public function restore_instance(restore_enrolments_structure_step $step, stdClass $data, $course, $oldid) {
        global $DB;

        if ($step->get_task()->get_target() == backup::TARGET_NEW_COURSE) {
            $merge = false;
        } else {
            $merge = [
                'courseid' => $data->courseid,
                'enrol' => $this->get_name(),
                'roleid' => $data->roleid,
                'cost' => $data->cost,
                'currency' => $data->currency,
                'customint1' => $data->customint1,
                'customchar1' => $data->customchar1 ?? '',
                'customtext1' => $data->customtext1 ?? '',
                'customchar2' => $data->customchar2 ?? '',
            ];
        }

        if ($merge && ($instances = $DB->get_records('enrol', $merge, 'id'))) {
            $instance = reset($instances);
            $instanceid = $instance->id;
        } else {
            $instanceid = $this->add_instance($course, (array)$data);
        }

        $step->set_mapping('enrol', $oldid, $instanceid);
    }

    /**
     * Restore user enrolment.
     *
     * {@inheritdoc}
     *
     * @param restore_enrolments_structure_step $step
     * @param stdClass $data
     * @param stdClass $instance
     * @param int $userid
     * @param int $oldinstancestatus
     * @throws coding_exception
     */
    public function restore_user_enrolment(
        restore_enrolments_structure_step $step,
        $data,
        $instance,
        $userid,
        $oldinstancestatus
    ) {
        $this->enrol_user($instance, $userid, null, $data->timestart, $data->timeend, $data->status);
    }

    /**
     * Add elements to the edit instance form.
     *
     * @param stdClass $instance
     * @param MoodleQuickForm $mform
     * @param context $context
     * @throws coding_exception
     */
    public function edit_instance_form($instance, MoodleQuickForm $mform, $context) {
        global $PAGE, $SITE;
        $PAGE->requires->js_call_amd('enrol_cart/instance', 'init');
        $instance->customtext1 = [
            'text' => $instance->customtext1 ?? '',
        ];

        // Instance status.
        $mform->addElement('select', 'status', get_string('status', 'enrol_cart'), $this->get_status_options());
        $mform->setDefault('status', cart_helper::get_config('status'));

        $mform->addElement('html', '<hr/>');

        // Cost.
        $mform->addElement('text', 'cost', get_string('cost', 'enrol_cart'), ['dir' => 'ltr']);
        $mform->setType('cost', PARAM_RAW);
        $mform->addHelpButton('cost', 'cost', 'enrol_cart');

        // Discount type.
        $mform->addElement(
            'select',
            'customint1',
            get_string('discount_type', 'enrol_cart'),
            cart_enrollment_instance::get_discount_type_options(),
        );
        $mform->setType('customint1', PARAM_RAW);

        // Discount amount.
        $mform->addElement('text', 'customchar1', get_string('discount_amount', 'enrol_cart'), ['dir' => 'ltr']);
        $mform->setType('customchar1', PARAM_RAW);

        // Currency only show.
        $mform->addElement(
            'select',
            'currency',
            get_string('currency', 'enrol_cart'),
            payment_helper::get_available_currencies(),
            ['disabled' => true],
        );
        $mform->setDefault('currency', cart_helper::get_config('payment_currency'));

        // Payable amount (only show).
        $mform->addElement('static', 'payable', get_string('payable', 'enrol_cart'));

        $mform->addElement('html', '<hr/>');

        // Instance name.
        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));
        $mform->setType('name', PARAM_TEXT);

        // Instructions.
        $mform->addElement('editor', 'customtext1', get_string('instructions', 'enrol_cart'), ['rows' => 5]);
        $mform->setType('customtext1', PARAM_RAW);

        $mform->addElement('html', '<hr/>');

        // The User filter definition.
        if (!empty($instance->customtext2)) {
            $instance->availabilityconditionsjson = $instance->customtext2;
            unset($instance->customtext2);
        }
        $mform->addElement('textarea', 'availabilityconditionsjson', get_string('availability', 'enrol_cart'));
        $mform->addHelpButton('availabilityconditionsjson', 'availability', 'enrol_cart');
        \core_availability\frontend::include_all_javascript($SITE);

        $mform->addElement('html', '<hr/>');

        // Add to group.
        $select = $mform->addElement(
            'select',
            'customchar2',
            get_string('add_to_group', 'enrol_cart'),
            $this->get_group_options($context)
        );
        $select->setMultiple(true);

        $mform->addElement('html', '<hr/>');

        // Role.
        $mform->addElement(
            'select',
            'roleid',
            get_string('assign_role', 'enrol_cart'),
            $this->get_role_id_options($instance, $context),
        );
        $mform->setDefault('roleid', cart_helper::get_config('assign_role'));

        // Enrol period.
        $mform->addElement('duration', 'enrolperiod', get_string('enrol_period', 'enrol_cart'), [
            'optional' => true,
            'defaultunit' => 86400,
        ]);
        $mform->setDefault('enrolperiod', cart_helper::get_config('enrol_period'));
        $mform->addHelpButton('enrolperiod', 'enrol_period', 'enrol_cart');

        // Enrol start date.
        $mform->addElement('date_time_selector', 'enrolstartdate', get_string('enrol_start_date', 'enrol_cart'), [
            'optional' => true,
        ]);
        $mform->setDefault('enrolstartdate', 0);
        $mform->addHelpButton('enrolstartdate', 'enrol_start_date', 'enrol_cart');

        // Enrol end date.
        $mform->addElement('date_time_selector', 'enrolenddate', get_string('enrol_end_date', 'enrol_cart'), [
            'optional' => true,
        ]);
        $mform->setDefault('enrolenddate', 0);
        $mform->addHelpButton('enrolenddate', 'enrol_end_date', 'enrol_cart');

        // Warning text.
        if (enrol_accessing_via_instance($instance)) {
            $warningtext = get_string('instanceeditselfwarningtext', 'core_enrol');
            $mform->addElement('static', 'selfwarn', get_string('instanceeditselfwarning', 'core_enrol'), $warningtext);
        }
    }

    /**
     * Perform custom validation of the data used to edit the instance.
     *
     * @param array $data array of ("fieldname"=>value) of submitted data
     * @param array $files array of uploaded files "element_name"=>tmp_file_path
     * @param object $instance The instance loaded from the DB
     * @param context $context The context of the instance we are editing
     * @return array of "element_name"=>"error_description" if there are errors,
     *         or an empty array if everything is OK.
     * @return void
     * @throws coding_exception
     */
    public function edit_instance_validation($data, $files, $instance, $context): array {
        $errors = [];

        // Validate availability conditions.
        \core_availability\frontend::report_validation_errors($data, $errors);

        // Enrol end date validate.
        if (!empty($data['enrolenddate']) && $data['enrolenddate'] < $data['enrolstartdate']) {
            $errors['enrolenddate'] = get_string('error_enrol_end_date', 'enrol_cart');
        }

        // Cost validate.
        $cost = str_replace(get_string('decsep', 'langconfig'), '.', $data['cost']);
        if (!is_numeric($cost)) {
            $errors['cost'] = get_string('error_cost', 'enrol_cart');
        }

        // Discount type validate.
        $discounttype = $data['customint1'];
        if (!in_array($discounttype, array_keys(cart_enrollment_instance::get_discount_type_options()))) {
            $errors['customint1'] = get_string('error_discount_type_is_invalid', 'enrol_cart');
        }

        // Discount amount validate.
        $discountamount = $data['customchar1'] ?? '';
        if ($discounttype) {
            if (!is_numeric($discountamount)) {
                $errors['customchar1'] = get_string('error_discount_amount_is_invalid', 'enrol_cart');
            }

            if (
                empty($errors['customchar1']) &&
                $discounttype == discount_type_interface::FIXED &&
                $discountamount > $cost
            ) {
                $errors['customchar1'] = get_string('error_discount_amount_is_higher', 'enrol_cart');
            }

            if (
                empty($errors['customchar1']) &&
                $discounttype == discount_type_interface::PERCENTAGE &&
                (!ctype_digit(strval($discountamount)) || $discountamount > 100 || $discountamount < 0)
            ) {
                $errors['customchar1'] = get_string('error_discount_amount_percentage_is_invalid', 'enrol_cart');
            }
        }

        // Status validate.
        if ($data['status'] == ENROL_INSTANCE_ENABLED) {
            if (!cart_helper::get_config('payment_account')) {
                $errors['status'] = get_string('error_status_no_payment_account', 'enrol_cart');
            } else if (!cart_helper::get_config('payment_currency')) {
                $errors['status'] = get_string('error_status_no_payment_currency', 'enrol_cart');
            }
        }

        $groupoptions = array_keys($this->get_group_options($context));
        foreach ($data['customchar2'] as $groupid) {
            if (!in_array($groupid, $groupoptions)) {
                $errors['customchar2'] = get_string('error_group_is_invalid', 'enrol_cart');
            }
        }

        $data['customtext1'] = $data['customtext1']['text'];

        // Validate params.
        $typeerrors = $this->validate_param_types($data, [
            'name' => PARAM_TEXT,
            'status' => array_keys($this->get_status_options()),
            'roleid' => array_keys($this->get_role_id_options($instance, $context)),
            'enrolperiod' => PARAM_INT,
            'enrolstartdate' => PARAM_INT,
            'enrolenddate' => PARAM_INT,
            'customtext1' => PARAM_RAW,
        ]);

        // Return errors.
        return array_merge($errors, $typeerrors);
    }

    /**
     * Execute synchronisation.
     *
     * @param progress_trace $trace
     * @return int exit code, 0 means ok
     */
    public function sync(progress_trace $trace): int {
        $this->process_expirations($trace);
        return 0;
    }

    /**
     * Is it possible to delete enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     * @throws coding_exception
     */
    public function can_delete_instance($instance): bool {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/cart:config', $context);
    }

    /**
     * Is it possible to hide/show enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     * @throws coding_exception
     */
    public function can_hide_show_instance($instance): bool {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/cart:config', $context);
    }
}
