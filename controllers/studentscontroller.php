<?php

require_once'../models/config.php';
require_once'../models/Student.php';
require_once'../models/Country.php';
require_once'../models/City.php';
require_once'../models/Branch.php';
require_once'../models/Address.php';

$database = new Database('localhost', 'root', '', 'test');
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
        $row = $student->get('id', $student_id);
        if ($row != false) {
            print_r($row);
            print_r($student->get_branch($student_id));
        } else {
            echo 'not exist';
        }
    } else {
        $form_type = 'insert';
        include_once '../views/students.php';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_type = 'insert';
    $student_array = array();
    $address_array = array();

    $student_array['name'] = $_POST['name'];
    $student_array['phone'] = $_POST['phone'];
    $student_array['mobile'] = $_POST['mobile'];
    $student_array['country_id'] = $_POST['country'];
    $student_array['city_id'] = $_POST['city'];
    $student_array['branch_id'] = $_POST['branch'];
    $student_array['street'] = $_POST['street'];
    $student_array['created_at'] = date('Y-m-d h:i:s');
    $student_array['notes'] = $_POST['notes'];

    $address_array['country'] = $_POST['country'];
    $address_array['city'] = $_POST['city'];
    $address_array['street'] = $_POST['street'];

    if ($student->get('phone', $student_array['phone'])) {
        $error_msg = 'خطأ رقم التليفون موجود مسبقا';
    } elseif ($student->get('mobile', $student_array['mobile'])) {
        $error_msg = 'خطأ رقم الموبايل موجود مسبقا';
    } else {
        $student_array['address_id'] = $address->add($address_array); // add address first, before add the student
        if ($student->add($student_array)) {
            $success_msg = 'تم اضافة طالب جديد';
            $_POST = NULL;
        }
    }
    include_once '../views/students.php';
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $form_type = 'insert';
}
?>