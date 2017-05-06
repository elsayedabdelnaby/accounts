<?php

require_once '../models/config.php';
require_once '../models/Course.php';
require_once '../models/Branch.php';
require_once '../models/Currency.php';

$database = new Database('localhost', 'root', '', 'accounts');
$conn = $database->get_connection();
$course = new Course($conn);
$branch = new Branch($conn);
$currency = new Currency($conn);

$courses = $course->fetch_all();
$branches = $branch->fetch_all();
$currencies = $currency->fetch_all();

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
    $course_array['start_date'] = explode('-', $_POST['start_date']);
    $course_array['start_date'] = $course_array['start_date'][2] . '-' . $course_array['start_date'][1] . '-' . $course_array['start_date'][0];
    $course_array['end_date'] = explode('-', $_POST['end_date']);
    $course_array['end_date'] = $course_array['end_date'][2] . '-' . $course_array['end_date'][1] . '-' . $course_array['end_date'][0];
    $course_array['total_hours'] = $_POST['total_hours'];
    $course_array['price'] = $_POST['price'];
    $course_array['created_at'] = date('Y-m-d h:i:s');
    $course_array['notes'] = $_POST['notes'];
    $course_array['branch_id'] = $_POST['branch'];
    $course_array['currency_id'] = $_POST['currency'];
    $row = $course_array;

    if (isset($_GET['id'])) { // update request
        $row['id'] = $course_array['id'] = $_GET['id'];
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
        if (strtotime($course_array['start_date']) >= strtotime($course_array['end_date'])) {
            $error_msg = 'تاريخ بداية الكورس يجب انو يكون اقل من تاريخ نهاية';
        } else if ($course->add($course_array)) {
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