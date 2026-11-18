<?php
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

$templatecontext = [
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes(['tresa-login']),
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), 'escape' => false]),
    'homeurl' => (new moodle_url('/'))->out(false),
];

echo $OUTPUT->render_from_template('theme_tresa/login', $templatecontext);
