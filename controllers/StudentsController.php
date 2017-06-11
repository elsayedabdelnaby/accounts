<?php

require_once'../models/config.php';
require_once'../models/Student.php';

$student = new Student($conn);

$students = $student->fetch_all();
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $student_id = $_GET['id'];
        $form_type = 'update';
        $row = $student->get(array('meds_students.id = ' => $student_id));
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذا الطالب غير موجود';
        }
    } else {
        $form_type = 'insert';
    }
    include_once '../views/students.php';
    $error_msg = '';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_array = array();
    $address_array = array();

    $student_array['name'] = $_POST['name'];
    $student_array['phone'] = $_POST['phone'];
    $row = $student_array;

    if (isset($_GET['id'])) { // update request
        $row['id'] = $student_array['id'] = $_GET['id'];
        $form_type = 'update';
        if ($student->get(array('meds_students.id <> ' => $student_array['id'], 'meds_students.phone = ' => $student_array['phone']))) {
            $error_msg = 'خطأ رقم التليفون موجود مسبقا';
        } else {
            if ($student->update($student_array)) {
                $success_msg = 'تم تعديل البيانات';
                $form_type = 'update';
                $_POST = NULL;
                $_GET = NULL;
            }
        }
        include_once '../views/students.php';
        $success_msg = '';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        if ($student->get(array('meds_students.phone = ' => $student_array['phone']))) {
            $error_msg = 'خطأ رقم التليفون موجود مسبقا';
        } else {
            if ($student->add($student_array)) {
                $success_msg = 'تم اضافة طالب جديد';
                $_POST = NULL;
            }
        }
        include_once '../views/students.php';
        $success_msg = '';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $form_type = 'insert';
}
?>