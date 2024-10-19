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

defined('MOODLE_INTERNAL') || die();

use core_payment\helper;
use enrol_cart\helper\CartHelper;
use enrol_cart\helper\PaymentHelper;
use enrol_cart\object\CartEnrollmentInstance;
use enrol_cart\object\DiscountTypeInterface;

class enrol_cart_plugin extends enrol_plugin
{
    /**
     * Return an array of valid options for the status.
     *
     * @return array
     */
    public function getStatusOptions(): array
    {
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
    public function getRoleIdOptions(stdClass $instance, context $context): array
    {
        if ($instance->id) {
            $roles = get_default_enrol_roles($context, $instance->roleid);
        } else {
            $roles = get_default_enrol_roles($context, CartHelper::getConfig('assign_role'));
        }

        return $roles;
    }

    /**
     * @inheritdoc
     *
     * @param array $instances all enrol instances of this type in one course
     * @return array of pix_icon
     */
    public function get_info_icons(array $instances): array
    {
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
     * @inheritdoc
     */
    public function roles_protected(): bool
    {
        // Users with role assign cap may tweak the roles later.
        return false;
    }

    /**
     * @inheritdoc
     * @param stdClass $instance course enrol instance
     * @return bool
     */
    public function allow_unenrol(stdClass $instance): bool
    {
        // Users with unenrol cap may unenrol other users manually - requires enrol/cart:unenrol.
        return true;
    }

    /**
     * @inheritdoc
     * @param stdClass $instance course enrol instance
     * @return bool - true means it is possible to change enrol period and status in user_enrolments table
     */
    public function allow_manage(stdClass $instance): bool
    {
        // Users with manage cap may tweak period and status - requires enrol/cart:manage.
        return true;
    }

    /**
     * @inheritdoc
     * @param stdClass $instance course enrol instance
     * @return bool - true means show "Enrol me in this course" link in course UI
     */
    public function show_enrolme_link(stdClass $instance): bool
    {
        return $instance->status == ENROL_INSTANCE_ENABLED;
    }

    /**
     * Returns true if the user can add a new instance in this course.
     * @param int $courseid
     * @return boolean
     * @throws coding_exception
     */
    public function can_add_instance($courseid): bool
    {
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
    public function use_standard_editing_ui(): bool
    {
        return true;
    }

    /**
     * Add new instance of enrol plugin.
     * @param object $course
     * @param array|null $fields instance fields
     * @return int|null id of new instance, null when can not be created
     * @throws coding_exception
     */
    public function add_instance($course, array $fields = null): ?int
    {
        if ($fields && !empty($fields['cost'])) {
            $fields['cost'] = unformat_float($fields['cost']);
            $fields['customint1'] = unformat_float($fields['customint1']);
            $fields['customchar1'] = unformat_float($fields['customchar1'] ?? '');
            unset($fields['currency']);
        }

        return parent::add_instance($course, $fields);
    }

    /**
     * Update instance of enrol plugin.
     * @param stdClass $instance
     * @param stdClass $data modified instance fields
     * @return boolean
     */
    public function update_instance($instance, $data): bool
    {
        if ($data) {
            $data->cost = unformat_float($data->cost);
            $data->customint1 = unformat_float($data->customint1);
            $data->customchar1 = unformat_float($data->customchar1 ?? '');
            $instance->currency = null;
            unset($data->currency);
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
    public function enrol_page_hook(stdClass $instance): string
    {
        global $USER, $OUTPUT, $DB;

        // user enrolled
        if (
            $DB->record_exists('user_enrolments', [
                'userid' => $USER->id,
                'enrolid' => $instance->id,
            ])
        ) {
            return '';
        }

        // enrol not started
        if ($instance->enrolstartdate != 0 && $instance->enrolstartdate > time()) {
            return '';
        }

        // enrol ended
        if ($instance->enrolenddate != 0 && $instance->enrolenddate < time()) {
            return '';
        }

        $instanceObject = CartEnrollmentInstance::findOneById($instance->id);

        return $OUTPUT->box(
            $OUTPUT->render_from_template('enrol_cart/enrol_page', [
                'instance' => $instanceObject,
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
    public function restore_instance(restore_enrolments_structure_step $step, stdClass $data, $course, $oldid)
    {
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
            ];
        }

        if ($merge && ($instances = $DB->get_records('enrol', $merge, 'id'))) {
            $instance = reset($instances);
            $instanceId = $instance->id;
        } else {
            $instanceId = $this->add_instance($course, (array) $data);
        }

        $step->set_mapping('enrol', $oldid, $instanceId);
    }

    /**
     * Restore user enrolment.
     *
     * @inheritDoc
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
    public function edit_instance_form($instance, MoodleQuickForm $mform, $context)
    {
        global $PAGE;
        $PAGE->requires->js_call_amd('enrol_cart/instance', 'init');

        // instance name
        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));
        $mform->setType('name', PARAM_TEXT);

        // instance status
        $mform->addElement('select', 'status', get_string('status', 'enrol_cart'), $this->getStatusOptions());
        $mform->setDefault('status', CartHelper::getConfig('status'));

        $mform->addElement('html', '<hr/>');

        // cost
        $mform->addElement('text', 'cost', get_string('cost', 'enrol_cart'), ['dir' => 'ltr']);
        $mform->setType('cost', PARAM_RAW);
        $mform->addHelpButton('cost', 'cost', 'enrol_cart');

        // discount type
        $mform->addElement(
            'select',
            'customint1',
            get_string('discount_type', 'enrol_cart'),
            CartEnrollmentInstance::getDiscountTypeOptions(),
        );
        $mform->setType('customint1', PARAM_RAW);

        // discount amount
        $mform->addElement('text', 'customchar1', get_string('discount_amount', 'enrol_cart'), ['dir' => 'ltr']);
        $mform->setType('customchar1', PARAM_RAW);

        // currency only show
        $mform->addElement(
            'select',
            'currency',
            get_string('currency', 'enrol_cart'),
            PaymentHelper::getAvailableCurrencies(),
            ['disabled' => true],
        );
        $mform->setDefault('currency', CartHelper::getConfig('currency'));

        // payable amount (only show)
        $mform->addElement('static', 'payable', get_string('payable', 'enrol_cart'));

        $mform->addElement('html', '<hr/>');

        // role
        $mform->addElement(
            'select',
            'roleid',
            get_string('assign_role', 'enrol_cart'),
            $this->getRoleIdOptions($instance, $context),
        );
        $mform->setDefault('roleid', CartHelper::getConfig('assign_role'));

        // enrol period
        $mform->addElement('duration', 'enrolperiod', get_string('enrol_period', 'enrol_cart'), [
            'optional' => true,
            'defaultunit' => 86400,
        ]);
        $mform->setDefault('enrolperiod', CartHelper::getConfig('enrol_period'));
        $mform->addHelpButton('enrolperiod', 'enrol_period', 'enrol_cart');

        // enrol start date
        $mform->addElement('date_time_selector', 'enrolstartdate', get_string('enrol_start_date', 'enrol_cart'), [
            'optional' => true,
        ]);
        $mform->setDefault('enrolstartdate', 0);
        $mform->addHelpButton('enrolstartdate', 'enrol_start_date', 'enrol_cart');

        // enrol end date
        $mform->addElement('date_time_selector', 'enrolenddate', get_string('enrol_end_date', 'enrol_cart'), [
            'optional' => true,
        ]);
        $mform->setDefault('enrolenddate', 0);
        $mform->addHelpButton('enrolenddate', 'enrol_end_date', 'enrol_cart');

        // warning text
        if (enrol_accessing_via_instance($instance)) {
            $warningText = get_string('instanceeditselfwarningtext', 'core_enrol');
            $mform->addElement('static', 'selfwarn', get_string('instanceeditselfwarning', 'core_enrol'), $warningText);
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
    public function edit_instance_validation($data, $files, $instance, $context): array
    {
        $errors = [];

        //  enrol_end_date validate
        if (!empty($data['enrolenddate']) && $data['enrolenddate'] < $data['enrolstartdate']) {
            $errors['enrolenddate'] = get_string('error_enrol_end_date', 'enrol_cart');
        }

        // cost validate
        $cost = str_replace(get_string('decsep', 'langconfig'), '.', $data['cost']);
        if (!is_numeric($cost)) {
            $errors['cost'] = get_string('error_cost', 'enrol_cart');
        }

        // discount type validate
        $discountType = $data['customint1'];
        if (!in_array($discountType, array_keys(CartEnrollmentInstance::getDiscountTypeOptions()))) {
            $errors['customint1'] = get_string('error_discount_type_is_invalid', 'enrol_cart');
        }

        // discount amount validate
        $discountAmount = $data['customchar1'] ?? '';
        if ($discountType) {
            if (!is_numeric($discountAmount)) {
                $errors['customchar1'] = get_string('error_discount_amount_is_invalid', 'enrol_cart');
            }

            if (
                empty($errors['customchar1']) &&
                $discountType == DiscountTypeInterface::FIXED &&
                $discountAmount > $cost
            ) {
                $errors['customchar1'] = get_string('error_discount_amount_is_higher', 'enrol_cart');
            }

            if (
                empty($errors['customchar1']) &&
                $discountType == DiscountTypeInterface::PERCENTAGE &&
                (!ctype_digit(strval($discountAmount)) || $discountAmount > 100 || $discountAmount < 0)
            ) {
                $errors['customchar1'] = get_string('error_discount_amount_percentage_is_invalid', 'enrol_cart');
            }
        }

        // status validate
        if ($data['status'] == ENROL_INSTANCE_ENABLED) {
            if (!CartHelper::getConfig('payment_account')) {
                $errors['status'] = get_string('error_status_no_payment_account', 'enrol_cart');
            } elseif (!CartHelper::getConfig('payment_currency')) {
                $errors['status'] = get_string('error_status_no_payment_currency', 'enrol_cart');
            } elseif (!CartHelper::getConfig('payment_gateways')) {
                $errors['status'] = get_string('error_status_no_payment_gateways', 'enrol_cart');
            }
        }

        // validate params
        $typeErrors = $this->validate_param_types($data, [
            'name' => PARAM_TEXT,
            'status' => array_keys($this->getStatusOptions()),
            'roleid' => array_keys($this->getRoleIdOptions($instance, $context)),
            'enrolperiod' => PARAM_INT,
            'enrolstartdate' => PARAM_INT,
            'enrolenddate' => PARAM_INT,
        ]);

        // return errors
        return array_merge($errors, $typeErrors);
    }

    /**
     * Execute synchronisation.
     * @param progress_trace $trace
     * @return int exit code, 0 means ok
     */
    public function sync(progress_trace $trace): int
    {
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
    public function can_delete_instance($instance): bool
    {
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
    public function can_hide_show_instance($instance): bool
    {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/cart:config', $context);
    }
}
