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
 * Plugin version info
 *
 * @package    tool
 * @subpackage moodlescript
 * @copyright  2018 Valery Fremaux {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2023062604; // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires  = 2020060900; // Requires this Moodle version.
$plugin->component = 'tool_moodlescript'; // Full name of the plugin (used for diagnostics).
$plugin->maturity = MATURITY_RC;
$plugin->release = '3.9.0 (Build 2023062604)';
$plugin->dependencies = array('local_moodlescript' => 2017082401);
$plugin->supported = [400, 401];

// Non moodle attributes.
$plugin->codeincrement = '4.0.0000';
$plugin->privacy = 'dualrelease';

