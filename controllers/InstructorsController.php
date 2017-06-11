<?php

require_once'../models/config.php';
require_once'../models/Instructor.php';
$instructor = new Instructor($conn);

$instructors = $instructor->fetch_all();
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['pays'])) {
        $who = 1;
        $obj = $instructor->get(array('id = '=> $_GET['id']));
        $allPayments = $instructor->getAllPayments($_GET['id']);
        $total = $instructor->getTotalPayments($_GET['id']);
        include_once '../views/paymentsdetails.php';
        return;
    } else if (isset($_GET['val'])) {
        if (empty($_GET['val'])) {
            echo json_encode($instructors);
        } else {
            echo json_encode($instructor->getOr(array('name LIKE "%' => $_GET['val'] . '%"', 'phone LIKE "%' => $_GET['val'] . '%"')));
        }
        exit;
    } elseif (isset($_GET['id'])) {
        $instructor_id = $_GET['id'];
        $form_type = 'update';
        $row = $instructor->get(array('meds_instructors.id = ' => $instructor_id));
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذا المحاضر غير موجود';
        }
    } else {
        $form_type = 'insert';
    }
    include_once '../views/instructors.php';
    $error_msg = '';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $instructor_array = array();
    $address_array = array();

    $instructor_array['name'] = $_POST['name'];
    $instructor_array['phone'] = $_POST['phone'];

    $row = $instructor_array;

    if (isset($_GET['id'])) { // update request
        $row['id'] = $instructor_array['id'] = $_GET['id'];
        $form_type = 'update';
        if ($instructor->get(array('meds_instructors.id <> ' => $instructor_array['id'], 'meds_instructors.phone = ' => $instructor_array['phone']))) {
            $error_msg = 'خطأ رقم التليفون موجود مسبقا';
        } else {
            if ($instructor->update($instructor_array)) {
                $success_msg = 'تم تعديل البيانات';
                $form_type = 'update';
                $_POST = NULL;
                $_GET = NULL;
            }
        }
        include_once '../views/instructors.php';
        $success_msg = '';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        if ($instructor->get(array('meds_instructors.phone = ' => $instructor_array['phone']))) {
            $error_msg = 'خطأ رقم التليفون موجود مسبقا';
        } else {
            if ($instructor->add($instructor_array)) {
                $success_msg = 'تم اضافة محاضر جديد';
                $_POST = NULL;
            }
        }
        include_once '../views/instructors.php';
        $success_msg = '';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $form_type = 'insert';
}
?>