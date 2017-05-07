<?php

class PaymentMethod {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_payment_methods.id AS id, meds_payment_methods.name AS name, meds_branches.id as branch_id, meds_branches.name as branch FROM'
                . ' meds_payment_methods INNER JOIN meds_branches ON meds_payment_methods.branch_id = meds_branches.id ';
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $paymentmethods = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $paymentmethods[] = $row;
            }
            return $paymentmethods;
        } else {
            return false;
        }
    }

    public function add($paymentmethod) { // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_payment_methods (name, branch_id) 
        VALUES (:name, :branch_id)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':branch_id', $branch_id);
        // insert a row
        $name = $paymentmethod['name'];
        $branch_id = $paymentmethod['branch_id'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($key, $value) {
        $query = 'SELECT meds_payment_methods.id AS id, meds_payment_methods.name AS name, meds_branches.id as branch_id, meds_branches.name as branch FROM'
                . ' meds_payment_methods INNER JOIN meds_branches ON meds_payment_methods.branch_id = meds_branches.id  WHERE ' . $key . ' = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $value, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function update($meds_paymentmethod) {
        $query = 'UPDATE meds_payment_methods SET name = ?, branch_id = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $meds_paymentmethod['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $meds_paymentmethod['branch_id'], PDO::PARAM_INT);
        $stmt->bindParam(3, $meds_paymentmethod['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

}
