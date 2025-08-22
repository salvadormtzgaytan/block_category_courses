<?php
defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname' => '\core\event\course_category_viewed',
        'callback' => 'block_category_courses_observer::load_colorpicker_js',
    ],
];