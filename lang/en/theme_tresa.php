<?php
/**
 * Theme Tresa - English language strings.
 *
 * @package   theme_tresa
 * @copyright 2026 Tresa Theme
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Tresa';
$string['choosereadme'] = 'Tresa is a clean, modern, fully standalone theme (no Boost dependency) with a custom landing page (hero banner, course grid and footer). It is built with native SCSS and compiles to plain CSS.';
$string['configtitle'] = 'Tresa';
$string['themecategoryname'] = 'Theme-Tresa';
$string['region-side-pre'] = 'Right';
$string['loginsiteinfo'] = 'Sign in to access your courses, track your progress and pick up where you left off.';

// General.
$string['generalsettings'] = 'General';
$string['preset'] = 'Theme preset';
$string['preset_desc'] = 'Choose a preset to broadly change the appearance of the theme.';
$string['preset_default'] = 'Default (Tresa)';
$string['preset_plain'] = 'Plain (base design system, no landing page components)';

// Colors.
$string['colorsettings'] = 'Colors';
$string['primarycolor'] = 'Primary colour';
$string['primarycolor_desc'] = 'Main brand colour, used for buttons, links and the hero banner.';
$string['secondarycolor'] = 'Secondary/accent colour';
$string['secondarycolor_desc'] = 'Accent colour used for highlights, hover states and marketing sections (course grid, badges). Everyday secondary buttons intentionally use a neutral grey instead of this colour, to keep admin/utility screens calm.';
$string['darkcolor'] = 'Dark colour';
$string['darkcolor_desc'] = 'Used for the footer background and dark text.';
$string['bodybgcolor'] = 'Page background colour';
$string['bodybgcolor_desc'] = 'Base background colour behind every page.';
$string['linkcolor'] = 'Link colour';
$string['linkcolor_desc'] = 'Colour of ordinary text links. Defaults to the primary colour if left blank.';

// Background images.
$string['backgroundsettings'] = 'Background images';
$string['pagebackgroundenabled'] = 'Enable page background image';
$string['pagebackgroundenabled_desc'] = 'Show an image behind the page content on every page (not just the front page hero).';
$string['pagebackgroundimage'] = 'Page background image';
$string['pagebackgroundimage_desc'] = 'Tiled or covers the full viewport behind the page, underneath a colour overlay for text contrast.';
$string['pagebackgroundstyle'] = 'Display style';
$string['pagebackgroundstyle_desc'] = 'How the background image is sized and positioned.';
$string['pagebackgroundstyle_cover'] = 'Cover (fill screen, cropped)';
$string['pagebackgroundstyle_tile'] = 'Tile (repeat)';
$string['pagebackgroundoverlay'] = 'Overlay colour';
$string['pagebackgroundoverlay_desc'] = 'Solid colour laid over the background image so page content stays readable. Set its transparency with the opacity setting below.';
$string['pagebackgroundopacity'] = 'Overlay opacity';
$string['pagebackgroundopacity_desc'] = 'How strong the overlay colour is, from 0 (fully see-through, image shows through clearly) to 100 (overlay colour only, image hidden).';
$string['loginbackgroundimage'] = 'Login page background image';
$string['loginbackgroundimage_desc'] = 'Replaces the plain gradient panel on the login page. Recommended size: 1200x900px or larger.';

// Social media.
$string['socialsettings'] = 'Social media';
$string['socialenabled'] = 'Show social icons';
$string['socialenabled_desc'] = 'Show the icons below in the site footer. Icons are only shown for the networks you fill in a URL for.';
$string['socialfacebook'] = 'Facebook URL';
$string['socialx'] = 'X (Twitter) URL';
$string['socialinstagram'] = 'Instagram URL';
$string['sociallinkedin'] = 'LinkedIn URL';
$string['socialyoutube'] = 'YouTube URL';

// Fonts.
$string['fontsettings'] = 'Fonts';
$string['basefontsize'] = 'Base text size';
$string['basefontsize_desc'] = 'Overall text size used across the whole site. "Compact" suits dense admin/reporting screens; "Comfortable" is the original Tresa default.';
$string['basefontsize_compact'] = 'Compact (12px, default)';
$string['basefontsize_standard'] = 'Standard (14px)';
$string['basefontsize_comfortable'] = 'Comfortable (16px)';
$string['headingfont'] = 'Heading font';
$string['headingfont_desc'] = 'Typeface used for headings and titles. Self-hosted, no external font requests.';
$string['bodyfont'] = 'Body font';
$string['bodyfont_desc'] = 'Typeface used for ordinary text. Self-hosted, no external font requests.';
$string['font_inter'] = 'Inter';
$string['font_montserrat'] = 'Montserrat';
$string['font_system'] = 'System default (fastest, no font download)';

// Login and navigation.
$string['loginnavsettings'] = 'Login and Navigation';
$string['showloginnavbar'] = 'Show "Log in" link in the navbar';
$string['showloginnavbar_desc'] = 'When off, logged-out visitors don\'t see a "Log in" link in the top navigation (the login form on the front page, if enabled, still works).';
$string['customloginlinktext'] = 'Extra login-page link text';
$string['customloginlinktext_desc'] = 'Optional extra link shown under the login form, e.g. a link to a signup page or help article. Leave blank to show nothing.';
$string['customloginlinkurl'] = 'Extra login-page link URL';
$string['customloginlinkurl_desc'] = 'Where the extra login-page link above should point to.';

// Hero.
$string['herosettings'] = 'Hero banner';
$string['herotitle'] = 'Hero title';
$string['herotitle_desc'] = 'Main heading shown in the landing page hero banner.';
$string['herotitle_default'] = 'Welcome to {$a}';
$string['herosubtitle'] = 'Hero subtitle';
$string['herosubtitle_desc'] = 'Supporting text shown under the hero title.';
$string['herosubtitle_default'] = 'Learn something new today. Explore our courses and start your journey.';
$string['herobuttontext'] = 'Hero button text';
$string['herobuttontext_desc'] = 'Label for the call-to-action button in the hero banner.';
$string['herobuttontext_default'] = 'Browse courses';
$string['herobuttonurl'] = 'Hero button link';
$string['herobuttonurl_desc'] = 'Where the hero call-to-action button should link to.';
$string['herobgtype'] = 'Hero background';
$string['herobgtype_desc'] = 'Choose whether the hero banner uses a colour gradient or an uploaded image.';
$string['herobgtype_gradient'] = 'Colour gradient';
$string['herobgtype_image'] = 'Image';
$string['heroimage'] = 'Hero background image(s)';
$string['heroimage_desc'] = 'Uploaded when "Hero background" above is set to Image. Recommended size: 1920x800px. Upload more than one image to enable an auto-scrolling banner.';
$string['herotextcolor'] = 'Hero text colour';
$string['herotextcolor_desc'] = 'Colour of the hero title/subtitle/button text.';
$string['herobgautoscroll'] = 'Auto-scroll banner';
$string['herobgautoscroll_desc'] = 'When multiple hero images are uploaded above, automatically crossfade between them. Has no effect with a single image, and is skipped automatically for visitors who have "reduce motion" enabled in their OS/browser.';
$string['herobgautoscrollinterval'] = 'Auto-scroll interval (seconds)';
$string['herobgautoscrollinterval_desc'] = 'How long each hero image is shown before crossfading to the next.';
$string['heroprevslide'] = 'Previous slide';
$string['heronextslide'] = 'Next slide';
$string['herogotoslide'] = 'Go to slide {$a}';

// Course grid.
$string['coursegridsettings'] = 'Course grid';
$string['coursegridtitle'] = 'Course grid title';
$string['coursegridtitle_desc'] = 'Heading shown above the course grid on the landing page.';
$string['coursegridtitle_default'] = 'Explore our courses';
$string['coursegridsubtitle'] = 'Course grid subtitle';
$string['coursegridsubtitle_desc'] = 'Optional supporting text shown under the course grid heading.';
$string['coursegridcount'] = 'Number of courses';
$string['coursegridcount_desc'] = 'How many courses to display in the grid.';
$string['coursegridcolumns'] = 'Grid columns';
$string['coursegridcolumns_desc'] = 'Number of columns in the course grid on large screens.';
$string['coursegridsource'] = 'Course source';
$string['coursegridsource_desc'] = 'Which courses to show in the grid.';
$string['coursegridsource_recent'] = 'Most recently created courses';
$string['coursegridsource_category'] = 'Courses from a specific category';
$string['coursegridcategory'] = 'Category ID';
$string['coursegridcategory_desc'] = 'Numeric ID of the course category to pull courses from (used when "Course source" is set to category).';

// Footer.
$string['footersettings'] = 'Footer';
$string['footerabout'] = 'About text';
$string['footerabout_desc'] = 'Short description shown in the first footer column.';
$string['footerlinks1title'] = 'Footer column 1 title';
$string['footerlinks1title_default'] = 'Support';
$string['footerlinks2title'] = 'Footer column 2 title';
$string['footerlinks2title_default'] = 'Explore';
$string['footerlinks'] = 'Footer links';
$string['footerlinks_desc'] = 'One link per line, formatted as: Link text|/relative/url or Link text|https://example.com';
$string['footercopyright'] = 'Copyright text';
$string['footercopyright_desc'] = 'Shown in the footer bottom bar. Use {$a} for the current year.';
$string['footercopyright_default'] = '© {$a} Tresa. All rights reserved.';
$string['footercontacttitle'] = 'Contact column title';
$string['footercontacttitle_default'] = 'Contact';
$string['footeraddress'] = 'Address';
$string['footeraddress_desc'] = 'Shown in the footer contact column. Leave blank to hide.';
$string['footerphone'] = 'Phone number';
$string['footerphone_desc'] = 'Shown in the footer contact column, as a tel: link. Leave blank to hide.';
$string['footeremail'] = 'Contact email';
$string['footeremail_desc'] = 'Shown in the footer contact column, as a mailto: link. Leave blank to hide.';

// Advanced.
$string['advancedsettings'] = 'Advanced';
$string['rawscss'] = 'Raw SCSS';
$string['rawscss_desc'] = 'Use this to add extra SCSS rules, appended after everything else in the stylesheet.';

// Left navigation drawer.
$string['sidebarhome'] = 'Home';
$string['sidebardashboard'] = 'Dashboard';
$string['sidebarmycourses'] = 'My Courses';
$string['sidebarsiteadmin'] = 'Site Administration';
$string['sidebarworkspace'] = 'User Workspace';
$string['sidebarcalendar'] = 'Site Calendar';
$string['sidebargradebook'] = 'Gradebook';
$string['sidebarmessages'] = 'Private Messages';
$string['sidebarprivatefiles'] = 'Private Files';
$string['sidebarpreferences'] = 'Preferences';
$string['sidebaradministrator'] = 'Moodle Admin';
$string['sidebarlearner'] = 'Learner';
$string['togglesidebar'] = 'Toggle navigation menu';
$string['toggledarklight'] = 'Toggle light/dark mode';

// Landing page strings.
$string['skiptocoursegrid'] = 'Skip to course list';
$string['viewcourse'] = 'View course';
$string['viewallcourses'] = 'View all courses';
$string['nocoursesyet'] = 'No courses are available yet. Check back soon.';
$string['backtotop'] = 'Back to top';
$string['statscourses'] = 'Courses';
$string['statsusers'] = 'Learners';
$string['statscategories'] = 'Categories';
$string['statsenrolments'] = 'Enrolments';

// "How it works" section.
$string['howitworkstitle'] = 'How your journey works';
$string['step1title'] = 'Sign in';
$string['step1text'] = 'Use your programme account to open your own dashboard.';
$string['step2title'] = 'Follow your stages';
$string['step2text'] = 'Each stage has clear instructions, templates and a deadline, so you always know the next step.';
$string['step3title'] = 'Submit and get feedback';
$string['step3text'] = 'Upload your work, meet your supervisor and receive structured feedback until each stage is approved.';

// "Why learn with us" section.
$string['featurestitle'] = 'Why researchers choose us';
$string['feature1title'] = 'Guided Stages';
$string['feature1text'] = 'Eight clear stages take you from onboarding to final clearance, with nothing left to guesswork.';
$string['feature2title'] = 'Expert Supervision';
$string['feature2text'] = 'An assigned supervisor, recorded meetings and timely feedback keep your research moving.';
$string['feature3title'] = 'Secure Submissions';
$string['feature3text'] = 'Every version of your work is stored safely, and only the people who need to see it can open it.';
$string['feature4title'] = 'Clear Progress';
$string['feature4text'] = 'Your dashboard shows what to do next, who is acting, and when each deadline falls.';

// Rotating highlight banner.
$string['ticker1'] = 'Stage-by-stage guidance from onboarding to final clearance.';
$string['ticker2'] = 'Submit, revise and track every version of your work in one place.';
$string['ticker3'] = 'Supervision meetings, feedback and deadlines, always in view.';

$string['font_outfit'] = 'Outfit';
$string['loginwelcome'] = 'Welcome Back!';
$string['loginlead'] = 'Please login to access your account';
$string['loginforgot'] = 'Forgot password?';
$string['logincopyright'] = '&copy; {$a->year} {$a->site}. All rights reserved.';
$string['loginremember'] = 'Remember username';

// Landing page (front page) text.
$string['landinglogin'] = 'Log in';
$string['landingmydashboard'] = 'My dashboard';
$string['landingjourney'] = 'Research journey';
$string['landingcourses'] = 'Courses';
$string['landingsupport'] = 'Support';
$string['landingwelcometitle'] = 'Begin Your Doctoral Journey';
$string['landingwelcomesub'] = 'Onboarding for the new intake is open';
$string['landingwelcometext'] = 'A doctorate is more than a thesis. We guide every researcher through clear stages, with supervisors and reviewers who help turn a promising idea into original, rigorous work you will be proud to defend.';
$string['landingwelcomebutton'] = 'Open your journey';
$string['landingabouttitle'] = 'About the programme';
$string['landingaboutp1'] = 'Our DBA and PhD programmes bring researchers, supervisors and academic reviewers together in one transparent workflow. Every stage has clear instructions, deadlines and feedback, so you always know what is expected and what happens next.';
$string['landingaboutp2'] = 'Submit your work, receive structured feedback, meet your supervisor and follow your progress from onboarding to final clearance, while the academic office keeps every decision recorded and every version safe.';
$string['landingnewstitle'] = 'News & Announcements';
