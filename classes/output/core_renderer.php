<?php
/**
 * Theme Tresa - core renderer.
 *
 * Tresa is standalone (no theme_boost parent), so this simply extends
 * Moodle's base core_renderer. Kept as an explicit class (even though empty)
 * so future renderer customisations have an obvious home, and so Tresa's
 * renderer resolution never depends on any other theme being present.
 *
 * @package   theme_tresa
 * @copyright 2026 Tresa Theme
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_tresa\output;

defined('MOODLE_INTERNAL') || die();

class core_renderer extends \core\output\core_renderer {
}
