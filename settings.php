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
 * @package    enrol_payro24
 * @copyright  payro24
 * @author     Mohammad Nabipour
 * @license    https://payro24.ir/
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    //--- my order history ------------------------------------------------------------------------------------------
    $previewnode = $PAGE->navigation->add((get_string('payro24_history', 'enrol_payro24')), new moodle_url('/enrol/payro24/payro24_log.php'), navigation_node::TYPE_CONTAINER);
    $previewnode->make_active();

    //--- settings ------------------------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('enrol_payro24_settings', '', get_string('pluginname_desc', 'enrol_payro24')));

    $settings->add(new admin_setting_configtext('enrol_payro24/api_key', get_string('api_key', 'enrol_payro24'), '', '', PARAM_RAW));;

    $settings->add(new admin_setting_configtext('enrol_payro24/currency', get_string('currency', 'enrol_payro24'), '', '', PARAM_RAW));;

    $settings->add(new admin_setting_configcheckbox('enrol_payro24/sandbox', get_string('sandbox', 'enrol_payro24'), '', 0));

    $settings->add(new admin_setting_configcheckbox('enrol_payro24/mailstudents', get_string('mailstudents', 'enrol_payro24'), '', 0));

    $settings->add(new admin_setting_configcheckbox('enrol_payro24/mailteachers', get_string('mailteachers', 'enrol_payro24'), '', 0));

    $settings->add(new admin_setting_configcheckbox('enrol_payro24/mailadmins', get_string('mailadmins', 'enrol_payro24'), '', 0));

    // Note: let's reuse the ext sync constants and strings here, internally it is very similar,
    //       it describes what should happen when users are not supposed to be enrolled any more.
    $options = array(
        ENROL_EXT_REMOVED_KEEP => get_string('extremovedkeep', 'enrol'),
        ENROL_EXT_REMOVED_SUSPENDNOROLES => get_string('extremovedsuspendnoroles', 'enrol'),
        ENROL_EXT_REMOVED_UNENROL => get_string('extremovedunenrol', 'enrol'),
    );

    $settings->add(new admin_setting_configselect('enrol_payro24/expiredaction', get_string('expiredaction', 'enrol_payro24'), get_string('expiredaction_help', 'enrol_payro24'), ENROL_EXT_REMOVED_SUSPENDNOROLES, $options));



    //--- enrol instance defaults ----------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('enrol_payro24_defaults',
        get_string('enrolinstancedefaults', 'admin'), get_string('enrolinstancedefaults_desc', 'admin')));

    $options = array(ENROL_INSTANCE_ENABLED => get_string('yes'),
        ENROL_INSTANCE_DISABLED => get_string('no'));
    $settings->add(new admin_setting_configselect('enrol_payro24/status',
        get_string('status', 'enrol_payro24'), get_string('status_desc', 'enrol_payro24'), ENROL_INSTANCE_DISABLED, $options));

    $settings->add(new admin_setting_configtext('enrol_payro24/cost', get_string('cost', 'enrol_payro24'), '', 0, PARAM_FLOAT, 4));

    $payro24currencies = enrol_get_plugin('payro24')->get_currencies();
    $settings->add(new admin_setting_configselect('enrol_payro24/currency', get_string('currency', 'enrol_payro24'), '', 'USD', $payro24currencies));

    if (!during_initial_install()) {
        $options = get_default_enrol_roles(context_system::instance());
        $student = get_archetype_roles('student');
        $student = reset($student);
        $settings->add(new admin_setting_configselect('enrol_payro24/roleid',
            get_string('defaultrole', 'enrol_payro24'), get_string('defaultrole_desc', 'enrol_payro24'), $student->id, $options));
    }

    $settings->add(new admin_setting_configduration('enrol_payro24/enrolperiod',
        get_string('enrolperiod', 'enrol_payro24'), get_string('enrolperiod_desc', 'enrol_payro24'), 0));

}
