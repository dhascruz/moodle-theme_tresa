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
 * Theme Tresa - general layout.
 *
 * Used for the vast majority of pages: standard, course, coursecategory,
 * incourse, admin, mycourses, mydashboard, mypublic, report. Renders the
 * navbar, an optional side-pre block column, and the page's main content.
 *
 * @package   theme_tresa
 * @copyright 2026 Tresa Theme
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/theme/tresa/lib.php');

// The left nav drawer only makes sense for a signed-in user with an actual
// account (calendar/gradebook/private files/preferences links, profile
// card) - skipped for guest access and logged-out visitors browsing a
// public course.
$hassidebar = isloggedin() && !isguestuser();

$templatecontext = theme_tresa_get_chrome_context(
    $PAGE,
    $OUTPUT,
    $hassidebar ? ['tresa-general', 'tresa-has-sidebar'] : ['tresa-general']
);

$header = $PAGE->activityheader;
$templatecontext['headercontent'] = $header ? $header->export_for_template($OUTPUT) : null;
$templatecontext['footer'] = theme_tresa_get_footer_context($PAGE);
$templatecontext['sidebar'] = $hassidebar ? theme_tresa_get_sidebar_context($PAGE) : null;

$templatecontext['hasrightcolumn'] = $templatecontext['hasblocks'];

echo $OUTPUT->render_from_template('theme_tresa/general', $templatecontext);
