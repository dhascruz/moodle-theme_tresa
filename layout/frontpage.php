<?php
/**
 * Theme Tresa - custom landing page layout.
 *
 * Uses Tresa's own head/navbar/footer-scripts partials (not Boost's) and
 * replaces the front page BODY with a custom hero banner + course grid +
 * footer instead of the default "topics" front page body.
 *
 * @package   theme_tresa
 * @copyright 2026 Tresa Theme
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/theme/tresa/lib.php');

$templatecontext = theme_tresa_get_chrome_context($PAGE, $OUTPUT, ['tresa-landing']);

// ---------------------------------------------------------------------
// Tresa-specific landing page content: hero banner, course grid, footer.
// ---------------------------------------------------------------------
$theme = $PAGE->theme;

$herobgtype = $theme->settings->herobgtype ?? 'gradient';
$heroimageurls = ($herobgtype === 'image') ? theme_tresa_get_hero_image_urls() : [];

$heroimages = array_map(function($url, $index) {
    return ['url' => $url, 'first' => ($index === 0), 'index1' => $index + 1];
}, $heroimageurls, array_keys($heroimageurls));

$herobgautoscroll = !empty($theme->settings->herobgautoscroll) && count($heroimages) > 1;
$herobgautoscrollinterval = !empty($theme->settings->herobgautoscrollinterval) ? (int) $theme->settings->herobgautoscrollinterval : 5;

$templatecontext['hero'] = [
    'title' => !empty($theme->settings->herotitle)
        ? format_string($theme->settings->herotitle, true, ['context' => context_system::instance()])
        : get_string('herotitle_default', 'theme_tresa', format_string($SITE->fullname)),
    'subtitle' => !empty($theme->settings->herosubtitle) ? $theme->settings->herosubtitle : get_string('herosubtitle_default', 'theme_tresa'),
    'buttontext' => !empty($theme->settings->herobuttontext) ? $theme->settings->herobuttontext : get_string('herobuttontext_default', 'theme_tresa'),
    'buttonurl' => !empty($theme->settings->herobuttonurl) ? $theme->settings->herobuttonurl : (new moodle_url('/course/index.php'))->out(false),
    'hasimage' => !empty($heroimages),
    'imageurl' => !empty($heroimageurls) ? $heroimageurls[0] : null,
    'images' => $heroimages,
    'hasmultipleimages' => count($heroimages) > 1,
    'autoscroll' => $herobgautoscroll,
    'autoscrollinterval' => $herobgautoscrollinterval * 1000,
];

$coursegridcount = !empty($theme->settings->coursegridcount) ? (int) $theme->settings->coursegridcount : 6;
$courses = theme_tresa_get_frontpage_courses($coursegridcount);

$templatecontext['coursegrid'] = [
    'title' => !empty($theme->settings->coursegridtitle) ? $theme->settings->coursegridtitle : get_string('coursegridtitle_default', 'theme_tresa'),
    'subtitle' => $theme->settings->coursegridsubtitle ?? '',
    'courses' => array_values($courses),
    'hascourses' => !empty($courses),
    'viewallurl' => (new moodle_url('/course/index.php'))->out(false),
    'viewalltext' => get_string('viewallcourses', 'theme_tresa'),
];

$templatecontext = array_merge($templatecontext, theme_tresa_get_frontpage_stats_context());
$templatecontext['topbar'] = theme_tresa_get_landing_topbar_context();
$templatecontext = array_merge($templatecontext, theme_tresa_get_landing_sections_context($heroimageurls));
$templatecontext['steps'] = theme_tresa_get_frontpage_steps_context();
$templatecontext['features'] = theme_tresa_get_frontpage_features_context();
$templatecontext['ticker'] = theme_tresa_get_frontpage_ticker_context();
$templatecontext['footer'] = theme_tresa_get_footer_context($PAGE);

echo $OUTPUT->render_from_template('theme_tresa/frontpage', $templatecontext);
