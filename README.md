# Tresa - Moodle theme

A fully standalone Moodle theme (`$THEME->parents = []` - no dependency on
Boost or any other theme) with a custom landing page: hero banner, course
grid and footer. Styling is a hand-authored native SCSS design system that
compiles to plain CSS.

## Requirements

- Moodle 4.5+ (developed and verified against a live 5.2.1 core checkout).
  No other theme plugin is required.

## Install

1. Copy this `tresa` folder to `<moodleroot>/theme/tresa`.
2. Visit *Site administration > Notifications* to complete the install/upgrade.
3. Go to *Site administration > Appearance > Themes > Theme selector* and set
   Tresa as the theme.
4. Configure it under *Site administration > Appearance > Themes > Tresa*.
5. *Site administration > Development > Purge caches*.

## Why "standalone" is a real architectural change

Every other Moodle theme you'll find (Boost and its many child themes) is
built on top of Boost, because Boost is where the actual Bootstrap 5
framework source lives in Moodle core (`theme/boost/scss/bootstrap`) along
with ~40 SCSS partials that polish core Moodle's HTML on top of it, plus the
drawer-based navigation system and its renderer overrides. None of that is
reachable once a theme stops declaring Boost as a parent - Moodle's SCSS
compiler only looks in a theme's own `scss/` folder and its parents' (see
`theme_config::get_scss_property()`).

So "no Boost" means Tresa can't import the real Bootstrap. Instead:

- **The design system is hand-authored**, not vendored. `scss/tresa/_grid.scss`,
  `_buttons.scss`, `_forms.scss`, `_nav.scss` and `_components.scss` implement
  the Bootstrap 5 **class names** Moodle's core HTML already emits (`btn
  btn-primary`, `container`, `row`/`col-*`, `nav`/`nav-tabs`, `card`,
  `alert-*`, `table`, `dropdown-menu`, etc.) with our own CSS rules. It
  covers the classes used most heavily across core Moodle output, but it is
  not a byte-for-byte reimplementation of Bootstrap - some less common
  components/states (complex modal animations, some form validation states,
  tooltips/popovers) may look plainer than on a Boost-based theme.
- **Navigation is simplified.** Boost's course-index and block "drawers"
  (the slide-out panels) are Boost-specific machinery tied to its renderer
  overrides. Tresa doesn't replicate them: the block region (`side-pre`)
  renders instead as a plain sidebar column next to the main content on
  pages that have blocks (see `layout/general.php`).
- **No custom renderer overrides.** `classes/output/core_renderer.php` is an
  empty subclass of Moodle's base `\core\output\core_renderer` - Tresa only
  calls renderer methods that exist on that base class (`doctype()`,
  `standard_head_html()`, `blocks()`, `main_content()`, `user_menu` data via
  `\core\navigation\output\primary`, etc.), so it never depends on
  Boost-only methods.
- **Admin settings are a real category, not a tabbed page.** `settings.php`
  registers a dedicated "Theme-Tresa" admin_category (via `$ADMIN->add()`,
  same pattern theme_cruz uses) with each section as its own
  `admin_settingpage` - shows up as its own expandable tree under Site
  administration > Appearance, not buried inside Appearance > Themes > Tresa.

## What's included

- `version.php`, `config.php`, `lib.php`, `settings.php` - plugin scaffolding.
  `config.php` maps every Moodle layout key (`base`, `standard`, `course`,
  `coursecategory`, `incourse`, `admin`, `mycourses`, `mydashboard`,
  `mypublic`, `report`, `login`, `popup`, `frametop`, `embedded`, `print`,
  `redirect`, `secure`, `maintenance`, `frontpage`) to one of six layout
  files, so no page is left without a working layout.
- `layout/` - `base.php` (bare chrome), `general.php` (navbar + optional
  block sidebar + content - used for most of the site), `columns1.php`
  (no navbar, no blocks - popups/embedded/print/secure), `login.php`
  (centred card), `maintenance.php` (bare), `frontpage.php` (the landing
  page).
- `templates/` - `head.mustache`, `navbar.mustache`, `footer-scripts.mustache`
  (the chrome, shared by every layout), `base/general/columns1/login/
  maintenance/frontpage.mustache` (per-layout page shells), and
  `hero/course-grid/footer.mustache` (the landing page components).
  The navbar reuses Moodle's own **core** templates (`core/moremenu`,
  `core/user_menu`) fed by `\core\navigation\output\primary` - those are
  core component templates, not Boost's.
- `scss/preset/default.scss` + `scss/tresa/*.scss` - the SCSS source:
  `_variables.scss` (design tokens), `_reset.scss`, `_grid.scss`,
  `_buttons.scss`, `_forms.scss`, `_nav.scss`, `_components.scss` (the
  hand-authored design system), then `_hero.scss`, `_course-grid.scss`,
  `_footer.scss`, `_misc.scss` (the landing page + per-layout tweaks).
  `scss/preset/plain.scss` is a secondary preset (selectable in settings)
  with just the design system and Tresa's brand colours, no landing-page
  components.
- `style/tresa.css` - a native, hand-written plain-CSS mirror of the
  landing-page components only (hero/course-grid/footer/skip-link), using
  CSS custom properties. It's a standalone reference/preview copy - Moodle
  loads styles through the SCSS pipeline above, not this file.
- `lang/en/theme_tresa.php` - all UI strings.

## Customising the landing page

Everything is editable from *Appearance > Themes > Tresa*, no code required:

- **General**: preset, primary/secondary/dark colours.
- **Hero banner**: title, subtitle, button text/link, background (gradient
  or uploaded image), hero text colour.
- **Course grid**: heading, subheading, number of courses, columns, and
  whether to pull the most recently created courses or courses from one
  category (by category ID).
- **Footer**: about text and two configurable link columns (`Label|/url`
  per line), plus the copyright line.
- **Advanced**: a raw SCSS box for one-off tweaks, appended after everything
  else.

## Things worth knowing before going to production

- Course images use `get_area_files()` against the `course`/`overviewfiles`
  file area (the same source Moodle's own course cards use); courses
  without an image fall back to a gradient placeholder card.
- Block plugins that assume Boost's drawer JS/markup (rare, but some exist)
  may not render exactly as they would on Boost - most blocks only need the
  `side-pre` region to exist, which Tresa provides in `layout/general.php`.
- Add a `pix/screenshot.png` (~500x350px) if you want a thumbnail in the
  theme selector - optional, not required for the theme to work.
- If a Moodle version-specific page ever references a very Boost-specific
  method Tresa's renderer doesn't have, it'll be a clear "undefined method"
  error naming the missing method - that's the tradeoff of dropping the
  Boost dependency, and it's fixable by adding that one method to
  `classes/output/core_renderer.php`.
# tresa
