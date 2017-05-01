<?php

require_once '../models/Student.php';
$st = new Student();
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
        if($students){
            var_dump($students);
        }
        $form_type = 'insert';
    }
} elseif ($_REQUEST['REQUEST_METHOD'] == 'POST') {
    $form_type = 'insert';
    $student = array();
    $student['name'] = 'mohamed';
    $student['phone'] = '01234';
    $student['mobile'] = '56789';
    $student['address'] = 'hassan';
    $student['balance'] = 0;
    $student['notes'] = 'crazy';
    $student['created_at'] = date('Y-m-d h:i:s');
    $student['branch_id'] = '10';
    echo $st->add($student) . "inserted successfuly";
} elseif ($_REQUEST['REQUEST_METHOD'] == 'PATCH') {
    $form_type = 'insert';
}
?>