<?php

require_once'../models/config.php';
require_once'../models/Branch.php';

$database = new Database('localhost', 'root', '', 'accounts');
$conn = $database->get_connection();
$branch = new Branch($conn);
$branches = $branch->fetch_all();
$success_msg = '';
$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $branch_id = $_GET['id'];
        $row = $branch->get('id', $branch_id);
        $form_type = 'update';
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذا الفرع غير موجود';
            include_once '../views/branches.php';
            $error_msg = '';
        }
        include_once '../views/branches.php';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        include_once '../views/branches.php';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $branch_array = array();
    $branch_array['name'] = $_POST['name'];
    if (isset($_GET['id'])) { // update request
        $branch_array['id'] = $_GET['id'];
        $row = $branch_array;
        if ($branch->update($branch_array)) {
            $success_msg = 'تم تعديل البيانات';
            $form_type = 'update';
            $_POST = NULL;
            $_GET = NULL;
        } else {
            $form_type = 'update';
        }
    } else { //insert request
        $form_type = 'insert';
        if ($branch->add($branch_array)) {
            $success_msg = 'تم اضافة فرع جديد';
            $_POST = NULL;
        }
    }
    include_once '../views/branches.php';
    $success_msg = '';
}
?>