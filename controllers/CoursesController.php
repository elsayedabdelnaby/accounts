<?php

require_once '../models/config.php';
require_once '../models/Course.php';

$course = new Course($conn);
$courses = $course->fetch_all();

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $course_id = $_GET['id'];
        $form_type = 'update';
        $row = $course->get(array('meds_courses.id = ' => $course_id));
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذا الكورس غير موجود';
        }
    } else {
        $form_type = 'insert';
    }
    include_once '../views/courses.php';
    $error_msg = '';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_array = array();

    $course_array['name'] = $_POST['name'];
    $course_array['hours_number'] = $_POST['hours_number'];
    $course_array['content'] = $_POST['content'];
    $course_array['learning_objectives'] = $_POST['learning_objectives'];
    $course_array['notes'] = $_POST['notes'];
    $row = $course_array;

    if (isset($_GET['id'])) { // update request
        $row['id'] = $course_array['id'] = $_GET['id'];
        $row['updated_by'] = $course_array['updated_by'] = 1;
        if ($course->update($course_array)) {
            $success_msg = 'تم تعديل البيانات';
            $form_type = 'update';
            $_POST = NULL;
            $_GET = NULL;
        }
        $form_type = 'update';
        include_once '../views/courses.php';
        $success_msg = '';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        $row['created_by'] = $course_array['created_by'] = 1;
        if ($course->add($course_array)) {
            $success_msg = 'تم اضافة كورس جديد';
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