<?php
require_once '../models/Student.php';
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $form_type = 'insert';
    if(isset($_GET['id'])){ // edit/update form
        $form_type = 'update';
        $student = array();
        $student['name'] = 'mohamed';
        $student['phone'] = '01234';
        $student['mobile'] = '56789';
        $student['address'] = 'hassan';
        $student['balance'] = 0;
        $student['notes'] = 'crazy';
        $student['created_at'] = date('Y-m-d h:i:s');
        $student['branch_id'] = '10';
        $st = new Student();
        echo $st->add($student);
    } else {
        $form_type = 'insert';
    }
} elseif($_REQUEST['REQUEST_METHOD'] == 'POST') {
    $form_type = 'insert';
} elseif($_REQUEST['REQUEST_METHOD'] == 'PATCH'){
    $form_type = 'insert';
}
?>