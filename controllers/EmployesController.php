<?php

require_once '../models/config.php';
require_once '../models/Employe.php';

$employe = new Employe($conn);
$employes = $employe->fetch_all();

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['pays'])) { // edit/update form
        $who = 2;
        $obj = $employe->get(array('id = ' => $_GET['id']));
        $allPayments = $employe->getAllPayments($_GET['id']);
        $total = $employe->getTotalPayments($_GET['id']);
        include_once '../views/paymentsdetails.php';
        return;
    } elseif (isset($_GET['val'])) {
        if (empty($_GET['val'])) {
            echo json_encode($employes);
        } else {
            echo json_encode($employe->get(array('name LIKE "%' => $_GET['val'] . '%"')));
        }
        exit;
    } elseif (isset($_GET['id'])) {
        $employe_id = $_GET['id'];
        $form_type = 'update';
        $row = $employe->get(array('meds_employes.id = ' => $employe_id));
        if ($row == false) {
            $form_type = 'insert';
            $error_msg = 'هذا الموظف غير موجود';
        }
    } else {
        $form_type = 'insert';
    }
    include_once '../views/employes.php';
    $error_msg = '';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employe_array = array();
    $employe_array['name'] = $_POST['name'];
    $row = $employe_array;

    if (isset($_GET['id'])) { // update request
        $row['id'] = $employe_array['id'] = $_GET['id'];
        $row['updated_by'] = $employe_array['updated_by'] = 1;
        if ($employe->update($employe_array)) {
            $success_msg = 'تم تعديل البيانات';
            $form_type = 'update';
            $_POST = NULL;
            $_GET = NULL;
        }
        $form_type = 'update';
        include_once '../views/employes.php';
        $success_msg = '';
        $error_msg = '';
    } else {
        $form_type = 'insert';
        if ($employe->add($employe_array)) {
            $success_msg = 'تم اضافة موظف جديد';
            $_POST = NULL;
        }

        include_once '../views/employes.php';
        $success_msg = '';
        $error_msg = '';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $form_type = 'insert';
}
?>