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
 * Theme Tresa - login layout.
 *
 * A simple, centred login card. No side blocks.
 *
 * @package   theme_tresa
 * @copyright 2026 Tresa Theme
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/theme/tresa/lib.php');

global $SITE;

// Optional admin-chosen background image (Background images tab). Without one the page uses the
// deep green + multilingual pattern defined in the theme styles.
$theme = $PAGE->theme;
$bgimageurl = $theme->setting_file_url('loginbackgroundimage', 'loginbackgroundimage');

$showcustomloginlink = !empty($theme->settings->customloginlinktext) && !empty($theme->settings->customloginlinkurl);

$templatecontext = [
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes(['tresa-login']),
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), 'escape' => false]),
    'homeurl' => (new moodle_url('/'))->out(false),
    'hasbgimage' => !empty($bgimageurl),
    'bgimageurl' => $bgimageurl ?: null,
    'loginnotices' => class_exists('\\local_dbajourney\\hook_callbacks') ? \local_dbajourney\hook_callbacks::login_notices_html() : '',
    'copyrighttext' => get_string('logincopyright', 'theme_tresa', (object) [
        'year' => date('Y'),
        'site' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID)]),
    ]),
    'showcustomloginlink' => $showcustomloginlink,
    'customloginlinktext' => $showcustomloginlink ? format_string($theme->settings->customloginlinktext) : '',
    'customloginlinkurl' => $showcustomloginlink ? $theme->settings->customloginlinkurl : '',
    // See lib.php:theme_tresa_get_chrome_context() for why this doesn't go
    // through core's get_compact_logo_url().
    'tresalogourl' => $OUTPUT->image_url('logo', 'theme_tresa')->out(false),
];

echo $OUTPUT->render_from_template('theme_tresa/login', $templatecontext);
