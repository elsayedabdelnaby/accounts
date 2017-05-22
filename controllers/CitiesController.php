<?php

require_once'../models/config.php';
require_once'../models/Country.php';
require_once'../models/City.php';

$country = new Country($conn);
$city = new City($conn);
$countries = $country->fetch_all();
$cities = $city->fetch_all();
$success_msg = '';
$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $city_id = $_GET['id'];
        $row = $city->get(array('meds_cities.id = '=> $city_id));
        $form_type = 'update';
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذه المدينة غير موجوده';
            include_once '../views/cities.php';
            $error_msg = '';
        }
        include_once '../views/cities.php';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        include_once '../views/cities.php';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $city_array = array();
    $city_array['name'] = $_POST['name'];
    $city_array['country_id'] = $_POST['countries'];
    if (isset($_GET['id'])) { // update request
        $city_array['id'] = $_GET['id'];
        $row = $city_array;
        if ($city->update($city_array)) {
            $success_msg = 'تم تعديل البيانات';
            $form_type = 'update';
            $_POST = NULL;
            $_GET = NULL;
        } else {
            $form_type = 'update';
        }
    } else { //insert request
        $form_type = 'insert';
        if ($city->add($city_array)) {
            $success_msg = 'تم اضافة دولة جديد';
            $_POST = NULL;
        }
    }
    include_once '../views/cities.php';
    $success_msg = '';
}
?>