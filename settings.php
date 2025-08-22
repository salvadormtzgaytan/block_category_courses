<?php
defined('MOODLE_INTERNAL') || die();

// Add management page
$ADMIN->add('blocksettings', new admin_externalpage(
    'block_category_courses_images',
    get_string('manageimages', 'block_category_courses'),
    new moodle_url('/blocks/category_courses/manage_images.php')
));

if ($ADMIN->fulltree) {
    // Display options
    $settings->add(new admin_setting_configcheckbox(
        'block_category_courses/showprogress',
        get_string('showprogress', 'block_category_courses'),
        get_string('showprogress_desc', 'block_category_courses'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        'block_category_courses/showdescription',
        get_string('showdescription', 'block_category_courses'),
        get_string('showdescription_desc', 'block_category_courses'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        'block_category_courses/showcoursecount',
        get_string('showcoursecount', 'block_category_courses'),
        get_string('showcoursecount_desc', 'block_category_courses'),
        1
    ));

    // Sorting options
    $settings->add(new admin_setting_configselect(
        'block_category_courses/sortorder',
        get_string('sortorder', 'block_category_courses'),
        get_string('sortorder_desc', 'block_category_courses'),
        'core',
        [
            'core' => get_string('sortorder_core', 'block_category_courses'),
            'alphabetical' => get_string('sortorder_alphabetical', 'block_category_courses'),
            'coursecount' => get_string('sortorder_coursecount', 'block_category_courses'),
            'progress' => get_string('sortorder_progress', 'block_category_courses')
        ]
    ));

    // Include subcategories
    $settings->add(new admin_setting_configcheckbox(
        'block_category_courses/includesubcategories',
        get_string('includesubcategories', 'block_category_courses'),
        get_string('includesubcategories_desc', 'block_category_courses'),
        0
    ));

    // Include hidden courses
    $settings->add(new admin_setting_configcheckbox(
        'block_category_courses/includehidden',
        get_string('includehidden', 'block_category_courses'),
        get_string('includehidden_desc', 'block_category_courses'),
        0
    ));

    // Limits
    $settings->add(new admin_setting_configtext(
        'block_category_courses/maxcategories',
        get_string('maxcategories', 'block_category_courses'),
        get_string('maxcategories_desc', 'block_category_courses'),
        12,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configtext(
        'block_category_courses/descriptionlimit',
        get_string('descriptionlimit', 'block_category_courses'),
        get_string('descriptionlimit_desc', 'block_category_courses'),
        150,
        PARAM_INT
    ));

    // Cache TTL
    $settings->add(new admin_setting_configtext(
        'block_category_courses/cachettl',
        get_string('cachettl', 'block_category_courses'),
        get_string('cachettl_desc', 'block_category_courses'),
        300,
        PARAM_INT
    ));
}
