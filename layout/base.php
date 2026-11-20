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
 * Theme Tresa - base layout (no navbar, no blocks).
 *
 * Used for the "base" layout key: the most stripped-down chrome Moodle
 * asks a theme for.
 *
 * @package   theme_tresa
 * @copyright 2026 Tresa Theme
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/theme/tresa/lib.php');

$templatecontext = theme_tresa_get_chrome_context($PAGE, $OUTPUT, ['tresa-base']);
$templatecontext['footer'] = theme_tresa_get_footer_context($PAGE);

echo $OUTPUT->render_from_template('theme_tresa/base', $templatecontext);
