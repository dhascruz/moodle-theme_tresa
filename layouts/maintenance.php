<?php
/**
 * Theme Tresa - maintenance layout.
 *
 * Used during upgrade and for the "site under maintenance" message. Must
 * stay extremely simple: no DB/cache-dependent calls beyond what core's
 * maintenance renderer already does for us via $OUTPUT.
 *
 * @package   theme_tresa
 * @copyright 2026 Tresa Theme
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$templatecontext = [
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes(['tresa-maintenance']),
];

echo $OUTPUT->render_from_template('theme_tresa/maintenance', $templatecontext);
