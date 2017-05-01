<?php

class Student {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_students.id, meds_students.name, meds_students.phone, meds_students.mobile, meds_students.balance, meds_students.notes,'
                . ' meds_branches.name as branch, meds_branches.id as branch_id,'
                . ' meds_countries.name AS country, meds_countries.id AS country_id,'
                . ' meds_cities.name as city, meds_cities.id as city_id,'
                . ' meds_addresses.street FROM meds_students'
                . ' INNER JOIN meds_branches ON meds_students.branch_id = meds_branches.id'
                . ' INNER JOIN meds_addresses on meds_students.address_id = meds_addresses.id'
                . ' INNER JOIN meds_countries ON meds_addresses.country_id = meds_countries.id'
                . ' INNER JOIN meds_cities ON meds_addresses.city_id = meds_cities.id';
        $stmt = $this->conn->prepare($query);
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
        $stmt = $this->conn->prepare('INSERT INTO meds_students (name, phone, mobile, created_at, notes, branch_id, address_id) 
        VALUES (:name, :phone, :mobile, :created_at, :notes, :branch_id, :address_id)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':branch_id', $branch_id);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':address_id', $address_id);
        // insert a row
        $name = $student['name'];
        $phone = $student['phone'];
        $mobile = $student['mobile'];
        $notes = $student['notes'];
        $branch_id = $student['branch_id'];
        $created_at = $student['created_at'];
        $address_id = $student['address_id'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($student_id) {
        $query = 'SELECT meds_students.id, meds_students.name, meds_students.phone, meds_students.mobile, meds_students.balance, meds_students.notes,'
                . ' meds_branches.name as branch, meds_branches.id as branch_id,'
                . ' meds_countries.name AS country, meds_countries.id AS country_id,'
                . ' meds_cities.name as city, meds_cities.id as city_id,'
                . ' meds_addresses.street FROM meds_students'
                . ' INNER JOIN meds_branches ON meds_students.branch_id = meds_branches.id'
                . ' INNER JOIN meds_addresses on meds_students.address_id = meds_addresses.id'
                . ' INNER JOIN meds_countries ON meds_addresses.country_id = meds_countries.id'
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
