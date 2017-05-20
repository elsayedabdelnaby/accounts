<?php

require_once'../models/config.php';
require_once'../models/Vendor.php';
require_once'../models/Country.php';
require_once'../models/City.php';
require_once'../models/Branch.php';
require_once'../models/Address.php';

$vendor = new Vendor($conn);
$country = new Country($conn);
$city = new City($conn);
$address = new Address($conn);

$vendors = $vendor->fetch_all();
$countries = $country->fetch_all();
$cities = $city->fetch_all();
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $vendor_id = $_GET['id'];
        $form_type = 'update';
        $row = $vendor->get(array('meds_vendors.id = ' => $vendor_id));
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذا المورد غير موجود';
        }
    } else {
        $form_type = 'insert';
    }
    include_once '../views/vendors.php';
    $error_msg = '';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vendor_array = array();
    $address_array = array();

    $vendor_array['name'] = $_POST['name'];
    $vendor_array['phone'] = $_POST['phone'];
    $vendor_array['mobile'] = $_POST['mobile'];
    $vendor_array['type'] = $_POST['type'];
    $vendor_array['created_by'] = 1;
    $vendor_array['notes'] = $_POST['notes'];

    $row = $vendor_array;

    $row['country_id'] = $address_array['country'] = $_POST['country'];
    $row['city_id'] = $address_array['city'] = $_POST['city'];
    $row['street'] = $address_array['street'] = $_POST['street'];

    if (isset($_GET['id'])) { // update request
        $row['id'] = $vendor_array['id'] = $_GET['id'];
        $address_array['id'] = $vendor->get_address($vendor_array['id'])['id'];
        $form_type = 'update';
        if ($vendor->get(array('meds_vendors.id <> ' => $vendor_array['id'], 'meds_vendors.phone = ' => $vendor_array['phone']))) {
            $error_msg = 'خطأ رقم التليفون موجود مسبقا';
        } elseif ($vendor->get(array('meds_vendors.id <> ' => $vendor_array['id'], 'meds_vendors.mobile = ' => $vendor_array['mobile']))) {
            $error_msg = 'خطأ رقم الموبايل موجود مسبقا';
        } else {
            if ($address->update($address_array) || $vendor->update($vendor_array)) {
                $success_msg = 'تم تعديل البيانات';
                $form_type = 'update';
                $_POST = NULL;
                $_GET = NULL;
            }
        }
        include_once '../views/vendors.php';
        $success_msg = '';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        if ($vendor->get(array('meds_vendors.phone = ' => $vendor_array['phone']))) {
            $error_msg = 'خطأ رقم التليفون موجود مسبقا';
        } elseif ($vendor->get(array('meds_vendors.mobile = ' => $vendor_array['mobile']))) {
            $error_msg = 'خطأ رقم الموبايل موجود مسبقا';
        } else {
            $vendor_array['address_id'] = $address->add($address_array); // add address first, before add the student
            if ($vendor->add($vendor_array)) {
                $success_msg = 'تم اضافة مورد جديد';
                $_POST = NULL;
            }
        }
        include_once '../views/vendors.php';
        $success_msg = '';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $form_type = 'insert';
}
?>