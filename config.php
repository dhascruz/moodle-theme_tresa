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
 * Theme Tresa - configuration.
 *
 * Tresa is fully standalone: $THEME->parents is empty, so it does not
 * inherit anything from Boost (or any other theme). Every layout, the
 * chrome (head/navbar/footer) and the SCSS design system are Tresa's own.
 *
 * @package   theme_tresa
 * @copyright 2026 Tresa Theme
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$THEME->name = 'tresa';
$THEME->parents = [];
$THEME->sheets = [];
$THEME->editor_sheets = [];
$THEME->enable_dock = false;
$THEME->yuicssmodules = [];
$THEME->rarely_used_stylesheets = false;
$THEME->requiredblocks = '';
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;
$THEME->usescourseindex = false;
$THEME->haseditswitch = true;
$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;
$THEME->activityheaderconfig = [
    'notitle' => false,
];

// Home/Dashboard/My courses/Site administration already live in the left
// nav drawer (theme_tresa/sidebar - see lib.php) for every signed-in,
// non-guest user, so showing them a second time in the top navbar's
// primary menu is pure duplication. Guests/logged-out visitors never get
// the sidebar (see general.php's $hassidebar check), so they keep the full
// top nav as their only means of navigating - this mirrors that same
// condition. Uses core's own removedprimarynavitems mechanism (see
// \core\navigation\views\primary) rather than filtering the exported menu
// array by hand.
if (isloggedin() && !isguestuser()) {
    $THEME->removedprimarynavitems = ['home', 'myhome', 'mycourses', 'siteadminnode'];
}

// A handful of PHP files cover every layout key Moodle core uses:
// - base.php         bare chrome, no blocks (layout "base")
// - general.php       navbar + optional side-pre blocks (most page types)
// - columns1.php      no navbar, no blocks - popups/print/embedded/secure
// - login.php         centred login card
// - maintenance.php   bare-bones, used during upgrade/maintenance
// - frontpage.php     the custom hero/course-grid/footer landing page
$THEME->layouts = [
    'base' => [
        'file' => 'base.php',
        'regions' => [],
    ],
    'standard' => [
        'file' => 'general.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'course' => [
        'file' => 'general.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'coursecategory' => [
        'file' => 'general.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'incourse' => [
        'file' => 'general.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'frontpage' => [
        'file' => 'frontpage.php',
        'regions' => [],
    ],
    'admin' => [
        'file' => 'general.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'mycourses' => [
        'file' => 'general.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'mydashboard' => [
        'file' => 'general.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'mypublic' => [
        'file' => 'general.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'report' => [
        'file' => 'general.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'login' => [
        'file' => 'login.php',
        'regions' => [],
    ],
    'popup' => [
        'file' => 'columns1.php',
        'regions' => [],
    ],
    'frametop' => [
        'file' => 'columns1.php',
        'regions' => [],
    ],
    'embedded' => [
        'file' => 'columns1.php',
        'regions' => [],
    ],
    'print' => [
        'file' => 'columns1.php',
        'regions' => [],
    ],
    'redirect' => [
        'file' => 'columns1.php',
        'regions' => [],
    ],
    'secure' => [
        'file' => 'columns1.php',
        'regions' => [],
    ],
    'maintenance' => [
        'file' => 'maintenance.php',
        'regions' => [],
    ],
];

// SCSS pipeline (see lib.php for the callback implementations).
$THEME->scss = function($theme) {
    return theme_tresa_get_main_scss_content($theme);
};
$THEME->prescsscallback = 'theme_tresa_get_pre_scss';
$THEME->extrascsscallback = 'theme_tresa_get_extra_scss';
