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
 * @package tool_moodlescript
 * @category tool
 */
require('../../../config.php');

require_once($CFG->dirroot.'/local/moodlescript/lib.php');
require_once($CFG->dirroot.'/admin/tool/moodlescript/forms/script_form.php');

local_moodlescript_load_engine();

$url = new moodle_url('/admin/tool/moodlescript/index.php');

require_login();

$context = context_system::instance();
require_capability('moodle/site:config', $context);

$PAGE->set_url($url);
$PAGE->set_context($context);

$globalcontext = new StdClass;
$globalcontext->wwwroot = $CFG->wwwroot;
$globalcontext->currentuserid = $USER->id;
$globalcontext->currentusername = $USER->username;
$globalcontext->siteshortname = $SITE->shortname;

$renderer = $PAGE->get_renderer('tool_moodlescript');

$step = optional_param('step', PROCESSING_INPUT, PARAM_INT);
$save = optional_param('save', 0, PARAM_INT);
$script = optional_param('script', '', PARAM_RAW);

if ($save) {
    $params = array('script' => $script);
    $saveurl = new moodle_url('/admin/tool/moodlescript/pro/edit.php', $params);
    redirect($saveurl);
}

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('executescript', 'tool_moodlescript'));

if (tool_moodlescript_supports_feature('scripts/bank')) {
    echo $renderer->bankbutton();
}

switch ($step) {
    case PROCESSING_INPUT: {

        echo $OUTPUT->heading(get_string('script', 'tool_moodlescript'), 3);
        $formdata = new StdClass;
        $formdata->script = optional_param('script', '', PARAM_RAW);
        $form = new script_form();
        $form->set_data($formdata);
        $form->display();

        break;
    }

    case PROCESSING_PARSING: {

        $script = required_param('script', PARAM_TEXT);

        echo '<pre>';
        echo $script;
        echo '</pre>';

        $parser = new \local_moodlescript\engine\parser($script);
        $parser->parse($globalcontext);

        echo $OUTPUT->heading(get_string('validationresult', 'tool_moodlescript'), 3);

        $str = '<pre>';
        $str .=  $parser->print_errors();
        $str .= '</pre>';

        if (!$parser->has_errors()) {
            echo $OUTPUT->notification($str, 'notifysuccess');
        } else {
            echo $OUTPUT->notification($str, 'notifyproblem');
        }

        echo $OUTPUT->heading(get_string('stack', 'tool_moodlescript'), 3);
        echo '<pre>';
        echo $parser->print_stack();
        echo '</pre>';

        echo $OUTPUT->heading(get_string('trace', 'tool_moodlescript'), 3);
        echo '<pre>';
        echo $parser->print_trace();
        echo '</pre>';

        echo $OUTPUT->box_start('tool-moodlescript-inline');

        if (!$parser->has_errors()) {
            $params = array('run' => 1, 'sesskey' => sesskey(), 'script' => $script, 'step' => PROCESSING_RUNNING);
            $buttonurl = new moodle_url('/admin/tool/moodlescript/index.php', $params);
            $label = get_string('runstack', 'tool_moodlescript');
            echo $OUTPUT->single_button($buttonurl, $label);

            $params = array('save' => 1, 'sesskey' => sesskey(), 'script' => $script, 'step' => PROCESSING_PARSING);
            $buttonurl = new moodle_url('/admin/tool/moodlescript/index.php', $params);
            $label = get_string('save', 'tool_moodlescript');
            echo $OUTPUT->single_button($buttonurl, $label);
        }

        $params = array('run' => 0, 'sesskey' => sesskey(), 'script' => $script, 'step' => PROCESSING_INPUT);
        $buttonurl = new moodle_url('/admin/tool/moodlescript/index.php', $params);
        $label = get_string('change', 'tool_moodlescript');
        echo $OUTPUT->single_button($buttonurl, $label);

        echo $OUTPUT->box_end();

        break;
    }

    case PROCESSING_RUNNING: {

        $script = required_param('script', PARAM_TEXT);

        echo '<pre>';
        echo $script;
        echo '</pre>';

        $parser = new \local_moodlescript\engine\parser($script);
        $stack = $parser->parse($globalcontext);

        $stack->check(null);

        echo $OUTPUT->heading(get_string('check', 'tool_moodlescript'), 3);
        echo '<pre>';
        echo $stack->print_log();
        echo '</pre>';

        if (!$stack->has_errors()) {

            $stack->execute($globalcontext);

            $log = $stack->get_log();

            echo $OUTPUT->heading(get_string('log', 'tool_moodlescript'), 3);
            echo '<pre>';
            echo $stack->print_log();
            echo '</pre>';

            echo '<div class="processing-flatform">';

            $buttonurl = new moodle_url('/admin/tool/moodlescript/index.php');
            $label = get_string('newscript', 'tool_moodlescript');
            echo $OUTPUT->single_button($buttonurl, $label);

            $buttonurl = new moodle_url('/admin/tool/moodlescript/index.php');
            $label = get_string('reusescript', 'tool_moodlescript');
            echo $OUTPUT->single_button($buttonurl, $label);

            echo '</div>';
        } else {
            echo $OUTPUT->heading(get_string('runtimeerrors', 'tool_moodlescript'), 3);
            echo '<pre>';
            echo $stack->print_errors();
            echo '</pre>';
        }
    }
}

echo $OUTPUT->footer();
