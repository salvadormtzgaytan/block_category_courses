<?php
require_once('../../config.php');
require_login();

$categoryid = required_param('categoryid', PARAM_INT);

$category = core_course_category::get($categoryid, IGNORE_MISSING);
if (!$category) {
    throw new moodle_exception('invalidcategoryid');
}

$context = context_coursecat::instance($categoryid);
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/category_courses/view_courses.php', ['categoryid' => $categoryid]));
$PAGE->set_pagelayout('mydashboard');

$catname = format_string($category->get_formatted_name());
$PAGE->set_title($catname . ' - ' . get_string('mycourses', 'moodle'));
$PAGE->set_heading($catname);

echo $OUTPUT->header();

// 1) Trae TODOS los cursos en los que el usuario está inscrito
//    (solo activos) y luego filtra por categoría.
$fields = 'id, fullname, shortname, summary, category, startdate, enddate, visible';
$mycourses = enrol_get_my_courses($fields, 'sortorder ASC');

// 2) Filtra por categoría
$filtered = array_filter($mycourses, function($c) use ($categoryid) {
    return (int)$c->category === (int)$categoryid;
});

if (!empty($filtered)) {
    echo html_writer::start_div('category-courses row');
    foreach ($filtered as $course) {
        $courseurl = new moodle_url('/course/view.php', ['id' => $course->id]);

        // Tarjeta sencilla (Bootstrap-ish)
        echo html_writer::start_div('col-12 col-md-6 col-lg-4 mb-3');
        echo html_writer::start_div('card h-100');

        echo html_writer::div(
            html_writer::tag('h5', format_string($course->fullname), ['class' => 'card-title']) .
            html_writer::tag('p', shorten_text(format_text($course->summary, FORMAT_HTML), 180), ['class' => 'card-text']),
            'card-body'
        );

        echo html_writer::div(
            html_writer::link($courseurl, get_string('entercourse', 'core'), ['class' => 'btn btn-primary']),
            'card-footer bg-transparent border-0'
        );

        echo html_writer::end_div(); // .card
        echo html_writer::end_div(); // col
    }
    echo html_writer::end_div(); // row
} else {
    echo $OUTPUT->notification('No estás inscrito en cursos de esta categoría.', 'info');
}

echo $OUTPUT->footer();
