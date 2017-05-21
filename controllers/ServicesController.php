<?php

require_once'../models/config.php';
require_once'../models/Vendor.php';
require_once'../models/Branch.php';
require_once '../models/Service.php';


$vendor = new Vendor($conn);
$branch = new Branch($conn);
$service = new Service($conn);

$vendors = $vendor->fetch_all();
$branches = $branch->fetch_all();
$services = $service->fetch_all();
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $service_id = $_GET['id'];
        $form_type = 'update';
        $row = $service->get(array('meds_vendors_services.id = ' => $service_id));
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذه الخدمة غير موجوده';
        }
    } else {
        $form_type = 'insert';
    }
    include_once '../views/services.php';
    $error_msg = '';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_array = array();

    $service_array['request_date'] = explode('-', $_POST['request_date']);
    $service_array['request_date'] = $service_array['request_date'][2] . '-' . $service_array['request_date'][1] . '-' . $service_array['request_date'][0] . ' ' . date('H:i:s');
    $service_array['service_name'] = $_POST['service_name'];
    $service_array['quantity'] = $_POST['quantity'];
    $service_array['unit_price'] = $_POST['unit_price'];
    $service_array['created_by'] = 1;
    $service_array['vendor_id'] = $_POST['vendors'];
    $service_array['branch_id'] = $_POST['branches'];
    $service_array['notes'] = $_POST['notes'];
    $service_array['total_price'] = $_POST['quantity'] * $_POST['unit_price'];

    $row = $service_array;

    if (isset($_GET['id'])) { // update request
        $row['id'] = $service_array['id'] = $_GET['id'];
        $form_type = 'update';
        if ($service->update($$service_array)) {
            $success_msg = 'تم تعديل البيانات';
            $form_type = 'update';
            $_POST = NULL;
            $_GET = NULL;
        }

        include_once '../views/services.php';
        $success_msg = '';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        if ($service->add($service_array)) {
            $success_msg = 'تم اضافة خدمه جديدة';
            $_POST = NULL;
        }

        include_once '../views/services.php';
        $success_msg = '';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $form_type = 'insert';
}
?>