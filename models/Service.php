<?php

class Service {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT services.id, services.request_date, services.service_name as name, services.quantity, services.unit_price, services.total_price, services.notes,'
                . ' services.vendor_id , meds_vendors.name AS vendor,'
                . ' services.branch_id, meds_branches.name AS branch, meds_users.name as creator'
                . ' FROM meds_vendors_services AS services'
                . ' INNER JOIN meds_users ON services.created_by = meds_users.id'
                . ' INNER JOIN meds_branches ON services.branch_id = meds_branches.id'
                . ' INNER JOIN meds_vendors ON services.vendor_id = meds_vendors.id';
        echo $query;
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $services = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $services[] = $row;
            }
            return $services;
        } else {
            return false;
        }
    }

    public function add($service) { // take vendor(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_vendors_services (request_date, service_name, quantity, created_by, unit_price, total_price, vendor_id, branch_id, notes) 
        VALUES (:request_date, :service_name, :quantity, :created_by, :unit_price, :total_price, :vendor_id, :branch_id, :notes)');
        $stmt->bindParam(':request_date', $request_date);
        $stmt->bindParam(':service_name', $service_name);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':unit_price', $unit_price);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':vendor_id', $vendor_id);
        $stmt->bindParam(':branch_id', $branch_id);
        $stmt->bindParam(':notes', $notes);
        // insert a row
        $request_date = $service['request_date'];
        $service_name = $service['service_name'];
        $quantity = $service['quantity'];
        $created_by = $service['created_by'];
        $unit_price = $service['unit_price'];
        $total_price = $service['total_price'];
        $vendor_id = $service['vendor_id'];
        $branch_id = $service['branch_id'];
        $notes = $service['notes'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($conditions) {
        $query = 'SELECT services.id, services.request_date, services.service_name as name, services.quantity, services.unit_price, services.total_price, services.notes,'
                . ' services.vendor_id , meds_vendors.name AS vendor,'
                . ' services.branch_id, meds_branches.name AS branch, meds_users.name as creator'
                . ' FROM meds_vendors_services AS services'
                . ' INNER JOIN meds_users ON services.created_by = meds_users.id'
                . ' INNER JOIN meds_branches ON services.branch_id = meds_branches.id'
                . ' INNER JOIN meds_vendors ON services.vendor_id = meds_vendors.id WHERE ';
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

}
