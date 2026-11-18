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
$heroimageurl = theme_tresa_get_hero_image_url();

$templatecontext['hero'] = [
    'title' => !empty($theme->settings->herotitle)
        ? format_string($theme->settings->herotitle, true, ['context' => context_system::instance()])
        : get_string('herotitle_default', 'theme_tresa', format_string($SITE->fullname)),
    'subtitle' => !empty($theme->settings->herosubtitle) ? $theme->settings->herosubtitle : get_string('herosubtitle_default', 'theme_tresa'),
    'buttontext' => !empty($theme->settings->herobuttontext) ? $theme->settings->herobuttontext : get_string('herobuttontext_default', 'theme_tresa'),
    'buttonurl' => !empty($theme->settings->herobuttonurl) ? $theme->settings->herobuttonurl : (new moodle_url('/course/index.php'))->out(false),
    'hasimage' => ($herobgtype === 'image' && !empty($heroimageurl)),
    'imageurl' => $heroimageurl ?: null,
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

$footerlinkcol = function(string $rawtitle, string $rawlinks) {
    $links = [];
    foreach (preg_split('/\r?\n/', trim((string) $rawlinks)) as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '|') === false) {
            continue;
        }
        [$text, $url] = array_map('trim', explode('|', $line, 2));
        if ($text === '' || $url === '') {
            continue;
        }
        $links[] = ['text' => $text, 'url' => $url];
    }
    return ['title' => $rawtitle, 'links' => $links];
};

$templatecontext['footer'] = [
    'sitename' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID)]),
    'about' => $theme->settings->footerabout ?? '',
    'col1' => $footerlinkcol($theme->settings->footerlinks1title ?? get_string('footerlinks1title_default', 'theme_tresa'), $theme->settings->footerlinks1 ?? ''),
    'col2' => $footerlinkcol($theme->settings->footerlinks2title ?? get_string('footerlinks2title_default', 'theme_tresa'), $theme->settings->footerlinks2 ?? ''),
    'copyright' => str_replace(
        '{$a}',
        date('Y'),
        !empty($theme->settings->footercopyright) ? $theme->settings->footercopyright : get_string('footercopyright_default', 'theme_tresa', date('Y'))
    ),
    'backtotoptext' => get_string('backtotop', 'theme_tresa'),
];

echo $OUTPUT->render_from_template('theme_tresa/frontpage', $templatecontext);
