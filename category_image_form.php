<?php
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class category_image_form extends moodleform {

    protected function definition() {
        global $DB;
        
        $mform = $this->_form;
        $categoryid = $this->_customdata['categoryid'];
        
        $category = core_course_category::get($categoryid);
        $customdata = $DB->get_record('block_catcourse_images', ['categoryid' => $categoryid]);
        
        $mform->addElement('header', 'categoryheader', format_string($category->name));
        
        // File upload
        $mform->addElement('filemanager', 'categoryimage', get_string('categoryimage', 'block_category_courses'), null, [
            'subdirs' => 0,
            'maxbytes' => 2097152, // 2MB
            'maxfiles' => 1,
            'accepted_types' => ['web_image']
        ]);
        $mform->addHelpButton('categoryimage', 'categoryimage', 'block_category_courses');
        
        // Color picker group
        $colorgroup = [];
        $colorgroup[] = $mform->createElement('text', 'bgcolor', '', ['size' => 10, 'placeholder' => '#667eea', 'id' => 'id_bgcolor']);
        $colorgroup[] = $mform->createElement('html', '<input type="color" id="color_picker" value="' . ($customdata->bgcolor ?? '#667eea') . '" style="width: 50px; height: 35px; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; margin-left: 10px;">');
        $mform->addGroup($colorgroup, 'colorgroup', get_string('categorycolor', 'block_category_courses'), ' ', false);
        $mform->setType('bgcolor', PARAM_TEXT);
        $mform->setDefault('bgcolor', $customdata->bgcolor ?? '#667eea');
        
        // Hidden field
        $mform->addElement('hidden', 'categoryid', $categoryid);
        $mform->setType('categoryid', PARAM_INT);
        
        $this->add_action_buttons(true, get_string('savechanges'));
        
        // Add JavaScript for color picker
        $mform->addElement('html', '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var colorPicker = document.getElementById("color_picker");
            var textInput = document.getElementById("id_bgcolor");
            
            if (colorPicker && textInput) {
                colorPicker.addEventListener("change", function() {
                    textInput.value = this.value;
                });
                
                textInput.addEventListener("change", function() {
                    if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                        colorPicker.value = this.value;
                    }
                });
            }
        });
        </script>');
        
        // Set existing file data
        if ($customdata && $customdata->imageurl) {
            $context = context_system::instance();
            $draftitemid = file_get_submitted_draft_itemid('categoryimage');
            file_prepare_draft_area($draftitemid, $context->id, 'block_category_courses', 'categoryimage', $categoryid, [
                'subdirs' => 0,
                'maxfiles' => 1
            ]);
            $mform->setDefault('categoryimage', $draftitemid);
        }
    }
}