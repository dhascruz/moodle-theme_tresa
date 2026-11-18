<?php
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

// Decorative study widgets (see lib.php), same pages as the dark reskin in
// _dashboard.scss. The right-hand column set (dashboardwidgets - focus
// timer/study goal/co-pilot/engagement chart) also shows on the Calendar
// page, matching the reference design; the hero/stats/charts set
// (mainwidgets) is Dashboard/My courses only - Calendar keeps its own real
// content as the main focus.
//
// Keyed on pagetype, NOT pagelayout: several unrelated pages (e.g.
// message/index.php) reuse the "mydashboard" pagelayout key just to get a
// blocks column, which previously made this check misfire and stack the
// Dashboard's hero/stat-tile widgets on top of the messaging UI.
$isdashboardpage = $hassidebar && in_array($PAGE->pagetype, ['my-index', 'my-courses'], true);
$iscalendarpage = $hassidebar && strpos($PAGE->pagetype, 'calendar-') === 0;
$templatecontext['dashboardwidgets'] = ($isdashboardpage || $iscalendarpage) ? theme_tresa_get_dashboard_widgets_context() : null;
$templatecontext['mainwidgets'] = $isdashboardpage ? theme_tresa_get_main_widgets_context($PAGE) : null;
$templatecontext['hasrightcolumn'] = $templatecontext['hasblocks'] || !empty($templatecontext['dashboardwidgets']);

echo $OUTPUT->render_from_template('theme_tresa/general', $templatecontext);
