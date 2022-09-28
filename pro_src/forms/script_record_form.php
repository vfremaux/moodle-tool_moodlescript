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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/lib/formslib.php');

class script_record_form extends moodleform {

    public function definition() {

        $mform = $this->_form;

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'dirty');
        $mform->setType('dirty', PARAM_BOOL);

        $mform->addElement('text', 'name', get_string('name'));
        $mform->setType('name', PARAM_TEXT);

        $attrs = array('cols' => 120, 'rows' => 40);
        $mform->addElement('textarea', 'script', get_string('script', 'tool_moodlescript'), $attrs);
        $mform->setType('name', PARAM_RAW);

        $options = array('1' => get_string('system', 'tool_moodlescript'));

        $mform->addElement('select', 'context', get_string('context', 'tool_moodlescript'), $options);
        $mform->setType('context', PARAM_INT);

        $this->add_action_buttons();
    }

}