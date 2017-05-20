<?php

require_once '../models/config.php';
require_once '../models/Course.php';
require_once '../models/Branch.php';
require_once '../models/CourseBranch.php';

$course = new Course($conn);
$branch = new Branch($conn);
$course_branch = new CourseBranch($conn);
$courses = $course->fetch_all();
$branches = $branch->fetch_all();
$courses_branches = $course_branch->fetch_all();

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $course_branch_id = $_GET['id'];
        $form_type = 'update';
        $row = $course_branch->get(array('meds_course_branch.id = ' => $course_branch_id));
        $row['start_date'] = explode('-', $row['start_date']);
        $row['start_date'] = $row['start_date'][2] . '-' . $row['start_date'][1] . '-' . $row['start_date'][0];
        $row['end_date'] = explode('-', $row['end_date']);
        $row['end_date'] = $row['end_date'][2] . '-' . $row['end_date'][1] . '-' . $row['end_date'][0];
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذا الكورس غير موجود';
        }
    } else {
        $form_type = 'insert';
    }
    include_once '../views/coursesbranches.php';
    $error_msg = '';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_branch_array = array();

    $course_branch_array['course_id'] = $_POST['courses'];
    $course_branch_array['branch_id'] = $_POST['branches'];
    $course_branch_array['start_date'] = explode('-', $_POST['start_date']);
    $course_branch_array['start_date'] = $course_branch_array['start_date'][2] . '-' . $course_branch_array['start_date'][1] . '-' . $course_branch_array['start_date'][0];
    $course_branch_array['end_date'] = explode('-', $_POST['end_date']);
    $course_branch_array['end_date'] = $course_branch_array['end_date'][2] . '-' . $course_branch_array['end_date'][1] . '-' . $course_branch_array['end_date'][0];
    $course_branch_array['lectures_number'] = $_POST['lectures_number'];
    $course_branch_array['price'] = $_POST['price'];
    $course_branch_array['currency_id'] = 1;

    $row = $course_branch_array;
    $row['start_date'] = $_POST['start_date'];
    $row['end_date'] = $_POST['end_date'];

    if (isset($_GET['id'])) { // update request
        $row['id'] = $course_branch_array['id'] = $_GET['id'];
        $row['updated_by'] = $course_branch_array['updated_by'] = 1;
        if (strtotime($course_branch_array['start_date']) >= strtotime($course_branch_array['end_date'])) {
            $error_msg = 'تاريخ بداية الكورس يجب انو يكون اقل من تاريخ نهاية';
        } else if ($course_branch->update($course_branch_array)) {
            $success_msg = 'تم تعديل البيانات';
            $form_type = 'update';
            $_POST = NULL;
            $_GET = NULL;
        }
        $form_type = 'update';
        include_once '../views/coursesbranches.php';
        $success_msg = '';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        $row['created_by'] = $course_branch_array['created_by'] = 1;
        if (strtotime($course_branch_array['start_date']) >= strtotime($course_branch_array['end_date'])) {
            $error_msg = 'تاريخ بداية الكورس يجب انو يكون اقل من تاريخ نهاية';
        } else if ($course_branch->add($course_branch_array)) {
            $success_msg = 'تم اضافة كورس على الفرع';
            $_POST = NULL;
        }

        include_once '../views/courses.php';
        $success_msg = '';
        $error_msg = '';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $form_type = 'insert';
}
?>