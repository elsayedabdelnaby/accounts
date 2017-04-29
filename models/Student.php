<?php
require_once'./config.php' ;
class Student{
    public function add($student){ // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $conn->prepare("INSERT INTO meds_students (name, phone, mobile, address, balance, created_at, update_at, notes, branch_id) 
        VALUES (:name, :phone, :mobile, :address, :balance, :created_at, :updated_at, :notes, :branch_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':balance', $balance);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':branch_id', $branch_id);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':updated_at', $updated_at);
        // insert a row
        $name = $student['name'];
        $phone = $student['phone'];
        $mobile = $student['mobile'];
        $address = $student['address'];
        $balance = $student['balance'];
        $notes = $student['notes'];
        $branch_id = $student['branch_id'];
        $created_at = $student['created_at'];
        $updated_at = $student['updated_at'];
        $stmt->execute();
    }
}