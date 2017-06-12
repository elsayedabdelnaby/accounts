<?php

require_once'../models/config.php';
require_once'../models/Student.php';
require_once'../models/Course.php';
require_once'../models/Branch.php';
require_once'../models/PaymentMethods.php';

$student = new Student($conn);
$course = new Course($conn);
$branch = new Branch($conn);
$paymentmethod = new PaymentMethod($conn);

$students = $student->fetch_all();
$courses = $course->fetch_all();
$branches = $branch->fetch_all();
$paymentmethods = $paymentmethod->fetch_all();

$success_msg = '';
$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = 'SELECT *, meds_courses.name AS course, meds_students.name AS student, meds_payment_methods.name as paymentmethod, meds_users.name as creator, meds_branches.name AS branch FROM meds_entrances'
            . ' LEFT JOIN meds_courses ON meds_entrances.course_id  = meds_courses.id '
            . ' LEFT JOIN meds_students ON meds_entrances.student_id  = meds_students.id'
            . ' LEFT JOIN meds_payment_methods ON meds_entrances.payment_method_id = meds_payment_methods.id'
            . ' INNER JOIN meds_users ON meds_entrances.created_by  = meds_users.id'
            . ' INNER JOIN meds_branches ON meds_entrances.branch_id  = meds_branches.id';
    $stmt = $conn->prepare($query);
    if ($stmt->execute()) {
        $payments = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $payments[] = $row;
        }
    }
    $sum = 'SELECT sum(value) AS total FROM meds_entrances';
    $stmt = $conn->prepare($sum);
    if ($stmt->execute()) {
        $sum = $stmt->fetch(PDO::FETCH_ASSOC);
        $sum = $sum['total'];
    }
    $form_type = 'insert';
    include_once '../views/entrances.php';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['id'])) { // update request
    } else { //insert request
        $form_type = 'insert';
        $_POST['created_by'] = 1;
        $_POST['created_at'] = date('Y-m-d h:i:s');
        if ($_POST['who'] == '4') {
            $query = "INSERT INTO meds_entrances(other, value, created_by, branch_id, created_at)VALUES(:other, :value, :created_by, :branch_id, :created_at)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':other', $other);
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':created_by', $created_by);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':branch_id', $branch_id);

            $other = $_POST['typeahead_example_2'];
            $value = $_POST['value'];
            $created_by = $_POST['created_by'];
            $branch_id = $_POST['branches'];
            $created_at = $_POST['created_at'];
            if ($stmt->execute()) {
                $success_msg = 'تم اضافة دخل جديد';
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
    include_once '../views/entrances.php';
    $success_msg = '';
    $error_msg = '';
}

function getId($value, $who, $data) {
    $searchValue = trim(explode('-', $value)[0]);
    global $student, $course;
    global $conn;
    $who = $student->getOr(array('meds_students.name = "' => $searchValue . '"', 'meds_students.phone = "' => $searchValue . '"'));
    $price = $course->get(array('meds_courses.id = '=>$data['courses']));
    $price = $price['price'];
    $course_payments = 'SELECT SUM(value) AS total_payments FROM meds_entrances WHERE course_id = "'.$data['courses'].'" AND student_id = "'.$who['id'].'"';
    $stmt = $conn->prepare($course_payments);
    if ($stmt->execute()) {
        $sum = $stmt->fetch(PDO::FETCH_ASSOC);
        $sum = $sum['total_payments'];
    }
    $data['remaing'] = $price - ($sum+$data['value']);
    if ($who == false) {
        return false;
    } else {
        $query = "INSERT INTO meds_entrances(student_id, course_id, value, remaing, created_by, branch_id, payment_method_id, created_at)VALUES(:student_id, :course_id, :value, :remaing, :created_by, :branch_id, :payment_method_id, :created_at)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':remaing', $remaing);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':branch_id', $branch_id);
        $stmt->bindParam(':payment_method_id', $payment_method_id);

        $student_id = $who['id'];
        $course_id = $data['courses'];
        $remaing = $data['remaing'];
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
}

?>