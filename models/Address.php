<?php

class Address {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function add($address) { // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_addresses (country_id, city_id, street) 
        VALUES (:country_id, :city_id, :street)');
        $stmt->bindParam(':country_id', $country_id);
        $stmt->bindParam(':city_id', $city_id);
        $stmt->bindParam(':street', $street);
        // insert a row
        $country_id = $address['country'];
        if ($address['city'] == 0) {
            $address['city'] = NULL;
        }
        $city_id = $address['city'];
        if ($address['street'] == '') {
            $address['street'] = NULL;
        }
        $street = $address['street'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($address_id) {
        $query = 'SELECT meds_addresses.id, meds_addresses.street, meds_countries.id AS country_id, meds_countries.name AS country, '
                . 'meds_cities.id AS city_id, meds_cities.name AS city FROM meds_addresses'
                . ' INNER JOIN meds_countries ON meds_addresses.country_id = meds_countries.id'
                . ' INNER JOIN meds_cities ON meds_addresses.city_id = meds_city.id WHERE meds_addresses.id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $address_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

}
