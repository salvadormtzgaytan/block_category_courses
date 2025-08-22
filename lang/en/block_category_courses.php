<?php
defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Category Cards';
$string['notauth'] = 'You must be logged in to see your course categories.';
$string['privacy:metadata'] = 'The Category Cards block does not store any personal data.';

// Settings
$string['cardstyle'] = 'Card style';
$string['cardstyle_desc'] = 'Choose the visual style for category cards';
$string['cardstyle_rounded'] = 'Rounded corners';
$string['cardstyle_flat'] = 'Flat design';

$string['showprogress'] = 'Show progress percentage';
$string['showprogress_desc'] = 'Display completion percentage for each category';
$string['showdescription'] = 'Show description';
$string['showdescription_desc'] = 'Display category description excerpt';
$string['showcoursecount'] = 'Show course count';
$string['showcoursecount_desc'] = 'Display number of enrolled courses';

$string['sortorder'] = 'Sort order';
$string['sortorder_desc'] = 'How to sort categories';
$string['sortorder_core'] = 'Moodle core order';
$string['sortorder_alphabetical'] = 'Alphabetical';
$string['sortorder_coursecount'] = 'Number of courses';
$string['sortorder_progress'] = 'Progress percentage';

$string['includesubcategories'] = 'Include subcategories';
$string['includesubcategories_desc'] = 'Count courses from subcategories';
$string['includehidden'] = 'Include hidden courses';
$string['includehidden_desc'] = 'Include hidden courses in counts';

$string['maxcategories'] = 'Maximum categories';
$string['maxcategories_desc'] = 'Maximum number of categories to display';
$string['descriptionlimit'] = 'Description limit';
$string['descriptionlimit_desc'] = 'Maximum characters for description excerpt';

$string['cachettl'] = 'Cache TTL (seconds)';
$string['cachettl_desc'] = 'Time to live for user/category cache';

$string['nocategories'] = 'No categories available';
$string['coursesenrolled'] = '{$a} courses enrolled';
$string['completed'] = 'Completed';
$string['viewcategory'] = 'View category';

// Block configuration
$string['customtitle'] = 'Custom title';

// Management page
$string['manageimages'] = 'Manage Category Images';
$string['editcategoryimage'] = 'Edit Category Image';
$string['categoryimage'] = 'Category Image';
$string['categoryimage_help'] = 'Upload an image for this category. Supported formats: JPG, PNG, GIF, WebP. Maximum size: 2MB.';
$string['categorycolor'] = 'Background Color';

// Status labels
$string['configured'] = 'Configured';
$string['defaultstatus'] = 'Default';
$string['edit'] = 'Edit';
$string['currentpreview'] = 'Current preview';
$string['categoryupdated'] = 'Category updated successfully';
$string['coursescompleted'] = '{$a->completed} of {$a->total} courses completed';

// Click behavior
$string['clickbehavior'] = 'Click behavior';
$string['clickbehavior_category'] = 'Open category page';
$string['clickbehavior_courses'] = 'Show course list modal';
