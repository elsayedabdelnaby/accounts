<?php

require_once '../models/config.php';
require_once '../models/User.php';
require_once '../models/Branch.php';

$user = new User($conn);
$branch = new Branch($conn);

$users = $user->fetch_all();
$branches = $branch->fetch_all();

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];
        $form_type = 'update';
        $row = $user->get(array('meds_users.id = ' => $user_id));
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذا المستخدم غير موجود';
        }
    } else {
        $form_type = 'insert';
    }
    include_once '../views/users.php';
    $error_msg = '';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_array = array();
    $user_array['name'] = $_POST['name'];
    $user_array['branch_id'] = $_POST['branches'];
    $user_array['password'] = $_POST['password'];
    $row = $user_array;

    if (isset($_GET['id'])) { // update request
        $row['id'] = $user_array['id'] = $_GET['id'];
        if ($user->update($user_array)) {
            $success_msg = 'تم تعديل البيانات';
            $form_type = 'update';
            $_POST = NULL;
            $_GET = NULL;
        }
        $form_type = 'update';
        include_once '../views/users.php';
        $success_msg = '';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        if ($user->add($user_array)) {
            $success_msg = 'تم اضافة مستخدم جديد';
            $_POST = NULL;
        }

        include_once '../views/users.php';
        $success_msg = '';
        $error_msg = '';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $form_type = 'insert';
}
?>