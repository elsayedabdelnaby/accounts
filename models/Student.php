<?php
require_once'config.php' ;
class Student{
    var $conn;
    function __construct(){
        $database = new Database('localhost', 'root', '', 'test');
        $this->conn = $database->get_connection();
    }
    public function add($student){ // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare("INSERT INTO meds_students (name, phone, mobile, address, balance, created_at, notes, branch_id) 
        VALUES (:name, :phone, :mobile, :address, :balance, :created_at, :notes, :branch_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':balance', $balance);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':branch_id', $branch_id);
        $stmt->bindParam(':created_at', $created_at);
        // insert a row
        $name = $student['name'];
        $phone = $student['phone'];
        $mobile = $student['mobile'];
        $address = $student['address'];
        $balance = $student['balance'];
        $notes = $student['notes'];
        $branch_id = $student['branch_id'];
        $created_at = $student['created_at'];
        if($stmt->execute()){
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }
}