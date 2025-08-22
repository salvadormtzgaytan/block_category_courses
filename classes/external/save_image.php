<?php
namespace block_category_courses\external;

use external_api;
use external_function_parameters;
use external_value;
use external_single_structure;

defined('MOODLE_INTERNAL') || die();

class save_image extends external_api {

    public static function execute_parameters() {
        return new external_function_parameters([
            'categoryid' => new external_value(PARAM_INT, 'Category ID'),
            'imageurl' => new external_value(PARAM_URL, 'Image URL', VALUE_DEFAULT, ''),
            'bgcolor' => new external_value(PARAM_TEXT, 'Background color', VALUE_DEFAULT, '#667eea'),
        ]);
    }

    public static function execute($categoryid, $imageurl, $bgcolor) {
        global $DB;

        $params = self::validate_parameters(self::execute_parameters(), [
            'categoryid' => $categoryid,
            'imageurl' => $imageurl,
            'bgcolor' => $bgcolor,
        ]);

        $context = \context_system::instance();
        self::validate_context($context);
        require_capability('block/category_courses:manage', $context);

        $record = $DB->get_record('block_category_courses_images', ['categoryid' => $params['categoryid']]);
        
        if ($record) {
            $record->imageurl = $params['imageurl'];
            $record->bgcolor = $params['bgcolor'];
            $record->timemodified = time();
            $DB->update_record('block_category_courses_images', $record);
        } else {
            $record = new \stdClass();
            $record->categoryid = $params['categoryid'];
            $record->imageurl = $params['imageurl'];
            $record->bgcolor = $params['bgcolor'];
            $record->timecreated = time();
            $record->timemodified = time();
            $DB->insert_record('block_category_courses_images', $record);
        }

        return ['success' => true];
    }

    public static function execute_returns() {
        return new external_single_structure([
            'success' => new external_value(PARAM_BOOL, 'Success status'),
        ]);
    }
}