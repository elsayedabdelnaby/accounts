<?php

require_once'../models/config.php';
require_once'../models/Branch.php';
require_once'../models/Instructor.php';
require_once'../models/Vendor.php';
require_once'../models/Employe.php';
require_once'../models/PaymentMethods.php';

$branch = new Branch($conn);
$instructor = new Instructor($conn);
$vendor = new Vendor($conn);
$employe = new Employe($conn);
$paymentmethod = new PaymentMethod($conn);

$branches = $branch->fetch_all();
$instructors = $instructor->fetch_all();
$vendors = $vendor->fetch_all();
$employes = $employe->fetch_all();
$paymentmethods = $paymentmethod->fetch_all();

$success_msg = '';
$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = 'SELECT *, meds_instructors.name AS instructor, meds_employes.name AS employe, meds_vendors.name AS vendor, meds_branches.name AS branch, meds_payment_methods.name as paymentmethod, meds_users.name as creator FROM meds_payments'
            . ' LEFT JOIN meds_instructors ON meds_payments.instructor_id  = meds_instructors.id '
            . ' LEFT JOIN meds_vendors ON meds_payments.vendor_id  = meds_vendors.id'
            . ' LEFT JOIN meds_employes ON meds_payments.employe_id  = meds_employes.id '
            . ' INNER JOIN meds_branches ON meds_payments.branch_id = meds_branches.id'
            . ' INNER JOIN meds_payment_methods ON meds_payments.payment_method_id = meds_payment_methods.id'
            . ' INNER JOIN meds_users ON meds_payments.created_by  = meds_users.id';
    $stmt = $conn->prepare($query);
    if ($stmt->execute()) {
        $payments = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $payments[] = $row;
        }
    }
    $sum = 'SELECT sum(value) AS total FROM meds_payments';
    $stmt = $conn->prepare($sum);
    if ($stmt->execute()) {
        $sum = $stmt->fetch(PDO::FETCH_ASSOC);
        $sum = $sum['total'];
    }
    $form_type = 'insert';
//    if (isset($_GET['id'])) { // edit/update form
//        $branch_id = $_GET['id'];
//        $row = $branch->get('id', $branch_id);
//        $form_type = 'update';
//        if ($row == false) {
//            $form_type = 'insert';
//            $error_msg = 'هذا الفرع غير موجود';
//            include_once '../views/payments.php';
//            $error_msg = '';
//        }
//        include_once '../views/payments.php';
//        $error_msg = '';
//    } else {
    $form_type = 'insert';
    include_once '../views/payments.php';
//    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['id'])) { // update request
//        $branch_array['id'] = $_GET['id'];
//        $row = $branch_array;
//        if ($branch->update($branch_array)) {
//            $success_msg = 'تم تعديل البيانات';
//            $form_type = 'update';
//            $_POST = NULL;
//            $_GET = NULL;
//        } else {
//            $form_type = 'update';
//        }
    } else { //insert request
        $form_type = 'insert';
        $_POST['created_by'] = 1;
        $_POST['created_at'] = date('Y-m-d h:i:s');
        if ($_POST['who'] == '4') {
            $query = "INSERT INTO meds_payments(other, value, created_by, branch_id, payment_method_id, created_at)VALUES(:other, :value, :created_by, :branch_id, :payment_method_id, :created_at)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':other', $other);
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':created_by', $created_by);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':branch_id', $branch_id);
            $stmt->bindParam(':payment_method_id', $payment_method_id);

            $other = $_POST['typeahead_example_2'];
            $value = $_POST['value'];
            $created_by = $_POST['created_by'];
            $branch_id = $_POST['branches'];
            $payment_method_id = $_POST['paymentmethods'];
            $created_at = $_POST['created_at'];
            if ($stmt->execute()) {
                $success_msg = 'تم اضافة خرج جديد';
                $_POST = NULL;
            } else {
                $error_msg = 'يوجد خطا';
            }
        } else {
            if (getId($_POST['typeahead_example_2'], $_POST['who'], $_POST)) {
                $success_msg = 'تم اضافة خرج جديد';
                $_POST = NULL;
            } else {
                $error_msg = 'الاسم\رقم التليفون غير مسجل';
            }
        }
    }
    include_once '../views/payments.php';
    $success_msg = '';
    $error_msg = '';
}

function getId($value, $who, $data) {
    $searchValue = trim(explode('-', $value)[0]);
    global $instructor, $employe, $vendor;
    global $conn;
    switch ($who) {
        case 1:
            $who = $instructor->getOr(array('name = "' => $searchValue . '"'));
            if ($who == false) {
                return false;
            } else {
                $query = "INSERT INTO meds_payments(instructor_id, value, created_by, branch_id, payment_method_id, created_at)VALUES(:instructor_id, :value, :created_by, :branch_id, :payment_method_id, :created_at)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':instructor_id', $instructor_id);
                $stmt->bindParam(':value', $value);
                $stmt->bindParam(':created_by', $created_by);
                $stmt->bindParam(':created_at', $created_at);
                $stmt->bindParam(':branch_id', $branch_id);
                $stmt->bindParam(':payment_method_id', $payment_method_id);

                $instructor_id = $who[0]['id'];
                $value = $data['value'];
                $created_by = $data['created_by'];
                $branch_id = $data['branches'];
                $payment_method_id = $data['paymentmethods'];
                $created_at = $data['created_at'];
                if ($stmt->execute()) {
                    return $conn->lastInsertId();
                } else {
                    return false;
                }
            }
            break;
        case 2:
            $who = $employe->get(array('name = "' => $searchValue . '"'));
            if ($who == false) {
                return false;
            } else {
                $query = "INSERT INTO meds_payments(employe_id, value, created_by, branch_id, payment_method_id, created_at)VALUES(:employe_id, :value, :created_by, :branch_id, :payment_method_id, :created_at)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':employe_id', $employe_id);
                $stmt->bindParam(':value', $value);
                $stmt->bindParam(':created_by', $created_by);
                $stmt->bindParam(':created_at', $created_at);
                $stmt->bindParam(':branch_id', $branch_id);
                $stmt->bindParam(':payment_method_id', $payment_method_id);

                $employe_id = $who['id'];
                $value = $data['value'];
                $created_by = $data['created_by'];
                $branch_id = $data['branches'];
                $payment_method_id = $data['paymentmethods'];
                $created_at = $data['created_at'];
                if ($stmt->execute()) {
                    return $conn->lastInsertId();
                } else {
                    return false;
                }
            }
            break;
        case 3:
            $who = $vendor->getOr(array('meds_vendors.name = "' => $searchValue . '"', 'meds_vendors.phone = "' => $searchValue . '"'));
            if ($who == false) {
                return false;
            } else {
                $query = "INSERT INTO meds_payments(vendor_id, value, created_by, branch_id, payment_method_id, created_at)VALUES(:vendor_id, :value, :created_by, :branch_id, :payment_method_id, :created_at)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':vendor_id', $vendor_id);
                $stmt->bindParam(':value', $value);
                $stmt->bindParam(':created_by', $created_by);
                $stmt->bindParam(':created_at', $created_at);
                $stmt->bindParam(':branch_id', $branch_id);
                $stmt->bindParam(':payment_method_id', $payment_method_id);

                $vendor_id = $who['id'];
                $value = $data['value'];
                $created_by = $data['created_by'];
                $branch_id = $data['branches'];
                $payment_method_id = $data['paymentmethods'];
                $created_at = $data['created_at'];
                if ($stmt->execute()) {
                    return $conn->lastInsertId();
                } else {
                    return false;
                }
            }
            break;
    }
}

?>