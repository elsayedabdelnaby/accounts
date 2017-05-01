<?php

class Country {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT * FROM meds_countries';
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $countries = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $countries[] = $row;
            }
            return $countries;
        } else {
            return false;
        }
    }

    public function add($country) { // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_countries (name) 
        VALUES (:name)');
        $stmt->bindParam(':name', $name);
        // insert a row
        $name = $country['name'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($country_id) {
        $query = 'SELECT * FROM meds_countries WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $country_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function get_cities($country_id) {
        $query = 'SELECT * FROM meds_cities WHERE country_id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $country_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $cities = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cities[] = $row;
            }
            return $cities;
        } else {
            return false;
        }
    }

    /*
     * get all students that exist in this country
     */

    public function get_students($country_id) {
        $query = 'SELECT meds_students.id, meds_students.name, meds_students.phone, meds_students.mobile, meds_students.balance, meds_students.notes,'
                . ' meds_branches.name as branch, meds_branches.id as branch_id,'
                . ' meds_countries.name AS country, meds_countries.id AS country_id,'
                . ' meds_cities.name as city, meds_cities.id as city_id,'
                . ' meds_addresses.street FROM meds_students'
                . ' INNER JOIN meds_branches ON meds_students.branch_id = meds_branches.id'
                . ' INNER JOIN meds_addresses on meds_students.address_id = meds_addresses.id'
                . ' INNER JOIN meds_countries ON meds_addresses.country_id = meds_countries.id'
                . ' INNER JOIN meds_cities ON meds_addresses.city_id = meds_cities.id WHERE meds_countries.id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $country_id, PDO::PARAM_INT);
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
