<?php
defined('MOODLE_INTERNAL') || die();

class block_category_courses_observer {
    
    public static function load_colorpicker_js($event) {
        global $PAGE;
        
        // Only load on category management pages
        if (strpos($PAGE->url->get_path(), '/course/editcategory.php') !== false) {
            $PAGE->requires->js_call_amd('block_category_courses/colorpicker', 'init');
        }
    }
}