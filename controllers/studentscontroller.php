<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $form_type = 'insert';
    if(isset($_GET['id'])){ // edit/update form
        $form_type = 'update';

    } else {
        $form_type = 'insert';
    }
} elseif($_REQUEST['REQUEST_METHOD'] == 'POST') {
    $form_type = 'insert';
} elseif($_REQUEST['REQUEST_METHOD'] == 'PATCH'){
    $form_type = 'insert';
}
?>