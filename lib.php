<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Serves files from the block_category_courses file areas
 */
function block_category_courses_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    global $DB;

    // Check context level
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }

    // Check if user is logged in
    require_login();

    // Check filearea
    if ($filearea !== 'categoryimage') {
        return false;
    }

    // Get file details
    $itemid = (int)array_shift($args);
    $filename = array_pop($args);
    $filepath = $args ? '/'.implode('/', $args).'/' : '/';

    // Get file from storage
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'block_category_courses', $filearea, $itemid, $filepath, $filename);

    if (!$file || $file->is_directory()) {
        return false;
    }

    // Send the file
    send_stored_file($file, 86400, 0, $forcedownload, $options);
    return true;
}

/**
 * Load color picker JS on category edit pages
 */
function block_category_courses_before_footer() {
    global $PAGE;
    
    // Load color picker on category edit pages
    if (strpos($PAGE->url->get_path(), '/course/editcategory.php') !== false ||
        strpos($PAGE->url->get_path(), '/course/management.php') !== false) {
        $PAGE->requires->js_call_amd('block_category_courses/colorpicker', 'init');
    }
}