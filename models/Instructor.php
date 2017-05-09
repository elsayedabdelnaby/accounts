<?php

class Instructor {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_instructor.id, meds_instructor.name, meds_instructor.phone, meds_instructor.mobile, meds_instructor.email, meds_instructor.description,'
                . ' meds_countries.name AS country, meds_countries.id AS country_id,'
                . ' meds_cities.name as city, meds_cities.id as city_id,'
                . ' meds_addresses.street FROM meds_instructor'
                . ' INNER JOIN meds_addresses ON meds_instructor.address_id = meds_addresses.id'
                . ' INNER JOIN meds_countries ON meds_addresses.country_id = meds_countries.id'
                . ' INNER JOIN meds_cities ON meds_addresses.city_id = meds_cities.id';
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $instructors = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $instructors[] = $row;
            }
            return $instructors;
        } else {
            return false;
        }
    }

    public function add($instructor) { // take instructor(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_instructor (name, phone, mobile, email, description, address_id) 
        VALUES (:name, :phone, :mobile, :email, :description, :address_id)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':address_id', $address_id);
        // insert a row
        $name = $instructor['name'];
        $phone = $instructor['phone'];
        $mobile = $instructor['mobile'];
        $email = $instructor['email'];
        $description = $instructor['description'];
        $address_id = $instructor['address_id'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($conditions) {
        $query = 'SELECT meds_instructor.id, meds_instructor.name, meds_instructor.phone,'
                . ' meds_instructor.mobile, meds_instructor.email, meds_instructor.description, meds_instructor.address_id,'
                . ' meds_countries.name AS country, meds_countries.id AS country_id,'
                . ' meds_cities.name as city, meds_cities.id as city_id,'
                . ' meds_addresses.street FROM meds_instructor'
                . ' INNER JOIN meds_addresses on meds_instructor.address_id = meds_addresses.id'
                . ' INNER JOIN meds_countries ON meds_addresses.country_id = meds_countries.id'
                . ' INNER JOIN meds_cities ON meds_addresses.city_id = meds_cities.id WHERE ';
        if (!empty($conditions)) {
            $count = 0;
            foreach ($conditions as $key => $value) {
                if ($count == 0) {
                    $query .= $key . $value;
                } else {
                    $query .= ' AND ' . $key . $value;
                }
                $count++;
            }
        }
        $stmt = $this->conn->prepare($query);
        $count = 1;
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function get_address($instructor_id) {
        $stmt = $this->conn->prepare('SELECT * FROM meds_instructor INNER JOIN meds_addresses ON meds_instructor.address_id = meds_addresses.id WHERE meds_instructor.id = ?');
        $stmt->bindParam(1, $instructor_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function update($instructor) {
        $query = 'UPDATE meds_instructor SET name = ?, phone = ?, mobile = ?, email = ?, description = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $instructor['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $instructor['phone'], PDO::PARAM_STR);
        $stmt->bindParam(3, $instructor['mobile'], PDO::PARAM_STR);
        $stmt->bindParam(4, $instructor['email'], PDO::PARAM_STR);
        $stmt->bindParam(5, $instructor['description'], PDO::PARAM_INT);
        $stmt->bindParam(6, $instructor['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

}
