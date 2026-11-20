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
