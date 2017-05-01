<?php

require_once'config.php';

class Student {

    var $conn;

    function __construct() {
        $database = new Database('localhost', 'root', '', 'test');
        $this->conn = $database->get_connection();
    }

    public function fetch_all() {
        $stmt = $this->conn->prepare('SELECT * FROM meds_students');
        if ($stmt->execute()) {
            $students = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $students[] = $row;
            }
            return $students;
        } else {
            return false;
        }
    }

    public function add($student) { // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_students (name, phone, mobile, address, balance, created_at, notes, branch_id) 
        VALUES (:name, :phone, :mobile, :address, :balance, :created_at, :notes, :branch_id)');
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
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($student_id) {
        $stmt = $this->conn->prepare('SELECT * FROM meds_students WHERE id = ?');
        $stmt->bindParam(1, $student_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function get_branch($student_id) {
        $stmt = $this->conn->prepare('SELECT meds_branches.id, meds_branches.name FROM meds_students INNER JOIN meds_branches ON meds_students.branch_id = meds_branches.id WHERE meds_students.id = ?');
        $stmt->bindParam(1, $student_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function get_address($student_id) {
        $stmt = $this->conn->prepare('SELECT * FROM meds_students INNER JOIN meds_addresses ON meds_students.address_id = meds_addresses.id WHERE meds_students.id = ?');
        $stmt->bindParam(1, $student_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function get_country($student_id) {
        $query = 'SELECT meds_countries.id AS id, meds_countries.name AS name FROM meds_students'
                . ' INNER JOIN meds_addresses ON meds_students.address_id  = meds_addresses.id'
                . ' INNER JOIN meds_countries ON meds_addresses.country_id = meds_countries.id'
                . ' WHERE meds_students.id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $student_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function get_city($student_id) {
        $query = 'SELECT meds_cities.id AS id, meds_cities.name AS name FROM meds_students'
                . ' INNER JOIN meds_addresses ON meds_students.address_id  = meds_addresses.id'
                . ' INNER JOIN meds_cities ON meds_addresses.city_id = meds_cities.id'
                . ' WHERE meds_students.id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $student_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

}
