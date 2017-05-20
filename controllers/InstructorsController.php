<?php

require_once'../models/config.php';
require_once'../models/Instructor.php';
require_once'../models/Country.php';
require_once'../models/City.php';
require_once'../models/Address.php';

$database = new Database('localhost', 'root', '', 'accounts');
$conn = $database->get_connection();
$instructor = new Instructor($conn);
$country = new Country($conn);
$city = new City($conn);
$address = new Address($conn);

$instructors = $instructor->fetch_all();
$countries = $country->fetch_all();
$cities = $city->fetch_all();

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
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
    $instructor_array['mobile'] = $_POST['mobile'];
    $instructor_array['email'] = $_POST['email'];
    $instructor_array['description'] = $_POST['description'];

    $row = $instructor_array;

    $row['country_id'] = $address_array['country'] = $_POST['country'];
    $row['city_id'] = $address_array['city'] = $_POST['city'];
    $row['street'] = $address_array['street'] = $_POST['street'];

    if (isset($_GET['id'])) { // update request
        $row['id'] = $instructor_array['id'] = $_GET['id'];
        $address_array['id'] = $instructor->get_address($instructor_array['id'])['id'];
        $form_type = 'update';
        if ($instructor->get(array('meds_instructors.id <> ' => $instructor_array['id'], 'meds_instructors.phone = ' => $instructor_array['phone']))) {
            $error_msg = 'خطأ رقم التليفون موجود مسبقا';
        } elseif ($instructor->get(array('meds_instructors.id <> ' => $instructor_array['id'], 'meds_instructors.mobile = ' => $instructor_array['mobile']))) {
            $error_msg = 'خطأ رقم الموبايل موجود مسبقا';
        } else {
            if ($address->update($address_array) || $instructor->update($instructor_array)) {
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
        } elseif ($instructor->get(array('meds_instructors.mobile = ' => $instructor_array['mobile']))) {
            $error_msg = 'خطأ رقم الموبايل موجود مسبقا';
        } else {
            $instructor_array['address_id'] = $address->add($address_array); // add address first, before add the instructor
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