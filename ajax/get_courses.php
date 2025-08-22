<?php
define('AJAX_SCRIPT', true);
require_once('../../../config.php');
require_once($CFG->libdir.'/completionlib.php');
require_once($CFG->libdir.'/gradelib.php');

require_login();
require_sesskey();

$categoryid = required_param('categoryid', PARAM_INT);

// Set JSON header
header('Content-Type: application/json');

try {

// Get user's courses in this category
$usercourses = enrol_get_my_courses(['summary' => true]);
$categorycourses = [];

foreach ($usercourses as $course) {
    if ($course->category == $categoryid) {
        $categorycourses[] = $course;
    }
}

if (empty($categorycourses)) {
    echo json_encode(['html' => '<div class="alert alert-info">No tienes cursos asignados en esta categoría.</div>']);
    exit;
}

$html = '<div class="course-list-modal">';
foreach ($categorycourses as $course) {
    // Get course completion
    $completion = new completion_info($course);
    $percentage = 0;
    $grade = '-';

    if ($completion->is_enabled()) {
        $completions = $completion->get_completions($USER->id, COMPLETION_CRITERIA_TYPE_COURSE);
        if (!empty($completions)) {
            $coursecompletion = reset($completions);
            if ($coursecompletion->is_complete()) {
                $percentage = 100;
            } else {
                // Calculate percentage based on completed activities
                $activities = $completion->get_activities();
                $completed = 0;
                $total = count($activities);

                foreach ($activities as $activity) {
                    $activitycompletion = $completion->get_completion($USER->id, $activity);
                    if ($activitycompletion && $activitycompletion->is_complete()) {
                        $completed++;
                    }
                }

                $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
            }
        }
    }

    // Get final grade - simplified
    $grade = '-';
    try {
        $context = context_course::instance($course->id);
        if (has_capability('moodle/grade:view', $context)) {
            // Simple grade check without complex API
            $grade = 'N/A';
        }
    } catch (Exception $gradeex) {
        // Grade not available
        $grade = '-';
    }

    $courseurl = new moodle_url('/course/view.php', ['id' => $course->id]);

    $html .= '<div class="course-item border rounded p-3 mb-2">';
    $html .= '<div class="d-flex justify-content-between align-items-start">';
    $html .= '<div class="course-info flex-grow-1">';
    $html .= '<h5 class="mb-1"><a href="' . $courseurl . '" target="_self">' . format_string($course->fullname) . '</a></h5>';
    if (!empty($course->summary)) {
        $html .= '<p class="text-muted small mb-2">' . format_text($course->summary, FORMAT_PLAIN, ['para' => false]) . '</p>';
    }
    $html .= '</div>';
    $html .= '<div class="course-stats text-right ml-3">';
    $html .= '<div class="badge badge-primary mb-1">Progreso: ' . round($percentage) . '%</div><br>';
    $html .= '<div class="badge badge-secondary">Calificación: ' . $grade . '</div>';
    $html .= '</div>';
    $html .= '</div>';

    // Progress bar
    $html .= '<div class="progress mt-2" style="height: 6px;">';
    $html .= '<div class="progress-bar bg-success" style="width: ' . $percentage . '%"></div>';
    $html .= '</div>';

    $html .= '</div>';
}
$html .= '</div>';

echo json_encode(['html' => $html]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor']);
}
