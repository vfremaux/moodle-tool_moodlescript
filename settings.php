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
 * Flatfile enrolments plugin settings and presets.
 *
 * @package    tool_moodlescript
 * @copyright  2014 Valery Feemaux
 * @author     Valery Fremaux - based on code by Petr Skoda and others
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/admin/tool/moodlescript/lib.php');

if ($hassiteconfig) {
    $toolurl = new moodle_url('/admin/tool/moodlescript/index.php');
    $label = get_string('execscript', 'tool_moodlescript');
    $ADMIN->add('tools', new admin_externalpage('toolmoodlescript', $label, $toolurl));

    $settings = new admin_settingpage('tool_moodlescript', get_string('pluginname', 'tool_moodlescript'));

    if (tool_moodlescript_supports_feature('emulate/community') == 'pro') {
        include_once($CFG->dirroot.'/admin/tool/moodlescript/pro/prolib.php');
        $promanager = tool_moodlescript\pro_manager::instance();
        $promanager->add_settings($ADMIN, $settings);
    } else {
        $label = get_string('plugindist', 'tool_moodlescript');
        $desc = get_string('plugindist_desc', 'tool_moodlescript');
        $settings->add(new admin_setting_heading('plugindisthdr', $label, $desc));
    }
}

