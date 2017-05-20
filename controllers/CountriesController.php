<?php

require_once'../models/config.php';
require_once'../models/Country.php';

$database = new Database('localhost', 'root', '', 'accounts');
$conn = $database->get_connection();
$country = new Country($conn);
$countries = $country->fetch_all();
$success_msg = '';
$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $country_id = $_GET['id'];
        $row = $country->get('id', $country_id);
        $form_type = 'update';
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذه الدولة غير موجوده';
            include_once '../views/countries.php';
            $error_msg = '';
        }
        include_once '../views/countries.php';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        include_once '../views/countries.php';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $country_array = array();
    $country_array['name'] = $_POST['name'];
    if (isset($_GET['id'])) { // update request
        $country_array['id'] = $_GET['id'];
        $row = $country_array;
        if ($country->update($country_array)) {
            $success_msg = 'تم تعديل البيانات';
            $form_type = 'update';
            $_POST = NULL;
            $_GET = NULL;
        } else {
            $form_type = 'update';
        }
    } else { //insert request
        $form_type = 'insert';
        if ($country->add($country_array)) {
            $success_msg = 'تم اضافة دولة جديد';
            $_POST = NULL;
        }
    }
    include_once '../views/countries.php';
    $success_msg = '';
}
?>