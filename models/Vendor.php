<?php

class Vendor {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_vendors.id, meds_vendors.name, meds_vendors.phone, meds_vendors.mobile, meds_vendors.notes, meds_vendors.type,'
                . ' meds_countries.name AS country, meds_countries.id AS country_id,'
                . ' meds_cities.name as city, meds_cities.id as city_id,'
                . ' meds_addresses.street, meds_users.name as created_by FROM meds_vendors'
                . ' INNER JOIN meds_users ON meds_vendors.created_by = meds_users.id'
                . ' INNER JOIN meds_addresses ON meds_vendors.address_id = meds_addresses.id'
                . ' INNER JOIN meds_countries ON meds_addresses.country_id = meds_countries.id'
                . ' INNER JOIN meds_cities ON meds_addresses.city_id = meds_cities.id';
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $vendors = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $vendors[] = $row;
            }
            return $vendors;
        } else {
            return false;
        }
    }

    public function add($vendor) { // take vendor(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_vendors (name, phone, mobile, created_by, notes, type, address_id) 
        VALUES (:name, :phone, :mobile, :created_by, :notes, :type, :address_id)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':address_id', $address_id);
        // insert a row
        $name = $vendor['name'];
        $phone = $vendor['phone'];
        $mobile = $vendor['mobile'];
        $notes = $vendor['notes'];
        $type = $vendor['type'];
        $created_by = $vendor['created_by'];
        $address_id = $vendor['address_id'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($conditions) {
        $query = 'SELECT meds_vendors.id, meds_vendors.name, meds_vendors.phone, meds_vendors.mobile, meds_vendors.notes, meds_vendors.type,'
                . ' meds_countries.name AS country, meds_countries.id AS country_id,'
                . ' meds_cities.name as city, meds_cities.id as city_id,'
                . ' meds_addresses.street, meds_users.name as created_by FROM meds_vendors'
                . ' INNER JOIN meds_users ON meds_vendors.created_by = meds_users.id'
                . ' INNER JOIN meds_addresses ON meds_vendors.address_id = meds_addresses.id'
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

    public function get_branch($vendor_id) {
        $stmt = $this->conn->prepare('SELECT meds_branches.id, meds_branches.name FROM meds_vendors INNER JOIN meds_branches ON meds_vendors.branch_id = meds_branches.id WHERE meds_vendors.id = ?');
        $stmt->bindParam(1, $vendor_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function get_address($vendor_id) {
        $stmt = $this->conn->prepare('SELECT * FROM meds_vendors INNER JOIN meds_addresses ON meds_vendors.address_id = meds_addresses.id WHERE meds_vendors.id = ?');
        $stmt->bindParam(1, $vendor_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function get_country($vendor_id) {
        $query = 'SELECT meds_countries.id AS id, meds_countries.name AS name FROM meds_vendors'
                . ' INNER JOIN meds_addresses ON meds_vendors.address_id  = meds_addresses.id'
                . ' INNER JOIN meds_countries ON meds_addresses.country_id = meds_countries.id'
                . ' WHERE meds_vendors.id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $vendor_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function get_city($vendor_id) {
        $query = 'SELECT meds_cities.id AS id, meds_cities.name AS name FROM meds_vendors'
                . ' INNER JOIN meds_addresses ON meds_vendors.address_id  = meds_addresses.id'
                . ' INNER JOIN meds_cities ON meds_addresses.city_id = meds_cities.id'
                . ' WHERE meds_vendors.id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $vendor_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function update($vendor) {
        $query = 'UPDATE meds_vendors SET name = ?, phone = ?, mobile = ?, notes = ?, type = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $vendor['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $vendor['phone'], PDO::PARAM_STR);
        $stmt->bindParam(3, $vendor['mobile'], PDO::PARAM_STR);
        $stmt->bindParam(4, $vendor['notes'], PDO::PARAM_STR);
        $stmt->bindParam(5, $vendor['type'], PDO::PARAM_INT);
        $stmt->bindParam(6, $vendor['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

}
