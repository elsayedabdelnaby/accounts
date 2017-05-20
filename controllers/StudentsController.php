<?php

require_once'../models/config.php';
require_once'../models/Student.php';
require_once'../models/Country.php';
require_once'../models/City.php';
require_once'../models/Branch.php';
require_once'../models/Address.php';

$database = new Database('localhost', 'root', '', 'accounts');
$conn = $database->get_connection();
$student = new Student($conn);
$country = new Country($conn);
$city = new City($conn);
$branch = new Branch($conn);
$address = new Address($conn);

$students = $student->fetch_all();
$countries = $country->fetch_all();
$cities = $city->fetch_all();
$branches = $branch->fetch_all();
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
    $student_array['mobile'] = $_POST['mobile'];
    $student_array['branch_id'] = $_POST['branch'];
    $student_array['created_at'] = date('Y-m-d h:i:s');
    $student_array['notes'] = $_POST['notes'];

    $row = $student_array;

    $row['country_id'] = $address_array['country'] = $_POST['country'];
    $row['city_id'] = $address_array['city'] = $_POST['city'];
    $row['street'] = $address_array['street'] = $_POST['street'];

    if (isset($_GET['id'])) { // update request
        $row['id'] = $student_array['id'] = $_GET['id'];
        $address_array['id'] = $student->get_address($student_array['id'])['id'];
        $form_type = 'update';
        if ($student->get(array('meds_students.id <> ' => $student_array['id'], 'meds_students.phone = ' => $student_array['phone']))) {
            $error_msg = 'خطأ رقم التليفون موجود مسبقا';
        } elseif ($student->get(array('meds_students.id <> ' => $student_array['id'], 'meds_students.mobile = ' => $student_array['mobile']))) {
            $error_msg = 'خطأ رقم الموبايل موجود مسبقا';
        } else {
            if ($address->update($address_array) || $student->update($student_array)) {
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
        } elseif ($student->get(array('meds_students.mobile = ' => $student_array['mobile']))) {
            $error_msg = 'خطأ رقم الموبايل موجود مسبقا';
        } else {
            $student_array['address_id'] = $address->add($address_array); // add address first, before add the student
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