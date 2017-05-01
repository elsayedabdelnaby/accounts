<?php

require_once'../models/config.php';
require_once'../models/Student.php';
require_once'../models/Country.php';
require_once'../models/City.php';
require_once'../models/Branch.php';

$database = new Database('localhost', 'root', '', 'test');
$conn = $database->get_connection();
$st = new Student($conn);
$country = new Country($conn);
$city = new City($conn);
$branch = new Branch($conn);

$countries = $country->fetch_all();
$cities = $city->fetch_all();
$branches = $branch->fetch_all();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $student_id = $_GET['id'];
        $form_type = 'update';
        $row = $st->get($student_id);
        if ($row != false) {
            print_r($row);
            print_r($st->get_branch($student_id));
        } else {
            echo 'not exist';
        }
    } else {
        $students = $st->fetch_all();
        $form_type = 'insert';
        include_once '../views/students.php';
    }
} elseif ($_REQUEST['REQUEST_METHOD'] == 'POST') {
    $form_type = 'insert';
    $student = array();
    $student['name'] = $_POST['name'];
    $student['phone'] = $_POST['phone'];
    $student['mobile'] = $_POST['mobile'];
    $student['country_id'] = $_POST['country'];
    $student['city_id'] = $_POST['city'];
    $student['street'] = $_POST['street'];
    $student['created_at'] = date('Y-m-d h:i:s');
    $student['branch_id'] = $_POST['branch'];
    $student['notes'] = $_POST['notes'];
    echo $st->add($student) . "inserted successfuly";
} elseif ($_REQUEST['REQUEST_METHOD'] == 'PATCH') {
    $form_type = 'insert';
}
?>