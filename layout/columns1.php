<?php
/**
 * Theme Tresa - bare single-column layout.
 *
 * No navbar, no blocks. Used for popup/frametop/embedded/print/redirect/secure
 * - pages that need minimal, distraction-free chrome (e.g. safe browser
 * windows, iframes, print views).
 *
 * @package   theme_tresa
 * @copyright 2026 Tresa Theme
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$templatecontext = [
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes(['tresa-columns1']),
];

echo $OUTPUT->render_from_template('theme_tresa/columns1', $templatecontext);
