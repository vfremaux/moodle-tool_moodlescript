<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/lib/formslib.php');
require_once($CFG->dirroot.'/local/moodlescript/lib.php');

class script_form extends moodleform {

    public function definition() {

        $mform = $this->_form;

        $mform->addElement('hidden', 'step', PROCESSING_PARSING);
        $mform->setType('step', PARAM_INT);

        $mform->addElement('textarea', 'script', get_string('script', 'tool_moodlescript'), array('cols' => 100, 'rows' => 20));
        $mform->setType('step', PARAM_TEXT);

        $this->add_action_buttons(true, get_string('parse', 'tool_moodlescript'));
    }
}