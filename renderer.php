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
 * @package local_moodlescript
 * @category local
 * @author Valery Fremaux (valery.fremaux@gmail.com)
 * @copyright (c) 2017 onwards Valery Fremaux (http://www.mylearningfactory.com)
 */

class tool_moodlescript_renderer extends plugin_renderer_base {

    public function bankbutton() {
        global $OUTPUT;

        $template = new StdClass;
        $template->bankurl = new moodle_url('/admin/tool/moodlescript/pro/bank.php');

        $template->bankstr = get_string('scriptbank', 'tool_moodlescript');

        return $OUTPUT->render_from_template('tool_moodlescript/bankbutton', $template);
    }

    public function returnbutton() {
        global $OUTPUT;

        $template = new StdClass;
        $template->indexurl = new moodle_url('/admin/tool/moodlescript/index.php');
        $template->returnstr = get_string('return', 'tool_moodlescript');

        return $OUTPUT->render_from_template('tool_moodlescript/returnbutton', $template);
    }

}