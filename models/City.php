<?php

class City {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_cities.id, meds_cities.name, meds_countries.id AS country_id, meds_countries.name AS country '
                . 'FROM meds_cities INNER JOIN meds_countries ON meds_cities.country_id = meds_countries.id';
        $stmt = $this->conn->prepare($query);
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

    public function add($city) { // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_cities (name, country_id) 
        VALUES (:name, :country_id)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':country_id', $country_id);
        // insert a row
        $name = $city['name'];
        $country_id = $city['country_id'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($city_id) {
        $query = 'SELECT meds_cities.id, meds_cities.name, meds_countries.id AS country_id, meds_countries.name AS country '
                . 'FROM meds_cities INNER JOIN meds_countries ON meds_cities.country_id = meds_countries.id WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $city_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    
    /*
     * get all students that exist in this city
     */
    public function get_students($city_id) {
        $query = 'SELECT meds_students.id, meds_students.name, meds_students.phone, meds_students.mobile, meds_students.balance, meds_students.notes,'
                . ' meds_branches.name as branch, meds_branches.id as branch_id,'
                . ' meds_countries.name AS country, meds_countries.id AS country_id,'
                . ' meds_cities.name as city, meds_cities.id as city_id,'
                . ' meds_addresses.street FROM meds_students'
                . ' INNER JOIN meds_branches ON meds_students.branch_id = meds_branches.id'
                . ' INNER JOIN meds_addresses on meds_students.address_id = meds_addresses.id'
                . ' INNER JOIN meds_countries ON meds_addresses.country_id = meds_countries.id'
                . ' INNER JOIN meds_cities ON meds_addresses.city_id = meds_cities.id WHERE meds_cities.id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $city_id, PDO::PARAM_INT);
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
