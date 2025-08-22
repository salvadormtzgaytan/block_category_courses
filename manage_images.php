<?php
require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/formslib.php');

admin_externalpage_setup('block_category_courses_images');

$categoryid = optional_param('categoryid', 0, PARAM_INT);

if ($categoryid) {
    // Show form for specific category
    require_once('category_image_form.php');
    $form = new category_image_form(null, ['categoryid' => $categoryid]);
    
    if ($form->is_cancelled()) {
        redirect(new moodle_url('/blocks/category_courses/manage_images.php'));
    } else if ($data = $form->get_data()) {
        // Handle form submission
        $record = $DB->get_record('block_catcourse_images', ['categoryid' => $categoryid]);
        
        if (!$record) {
            $record = new stdClass();
            $record->categoryid = $categoryid;
            $record->timecreated = time();
        }
        
        $record->bgcolor = $data->bgcolor;
        $record->timemodified = time();
        
        // Handle file upload
        if (!empty($data->categoryimage)) {
            $context = context_system::instance();
            
            // Save files from draft area
            file_save_draft_area_files($data->categoryimage, $context->id, 'block_category_courses', 'categoryimage', $categoryid, ['maxfiles' => 1]);
            
            // Just mark that image exists
            $record->imageurl = '1';
        }
        
        if (isset($record->id)) {
            $DB->update_record('block_catcourse_images', $record);
        } else {
            $DB->insert_record('block_catcourse_images', $record);
        }
        
        redirect(new moodle_url('/blocks/category_courses/manage_images.php'), get_string('categoryupdated', 'block_category_courses'));
    }
    
    $PAGE->set_title(get_string('editcategoryimage', 'block_category_courses'));
    echo $OUTPUT->header();
    
    // Add custom styles for the form
    echo '<style>
    .category-edit-container {
        max-width: 600px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 32px;
        margin-top: 24px;
    }
    </style>';
    
    echo '<div class="category-edit-container">';
    
    // Show category preview
    $category = core_course_category::get($categoryid);
    $customdata = $DB->get_record('block_catcourse_images', ['categoryid' => $categoryid]);
    
    echo '<div style="text-align: center; margin-bottom: 32px;">';
    echo '<h2 style="color: #1f2937; margin-bottom: 16px;">' . format_string($category->name) . '</h2>';
    
    // Current preview
    echo '<div style="width: 200px; height: 120px; margin: 0 auto; border-radius: 8px; overflow: hidden; border: 2px solid #e5e7eb;">';
    if ($customdata && !empty($customdata->imageurl)) {
        $context = context_system::instance();
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'block_category_courses', 'categoryimage', $categoryid, 'filename', false);
        if (!empty($files)) {
            $file = reset($files);
            $imageurl = moodle_url::make_pluginfile_url(
                $context->id,
                'block_category_courses',
                'categoryimage',
                $categoryid,
                '/',
                $file->get_filename()
            )->out();
            echo '<img src="' . $imageurl . '" style="width: 100%; height: 100%; object-fit: cover;" />';
        } else {
            echo '<div style="width: 100%; height: 100%; background: ' . ($customdata->bgcolor ?? '#667eea') . '; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px;">';
            $words = explode(' ', $category->name);
            foreach (array_slice($words, 0, 2) as $word) {
                echo strtoupper(substr($word, 0, 1));
            }
            echo '</div>';
        }
    } else {
        echo '<div style="width: 100%; height: 100%; background: ' . ($customdata->bgcolor ?? '#667eea') . '; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px;">';
        $words = explode(' ', $category->name);
        foreach (array_slice($words, 0, 2) as $word) {
            echo strtoupper(substr($word, 0, 1));
        }
        echo '</div>';
    }
    echo '</div>';
    echo '<p style="color: #6b7280; font-size: 14px;">' . get_string('currentpreview', 'block_category_courses') . '</p>';
    echo '</div>';
    
    $form->display();
    echo '</div>';
    echo $OUTPUT->footer();
    
} else {
    // Show list of categories
    $PAGE->set_title(get_string('manageimages', 'block_category_courses'));
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('manageimages', 'block_category_courses'));
    
    $categories = core_course_category::get_all();
    
    echo '<style>
    .category-management-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
        margin-top: 24px;
    }
    .category-management-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 20px;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    .category-management-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .category-preview {
        width: 100%;
        height: 120px;
        border-radius: 8px;
        margin-bottom: 16px;
        overflow: hidden;
        position: relative;
    }
    .category-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .category-preview-initials {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 24px;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }
    .category-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 12px 0;
        line-height: 1.4;
    }
    .category-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16px;
    }
    .category-status {
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 12px;
        font-weight: 500;
    }
    .status-configured {
        background: #dcfce7;
        color: #166534;
    }
    .status-default {
        background: #fef3c7;
        color: #92400e;
    }
    .btn-edit {
        background: #3b82f6;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.2s;
    }
    .btn-edit:hover {
        background: #2563eb;
        color: white;
        text-decoration: none;
    }
    </style>';
    
    echo '<div class="category-management-grid">';
    foreach ($categories as $category) {
        $customdata = $DB->get_record('block_catcourse_images', ['categoryid' => $category->id]);
        $editurl = new moodle_url('/blocks/category_courses/manage_images.php', ['categoryid' => $category->id]);
        $hasCustomization = $customdata && (!empty($customdata->imageurl) || ($customdata->bgcolor && $customdata->bgcolor != '#667eea'));
        
        echo '<div class="category-management-card">';
        
        // Preview
        echo '<div class="category-preview">';
        if ($customdata && !empty($customdata->imageurl)) {
            // Try to get the actual file
            $context = context_system::instance();
            $fs = get_file_storage();
            $files = $fs->get_area_files($context->id, 'block_category_courses', 'categoryimage', $category->id, 'filename', false);
            if (!empty($files)) {
                $file = reset($files);
                $imageurl = moodle_url::make_pluginfile_url(
                    $context->id,
                    'block_category_courses',
                    'categoryimage',
                    $category->id,
                    '/',
                    $file->get_filename()
                )->out();
                echo '<img src="' . $imageurl . '" alt="' . format_string($category->name) . '" />';
            } else {
                // Fallback to initials if file not found
                echo '<div class="category-preview-initials" style="background: ' . ($customdata->bgcolor ?? '#667eea') . ';">';
                $words = explode(' ', $category->name);
                foreach (array_slice($words, 0, 2) as $word) {
                    echo strtoupper(substr($word, 0, 1));
                }
                echo '</div>';
            }
        } else {
            echo '<div class="category-preview-initials" style="background: ' . ($customdata->bgcolor ?? '#667eea') . ';">';
            $words = explode(' ', $category->name);
            foreach (array_slice($words, 0, 2) as $word) {
                echo strtoupper(substr($word, 0, 1));
            }
            echo '</div>';
        }
        echo '</div>';
        
        // Title
        echo '<h3 class="category-title">' . format_string($category->name) . '</h3>';
        
        // Meta
        echo '<div class="category-meta">';
        if ($hasCustomization) {
            echo '<span class="category-status status-configured">' . get_string('configured', 'block_category_courses') . '</span>';
        } else {
            echo '<span class="category-status status-default">' . get_string('defaultstatus', 'block_category_courses') . '</span>';
        }
        echo '<a href="' . $editurl . '" class="btn-edit">' . get_string('edit', 'block_category_courses') . '</a>';
        echo '</div>';
        
        echo '</div>';
    }
    echo '</div>';
    
    echo $OUTPUT->footer();
}