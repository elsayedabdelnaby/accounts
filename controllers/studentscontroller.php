<?php

require_once'../models/config.php';
require_once'../models/Student.php';
require_once'../models/Country.php';
require_once'../models/City.php';
require_once'../models/Branch.php';
require_once'../models/Address.php';

$database = new Database('localhost', 'root', '', 'test');
$conn = $database->get_connection();
$student = new Student($conn);
$country = new Country($conn);
$city = new City($conn);
$branch = new Branch($conn);
$address = new Address($conn);

$countries = $country->fetch_all();
$cities = $city->fetch_all();
$branches = $branch->fetch_all();
$alert_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $form_type = 'insert';
    if (isset($_GET['id'])) { // edit/update form
        $student_id = $_GET['id'];
        $form_type = 'update';
        $row = $student->get($student_id);
        if ($row != false) {
            print_r($row);
            print_r($student->get_branch($student_id));
        } else {
            echo 'not exist';
        }
    } else {
        $students = $student->fetch_all();
        $form_type = 'insert';
        include_once '../views/students.php';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_type = 'insert';
    $student_array = array();
    $address_array = array();
    
    $student_array['name'] = $_POST['name'];
    $student_array['phone'] = $_POST['phone'];
    $student_array['mobile'] = $_POST['mobile'];
    $student_array['country_id'] = $_POST['country'];
    $student_array['city_id'] = $_POST['city'];
    $student_array['branch_id'] = $_POST['branch'];
    $student_array['street'] = $_POST['street'];
    $student_array['created_at'] = date('Y-m-d h:i:s');
    $student_array['notes'] = $_POST['notes'];
    
    $address_array['country'] = $_POST['country'];
    $address_array['city'] = $_POST['city'];
    $address_array['street'] = $_POST['street'];
    $student_array['address_id'] = $address->add($address_array);
    if($student->add($student_array)){
        echo "<script>alert('تم اضافة طالب جديد');</script>";
        header('Location: '.URL.'students');
    } else{
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $form_type = 'insert';
}
?>