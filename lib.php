<?php
/**
 * Theme Tresa - library functions (SCSS pipeline + landing page helpers).
 *
 * @package   theme_tresa
 * @copyright 2026 Tresa Theme
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Builds the template context shared by every Tresa layout: site name,
 * body attributes and the primary navigation (site nav menu, language menu,
 * user menu), all built the standard Moodle way via
 * \core\navigation\output\primary so theme_tresa/navbar can render them with
 * core's own core/moremenu and core/user_menu templates.
 *
 * @param moodle_page $page
 * @param \core\output\core_renderer $output
 * @param string[] $extrabodyclasses
 * @return array
 */
function theme_tresa_get_chrome_context($page, $output, array $extrabodyclasses = []): array {
    global $SITE;

    $primary = new \core\navigation\output\primary($page);
    $renderer = $page->get_renderer('core');
    $primarymenu = $primary->export_for_template($renderer);

    $blockshtml = in_array('side-pre', $page->blocks->get_regions(), true) ? $output->blocks('side-pre') : '';
    $hasblocks = strpos($blockshtml, 'data-block=') !== false;

    // Secondary navigation (the tabs/sub-links you get on admin pages, course
    // settings pages, user profile pages, etc). Without this, "Site
    // administration" and similar sections lose most of their sub-navigation.
    $secondarynavigation = false;
    $overflow = false;
    if ($page->has_secondary_navigation()) {
        $tablistnav = $page->has_tablist_secondary_navigation();
        $moremenu = new \core\navigation\output\more_menu($page->secondarynav, 'nav-tabs', true, $tablistnav);
        $secondarynavigation = $moremenu->export_for_template($output);

        $overflowdata = $page->secondarynav->get_overflow_menu_data();
        if (!is_null($overflowdata)) {
            $selectmenu = new \core\output\select_menu(
                'tertiarynavigation',
                $overflowdata->urls,
                $overflowdata->selected
            );
            $selectmenu->set_label($overflowdata->label, $overflowdata->labelattributes);
            $overflow = $selectmenu->export_for_template($output);
        }
    }

    // "..." menu for the main content region (e.g. course/activity admin
    // actions), only built when the page hasn't already folded it into the
    // header actions itself.
    $regionmainsettingsmenu = false;
    if (!$page->include_region_main_settings_in_header_actions() && !$page->has_secondary_navigation()) {
        $regionmainsettingsmenu = $output->region_main_settings_menu();
    }

    return [
        'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), 'escape' => false]),
        'homeurl' => (new moodle_url('/'))->out(false),
        'output' => $output,
        'bodyattributes' => $output->body_attributes($extrabodyclasses),
        'primarymoremenu' => $primarymenu['moremenu'],
        'mobileprimarynav' => $primarymenu['mobileprimarynav'],
        'usermenu' => $primarymenu['user'],
        'langmenu' => $primarymenu['lang'],
        'sidepreblocks' => $blockshtml,
        'hasblocks' => $hasblocks,
        'secondarymoremenu' => $secondarynavigation,
        'overflow' => $overflow,
        'regionmainsettingsmenu' => $regionmainsettingsmenu,
        'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
        // theme_tresa/showloginnavbar only makes sense for logged-out
        // visitors (usermenu renders the user's own avatar/dropdown once
        // logged in, which this setting was never meant to hide).
        'showloginnavbar' => isloggedin() || (bool) ($page->theme->settings->showloginnavbar ?? true),
        // Bundled theme logo (pix/logo.png), shown whenever no site-wide
        // logo is configured under Appearance > Logos - see navbar.mustache.
        // Deliberately NOT routed through core's own
        // get_compact_logo_url()/make_pluginfile_url(): that combination
        // concatenates the cache-busting revision straight onto the
        // filename with no separator ("...1785382515logocompact.png"),
        // which core_admin_pluginfile()'s array_shift()-based arg parsing
        // can't recover the filename from, 404ing every request - a real
        // bug in this Moodle build, not something a theme can fix.
        // $OUTPUT->image_url() builds its URL differently (proper "/"
        // between every segment - see theme_config::image_url()) and isn't
        // affected.
        'tresalogourl' => $output->image_url('logo', 'theme_tresa')->out(false),
    ];
}

/**
 * Builds the left navigation drawer context shared by every layout that
 * renders theme_tresa/sidebar (currently just the "general" layout - see
 * general.php): a primary link group (Home/Dashboard/My courses, plus Site
 * administration for admins), a "User workspace" group (calendar/grades/
 * messages/private files/preferences), and the compact profile card pinned
 * to the bottom.
 *
 * @param moodle_page $page
 * @return array
 */
function theme_tresa_get_sidebar_context($page): array {
    global $USER, $OUTPUT;

    $currentpath = parse_url($page->url->out(false), PHP_URL_PATH) ?: '';

    $link = function(string $text, string $path, string $icon) use ($currentpath) {
        $url = (new moodle_url($path))->out(false);
        return [
            'text' => $text,
            'url' => $url,
            'icon' => $icon,
            'active' => $currentpath !== '' && parse_url($url, PHP_URL_PATH) === $currentpath,
        ];
    };

    $primarylinks = [
        $link(get_string('sidebarhome', 'theme_tresa'), '/', 'fa-home'),
        // '/my/index.php', not the bare '/my/' directory path: my/index.php
        // itself calls $PAGE->set_url('/my/index.php', ...), so that's what
        // $page->url actually resolves to for the dashboard - matching
        // against '/my/' here would never mark this link active.
        $link(get_string('sidebardashboard', 'theme_tresa'), '/my/index.php', 'fa-th-large'),
        $link(get_string('sidebarmycourses', 'theme_tresa'), '/my/courses.php', 'fa-graduation-cap'),
    ];
    // DBA/PhD journey: where learners submit their work and staff review it.
    if (class_exists('\\local_dbajourney\\journey') && \local_dbajourney\journey::is_participant((int) $USER->id)) {
        array_splice($primarylinks, 2, 0, [$link(get_string('myjourney', 'local_dbajourney'), '/local/dbajourney/index.php', 'fa-flag')]);
    }
    if (class_exists('\\local_dbajourney\\journey') && has_capability('local/dbajourney:evaluate', context_system::instance())) {
        array_splice($primarylinks, 2, 0, [$link(get_string('myevaluations', 'local_dbajourney'), '/local/dbajourney/evaluator.php', 'fa-clipboard-check')]);
    }
    if (has_capability('moodle/site:config', context_system::instance())) {
        $primarylinks[] = $link(get_string('sidebarsiteadmin', 'theme_tresa'), '/admin/search.php', 'fa-cog');
    }

    $workspacelinks = [
        $link(get_string('sidebarcalendar', 'theme_tresa'), '/calendar/view.php', 'fa-calendar'),
        $link(get_string('sidebargradebook', 'theme_tresa'), '/grade/report/overview/index.php', 'fa-bar-chart'),
        $link(get_string('sidebarmessages', 'theme_tresa'), '/message/index.php', 'fa-comments'),
        $link(get_string('sidebarprivatefiles', 'theme_tresa'), '/user/files.php', 'fa-folder'),
        $link(get_string('sidebarpreferences', 'theme_tresa'), '/user/preferences.php', 'fa-sliders'),
    ];

    $roles = get_user_roles(context_system::instance(), $USER->id);
    $roletext = has_capability('moodle/site:config', context_system::instance())
        ? get_string('sidebaradministrator', 'theme_tresa')
        : (reset($roles) ? role_get_name(reset($roles)) : get_string('sidebarlearner', 'theme_tresa'));

    return [
        'primarylinks' => $primarylinks,
        'workspacelinks' => $workspacelinks,
        'sidebarworkspacelabel' => get_string('sidebarworkspace', 'theme_tresa'),
        'profileurl' => (new moodle_url('/user/profile.php'))->out(false),
        'userpictureimage' => $OUTPUT->user_picture($USER, ['size' => 36, 'link' => false]),
        'fullname' => fullname($USER),
        'roletext' => $roletext,
    ];
}

/**
 * Builds the decorative "study widgets" shown in the right-hand column of
 * the Dashboard/My courses pages, alongside the real Calendar/Recently
 * accessed blocks: a focus-timer card, a weekly-study-goal card, an "AI
 * study buddy" prompt box, and a study-engagement bar chart.
 *
 * These are deliberately static/demo UI, not real functionality - Moodle has
 * no underlying data for "study goals", "mentor link", "engagement" or an AI
 * chat buddy. The focus timer counts down for real (client-side only,
 * nothing persisted); the rest is fixed placeholder content matching the
 * reference design's look.
 *
 * @return array
 */
function theme_tresa_get_dashboard_widgets_context(): array {
    return [
        'engagementdays' => [
            ['label' => 'M', 'percent' => 55],
            ['label' => 'T', 'percent' => 70],
            ['label' => 'W', 'percent' => 40],
            ['label' => 'T', 'percent' => 85],
            ['label' => 'F', 'percent' => 60],
            ['label' => 'S', 'percent' => 30],
            ['label' => 'S', 'percent' => 45],
        ],
    ];
}

/**
 * Builds the decorative "analytics" widgets shown above the real Course
 * overview/Timeline content on the Dashboard/My courses pages: a hero
 * summary card, three stat tiles, an "Academic pulse" gauge, a 14-day focus
 * chart, a course-breakdown donut, a weekly/monthly study-hours bar chart,
 * and a "Learning intensity" gauge with a slider.
 *
 * Same caveat as theme_tresa_get_dashboard_widgets_context(): Moodle has no
 * underlying data for "peers", "study/access time", "sprints", "daily
 * packs" or "engagement pulse", so this is fixed placeholder content
 * matching the reference design, not real analytics - it sits alongside the
 * real (and still fully functional) course overview/timeline below it.
 *
 * @param moodle_page $page
 * @return array
 */
function theme_tresa_get_main_widgets_context($page): array {
    global $USER;

    return [
        'firstname' => $USER->firstname,
        'herostat' => [
            'modules' => 10,
            'hours' => '4.8',
            'percent' => 15,
        ],
        'stattiles' => [
            ['label' => 'Total Peers', 'value' => '7 Learners', 'meta' => 'Sync active', 'icon' => 'fa-users'],
            ['label' => 'Avg. Study Time', 'value' => '15 Minutes', 'meta' => 'Peak: 10AM - 1PM', 'icon' => 'fa-clock-o'],
            ['label' => 'Avg. Access Time', 'value' => '4.3 Minutes', 'meta' => 'Highly Engaged', 'icon' => 'fa-hourglass-half'],
        ],
        'academicpulsepercent' => 82,
        'focusvolumedays' => [
            ['label' => 'Mon', 'percent' => 35], ['label' => 'Tue', 'percent' => 55],
            ['label' => 'Wed', 'percent' => 40], ['label' => 'Thu', 'percent' => 90],
            ['label' => 'Fri', 'percent' => 60], ['label' => 'Sat', 'percent' => 20],
            ['label' => 'Sun', 'percent' => 30],
        ],
        'coursebreakdown' => theme_tresa_build_donut_segments(35, [
            ['label' => 'Courses', 'count' => 10, 'percent' => 29, 'color' => '#3b82f6'],
            ['label' => 'Daily Packs', 'count' => 13, 'percent' => 37, 'color' => '#22c55e'],
            ['label' => 'Quizzes', 'count' => 10, 'percent' => 29, 'color' => '#ef4444'],
            ['label' => 'Assessments', 'count' => 2, 'percent' => 6, 'color' => '#eab308'],
        ]),
        'sprinthours' => [
            'days' => [
                ['label' => 'Mon', 'percent' => 20], ['label' => 'Tue', 'percent' => 45],
                ['label' => 'Wed', 'percent' => 90], ['label' => 'Thu', 'percent' => 50],
                ['label' => 'Fri', 'percent' => 60], ['label' => 'Sat', 'percent' => 35],
                ['label' => 'Sun', 'percent' => 25],
            ],
            'totalhours' => '4.8',
        ],
        'learningintensitypercent' => 100,
    ];
}

/**
 * Turns a flat list of {label, count, percent, color} segments into cumulative
 * conic-gradient stops (each segment needs its running start/end percentage,
 * not just its own share) plus a ready-to-use CSS conic-gradient() value -
 * logic-less Mustache can't do running sums, so this is precomputed here
 * rather than in the template.
 *
 * @param int $total
 * @param array $segments
 * @return array
 */
function theme_tresa_build_donut_segments(int $total, array $segments): array {
    $cumulative = 0;
    $stops = [];
    foreach ($segments as $segment) {
        $start = $cumulative;
        $cumulative += $segment['percent'];
        $stops[] = "{$segment['color']} {$start}% {$cumulative}%";
    }

    return [
        'total' => $total,
        'segments' => $segments,
        'conicgradient' => 'conic-gradient(' . implode(', ', $stops) . ')',
    ];
}

/**
 * Builds the branded footer context (about blurb, two link columns,
 * copyright) shared by every Tresa layout, from theme_tresa's own settings.
 * Originally only built for the front page; every layout gets the same
 * footer now so the site looks consistent past the home page.
 *
 * @param moodle_page $page
 * @return array
 */
function theme_tresa_get_footer_context($page): array {
    global $SITE, $CFG;

    $theme = $page->theme;

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

    $sociallinks = theme_tresa_get_social_links();

    // Address/phone are theme settings with no sensible site-wide fallback
    // (left blank/hidden if the admin hasn't set them); email falls back to
    // the site's own support email ($CFG->supportemail) rather than being
    // blank by default, since that's real contact data Moodle already has
    // configured on practically every site, not a made-up placeholder.
    $address = trim((string) ($theme->settings->footeraddress ?? ''));
    $phone = trim((string) ($theme->settings->footerphone ?? ''));
    $email = trim((string) ($theme->settings->footeremail ?? '')) ?: ($CFG->supportemail ?? '');

    return [
        'sitename' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID)]),
        'about' => $theme->settings->footerabout ?? '',
        'contact' => [
            'title' => !empty($theme->settings->footercontacttitle)
                ? $theme->settings->footercontacttitle : get_string('footercontacttitle_default', 'theme_tresa'),
            'address' => $address,
            'hasaddress' => $address !== '',
            'phone' => $phone,
            'phonehref' => preg_replace('/[^0-9+]/', '', $phone),
            'hasphone' => $phone !== '',
            'email' => $email,
            'hasemail' => $email !== '',
        ],
        'hascontact' => $address !== '' || $phone !== '' || $email !== '',
        'col1' => $footerlinkcol(
            $theme->settings->footerlinks1title ?? get_string('footerlinks1title_default', 'theme_tresa'),
            $theme->settings->footerlinks1 ?? ''
        ),
        'col2' => $footerlinkcol(
            $theme->settings->footerlinks2title ?? get_string('footerlinks2title_default', 'theme_tresa'),
            $theme->settings->footerlinks2 ?? ''
        ),
        'copyright' => str_replace(
            '{$a}',
            date('Y'),
            !empty($theme->settings->footercopyright)
                ? $theme->settings->footercopyright
                : get_string('footercopyright_default', 'theme_tresa', date('Y'))
        ),
        'backtotoptext' => get_string('backtotop', 'theme_tresa'),
        'sociallinks' => $sociallinks,
        'hassociallinks' => !empty($sociallinks),
    ];
}

/**
 * Returns the main SCSS content, i.e. the selected preset.
 *
 * @param theme_config $theme
 * @return string
 */
function theme_tresa_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : 'default.scss';
    $fs = get_file_storage();
    $context = context_system::instance();

    if ($filename === 'default.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/tresa/scss/preset/default.scss');
    } else if ($filename === 'plain.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/tresa/scss/preset/plain.scss');
    } else if ($file = $fs->get_file($context->id, 'theme_tresa', 'preset', 0, '/', $filename)) {
        // A preset uploaded via the "preset files" setting.
        $scss .= $file->get_content();
    } else {
        // Fallback to the bundled default.
        $scss .= file_get_contents($CFG->dirroot . '/theme/tresa/scss/preset/default.scss');
    }

    return $scss;
}

/**
 * Injects admin-configured values as SCSS variables *before* the preset is
 * parsed, so they can be picked up by "!default" declarations further down
 * the pipeline (same pattern Boost itself uses in theme_boost_get_pre_scss).
 *
 * @param theme_config $theme
 * @return string
 */
function theme_tresa_get_pre_scss($theme) {
    $scss = '';

    $configurable = [
        // theme_tresa setting name => SCSS variable name.
        'primarycolor'   => 'tresa-primary',
        'secondarycolor' => 'tresa-secondary',
        'herotextcolor'  => 'tresa-hero-text-color',
        'darkcolor'      => 'tresa-dark',
        'bodybgcolor'    => 'tresa-body-bg',
        'linkcolor'      => 'tresa-link-color',
    ];

    foreach ($configurable as $setting => $scssvar) {
        if (!empty($theme->settings->{$setting})) {
            $scss .= '$' . $scssvar . ': ' . $theme->settings->{$setting} . ";\n";
        }
    }

    $herobgtype = $theme->settings->herobgtype ?? 'gradient';
    $scss .= '$tresa-hero-use-image: ' . ($herobgtype === 'image' ? 'true' : 'false') . ";\n";

    if (!empty($theme->settings->coursegridcolumns)) {
        $scss .= '$tresa-grid-columns: ' . (int) $theme->settings->coursegridcolumns . ";\n";
    }

    $fontsizes = ['compact' => '.75rem', 'standard' => '.875rem', 'comfortable' => '1rem'];
    $basefontsize = $theme->settings->basefontsize ?? 'compact';
    $scss .= '$tresa-font-size: ' . ($fontsizes[$basefontsize] ?? $fontsizes['compact']) . ";\n";

    $bodyfont = $theme->settings->bodyfont ?? 'Outfit';
    $scss .= '$tresa-font-family: ' . theme_tresa_font_stack($bodyfont) . ";\n";

    $headingfont = $theme->settings->headingfont ?? 'Outfit';
    $scss .= '$tresa-font-family-display: ' . theme_tresa_font_stack($headingfont) . ";\n";

    return $scss;
}

/**
 * Builds a font-family SCSS value (self-hosted family name, or the system
 * stack) for the "Fonts" admin settings tab. Shared by body/heading pickers
 * so both stay in sync with what's actually self-hosted (see _fonts.scss) -
 * anything other than Inter/Montserrat falls back to system fonts rather
 * than silently requesting a webfont that was never bundled.
 *
 * @param string $font one of 'Inter', 'Montserrat', 'Outfit', 'system'
 * @return string SCSS font-family value, ready to interpolate as-is
 */
function theme_tresa_font_stack(string $font): string {
    $systemstack = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif';
    if (!in_array($font, ['Inter', 'Montserrat', 'Outfit'], true)) {
        return $systemstack;
    }
    return '"' . $font . '", ' . $systemstack;
}

/**
 * Appends raw, admin-supplied SCSS at the very end of the pipeline.
 *
 * @param theme_config $theme
 * @return string
 */
function theme_tresa_get_extra_scss($theme) {
    $scss = theme_tresa_get_page_background_scss($theme);
    $scss .= !empty($theme->settings->rawscss) ? $theme->settings->rawscss : '';
    return $scss;
}

/**
 * Page background image (Background images tab): a full-bleed image behind
 * every page's content, under a configurable colour overlay for contrast.
 * Built as plain CSS (not a $tresa-* variable) since it needs a computed
 * pluginfile URL, not just a value swap.
 *
 * @param theme_config $theme
 * @return string
 */
function theme_tresa_get_page_background_scss($theme): string {
    if (empty($theme->settings->pagebackgroundenabled)) {
        return '';
    }

    $url = $theme->setting_file_url('pagebackgroundimage', 'pagebackgroundimage');
    if (empty($url)) {
        return '';
    }

    $style = $theme->settings->pagebackgroundstyle ?? 'cover';
    $overlaycolor = $theme->settings->pagebackgroundoverlay ?? '#FFFFFF';
    $opacity = isset($theme->settings->pagebackgroundopacity) ? ((int) $theme->settings->pagebackgroundopacity) / 100 : .85;
    $opacity = max(0, min(1, $opacity));

    $sizeposition = $style === 'tile'
        ? 'background-repeat: repeat; background-size: auto;'
        : 'background-repeat: no-repeat; background-size: cover;';

    return <<<CSS
body {
    background-image:
        linear-gradient(rgba({$overlaycolor}, {$opacity}), rgba({$overlaycolor}, {$opacity})),
        url('{$url}');
    background-attachment: fixed;
    {$sizeposition}
}
CSS;
}

/**
 * Social network links for the footer (Social media tab). Only returns
 * entries the admin has actually filled in a URL for.
 *
 * @return array<int, array{network: string, url: string, label: string, icon: string}>
 */
function theme_tresa_get_social_links(): array {
    global $PAGE;

    $theme = $PAGE->theme;
    if (empty($theme->settings->socialenabled)) {
        return [];
    }

    $networks = [
        'facebook'  => ['label' => 'Facebook',        'icon' => 'fa-facebook'],
        'x'         => ['label' => 'X (Twitter)',     'icon' => 'fa-x-twitter'],
        'instagram' => ['label' => 'Instagram',       'icon' => 'fa-instagram'],
        'linkedin'  => ['label' => 'LinkedIn',         'icon' => 'fa-linkedin'],
        'youtube'   => ['label' => 'YouTube',          'icon' => 'fa-youtube'],
    ];

    $links = [];
    foreach ($networks as $network => $info) {
        $url = $theme->settings->{'social' . $network} ?? '';
        if (empty($url)) {
            continue;
        }
        $links[] = [
            'network' => $network,
            'url' => $url,
            'label' => $info['label'],
            'icon' => $info['icon'],
        ];
    }

    return $links;
}

/**
 * Serves theme setting files (e.g. the hero background image).
 */
function theme_tresa_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    $allowed = ['heroimage', 'pagebackgroundimage', 'loginbackgroundimage'];
    if ($context->contextlevel == CONTEXT_SYSTEM && in_array($filearea, $allowed, true)) {
        $theme = theme_config::load('tresa');
        $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        return;
    }
    send_file_not_found();
}

/**
 * Returns the URL for the hero background image, if one has been uploaded.
 *
 * theme_config::setting_file_url() returns a protocol-relative URL string
 * ("//host/path"), by design, because moodle_url can't represent that form
 * (see the comment in theme_config::setting_file_url()) - wrapping it in
 * `new moodle_url()` mangles it into a double-domain URL. So this returns
 * the ready-to-use string as-is rather than a moodle_url.
 *
 * @return string|null
 */
function theme_tresa_get_hero_image_url(): ?string {
    $urls = theme_tresa_get_hero_image_urls();
    return $urls ? $urls[0] : null;
}

/**
 * Returns URLs for every image uploaded to the hero background image
 * setting, in upload order. There can be more than one - see herobgtype
 * (needed to power the auto-scrolling banner) - so, unlike
 * theme_tresa_get_hero_image_url(), this reads the file area directly
 * rather than going through theme_config::setting_file_url(), which only
 * ever knows about a single configured file.
 *
 * Unlike theme_tresa_get_course_image_url() (served by core's generic
 * course_pluginfile()), these files are served by theme_tresa_pluginfile(),
 * which delegates to theme_config::setting_file_serve(). That method
 * unconditionally does `$revision = array_shift($args)` - it always expects
 * a leading "revision" path segment before the real relative path,
 * regardless of its value - so the itemid passed to make_pluginfile_url()
 * here must NOT be null (which omits that segment entirely and silently
 * breaks the file lookup); any non-negative int is fine, so we reuse
 * theme_get_revision() for proper cache-busting, same as
 * theme_config::setting_file_url() already does for the single-file case.
 *
 * @return string[] absolute pluginfile URLs, oldest upload first
 */
function theme_tresa_get_hero_image_urls(): array {
    $syscontext = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($syscontext->id, 'theme_tresa', 'heroimage', 0, 'sortorder, itemid, filepath, filename', false);
    $revision = theme_get_revision();

    $urls = [];
    foreach ($files as $file) {
        if (!$file->is_valid_image()) {
            continue;
        }
        $urls[] = moodle_url::make_pluginfile_url(
            $file->get_contextid(),
            $file->get_component(),
            $file->get_filearea(),
            $revision,
            $file->get_filepath(),
            $file->get_filename()
        )->out(false);
    }

    return $urls;
}

/**
 * Looks up a course's overview image, the same way Moodle's own course
 * cards do: via the "overviewfiles" file area, not via any cache.
 *
 * @param int $courseid
 * @return string|null absolute pluginfile URL, or null if the course has no image
 */
function theme_tresa_get_course_image_url(int $courseid): ?string {
    $context = context_course::instance($courseid);
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'course', 'overviewfiles', 0, 'sortorder DESC, id ASC', false);

    foreach ($files as $file) {
        if ($file->is_valid_image()) {
            $url = moodle_url::make_pluginfile_url(
                $file->get_contextid(),
                $file->get_component(),
                $file->get_filearea(),
                null,
                $file->get_filepath(),
                $file->get_filename()
            );
            return $url->out(false);
        }
    }

    return null;
}

/**
 * Fetches a short list of courses for the landing-page course grid.
 *
 * Honours the "coursegridsource" setting: either the most recently created
 * courses site-wide, or the courses inside a specific category.
 *
 * @param int $limit maximum number of courses to return
 * @return array list of stdClass course summary objects ready for the template
 */
function theme_tresa_get_frontpage_courses(int $limit = 6): array {
    global $DB;

    $theme = theme_config::load('tresa');
    $source = $theme->settings->coursegridsource ?? 'recent';
    $categoryid = (int) ($theme->settings->coursegridcategory ?? 0);

    $params = ['siteid' => SITEID];
    $sql = "SELECT c.id, c.fullname, c.shortname, c.summary, c.summaryformat, c.category
              FROM {course} c
             WHERE c.id <> :siteid AND c.visible = 1";

    if ($source === 'category' && $categoryid > 0) {
        $sql .= " AND c.category = :categoryid";
        $params['categoryid'] = $categoryid;
    }

    $sql .= " ORDER BY c.timecreated DESC";

    $records = $DB->get_records_sql($sql, $params, 0, max(1, $limit));

    $courses = [];
    foreach ($records as $record) {
        $context = context_course::instance($record->id);

        $course = new stdClass();
        $course->id = $record->id;
        $course->fullname = format_string($record->fullname, true, ['context' => $context]);

        $summary = file_rewrite_pluginfile_urls($record->summary, 'pluginfile.php', $context->id, 'course', 'summary', null);
        $summary = format_text($summary, $record->summaryformat, ['context' => $context]);
        $course->summary = shorten_text(html_to_text($summary, 0, false), 140);

        $course->viewurl = (new moodle_url('/course/view.php', ['id' => $record->id]))->out(false);
        $course->imageurl = theme_tresa_get_course_image_url($record->id);

        $courses[] = $course;
    }

    return $courses;
}

/**
 * Builds the front page "stats bar" context (theme_tresa/frontpage-stats):
 * a row of site-wide numbers shown between the hero banner and the course
 * grid, each animated as a count-up when scrolled into view (see
 * scripts.mustache).
 *
 * Unlike the Dashboard's decorative widgets (see
 * theme_tresa_get_dashboard_widgets_context()), these are real counts from
 * the database, not placeholder content - this is public-facing marketing
 * copy, where a made-up number would be actively misleading rather than
 * just decorative.
 *
 * @return array
 */
function theme_tresa_get_frontpage_stats_context(): array {
    global $DB;

    $totalcourses = $DB->count_records_select('course', 'id <> :siteid AND visible = 1', ['siteid' => SITEID]);
    // id > 1 excludes the guest account; deleted/suspended users shouldn't
    // count as part of an active, current community.
    $totalusers = $DB->count_records_select('user', 'id > 1 AND deleted = 0 AND suspended = 0');
    $totalcategories = $DB->count_records('course_categories', ['visible' => 1]);
    $totalenrolments = $DB->count_records('user_enrolments');

    $stats = [
        ['value' => $totalcourses, 'label' => get_string('statscourses', 'theme_tresa'), 'icon' => 'fa-graduation-cap'],
        ['value' => $totalusers, 'label' => get_string('statsusers', 'theme_tresa'), 'icon' => 'fa-users'],
        ['value' => $totalcategories, 'label' => get_string('statscategories', 'theme_tresa'), 'icon' => 'fa-th-large'],
        ['value' => $totalenrolments, 'label' => get_string('statsenrolments', 'theme_tresa'), 'icon' => 'fa-check-circle'],
    ];

    return [
        'stats' => $stats,
        // Skip the whole section on a fresh/empty install rather than show
        // a row of unconvincing zeroes.
        'hasstats' => ($totalcourses + $totalusers) > 0,
    ];
}

/**
 * Builds the front page "How it works" section context
 * (theme_tresa/frontpage-steps): a static 3-step process explainer, each
 * step revealed in sequence (staggered) as it scrolls into view - unlike
 * the stats bar, this is generic marketing copy, not a claim about the
 * site's data, so there's nothing here that needs to come from the
 * database.
 *
 * @return array
 */
function theme_tresa_get_frontpage_steps_context(): array {
    return [
        'title' => get_string('howitworkstitle', 'theme_tresa'),
        'steps' => [
            ['number' => 1, 'icon' => 'fa-search', 'title' => get_string('step1title', 'theme_tresa'),
                'text' => get_string('step1text', 'theme_tresa'), 'delay' => 0],
            ['number' => 2, 'icon' => 'fa-user-plus', 'title' => get_string('step2title', 'theme_tresa'),
                'text' => get_string('step2text', 'theme_tresa'), 'delay' => 150],
            ['number' => 3, 'icon' => 'fa-rocket', 'title' => get_string('step3title', 'theme_tresa'),
                'text' => get_string('step3text', 'theme_tresa'), 'delay' => 300],
        ],
    ];
}

/**
 * Builds the front page "Why learn with us" section context
 * (theme_tresa/frontpage-features): 4 static feature highlight cards.
 * Same caveat as theme_tresa_get_frontpage_steps_context() - qualitative
 * marketing copy, not a data claim.
 *
 * @return array
 */
function theme_tresa_get_frontpage_features_context(): array {
    return [
        'title' => get_string('featurestitle', 'theme_tresa'),
        'features' => [
            ['icon' => 'fa-chalkboard-teacher', 'title' => get_string('feature1title', 'theme_tresa'),
                'text' => get_string('feature1text', 'theme_tresa'), 'delay' => 0],
            ['icon' => 'fa-clock', 'title' => get_string('feature2title', 'theme_tresa'),
                'text' => get_string('feature2text', 'theme_tresa'), 'delay' => 100],
            ['icon' => 'fa-certificate', 'title' => get_string('feature3title', 'theme_tresa'),
                'text' => get_string('feature3text', 'theme_tresa'), 'delay' => 200],
            ['icon' => 'fa-comments', 'title' => get_string('feature4title', 'theme_tresa'),
                'text' => get_string('feature4text', 'theme_tresa'), 'delay' => 300],
        ],
    ];
}

/**
 * Builds the front page rotating highlight banner context
 * (theme_tresa/frontpage-ticker): a thin strip crossfading between a few
 * short taglines - the same crossfade technique already used by the hero
 * banner's multi-image autoscroll (see scripts.mustache), just for text
 * instead of background images.
 *
 * @return array
 */
function theme_tresa_get_frontpage_ticker_context(): array {
    return [
        'slides' => [
            ['text' => get_string('ticker1', 'theme_tresa'), 'first' => true],
            ['text' => get_string('ticker2', 'theme_tresa'), 'first' => false],
            ['text' => get_string('ticker3', 'theme_tresa'), 'first' => false],
        ],
    ];
}


/**
 * Quick-links bar above the landing page navigation: where to sign in or continue, and a contact line.
 *
 * @return array
 */
function theme_tresa_get_landing_topbar_context(): array {
    global $CFG, $PAGE;

    $theme = $PAGE->theme;
    $links = [];
    $links[] = isloggedin() && !isguestuser()
        ? ['text' => get_string('landingmydashboard', 'theme_tresa'), 'url' => (new moodle_url('/my/'))->out(false)]
        : ['text' => get_string('landinglogin', 'theme_tresa'), 'url' => (new moodle_url('/login/index.php'))->out(false)];
    if (class_exists('\\local_dbajourney\\journey')) {
        $links[] = ['text' => get_string('landingjourney', 'theme_tresa'), 'url' => (new moodle_url('/local/dbajourney/index.php'))->out(false)];
    }
    $links[] = ['text' => get_string('landingcourses', 'theme_tresa'), 'url' => (new moodle_url('/course/index.php'))->out(false)];
    $links[] = ['text' => get_string('landingsupport', 'theme_tresa'), 'url' => (new moodle_url('/user/contactsitesupport.php'))->out(false)];

    $contact = [];
    if (!empty($theme->settings->footerphone)) {
        $contact[] = ['icon' => 'fa-phone', 'text' => s($theme->settings->footerphone),
            'url' => 'tel:' . preg_replace('/[^0-9+]/', '', $theme->settings->footerphone)];
    } else if (!empty($theme->settings->footeremail)) {
        $contact[] = ['icon' => 'fa-envelope', 'text' => s($theme->settings->footeremail), 'url' => 'mailto:' . s($theme->settings->footeremail)];
    }
    return ['links' => $links, 'contact' => $contact];
}

/**
 * Welcome block, "about" block and news for the landing page. Wording is plain marketing copy about the programme
 * (editable in the language strings); news is the public announcements from the journey plugin.
 *
 * @param string[] $heroimageurls
 * @return array ['welcome' => ..., 'about' => ..., 'news' => ...]
 */
function theme_tresa_get_landing_sections_context(array $heroimageurls): array {
    $news = [];
    if (class_exists('\\local_dbajourney\\journey')) {
        foreach (\local_dbajourney\journey::get_login_announcements(3) as $a) {
            $news[] = ['date' => userdate($a->timecreated, get_string('strftimedatefullshort')), 'title' => format_string($a->title),
                'body' => format_text($a->body, FORMAT_HTML, ['context' => context_system::instance()])];
        }
    }
    return [
        'welcome' => [
            'title' => get_string('landingwelcometitle', 'theme_tresa'),
            'subtitle' => get_string('landingwelcomesub', 'theme_tresa'),
            'text' => get_string('landingwelcometext', 'theme_tresa'),
            'buttontext' => get_string('landingwelcomebutton', 'theme_tresa'),
            'buttonurl' => (new moodle_url(isloggedin() && !isguestuser() ? '/local/dbajourney/index.php' : '/login/index.php'))->out(false),
            'imageurl' => $heroimageurls[1] ?? ($heroimageurls[0] ?? null),
        ],
        'about' => [
            'title' => get_string('landingabouttitle', 'theme_tresa'),
            'p1' => get_string('landingaboutp1', 'theme_tresa'),
            'p2' => get_string('landingaboutp2', 'theme_tresa'),
        ],
        'news' => ['title' => get_string('landingnewstitle', 'theme_tresa'), 'items' => $news, 'hasitems' => !empty($news)],
    ];
}
