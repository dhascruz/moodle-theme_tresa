<?php
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
