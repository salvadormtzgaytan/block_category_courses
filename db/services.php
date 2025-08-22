<?php
defined('MOODLE_INTERNAL') || die();

$functions = [
    'block_category_courses_save_image' => [
        'classname' => 'block_category_courses\external\save_image',
        'methodname' => 'execute',
        'description' => 'Save category image and color',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'block/category_courses:manage',
    ],
];