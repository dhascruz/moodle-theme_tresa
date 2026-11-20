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
 * Theme Tresa - admin settings.
 *
 * @package   theme_tresa
 * @copyright 2026 Tresa Theme
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// $settings stays null: rather than one page of in-page tabs (the old
// theme_tresa_admin_settingspage_tabs, now removed), each section below is
// its own admin_settingpage added straight to a dedicated "Theme-Tresa"
// category (mirroring how theme_cruz/settings.php does it) - that's what
// makes it show up as its own expandable tree under Site administration >
// Appearance, the same as every other custom theme, instead of being
// buried inside Appearance > Themes > Tresa.
$settings = null;

// Deliberately NOT gated behind "if ($ADMIN->fulltree)": the "Custom theme
// settings" overview list on Site administration > Appearance (and the
// left-hand admin nav tree) is built via settings_navigation::
// load_administration_settings(), which calls admin_get_root(false, false)
// - fulltree FALSE. A fulltree-gated category/page registration silently
// never runs for that lightweight build, so "Theme-Tresa" would never
// appear there (it'd only show up in the rare fulltree=true admin/
// search.php full-settings render) - exactly what core's own
// admin/settings/appearance.php sub-pages and theme_cruz/settings.php both
// already do (neither one gates on fulltree either).
$ADMIN->add('themes', new admin_category('theme_tresa', get_string('themecategoryname', 'theme_tresa')));

    // ---------------------------------------------------------------
    // General page.
    // ---------------------------------------------------------------
    $page = new admin_settingpage('theme_tresa_general', get_string('generalsettings', 'theme_tresa'));

    $name = 'theme_tresa/preset';
    $title = get_string('preset', 'theme_tresa');
    $description = get_string('preset_desc', 'theme_tresa');
    $default = 'default.scss';
    $choices = [
        'default.scss' => get_string('preset_default', 'theme_tresa'),
        'plain.scss'   => get_string('preset_plain', 'theme_tresa'),
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $ADMIN->add('theme_tresa', $page);

    // ---------------------------------------------------------------
    // Colors page.
    // ---------------------------------------------------------------
    $page = new admin_settingpage('theme_tresa_colors', get_string('colorsettings', 'theme_tresa'));

    $name = 'theme_tresa/primarycolor';
    $title = get_string('primarycolor', 'theme_tresa');
    $description = get_string('primarycolor_desc', 'theme_tresa');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#2C6E49');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/secondarycolor';
    $title = get_string('secondarycolor', 'theme_tresa');
    $description = get_string('secondarycolor_desc', 'theme_tresa');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#F4A259');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/darkcolor';
    $title = get_string('darkcolor', 'theme_tresa');
    $description = get_string('darkcolor_desc', 'theme_tresa');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#1B1B1F');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/bodybgcolor';
    $title = get_string('bodybgcolor', 'theme_tresa');
    $description = get_string('bodybgcolor_desc', 'theme_tresa');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#FFFFFF');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/linkcolor';
    $title = get_string('linkcolor', 'theme_tresa');
    $description = get_string('linkcolor_desc', 'theme_tresa');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '', null, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $ADMIN->add('theme_tresa', $page);

    // ---------------------------------------------------------------
    // Background images page.
    // ---------------------------------------------------------------
    $page = new admin_settingpage('theme_tresa_background', get_string('backgroundsettings', 'theme_tresa'));

    $name = 'theme_tresa/pagebackgroundenabled';
    $title = get_string('pagebackgroundenabled', 'theme_tresa');
    $description = get_string('pagebackgroundenabled_desc', 'theme_tresa');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/pagebackgroundimage';
    $title = get_string('pagebackgroundimage', 'theme_tresa');
    $description = get_string('pagebackgroundimage_desc', 'theme_tresa');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'pagebackgroundimage', 0, [
        'maxfiles' => 1,
        'accepted_types' => ['.jpg', '.jpeg', '.png', '.webp'],
    ]);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/pagebackgroundstyle';
    $title = get_string('pagebackgroundstyle', 'theme_tresa');
    $description = get_string('pagebackgroundstyle_desc', 'theme_tresa');
    $choices = [
        'cover' => get_string('pagebackgroundstyle_cover', 'theme_tresa'),
        'tile'  => get_string('pagebackgroundstyle_tile', 'theme_tresa'),
    ];
    $setting = new admin_setting_configselect($name, $title, $description, 'cover', $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/pagebackgroundoverlay';
    $title = get_string('pagebackgroundoverlay', 'theme_tresa');
    $description = get_string('pagebackgroundoverlay_desc', 'theme_tresa');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#FFFFFF');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/pagebackgroundopacity';
    $title = get_string('pagebackgroundopacity', 'theme_tresa');
    $description = get_string('pagebackgroundopacity_desc', 'theme_tresa');
    $setting = new admin_setting_configtext($name, $title, $description, 85, PARAM_INT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/loginbackgroundimage';
    $title = get_string('loginbackgroundimage', 'theme_tresa');
    $description = get_string('loginbackgroundimage_desc', 'theme_tresa');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackgroundimage', 0, [
        'maxfiles' => 1,
        'accepted_types' => ['.jpg', '.jpeg', '.png', '.webp'],
    ]);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $ADMIN->add('theme_tresa', $page);

    // ---------------------------------------------------------------
    // Social media page.
    // ---------------------------------------------------------------
    $page = new admin_settingpage('theme_tresa_social', get_string('socialsettings', 'theme_tresa'));

    $name = 'theme_tresa/socialenabled';
    $title = get_string('socialenabled', 'theme_tresa');
    $description = get_string('socialenabled_desc', 'theme_tresa');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    foreach (['facebook', 'x', 'instagram', 'linkedin', 'youtube'] as $network) {
        $name = 'theme_tresa/social' . $network;
        $title = get_string('social' . $network, 'theme_tresa');
        $setting = new admin_setting_configtext($name, $title, '', '', PARAM_URL);
        $page->add($setting);
    }

    $ADMIN->add('theme_tresa', $page);

    // ---------------------------------------------------------------
    // Fonts page.
    // ---------------------------------------------------------------
    $page = new admin_settingpage('theme_tresa_fonts', get_string('fontsettings', 'theme_tresa'));

    $name = 'theme_tresa/basefontsize';
    $title = get_string('basefontsize', 'theme_tresa');
    $description = get_string('basefontsize_desc', 'theme_tresa');
    $choices = [
        'compact'     => get_string('basefontsize_compact', 'theme_tresa'),
        'standard'    => get_string('basefontsize_standard', 'theme_tresa'),
        'comfortable' => get_string('basefontsize_comfortable', 'theme_tresa'),
    ];
    $setting = new admin_setting_configselect($name, $title, $description, 'compact', $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $fontchoices = [
        'Inter'      => get_string('font_inter', 'theme_tresa'),
        'Montserrat' => get_string('font_montserrat', 'theme_tresa'),
        'Outfit'     => get_string('font_outfit', 'theme_tresa'),
        'system'     => get_string('font_system', 'theme_tresa'),
    ];

    $name = 'theme_tresa/headingfont';
    $title = get_string('headingfont', 'theme_tresa');
    $description = get_string('headingfont_desc', 'theme_tresa');
    $setting = new admin_setting_configselect($name, $title, $description, 'Outfit', $fontchoices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/bodyfont';
    $title = get_string('bodyfont', 'theme_tresa');
    $description = get_string('bodyfont_desc', 'theme_tresa');
    $setting = new admin_setting_configselect($name, $title, $description, 'Outfit', $fontchoices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $ADMIN->add('theme_tresa', $page);

    // ---------------------------------------------------------------
    // Login and Navigation page.
    // ---------------------------------------------------------------
    $page = new admin_settingpage('theme_tresa_loginnav', get_string('loginnavsettings', 'theme_tresa'));

    $name = 'theme_tresa/showloginnavbar';
    $title = get_string('showloginnavbar', 'theme_tresa');
    $description = get_string('showloginnavbar_desc', 'theme_tresa');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/customloginlinktext';
    $title = get_string('customloginlinktext', 'theme_tresa');
    $description = get_string('customloginlinktext_desc', 'theme_tresa');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/customloginlinkurl';
    $title = get_string('customloginlinkurl', 'theme_tresa');
    $description = get_string('customloginlinkurl_desc', 'theme_tresa');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_LOCALURL);
    $page->add($setting);

    $ADMIN->add('theme_tresa', $page);

    // ---------------------------------------------------------------
    // Hero banner page.
    // ---------------------------------------------------------------
    $page = new admin_settingpage('theme_tresa_hero', get_string('herosettings', 'theme_tresa'));

    $name = 'theme_tresa/herotitle';
    $title = get_string('herotitle', 'theme_tresa');
    $description = get_string('herotitle_desc', 'theme_tresa');
    // Left blank by default: herotitle_default contains a {$a} site-name
    // placeholder that only get_string() can resolve (with the real site
    // name passed as $a, done at render time in layout/frontpage.php).
    // Using it here as a static default would bake the literal, unresolved
    // "{$a}" text into this setting the first time the theme is installed.
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/herosubtitle';
    $title = get_string('herosubtitle', 'theme_tresa');
    $description = get_string('herosubtitle_desc', 'theme_tresa');
    $default = get_string('herosubtitle_default', 'theme_tresa');
    $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/herobuttontext';
    $title = get_string('herobuttontext', 'theme_tresa');
    $description = get_string('herobuttontext_desc', 'theme_tresa');
    $default = get_string('herobuttontext_default', 'theme_tresa');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/herobuttonurl';
    $title = get_string('herobuttonurl', 'theme_tresa');
    $description = get_string('herobuttonurl_desc', 'theme_tresa');
    $setting = new admin_setting_configtext($name, $title, $description, '/course/index.php', PARAM_LOCALURL);
    $page->add($setting);

    $name = 'theme_tresa/herobgtype';
    $title = get_string('herobgtype', 'theme_tresa');
    $description = get_string('herobgtype_desc', 'theme_tresa');
    $choices = [
        'gradient' => get_string('herobgtype_gradient', 'theme_tresa'),
        'image'    => get_string('herobgtype_image', 'theme_tresa'),
    ];
    $setting = new admin_setting_configselect($name, $title, $description, 'gradient', $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/heroimage';
    $title = get_string('heroimage', 'theme_tresa');
    $description = get_string('heroimage_desc', 'theme_tresa');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'heroimage', 0, [
        'maxfiles' => 8,
        'accepted_types' => ['.jpg', '.jpeg', '.png', '.webp'],
    ]);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/herobgautoscroll';
    $title = get_string('herobgautoscroll', 'theme_tresa');
    $description = get_string('herobgautoscroll_desc', 'theme_tresa');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/herobgautoscrollinterval';
    $title = get_string('herobgautoscrollinterval', 'theme_tresa');
    $description = get_string('herobgautoscrollinterval_desc', 'theme_tresa');
    $setting = new admin_setting_configtext($name, $title, $description, 5, PARAM_INT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/herotextcolor';
    $title = get_string('herotextcolor', 'theme_tresa');
    $description = get_string('herotextcolor_desc', 'theme_tresa');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#FFFFFF');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $ADMIN->add('theme_tresa', $page);

    // ---------------------------------------------------------------
    // Course grid page.
    // ---------------------------------------------------------------
    $page = new admin_settingpage('theme_tresa_coursegrid', get_string('coursegridsettings', 'theme_tresa'));

    $name = 'theme_tresa/coursegridtitle';
    $title = get_string('coursegridtitle', 'theme_tresa');
    $description = get_string('coursegridtitle_desc', 'theme_tresa');
    $default = get_string('coursegridtitle_default', 'theme_tresa');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/coursegridsubtitle';
    $title = get_string('coursegridsubtitle', 'theme_tresa');
    $description = get_string('coursegridsubtitle_desc', 'theme_tresa');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/coursegridcount';
    $title = get_string('coursegridcount', 'theme_tresa');
    $description = get_string('coursegridcount_desc', 'theme_tresa');
    $setting = new admin_setting_configtext($name, $title, $description, 6, PARAM_INT);
    $page->add($setting);

    $name = 'theme_tresa/coursegridcolumns';
    $title = get_string('coursegridcolumns', 'theme_tresa');
    $description = get_string('coursegridcolumns_desc', 'theme_tresa');
    $choices = [2 => '2', 3 => '3', 4 => '4'];
    $setting = new admin_setting_configselect($name, $title, $description, 4, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tresa/coursegridsource';
    $title = get_string('coursegridsource', 'theme_tresa');
    $description = get_string('coursegridsource_desc', 'theme_tresa');
    $choices = [
        'recent'   => get_string('coursegridsource_recent', 'theme_tresa'),
        'category' => get_string('coursegridsource_category', 'theme_tresa'),
    ];
    $setting = new admin_setting_configselect($name, $title, $description, 'recent', $choices);
    $page->add($setting);

    if (class_exists('core_course_category')) {
        $name = 'theme_tresa/coursegridcategory';
        $title = get_string('coursegridcategory', 'theme_tresa');
        $description = get_string('coursegridcategory_desc', 'theme_tresa');
        $setting = new admin_setting_configtext($name, $title, $description, 0, PARAM_INT);
        $page->add($setting);
    }

    $ADMIN->add('theme_tresa', $page);

    // ---------------------------------------------------------------
    // Footer page.
    // ---------------------------------------------------------------
    $page = new admin_settingpage('theme_tresa_footer', get_string('footersettings', 'theme_tresa'));

    $name = 'theme_tresa/footerabout';
    $title = get_string('footerabout', 'theme_tresa');
    $description = get_string('footerabout_desc', 'theme_tresa');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $page->add($setting);

    $name = 'theme_tresa/footerlinks1title';
    $setting = new admin_setting_configtext($name, get_string('footerlinks1title', 'theme_tresa'), '', get_string('footerlinks1title_default', 'theme_tresa'), PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/footerlinks1';
    $setting = new admin_setting_configtextarea($name, get_string('footerlinks', 'theme_tresa'), get_string('footerlinks_desc', 'theme_tresa'), "Support|/help.php\nContact|/user/contactsitesupport.php");
    $page->add($setting);

    $name = 'theme_tresa/footerlinks2title';
    $setting = new admin_setting_configtext($name, get_string('footerlinks2title', 'theme_tresa'), '', get_string('footerlinks2title_default', 'theme_tresa'), PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/footerlinks2';
    $setting = new admin_setting_configtextarea($name, get_string('footerlinks', 'theme_tresa'), get_string('footerlinks_desc', 'theme_tresa'), "Courses|/course/index.php\nLogin|/login/index.php");
    $page->add($setting);

    $name = 'theme_tresa/footercopyright';
    $title = get_string('footercopyright', 'theme_tresa');
    $description = get_string('footercopyright_desc', 'theme_tresa');
    $default = get_string('footercopyright_default', 'theme_tresa');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/footercontacttitle';
    $default = get_string('footercontacttitle_default', 'theme_tresa');
    $setting = new admin_setting_configtext($name, get_string('footercontacttitle', 'theme_tresa'), '', $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/footeraddress';
    $setting = new admin_setting_configtextarea($name, get_string('footeraddress', 'theme_tresa'), get_string('footeraddress_desc', 'theme_tresa'), '', PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/footerphone';
    $setting = new admin_setting_configtext($name, get_string('footerphone', 'theme_tresa'), get_string('footerphone_desc', 'theme_tresa'), '', PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_tresa/footeremail';
    $setting = new admin_setting_configtext($name, get_string('footeremail', 'theme_tresa'), get_string('footeremail_desc', 'theme_tresa'), '', PARAM_EMAIL);
    $page->add($setting);

    $ADMIN->add('theme_tresa', $page);

    // ---------------------------------------------------------------
    // Advanced page.
    // ---------------------------------------------------------------
    $page = new admin_settingpage('theme_tresa_advanced', get_string('advancedsettings', 'theme_tresa'));

    $name = 'theme_tresa/rawscss';
    $title = get_string('rawscss', 'theme_tresa');
    $description = get_string('rawscss_desc', 'theme_tresa');
    $setting = new admin_setting_scsscode($name, $title, $description, '', PARAM_RAW);
    $page->add($setting);

    $ADMIN->add('theme_tresa', $page);
