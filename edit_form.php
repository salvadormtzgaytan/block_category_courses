<?php
defined('MOODLE_INTERNAL') || die();

class block_category_courses_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        // Section header
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Custom title
        $mform->addElement('text', 'config_title', get_string('customtitle', 'block_category_courses'));
        $mform->setType('config_title', PARAM_TEXT);

        // Display options
        $mform->addElement('advcheckbox', 'config_showprogress', get_string('showprogress', 'block_category_courses'));
        $mform->addElement('advcheckbox', 'config_showdescription', get_string('showdescription', 'block_category_courses'));
        $mform->addElement('advcheckbox', 'config_showcoursecount', get_string('showcoursecount', 'block_category_courses'));

        // Sort order override
        $mform->addElement('select', 'config_sortorder', get_string('sortorder', 'block_category_courses'), [
            '' => get_string('default'),
            'core' => get_string('sortorder_core', 'block_category_courses'),
            'alphabetical' => get_string('sortorder_alphabetical', 'block_category_courses'),
            'coursecount' => get_string('sortorder_coursecount', 'block_category_courses'),
            'progress' => get_string('sortorder_progress', 'block_category_courses')
        ]);

        // Maximum categories override
        $mform->addElement('text', 'config_maxcategories', get_string('maxcategories', 'block_category_courses'));
        $mform->setType('config_maxcategories', PARAM_INT);
        $mform->addRule('config_maxcategories', null, 'numeric', null, 'client');

        // Include subcategories
        $mform->addElement('advcheckbox', 'config_includesubcategories', get_string('includesubcategories', 'block_category_courses'));
        
        // Click behavior
        $clickoptions = [
            'category' => get_string('clickbehavior_category', 'block_category_courses'),
            'courses' => get_string('clickbehavior_courses', 'block_category_courses')
        ];
        $mform->addElement('select', 'config_clickbehavior', get_string('clickbehavior', 'block_category_courses'), $clickoptions);
        
        // Set defaults
        $mform->setDefault('config_showprogress', 1);
        $mform->setDefault('config_showdescription', 1);
        $mform->setDefault('config_showcoursecount', 1);
        $mform->setDefault('config_maxcategories', 12);
        $mform->setDefault('config_includesubcategories', 0);
        $mform->setDefault('config_clickbehavior', 'category');
    }
}