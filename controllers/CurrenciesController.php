<?php

require_once'../models/config.php';
require_once'../models/Currency.php';

$database = new Database('localhost', 'root', '', 'accounts');
$conn = $database->get_connection();
$currency = new Currency($conn);
$currencies = $currency->fetch_all();
$success_msg = '';
$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $currency_id = $_GET['id'];
        $row = $currency->get('id', $currency_id);
        $form_type = 'update';
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذه العملة غير موجوده';
            include_once '../views/currencies.php';
            $error_msg = '';
        }
        include_once '../views/currencies.php';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        include_once '../views/currencies.php';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currency_array = array();
    $currency_array['name'] = $_POST['name'];
    if (isset($_GET['id'])) { // update request
        $currency_array['id'] = $_GET['id'];
        $row = $currency_array;
        if ($currency->update($currency_array)) {
            $success_msg = 'تم تعديل البيانات';
            $form_type = 'update';
            $_POST = NULL;
            $_GET = NULL;
        } else {
            $form_type = 'update';
        }
    } else { //insert request
        $form_type = 'insert';
        if ($currency->add($currency_array)) {
            $success_msg = 'تم اضافة عملة جديدة';
            $_POST = NULL;
        }
    }
    include_once '../views/currencies.php';
    $success_msg = '';
}
?>