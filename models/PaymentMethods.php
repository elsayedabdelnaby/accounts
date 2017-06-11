<?php

class PaymentMethod {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_payment_methods.id AS id, meds_payment_methods.name AS name FROM'
                . ' meds_payment_methods';
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
        $stmt = $this->conn->prepare('INSERT INTO meds_payment_methods (name) 
        VALUES (:name)');
        $stmt->bindParam(':name', $name);
        // insert a row
        $name = $paymentmethod['name'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($key, $value) {
        $query = 'SELECT meds_payment_methods.id AS id, meds_payment_methods.name AS name FROM'
                . ' meds_payment_methods  WHERE ' . $key . ' = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $value, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function update($meds_paymentmethod) {
        $query = 'UPDATE meds_payment_methods SET name = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $meds_paymentmethod['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $meds_paymentmethod['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

}
