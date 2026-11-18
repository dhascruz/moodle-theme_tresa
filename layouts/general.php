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

$templatecontext = theme_tresa_get_chrome_context($PAGE, $OUTPUT, ['tresa-general']);

$header = $PAGE->activityheader;
$templatecontext['headercontent'] = $header ? $header->export_for_template($OUTPUT) : null;

echo $OUTPUT->render_from_template('theme_tresa/general', $templatecontext);
