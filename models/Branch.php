<?php

class Branch {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT * FROM meds_branches';
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $branches = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $branches[] = $row;
            }
            return $branches;
        } else {
            return false;
        }
    }

    public function add($branch) { // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_branches (name) 
        VALUES (:name)');
        $stmt->bindParam(':name', $name);
        // insert a row
        $name = $branch['name'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($branch_id) {
        $query = 'SELECT * FROM meds_branches WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $branch_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    /*
     * get all students that exist in this country
     */

    public function get_students($branch_id) {
        $query = 'SELECT meds_students.id, meds_students.name, meds_students.phone, meds_students.mobile, meds_students.balance, meds_students.notes,'
                . ' meds_branches.name as branch, meds_branches.id as branch_id,'
                . ' meds_countries.name AS country, meds_countries.id AS country_id,'
                . ' meds_cities.name as city, meds_cities.id as city_id,'
                . ' meds_addresses.street FROM meds_students'
                . ' INNER JOIN meds_branches ON meds_students.branch_id = meds_branches.id'
                . ' INNER JOIN meds_addresses on meds_students.address_id = meds_addresses.id'
                . ' INNER JOIN meds_countries ON meds_addresses.country_id = meds_countries.id'
                . ' INNER JOIN meds_cities ON meds_addresses.city_id = meds_cities.id WHERE meds_branches.id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $branch_id, PDO::PARAM_INT);
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

}
