<?php

require_once'../models/config.php';
require_once'../models/Vendor.php';

$vendor = new Vendor($conn);

$vendors = $vendor->fetch_all();
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['pays'])) { // edit/update form
        $who = 3;
        $obj = $vendor->get(array('meds_vendors.id = ' => $_GET['id']));
        $allPayments = $vendor->getAllPayments($_GET['id']);
        $total = $vendor->getTotalPayments($_GET['id']);
        include_once '../views/paymentsdetails.php';
        return;
    } else if (isset($_GET['val'])) {
        if (empty($_GET['val'])) {
            echo json_encode($vendors);
        } else {
            echo json_encode($vendor->getOr(array('meds_vendors.name LIKE "%' => $_GET['val'].'%"', 'meds_vendors.phone LIKE "%' => $_GET['val'].'%"')));
        }
        exit;
    } elseif (isset($_GET['id'])) {
        $vendor_id = $_GET['id'];
        $form_type = 'update';
        $row = $vendor->get(array('meds_vendors.id = ' => $vendor_id));
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذا المعمل غير موجود';
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
    $vendor_array['created_by'] = 1;
    $row = $vendor_array;

    if (isset($_GET['id'])) { // update request
        $row['id'] = $vendor_array['id'] = $_GET['id'];
        $form_type = 'update';
        if ($vendor->get(array('meds_vendors.id <> ' => $vendor_array['id'], 'meds_vendors.phone = ' => $vendor_array['phone']))) {
            $error_msg = 'خطأ رقم التليفون موجود مسبقا';
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
        } else {
            if ($vendor->add($vendor_array)) {
                $success_msg = 'تم اضافة معمل جديد';
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