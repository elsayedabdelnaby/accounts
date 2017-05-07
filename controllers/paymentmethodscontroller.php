<?php

require_once'../models/config.php';
require_once'../models/Branch.php';
require_once'../models/PaymentMethods.php';

$database = new Database('localhost', 'root', '', 'accounts');
$conn = $database->get_connection();
$paymentmethod = new PaymentMethod($conn);
$branch = new Branch($conn);
$paymentmethods = $paymentmethod->fetch_all();
$branches = $branch->fetch_all();
$success_msg = '';
$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $paymentmethod_id = $_GET['id'];
        $row = $paymentmethod->get('meds_payment_methods.id', $paymentmethod_id);
        $form_type = 'update';
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذه الطريقة غير موجوده';
            include_once '../views/payment_methods.php';
            $error_msg = '';
        }
        include_once '../views/payment_methods.php';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        include_once '../views/payment_methods.php';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $paymentmethod_array = array();
    $paymentmethod_array['name'] = $_POST['name'];
    $paymentmethod_array['branch_id'] = $_POST['branch'];
    if (isset($_GET['id'])) { // update request
        $paymentmethod_array['id'] = $_GET['id'];
        $row = $paymentmethod_array;
        if ($paymentmethod->update($paymentmethod_array)) {
            $success_msg = 'تم تعديل البيانات';
            $form_type = 'update';
            $_POST = NULL;
            $_GET = NULL;
        } else {
            $form_type = 'update';
        }
    } else { //insert request
        $form_type = 'insert';
        if ($paymentmethod->add($paymentmethod_array)) {
            $success_msg = 'تم اضافة طريقة سداد جديدة';
            $_POST = NULL;
        }
    }
    include_once '../views/payment_methods.php';
    $success_msg = '';
}
?>